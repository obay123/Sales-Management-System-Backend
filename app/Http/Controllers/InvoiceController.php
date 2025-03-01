<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest\StoreInvoiceRequest;
use App\Http\Requests\InvoiceRequest\UpdateInvoiceRequest;
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
        $validated = $request->validated();
        $totalQuantity = 0;
        $totalPrice = 0;

        foreach ($validated['items'] as $item) {
            $totalQuantity += $item['quantity'];
            $totalPrice += $item['quantity'] * $item['unit_price'];
        }

        $invoice = Invoice::create([
            'customer_id' => $validated['customer_id'],
            'date' => $validated['date'] ?? now(),
            'total_quantity' => $totalQuantity,
            'total_price' => $totalPrice,
        ]);

        foreach ($validated['items'] as $item) {
            $invoice->items()->attach($item['item_code'], [
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'line_total' => $item['quantity'] * $item['unit_price'],
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
    public function update(UpdateInvoiceRequest $request, $id)
    {
        $invoice = Invoice::findOrFail($id);

        $validated = $request->validated();

        $invoice->update([
            'customer_id' => $validated['customer_id'] ?? $invoice->customer_id,
            'date' => $validated['date'] ?? $invoice->date,
        ]);

        if (isset($validated['items'])) {
            $totalQuantity = 0;
            $totalPrice = 0;

            $invoice->items()->detach();

            foreach ($validated['items'] as $item) {
                $totalQuantity += $item['quantity'];
                $totalPrice += $item['quantity'] * $item['unit_price'];

                $invoice->items()->attach($item['item_code'], [
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'line_total' => $item['quantity'] * $item['unit_price'],
                ]);
            }
            $invoice->update([
                'total_quantity' => $totalQuantity,
                'total_price' => $totalPrice,
            ]);
        }
        return response()->json($invoice->load('items'), 200);
    }
    
    // Delete an invoice
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();
        return response()->json(['message' => 'Invoice deleted successfully'], 204);
    }
}
