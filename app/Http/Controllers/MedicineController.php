<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function index(Request $request)
    {
        $query = Medicine::with('category', 'unit');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $medicines = $query->orderBy('name')->paginate(15)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('medicines.index', compact('medicines', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $units = Unit::orderBy('name')->get();
        return view('medicines.create', compact('categories', 'units'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:medicines',
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'unit_id' => 'required|exists:units,id',
            'default_purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        Medicine::create($validated);

        return redirect()->route('medicines.index')
            ->with('success', 'Obat berhasil ditambahkan.');
    }

    public function show(Medicine $medicine)
    {
        $medicine->load('category', 'unit', 'batches');
        return view('medicines.show', compact('medicine'));
    }

    public function edit(Medicine $medicine)
    {
        $categories = Category::orderBy('name')->get();
        $units = Unit::orderBy('name')->get();
        return view('medicines.edit', compact('medicine', 'categories', 'units'));
    }

    public function update(Request $request, Medicine $medicine)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:medicines,code,' . $medicine->id,
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'unit_id' => 'required|exists:units,id',
            'default_purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $medicine->update($validated);

        return redirect()->route('medicines.index')
            ->with('success', 'Obat berhasil diperbarui.');
    }

    public function destroy(Medicine $medicine)
    {
        if ($medicine->stock_total > 0) {
            return back()->with('error', 'Obat dengan stok tidak bisa dihapus.');
        }

        $medicine->delete();

        return redirect()->route('medicines.index')
            ->with('success', 'Obat berhasil dihapus.');
    }

    /**
     * AJAX search for POS
     */
    public function search(Request $request)
    {
        $search = $request->get('q', '');

        $medicines = Medicine::with('unit')
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('code', 'like', "%{$search}%");
            })
            ->where('stock_total', '>', 0)
            ->limit(10)
            ->get()
            ->map(fn($m) => [
                'id' => $m->id,
                'code' => $m->code,
                'name' => $m->name,
                'selling_price' => $m->selling_price,
                'stock_total' => $m->stock_total,
                'unit' => $m->unit->abbreviation ?? $m->unit->name,
            ]);

        return response()->json($medicines);
    }
}
