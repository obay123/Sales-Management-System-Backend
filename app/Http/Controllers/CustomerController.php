<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequests\StoreCustomerRequest;
use App\Http\Requests\CustomerRequests\UpdateCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Auth::user()->customers;
        return response()->json($customers, 200);
    }

    public function store(StoreCustomerRequest $request)
    {
        $user_id = Auth::user()->id;
        $validatedData = $request->validated();
        $validatedData['user_id'] = $user_id;
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
}
