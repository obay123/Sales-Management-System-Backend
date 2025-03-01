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
        $invoices = Invoice::with('items')->get();
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

        $itemsToAttach = [];
        foreach ($validated['items'] as $item) {
            $itemsToAttach[$item['item_code']] = [
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'line_total' => $item['quantity'] * $item['unit_price'],
            ];
        }
        $invoice->items()->attach($itemsToAttach);

        return response()->json($invoice->load('items'), 201);
    }

    // Show a single invoice
    public function show(Invoice $invoice)
    {
        return response()->json($invoice->load('items'));
    }

    // Update an existing invoice
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
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

        return response()->json($invoice->load('items'), 200);
    }

    // Delete an invoice
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return response()->json(['message' => 'Invoice deleted successfully'], 200);
    }
}
