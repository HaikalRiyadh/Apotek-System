<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\MedicineBatch;
use App\Models\StockAdjustment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockAdjustmentController extends Controller
{
    public function index(Request $request)
    {
        $query = StockAdjustment::with(['medicine', 'medicineBatch', 'user'])
            ->latest();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('medicine', fn($q) => $q->where('name', 'like', "%{$search}%"));
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $adjustments = $query->paginate(20)->withQueryString();

        return view('stock-adjustments.index', compact('adjustments'));
    }

    public function create(Request $request)
    {
        $medicines = Medicine::with(['batches' => function ($q) {
            $q->where('remaining_quantity', '>', 0)->orderBy('expired_date', 'asc');
        }])->whereHas('batches', fn($q) => $q->where('remaining_quantity', '>', 0))
          ->orderBy('name')
          ->get();

        $selectedBatch = null;
        if ($request->filled('batch_id')) {
            $selectedBatch = MedicineBatch::with('medicine')->find($request->batch_id);
        }

        return view('stock-adjustments.create', compact('medicines', 'selectedBatch'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'medicine_batch_id' => 'required|exists:medicine_batches,id',
            'type' => 'required|in:dispose,correction,return,other',
            'quantity_adjusted' => 'required|integer|min:1',
            'reason' => 'required|string|max:255',
        ]);

        $batch = MedicineBatch::with('medicine')->findOrFail($validated['medicine_batch_id']);

        if ($validated['quantity_adjusted'] > $batch->remaining_quantity) {
            return back()->withErrors([
                'quantity_adjusted' => 'Jumlah penyesuaian melebihi sisa stok batch (' . $batch->remaining_quantity . ').',
            ])->withInput();
        }

        DB::transaction(function () use ($validated, $batch) {
            $quantityBefore = $batch->remaining_quantity;
            $quantityAfter = $quantityBefore - $validated['quantity_adjusted'];

            StockAdjustment::create([
                'medicine_batch_id' => $batch->id,
                'medicine_id' => $batch->medicine_id,
                'user_id' => auth()->id(),
                'type' => $validated['type'],
                'quantity_before' => $quantityBefore,
                'quantity_adjusted' => $validated['quantity_adjusted'],
                'quantity_after' => $quantityAfter,
                'reason' => $validated['reason'],
            ]);

            $batch->update(['remaining_quantity' => $quantityAfter]);
            $batch->medicine->recalculateStock();
        });

        return redirect()->route('stock-adjustments.index')
            ->with('success', 'Penyesuaian stok berhasil disimpan.');
    }

    public function disposeExpired()
    {
        $expiredBatches = MedicineBatch::with('medicine')
            ->where('expired_date', '<=', now())
            ->where('remaining_quantity', '>', 0)
            ->orderBy('expired_date', 'asc')
            ->get();

        return view('stock-adjustments.dispose-expired', compact('expiredBatches'));
    }

    public function disposeExpiredStore(Request $request)
    {
        $validated = $request->validate([
            'batch_ids' => 'required|array|min:1',
            'batch_ids.*' => 'exists:medicine_batches,id',
            'reason' => 'nullable|string|max:255',
        ]);

        $reason = $validated['reason'] ?? 'Pembuangan obat expired';
        $count = 0;

        DB::transaction(function () use ($validated, $reason, &$count) {
            $batches = MedicineBatch::with('medicine')
                ->whereIn('id', $validated['batch_ids'])
                ->where('remaining_quantity', '>', 0)
                ->where('expired_date', '<=', now())
                ->get();

            foreach ($batches as $batch) {
                StockAdjustment::create([
                    'medicine_batch_id' => $batch->id,
                    'medicine_id' => $batch->medicine_id,
                    'user_id' => auth()->id(),
                    'type' => 'dispose',
                    'quantity_before' => $batch->remaining_quantity,
                    'quantity_adjusted' => $batch->remaining_quantity,
                    'quantity_after' => 0,
                    'reason' => $reason,
                ]);

                $batch->update(['remaining_quantity' => 0]);
                $batch->medicine->recalculateStock();
                $count++;
            }
        });

        return redirect()->route('stock-adjustments.index')
            ->with('success', "{$count} batch obat expired berhasil dibuang.");
    }

    public function getBatches(Medicine $medicine)
    {
        $batches = $medicine->batches()
            ->where('remaining_quantity', '>', 0)
            ->orderBy('expired_date', 'asc')
            ->get(['id', 'batch_number', 'expired_date', 'remaining_quantity']);

        return response()->json($batches);
    }
}
