<!DOCTYPE html>
<html>
<head>
    <title>Cart Test</title>
</head>
<body>
    <h1>Cart ID: {{ $cart->id }}</h1>

    <h2>Products in Cart:</h2>
    <ul>
        @foreach ($cart->products as $product)
            <li>
                {{ $product->name }} - Quantity: {{ $product->pivot->quantity }}
            </li>
        @endforeach
    </ul>
</body>
</html>
