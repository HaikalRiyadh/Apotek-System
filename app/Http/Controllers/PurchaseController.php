<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Medicine;
use App\Models\Supplier;
use App\Services\PurchaseService;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function __construct(protected PurchaseService $purchaseService) {}

    public function index(Request $request)
    {
        $query = Purchase::with('supplier', 'user');

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereDate('purchase_date', '>=', $request->start_date)
                  ->whereDate('purchase_date', '<=', $request->end_date);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('supplier', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $purchases = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $suppliers = Supplier::orderBy('name')->get();
        $medicines = Medicine::with('unit')->orderBy('name')->get();
        return view('purchases.create', compact('suppliers', 'medicines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.medicine_id' => 'required|exists:medicines,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.purchase_price' => 'required|numeric|min:0',
            'items.*.batch_number' => 'required|string',
            'items.*.expired_date' => 'required|date|after:today',
        ], [
            'items.required' => 'Item pembelian wajib diisi.',
            'items.min' => 'Minimal harus ada 1 item pembelian.',
            'items.*.medicine_id.required' => 'Obat wajib dipilih pada setiap item.',
            'items.*.medicine_id.exists' => 'Obat yang dipilih tidak valid.',
            'items.*.quantity.required' => 'Jumlah wajib diisi pada setiap item.',
            'items.*.quantity.min' => 'Jumlah minimal adalah 1.',
            'items.*.purchase_price.required' => 'Harga beli wajib diisi pada setiap item.',
            'items.*.purchase_price.min' => 'Harga beli tidak boleh negatif.',
            'items.*.batch_number.required' => 'Nomor batch wajib diisi pada setiap item.',
            'items.*.expired_date.required' => 'Tanggal expired wajib diisi pada setiap item.',
            'items.*.expired_date.after' => 'Tanggal expired harus setelah hari ini.',
        ]);

        $purchase = $this->purchaseService->createPurchase(
            $request->only('supplier_id', 'purchase_date', 'notes'),
            $request->items
        );

        return redirect()->route('purchases.show', $purchase)
            ->with('success', 'Pembelian berhasil disimpan.');
    }

    public function show(Purchase $purchase)
    {
        $purchase->load('details.medicine.unit', 'supplier', 'user');
        return view('purchases.show', compact('purchase'));
    }
}
