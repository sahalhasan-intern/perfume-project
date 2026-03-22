@extends('layouts.app')

@section('content')
    <h1>Admin — Products</h1>
    <p><a href="{{ route('admin.products.create') }}">Create product</a></p>

    <table style="width:100%;border-collapse:collapse">
        <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td style="text-align:right">${{ number_format($product->price,2) }}</td>
                    <td style="text-align:right">{{ $product->stock }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top:1rem">{{ $products->links() }}</div>
@endsection
