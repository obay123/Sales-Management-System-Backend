<?php

namespace App\Http\Controllers;

use App\Exports\Export;
use App\Http\Requests\CustomerRequests\StoreCustomerRequest;
use App\Http\Requests\CustomerRequests\UpdateCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;


class CustomerController extends Controller
{
    public function index()
    {
        $customers = Auth::user()->customers()->paginate(20);
        return response()->json($customers, 200);
    }

    public function store(StoreCustomerRequest $request)
    {
        $user_id = Auth::user()->id;
        $validatedData = $request->validated();
        $validatedData['user_id'] = $user_id;
        if($request->hasFile('photo')){
            $path = $request->file('photo')->store('customers photo','public');
            $validatedData['photo'] = $path ;
        }
        $customer = Customer::create($validatedData);
        return response()->json($customer, 201);
    }

    public function show(Customer $customer)
    {
        if ($customer->user_id != Auth::user()->id) {
            return response()->json(["message" => "Unauthorized access"], 403);
        }
        return response()->json($customer, 200);
    }

    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        if ($customer->user_id != Auth::user()->id) {
            return response()->json(["message" => "Unauthorized access"], 403);
        }
        $customer->update($request->validated());
        return response()->json($customer, 200);
    }

    public function destroy(Customer $customer)
    {
        if ($customer->user_id != Auth::user()->id) {
            return response()->json(["message" => "Unauthorized access"], 403);
        }
        $customer->delete();
        return response()->json(["message" => "Deleted successfully"], 200);
    }

    public function bulkDelete(Request $request)
    {
        $customerIds = $request->input('ids');
        $deletedCount = Customer::whereIn('id', $customerIds)
        ->where('user_id', auth()->id())
        ->delete();
        return response()->json([
            "message" => "$deletedCount customers deleted successfully"
        ], 200);
    }

    public function exportCustomers()
    {
        $query = Customer::where('user_id', Auth::id());
        $columns = ['id', 'name', 'salesmen_code', 'tel1', 'tel2', 'address', 'gender', 'subscription_date', 'rate', 'tags', 'created_at'];
        $headings = ["ID", "Name", "Salesmen Code", "Tel1", "Tel2", "Address", "Gender", "Subscription Date", "Rate", "Tags", "Created At"];
    
        return Excel::download(new Export($query, $columns, $headings), 'customers.xlsx');

    }
}
