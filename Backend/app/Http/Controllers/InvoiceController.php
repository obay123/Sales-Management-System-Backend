<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest\StoreInvoiceRequest;
use App\Http\Requests\InvoiceRequest\UpdateInvoiceRequest;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Export;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Auth::user()->invoices()->with('items')->paginate(20);
        return response()->json(['message' => 'Invoices retrieved successfully', 'data' => $invoices], 200);
    }

    public function store(StoreInvoiceRequest $request)
    {
        $validated = $request->validated();
        $totalQuantity = 0;
        $totalPrice = 0;

        foreach ($validated['items'] as $item) {
            $totalQuantity += $item['quantity'];
            $totalPrice += $item['quantity'] * $item['unit_price'];
        }

        $invoice = Invoice::create([
            'user_id' => Auth::user()->id,
            'customer_id' => $validated['customer_id'],
            'date' => $validated['date'] ?? now(),
            'total_quantity' => $totalQuantity,
            'total_price' => $totalPrice,
        ]);

        $itemsToAttach = [];
        foreach ($validated['items'] as $item) {
            $itemsToAttach[$item['item_code']] = [
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'line_total' => $item['quantity'] * $item['unit_price'],
            ];
        }
        $invoice->items()->attach($itemsToAttach);
        return response()->json(['message' => 'Added successfully', 'data' => $invoice->load('items')], 201);
    }

    public function show(Invoice $invoice)
    {
        if ($invoice->user_id != Auth::user()->id) {
            return response()->json(["message" => "Unauthorized access"], 403);
        }
        return response()->json(['message' => 'Invoices retrieved successfully', 'data' => $invoice->load('items')], 200);
    }

    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        if ($invoice->user_id != Auth::user()->id) {
            return response()->json(["message" => "Unauthorized access"], 403);
        }

        $validated = $request->validated();

        $invoice->update([
            'customer_id' => $validated['customer_id'] ?? $invoice->customer_id,
            'date' => $validated['date'] ?? $invoice->date,
        ]);

        if (isset($validated['items'])) {
            $totalQuantity = 0;
            $totalPrice = 0;

            $itemsToSync = [];
            foreach ($validated['items'] as $item) {
                $totalQuantity += $item['quantity'];
                $totalPrice += $item['quantity'] * $item['unit_price'];

                $itemsToSync[$item['item_code']] = [
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'line_total' => $item['quantity'] * $item['unit_price'],
                ];
            }
            $invoice->items()->sync($itemsToSync);

            $invoice->update([
                'total_quantity' => $totalQuantity,
                'total_price' => $totalPrice,
            ]);
        }
        return response()->json(['message' => 'Invoices retrieved successfully', 'data' => $invoice->load('items')], 200);
    }

    public function destroy(Invoice $invoice)
    {
        if ($invoice->user_id != Auth::user()->id) {
            return response()->json(["message" => "Unauthorized access"], 403);
        }
        $invoice->delete();
        return response()->json(['message' => 'Invoice deleted successfully'], 200);
    }

    public function bulkDelete(Request $request)
    {
        $ItemIds = $request->input('ids');
        $deletedCount = Invoice::whereIn('id', $ItemIds)
            ->where('user_id', auth()->id())
            ->delete();
        return response()->json([
            "message" => "$deletedCount customers deleted successfully"
        ], 200);
    }

    public function exportInvoices()
    {
        $query = Invoice::where('user_id', Auth::id());
        $columns = ['id', 'customer_id', 'total_quantity', 'total_price', 'date', 'created_at'];
        $headings = ["ID", "Customer ID", "Total Quantity", "Total Price", "Date", "Created At"];

        return Excel::download(new Export($query, $columns, $headings), 'invoices.xlsx');
    }
}
