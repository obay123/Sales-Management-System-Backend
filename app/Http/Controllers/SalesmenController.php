<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalesmenRequests\StoreSalesmenRequest;
use App\Http\Requests\SalesmenRequests\UpdateSalesmenRequest;
use App\Models\Salesmen;
use Illuminate\Http\Request;

class SalesmenController extends Controller
{
    public function index()
    {
        $salesmen = Salesmen::paginate(10); 
        return response()->json($salesmen, 200);
    }

    public function store(StoreSalesmenRequest $request)
    {
        $salesman = Salesmen::create($request->validated());
        return response()->json($salesman, 201);
    }

    public function show(Salesmen $salesman) 
    {
        return response()->json($salesman, 200);
    }

    public function update(UpdateSalesmenRequest $request, Salesmen $salesman) 
    {
        $salesman->update($request->validated());
        return response()->json($salesman, 200);
    }

    public function destroy(Salesmen $salesman) 
    {
        $salesman->delete();
        return response()->json(null, 204); 
    }

    public function getCustomers(Salesmen $salesman) 
    {
        $customers = $salesman->customers;

        if ($customers->isEmpty()) {
            return response()->json(["message" => "No customers found for this salesman"], 200);
        }

        return response()->json($customers, 200);
    }
}
