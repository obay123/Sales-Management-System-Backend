<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequests\StoreCustomerRequest;
use App\Http\Requests\CustomerRequests\UpdateCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // List all customers
    public function index()
    {
        $customers = Customer::paginate(10);
        return response()->json($customers, 200);
    }

    // Create a new customer
    public function store(StoreCustomerRequest $request)
    {
        $customer = Customer::create($request->validated());
        return response()->json($customer, 201);
    }
    
    // Show a single customer
    public function show(Customer $customer) 
    {
        return response()->json($customer, 200);
    }

    // Update an existing customer
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->validated());
        return response()->json($customer, 200);
    }

    // Delete a customer
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->json(["message" => "Deleted successfully"], 200); 
    }
}
