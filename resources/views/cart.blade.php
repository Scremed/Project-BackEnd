<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cart</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    @extends('layouts.app')

    @section('content')
    <div class="container col-md-8" style="padding-top: 20px">
        <div class="card shadow">
            <div class="card-header text-center">{{ __('LIST OF ITEMS') }} </div>

            <div class="card-body">
                <div class="col-md-4" style="">
                    <form action="{{ route('searchCarts')}}" method="GET" class="input-group row">
                        <div class="input-group" style="">
                            <input type="text" class="form-control" name="search" placeholder="Search" value=""/>
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </form>
                <br>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Image</th>
                            <th scope="col">Item</th>
                            <th scope="col">Category</th>
                            <th scope="col">Price</th>
                            <th scope="col">Available</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Cart</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($items->isEmpty())
                        <p>No items found.</p>
                        @else
                        @foreach($items as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><img src="{{asset('storage/Image/'.$item->image)}}" alt="Error" style="height: 90px" ></td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->category->category_name}}</td>
                            <td>{{$item->price}}</td>
                            <td>{{$item->quantity}}</td>
                            <form action="{{ route('cartStore')}}" method="POST">
                                @CSRF
                                <input type="hidden" name="item_id" value="{{$item->id}}">
                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                <td>
                                    <input type="number" name="quantity" value="{{ old('quantity_' . $item->id, $item->quantity) }}" class="form-control" style="width: 60px;">
                                    @if ($errors->has('quantity_' . $item->id))
                                        <div class="text-danger">{{ $errors->first('quantity_' . $item->id) }}</div>
                                    @endif
                                </td>
                                <td><button type="submit" class="btn btn-success col-md" style="font-size: smaller;">Add To Cart</button></td>
                            </form>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="container col-md-6" style="padding-top: 20px">
        <div class="card shadow">
            <div class="card-header text-center">{{ __('CART') }} </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Item</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($carts as $cart)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$cart->item->name}}</td>
                            <td>{{$cart->item->price}}</td>
                            <td>{{$cart->quantity}}</td>
                            <td>{{$cart->item->price * $cart->quantity}}</td>
                            <td>
                                <form action="{{ route('deleteCart', ['id' => $cart->id])}}" method="POST">
                                    @CSRF
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger col-md">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div>
                    <h4>Total Price: {{$totalPrice}}</h4>
                    <form action="{{ route('storeInvoice')}}" method="POST">
                        @CSRF
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                        <input type="text" name="address" value="{{old('address')}}" class="form-control" placeholder="Address">
                        @error('address')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <input type="text" name="postal_code" value="{{old('postal_code')}}" class="form-control" placeholder="Postal Code">
                        @error('postal_code')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                        @if($carts->isEmpty())
                            <p class="text-warning">Your Cart is Empty</p>
                            <button type="submit" class="btn btn-primary col-md" disabled>Checkout</button>
                        @else
                            <button type="submit" class="btn btn-primary col-md">Checkout</button>
                        @endif
                    </form>
                </div>

            </div>
        </div>
    </div>
    @endsection
</body>
</html>