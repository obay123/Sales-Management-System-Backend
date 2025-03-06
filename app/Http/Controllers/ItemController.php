<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest\StoreItemRequest;
use App\Http\Requests\ItemRequest\UpdateItemRequest;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    function store(StoreItemRequest $request)
    {
        $user_id = Auth::user()->id;
        $validatedData = $request->validated();
        $validatedData['user_id'] = $user_id;
        $item = Item::create($validatedData);
        return response()->json($item, 201);
    }

    function index()
    {
        $items = Auth::user()->items()->paginate(20);
        return response()->json($items, 200);
    }

    public function update(UpdateItemRequest $request, Item $item)
    {
        $user_id = Auth::user()->id;
        if ($item->user_id != $user_id) {
            return response()->json(
                ['message' =>
                'You are not authorized to update this item.'],
                403
            );
        }
        $item->update($request->validated());
        return response()->json($item, 200);
    }

    public function show(Item $item)
    {
        $user_id = Auth::user()->id;
        if ($item->user_id != $user_id) {
            return response()->json(
                ['message'
                => 'You are not authorized to view this item.'],
                403
            );
        }
        return response()->json($item, 200);
    }

    public function destroy(Item $item)
    {
        $user_id = Auth::user()->id;
        if ($item->user_id != $user_id) {
            return response()->json(['message' =>
            'You are not authorized to delete this item.'], 403);
        }
        $item->delete();
        return response()->json(['message' => 'Item deleted successfully.'], 204);
    }
}
