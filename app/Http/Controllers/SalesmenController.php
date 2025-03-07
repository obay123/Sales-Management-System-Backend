<?php

namespace App\Http\Controllers;

use App\Exports\Export;
use App\Http\Requests\SalesmenRequests\StoreSalesmenRequest;
use App\Http\Requests\SalesmenRequests\UpdateSalesmenRequest;
use App\Models\Salesmen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class SalesmenController extends Controller
{
    public function index()
    {
        $salesmen = Auth::user()->salesmen()->paginate(20);
        return response()->json($salesmen, 200);
    }

    public function store(StoreSalesmenRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::user()->id;
        $salesman = Salesmen::create($data);
        return response()->json($salesman, 201);
    }

    public function show(Salesmen $salesman)
    {
        if ($salesman->user_id != Auth::user()->id) {
            return response()->json(["message" => "Unauthorized access"], 403);
        }
        return response()->json($salesman, 200);
    }

    public function update(UpdateSalesmenRequest $request, Salesmen $salesman)
    {
        if ($salesman->user_id != Auth::user()->id) {
            return response()->json(["message" => "Unauthorized access"], 403);
        }
        $salesman->update($request->validated());
        return response()->json($salesman, 200);
    }

    public function destroy(Salesmen $salesman)
    {
        if ($salesman->user_id != Auth::user()->id) {
            return response()->json(["message" => "Unauthorized access"], 403);
        }
        $salesman->delete();
        return response()->json(null, 204);
    }

    public function exportSalesmen()
    {
        $query = Salesmen::where('user_id', Auth::id());
        $columns = ['code','name', 'phone', 'address', 'is_inactive', 'created_at'];
        $headings = ["code", "Name", "Phone", "Aadress", "Is Inactive","Created At"];
    
        return Excel::download(new Export($query, $columns, $headings), 'salesmen.xlsx');
    }
    

    // public function getCustomers(Salesmen $salesman)
    // {
    //     if ($salesman->user_id != Auth::user()->id) {
    //         return response()->json(["message" => "Unauthorized access"], 403);
    //     }
    //     $customers = $salesman->customers;

    //     if ($customers->isEmpty()) {
    //         return response()->json(["message" =>
    //          "No customers found for this salesman"], 200);
    //     }
    //     return response()->json($customers, 200);
    // }
}
