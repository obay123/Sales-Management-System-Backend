<?php

namespace App\Http\Controllers;

use App\Exports\Export;
use App\Http\Requests\ItemRequest\StoreItemRequest;
use App\Http\Requests\ItemRequest\UpdateItemRequest;
use App\Models\Item;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

use function Laravel\Prompts\error;

class ItemController extends Controller
{
    public function store(StoreItemRequest $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            $validatedData = $request->validated();
            $validatedData['user_id'] = $user->id;
            $item = Item::create($validatedData);
            
            return response()->json($item, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error adding item', 'error' => $e->getMessage()], 500);
        }
    }


    function index()
    {
        $items = Auth::user()->items()->paginate(10);
        if ($items->isEmpty()) {
            return response()->json(['message' => 'no items found'], 200);
        }
        return response()->json([
            'message' => 'items retrieved successfully',
            'items' => $items
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
            'message' => 'Item Updated successfully',
            'item' => $item
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
            'message' => 'Item retrieved successfully',
            'item' => $item
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
