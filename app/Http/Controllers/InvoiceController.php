<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest\StoreInvoiceRequest;
use App\Http\Requests\InvoiceRequest\UpdateInvoiceRequest;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Auth::user()->invoices->with('items')->get()->paginate(20);
        return response()->json($invoices);
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
        return response()->json($invoice->load('items'), 201);
    }

    public function show(Invoice $invoice)
    {
        if ($invoice->user_id != Auth::user()->id) {
            return response()->json(["message" => "Unauthorized access"], 403);
        }
        return response()->json($invoice->load('items'));
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
        return response()->json($invoice->load('items'), 200);
    }

    public function destroy(Invoice $invoice)
    {
        if ($invoice->user_id != Auth::user()->id) {
            return response()->json(["message" => "Unauthorized access"], 403);
        }
        $invoice->delete();
        return response()->json(['message' => 'Invoice deleted successfully'], 200);
    }
}
