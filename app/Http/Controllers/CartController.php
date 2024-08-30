<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function getCart(){
        $data = $this->_getCartData();
        $items = $data['items'];
        $carts = $data['carts'];
        $totalPrice = $data['totalPrice'];

        return view('cart', compact('items', 'carts', 'totalPrice'));
    }

    public function cartStore(Request $request){
        $item = Item::find($request->item_id);

        if ($request->quantity > $item->quantity) {
            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'quantity_' . $item->id => 'The quantity exceeds the available stock.'
                ]);
        }
        if ($request->quantity < 1) {
            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'quantity_' . $item->id => 'The quantity must be at least 1.'
                ]);
        }

        Cart::create([
            'quantity' => $request->quantity,
            'item_id' => $request->item_id,
            'user_id' => $request->user_id,
        ]);


        
        $item->quantity -= $request->quantity;
        $item->save();

        return redirect(route('getCart'));
    }

    public function deleteCart($id){
        $item = Cart::find($id);
        $item->item->quantity += $item->quantity;
        $item->item->save();

        Cart::destroy($id);
        return redirect(route('getCart'));
    }
    
    public function searchCarts(Request $request) {
        $search = $request->input('search');
        $data = $this->_getCartData($search);
        $items = $data['items'];
        $carts = $data['carts'];
        $totalPrice = $data['totalPrice'];

        return view('cart', compact('items', 'carts', 'totalPrice'));
    }

    private function _getCartData($search = null) {
        $userID = Auth::user()->id;
        $carts = Cart::where('user_id', $userID)->get();
        $items = Item::all();

        if ($search) {
            $items = Item::where('name', 'like', "%$search%")->get();
        }

        $totalPrice = 0;
        foreach ($carts as $cart) {
            $item = Item::find($cart->item_id);
            $totalPrice += $cart->quantity * $item->price;
        }

        return compact('items', 'carts', 'totalPrice');
    }
}
