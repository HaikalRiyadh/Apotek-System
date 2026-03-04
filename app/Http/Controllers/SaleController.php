<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Services\SaleService;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function __construct(protected SaleService $saleService) {}

    public function index(Request $request)
    {
        $query = Sale::with('user');

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('sale_date', [$request->start_date, $request->end_date]);
        }

        $sales = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('sales.index', compact('sales'));
    }

    /**
     * POS Interface
     */
    public function create()
    {
        return view('sales.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.medicine_id' => 'required|exists:medicines,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.selling_price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'amount_paid' => 'required|numeric|min:0',
            'payment_method' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        try {
            $sale = $this->saleService->createSale(
                $request->only('discount', 'tax', 'amount_paid', 'payment_method', 'notes'),
                $request->items
            );

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil disimpan.',
                'sale' => $sale,
                'redirect' => route('sales.show', $sale),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function show(Sale $sale)
    {
        $sale->load('details.medicine.unit', 'user');
        return view('sales.show', compact('sale'));
    }
}
