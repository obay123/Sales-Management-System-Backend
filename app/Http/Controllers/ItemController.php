<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest\StoreItemRequest;
use App\Http\Requests\ItemRequest\UpdateItemRequest;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    function store(StoreItemRequest $request){
        $item = Item::create($request->validated());
        return response()->json($item,201);
     }
    
    
     function index (){
      $items =  Item::all();
      return response()->json($items,200);
     }
    
    
     function update(UpdateItemRequest $request,$itemId){
       $item =  Item::findOrFail($itemId);
       $item->update($request->validated());
       return response()->json($item , 200);
     }
    
    
     function show($itemId){
         $item = Item::find($itemId);
         return response()->json($item,200);
     }
    
    
    
     function destroy($itemId){
         $item =  Item::findOrFail($itemId);
         $item->delete();
         return response()->json(204);
     }
    
    
}
