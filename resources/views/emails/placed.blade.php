<!DOCTYPE html>
<html>
<head>
    <title>Order Placed</title>
</head>
<body>
    <h2>Order Confirmation</h2>
    <p>Your order has been successfully placed. Order details:</p>
    <ul>
        <li>Order ID: {{ $order->id }}</li>
        <li>Order Total: {{ $order->quantity }}</li>
    </ul>
    <p>Thank you for your purchase!</p>
</body>
</html>
