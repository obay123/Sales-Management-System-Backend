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
        $salesmen = Salesmen::all();
        return response()->json($salesmen,200);
    }
// 
    public function store(StoreSalesmenRequest $request)
    {
       $data = $request->validated();
       $salesman  = Salesmen::create($data);
       return response()->json($salesman,200);
    }
// 
    public function show($salesmen)
    {
        $salesman = Salesmen::findOrFail($salesmen);
        return response()->json($salesman,200);
    }

// 
    public function update(UpdateSalesmenRequest $request,  $salesmen)
    {
        $salesman  = Salesmen::findOrFail($salesmen);
        $salesman->update($request->validated());
        return response()->json($salesman,200);
    }
// 
    public function destroy($code)
    {
        $salesman = Salesmen::findOrFail($code);
        $salesman->delete();
        return response()->json(["message" => "Deleted successfully"],204);
    }
// 
    public function GetCustomers($code)
    {
       $customers =  Salesmen::findOrFail($code)->customers;
       return response()->json($customers,200);
    }
}
