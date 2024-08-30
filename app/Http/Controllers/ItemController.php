<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\ItemRequest;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function getCreatePage(){
        $categories = Category::all();

        return view('create', compact('categories'));
    }

    public function createItem(ItemRequest $request){
        $userName = Auth::user()->name;

        $extension = $request->file('image')->getClientOriginalExtension();
        $fileName = $userName . '_' . time() . '.' . $extension;//rename image
        $request->file('image')->storeAs('public/image/', $fileName);//save image

        Item::create([
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'category_id' => $request->category_id,
            'image' => $fileName,
        ]);

        return redirect(route('getItems'));
    }

    public function getItems(){
        $items = Item::with('category')->get();
        $categories = Category::with('item')->get();

        return view('view', compact('items', 'categories'));
    }

    public function createCategory(Request $request){
        $category = Category::create([
            'category_name' => $request->category_name,
        ]);

        return redirect('/create');
    }

    public function updateItem(ItemRequest $request, $id){
        $userName = Auth::user()->name;
        $item = Item::find($id);

        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileName = $userName . '_' . time() . '.' . $extension;//rename image
            $request->file('image')->storeAs('public/image/', $fileName);//save image
        }

        $item->update([
            'name' => $request->input('name', $item->name),
            'price' => $request->input('price', $item->price),
            'quantity' => $request->input('quantity', $item->quantity),
            'category_id' => $request->input('category_id', $item->category_id),
            'image' => $item->image,
        ]);

        return redirect(route('getItems'));
    }

    public function getItemById($id){
        $categories = Category::all();
        $item = Item::find($id);

        return view('update', compact('item', 'categories'));
    }

    public function searchItems(Request $request) {
        $search = $request->input('search');
        $items = Item::where('name', 'like', "%$search%")->get();

        return view('view', compact('items'));
    }

    public function deleteItem($id){
        Item::destroy($id);

        return redirect(route('getItems'));
    }
}