<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>UPDATE FORM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
    @extends('layouts.app')

    @section('content')
    <div class="container col-md-6" style="padding-top: 20px">
        <div class="card shadow">
        <div class="card-header text-center">{{ __('UPDATE ITEM') }} </div>
            <div class="card-body">
                <form action="{{ route('updateItem', ['id' => $item->id])}}" method="POST" enctype="multipart/form-data">
                    @CSRF
                    @method('patch')
                    <div class="mb-3">
                        <label for="name" class="form-label">Item Name</label>
                        <input name="name" value="{{$item->name}}" type="text" class="form-control" id="formGroupExampleInput" placeholder="Input Item">
                        @error('name')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Price of Item</label>
                        <input name="price" value="{{$item->price}}" type="number" class="form-control" id="formGroupExampleInput" placeholder="Input price">
                        @error('price')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input name="quantity" value="{{$item->quantity}}" type="number" class="form-control" id="formGroupExampleInput" placeholder="Input quantity">
                        @error('quantity')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select name="category_id" id="">
                            @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->category_name}}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        @if($item->image)
                        <img src="{{ asset('storage/image/' . $item->image) }}" alt="Item Image" class="img-thumbnail">
                        @endif

                        <input name="image" type="file" class="form-control" id="formGroupExampleInput" placeholder="Upload image">
                        @error('image')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success">Insert</button>

                </form>
            </div>
        </div>
    </div>
    @endsection
</body>
</html>