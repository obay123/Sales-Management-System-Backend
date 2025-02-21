<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequests\StoreCustomerRequest;
use App\Http\Requests\CustomerRequests\UpdateCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
      $customers =  Customer::all();
      return response()->json( $customers,200);
    }

    public function store(StoreCustomerRequest $request)
    {
        $customer = Customer::create($request->validated());
        return response()->json($customer,201);
    }
    

    public function show($customerId)
    {
        $customer = Customer::findOrFail($customerId) ; 
        return response()->json( $customer,200);
    }

    
    public function update(UpdateCustomerRequest $request, $customerId)
    {
        $customer = Customer::findOrFail($customerId);
        $customer->update($request->validated());
        return response()->json($customer,200);
    }

   
    public function destroy($customerId)
    {
        $customer = Customer::findOrFail($customerId);
        $customer->delete();
        return response()->json(["message" => "Deleted successfully"],204);
    }
}
