<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    @extends('layouts.app')

    @section('content')
    <div class="container col-md-8" style="padding-top: 20px">
        <div class="card shadow">
            <div class="card-header text-center">{{ __('Invoice Number: ') }} {{$invoiceData['invoice_number']}} </div>

            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Item Name</th>
                            <th scope="col">Category</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Price</th>
                            <th scope="col">SubTotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoiceData['items'] as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item['name']}}</td>
                            <td>{{$item['category']}}</td>
                            <td>{{$item['quantity']}}</td>
                            <td>{{$item['price']}}</td>
                            <td>{{$item['quantity'] * $item['price']}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <h2>Total Price: {{ $invoiceData['total_price'] }}</h2>
                <a href="{{ route('exportPDF', $invoiceData['invoice_id']) }}" class="btn btn-primary">Export to PDF</a>
            </div>
        </div>
    </div>
    @endsection
</body>
</html>