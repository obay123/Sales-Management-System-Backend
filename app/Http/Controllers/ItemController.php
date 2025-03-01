<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest\StoreItemRequest;
use App\Http\Requests\ItemRequest\UpdateItemRequest;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    function store(StoreItemRequest $request)
    {
        $item = Item::create($request->validated());
        return response()->json($item, 201);
    }

    function index()
    {
        $items = Item::paginate(10); 
        return response()->json($items, 200);
    }

    function update(UpdateItemRequest $request, Item $item)
    {
        $item->update($request->validated());
        return response()->json($item, 200);
    }

    function show(Item $item)
    {
        return response()->json($item, 200);
    }

    function destroy(Item $item)
    {
        $item->delete();
        return response()->json(['message' => 'Item deleted successfully'], 204);
    }
}
