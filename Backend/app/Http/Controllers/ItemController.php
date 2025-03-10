<?php

namespace App\Http\Controllers;

use App\Exports\Export;
use App\Http\Requests\ItemRequest\StoreItemRequest;
use App\Http\Requests\ItemRequest\UpdateItemRequest;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ItemController extends Controller
{
    public function store(StoreItemRequest $request)
    {
        try {
            $user_id = Auth::id();
            $validatedData = $request->validated();
            $validatedData['user_id'] = $user_id;
            $item = Item::create($validatedData);
            return response()->json($item, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error adding item'], 500);
        }
    }


    function index()
    {
        $items = Auth::user()->items;
        if ($items->isEmpty()) {
            return response()->json(['message' => 'no items found'], 200);
        }
        return response()->json([
            'message' => 'items retrieved successfully',
            'data' => $items
        ], 200);
    }

    public function update(UpdateItemRequest $request, Item $item)
    {
        $user_id = Auth::user()->id;
        if ($item->user_id != $user_id) {
            return response()->json(
                [
                    'message' =>
                        'You are not authorized to update this item.'
                ],
                403
            );
        }
        $item->update($request->validated());
        return response()->json([
            'message' => 'Updated successfully',
            'data' => $item
        ], 200);
    }

    public function show(Item $item)
    {
        $user_id = Auth::user()->id;
        if ($item->user_id != $user_id) {
            return response()->json(
                [
                    'message'
                    => 'You are not authorized to view this item.'
                ],
                403
            );
        }
        return response()->json([
            'message' => 'item retrieved successfully',
            'data' => $item
        ], 200);
    }

    public function destroy(Item $item)
    {
        $user_id = Auth::user()->id;
        if ($item->user_id != $user_id) {
            return response()->json([
                'message' =>
                    'You are not authorized to delete this item.'
            ], 403);
        }
        $item->delete();
        return response()->json(['message' => 'Item deleted successfully.'], 200);
    }

    public function bulkDelete(Request $request)
    {
        $ItemIds = $request->input('ids');
        $deletedCount = Item::whereIn('id', $ItemIds)
            ->where('user_id', auth()->id())
            ->delete();
        return response()->json([
            "message" => "$deletedCount customers deleted successfully"
        ], 200);
    }

    public function exportItems()
    {
        $query = Item::where('user_id', Auth::id());
        $columns = ['code', 'name', 'description', 'created_at'];
        $headings = ["code", "Name", "Description", "Created At"];

        return Excel::download(new Export($query, $columns, $headings), 'items.xlsx');
    }
}
