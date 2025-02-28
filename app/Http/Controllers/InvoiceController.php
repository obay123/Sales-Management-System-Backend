<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest\StoreInvoiceRequest;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    // List all invoices
    public function index()
    {
        $invoices = Invoice::all();
        return response()->json($invoices);
    }

    // Create a new invoice
    public function store(StoreInvoiceRequest $request)
    {
        $totalQuantity = 0;
        $totalPrice    = 0;
        foreach ($request->validated()['items'] as $item) {
            $totalQuantity += $item['quantity'];
            $totalPrice    += $item['quantity'] * $item['unit_price'];
        }
        $invoice = Invoice::create([
            'customer_id'    => $request['customer_id'],
            'date'           => $request['date'] ?? now(),
            'total_quantity' => $totalQuantity,
            'total_price'    => $totalPrice
        ]);
        foreach ($request['items'] as $item) {
            $invoice->items()->attach($item['item_id'], [
                'quantity'   => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'line_total' => $item['quantity'] * $item['unit_price']
            ]);
        }
        return response()->json($invoice->load('items'), 201);
    }

    // Show a single invoice
    public function show($id)
    {
        $invoice = Invoice::findOrFail($id);
        return response()->json($invoice);
    }

    // Update an existing invoice
    public function update(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);

        $validated = $request->validate([
            'customer_id'    => 'sometimes|required|exists:customers,id',
            'total_quantity' => 'sometimes|required|integer',
            'price'          => 'sometimes|required|numeric',
            'date'           => 'sometimes|nullable|date'
        ]);

        if (isset($validated['price']) || isset($validated['total_quantity'])) {
            $price = $validated['price'] ?? $invoice->price;
            $quantity = $validated['total_quantity'] ?? $invoice->total_quantity;
            $validated['total_price'] = $price * $quantity;
        }

        $invoice->update($validated);
        return response()->json($invoice, 200);
    }

    // Delete an invoice
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();
        return response()->json(['message' => 'Invoice deleted successfully'], 204);
    }
}
