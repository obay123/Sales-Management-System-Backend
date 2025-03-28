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
        return response()->json(['message' => 'Salesman retrieved successfully'
        , 'salesmen' => $salesmen], 200);
    }

    public function store(StoreSalesmenRequest $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            $validatedData = $request->all(); // Use all() instead of validated()
            $validatedData['user_id'] = $user->id;
            $salesman = Salesmen::create($validatedData);

            return response()->json($salesman, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error adding salesman', 'error' => $e->getMessage()], 500);
        }
    }
    public function show(Salesmen $salesman)
    {
        if ($salesman->user_id != Auth::user()->id) {
            return response()->json(["message" => "Unauthorized access"], 403);
        }
        return response()->json([
            'message' => 'retrieved successfully',
            'salesmen' => $salesman
        ], 200);
    }

    public function update(UpdateSalesmenRequest $request, Salesmen $salesman)
    {
        if ($salesman->user_id != Auth::user()->id) {
            return response()->json(["message" => "Unauthorized access"], 403);
        }
        $salesman->update($request->validated());
        return response()->json(["message" => "Salesman updated successfully"
        , 'salesmen' => $salesman], 200);
    }

    public function destroy(Salesmen $salesman)
    {
        if ($salesman->user_id != Auth::user()->id) {
            return response()->json(["message" => "Unauthorized access"], 403);
        }
        $salesman->delete();
        return response()->json(["message" => "Salesman deleted successfully"], 200);
    }

    public function bulkDelete(Request $request)
    {
        $ItemIds = $request->input('ids');
        $deletedCount = Salesmen::whereIn('code', $ItemIds)
            ->where('user_id', auth()->id())
            ->delete();
        return response()->json([
            "message" => "$deletedCount customers deleted successfully"
        ], 200);
    }

    public function exportSalesmen()
    {
        $query = Salesmen::where('user_id', Auth::id());
        $columns = ['code', 'name', 'phone', 'address', 'is_inactive', 'created_at'];
        $headings = ["code", "Name", "Phone", "Aadress", "Is Inactive", "Created At"];

        return Excel::download(new Export($query, $columns, $headings), 'salesmen.xlsx');
    }
    public function getSalesmenName()
    {
        $salesmen = Auth::user()->salesmen()->select('code', 'name')->get();

        if ($salesmen->isEmpty()) {
            return response()->json(['message' => 'no salesmen found'], 200);
        }

        return response()->json([
            'message' => 'salesmen retrieved successfully',
            'salesmen' => $salesmen
        ], 200);
    }

}
