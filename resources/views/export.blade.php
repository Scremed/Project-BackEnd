<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .card {
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
        }
        .card-header {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            text-align: center;
            font-size: 1.25rem;
            border-bottom: 1px solid #dee2e6;
        }
        .card-body {
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #dee2e6;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        h2 {
            text-align: right;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">{{ __('Invoice Number: ') }} {{$invoiceData['invoice_number']}} </div>
            <div class="card-body">
                <table>
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
            </div>
        </div>
    </div>
</body>
</html>