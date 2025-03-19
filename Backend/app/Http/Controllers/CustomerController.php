<?php

namespace App\Http\Controllers;

use App\Exports\Export;
use App\Http\Requests\CustomerRequests\StoreCustomerRequest;
use App\Http\Requests\CustomerRequests\UpdateCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;


class CustomerController extends Controller
{
    public function index()
{
    $customers = Auth::user()->customers()->paginate(20);

    if ($customers->isEmpty()) {
        return response()->json(['message' => 'no customer found'], 200);
    }

    // Transform each customer in the paginated collection to add the full photo_url.
    $customers->getCollection()->transform(function ($customer) {
        $customer->photo_url = $customer->photo ? url('storage/' . $customer->photo) : null;
        return $customer;
    });

    return response()->json([
        'message' => 'customers retrieved successfully',
        'customers' => $customers
    ], 200);
}

    public function show(Customer $customer)
    {
        if ($customer->user_id != Auth::id()) {
            return response()->json(["message" => "Unauthorized access"], 403);
        }
        $customerData = $customer->toArray();
        $customerData['photo_url'] = $customer->photo ? url('storage/' . $customer->photo) : null;

        return response()->json([
            'message' => 'Retrieved successfully',
            'customer' => $customerData
        ], 200);
    }
    public function store(StoreCustomerRequest $request)
    {
        try {
            $user_id = Auth::id();
            $validatedData = $request->validated();
            $validatedData['user_id'] = $user_id;

            if ($request->hasFile('photo')) {
                $path = $request->file('photo')->store('customers_photos', 'public');
                $validatedData['photo'] = $path;
            }

            $customer = Customer::create($validatedData);

            // Manually build full URL
            $photo_url = $customer->photo ? url('storage/' . $customer->photo) : null;

            return response()->json([
                'message' => 'Customer added successfully',
                'data' => [
                    ...$customer->toArray(),
                    'photo_url' => $photo_url
                ]
            ], 201);
        } catch (\Exception $e) {
            \Log::error("Customer store error: " . $e->getMessage());

            return response()->json([
                'error' => 'Something went wrong!',
                'details' => $e->getMessage()
            ], 500);
        }
    }


    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        if ($customer->user_id != Auth::user()->id) {
            return response()->json(["message" => "Unauthorized access"], 403);
        }
        $customer->update($request->validated());
        return response()->json(["message" => "Customer updated successfully", 'customer' => $customer], 200);
    }

    public function destroy(Customer $customer)
    {
        if ($customer->user_id != Auth::user()->id) {
            return response()->json(["message" => "Unauthorized access"], 403);
        }
        $customer->delete();
        return response()->json(["message" => "Customer deleted successfully"], 200);
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
    public function getCustomerNames()
    {
        $customers = Auth::user()->customers->select('name', 'id');
        if ($customers->isEmpty()) {
            return response()->json(['message' => 'no customer found'], 200);
        }
        return response()->json([
            'message' => 'customers retrieved successfully',
            'customers' => $customers
        ], 200);
    }
}
