<!DOCTYPE html>
<html>
<head>
    <title>Order Placed Successfully</title>
</head>

<style>
      table {
            width: 50%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
</style>

<body>
    <h2>Order Confirmation</h2>
    <p>Your order has been placed successfully.</p>
    <td><h3>Order Details:</h3></td> 
    <table>
        <thead>
          
        </thead>

        <tbody>
            <tr>
                <td><strong>Customer ID:</strong> </td>
                <td>{{ $order->customer_id }} </td>
            </tr>
            <tr>
                <td><strong>Quantity:</strong></td>
                <td>{{ $order->quantity }} </td>
            </tr>
            <tr>
                <td><strong>Color:</strong> </td>
                <td>{{ $order->color }} </td>
            </tr>
            <tr>
                <td><strong>Company Info:</strong> </td>
                <td>{{ $order->company_info ?? 'N/A' }} </td>
            </tr>
            <tr>
                <td><strong>Cheque Start Number::</strong> </td>
                <td>{{ $order->cheque_start_number ?? 'N/A' }} </td>
            </tr>
            <tr>
                <td><strong>Customer ID:</strong> </td>
                <td>{{ $order->customer_id }} </td>
            </tr>
            <tr>
                <td><strong>Cheque End Number:</strong> </td>
                <td>{{ $order->cheque_end_number ?? 'N/A' }} </td>
            </tr>
            <tr>
                <td><strong>Cart Quantity:</strong> </td>
                <td>{{ $order->cart_quantity }} </td>
            </tr>
            <tr>
                <td><strong>Cheque Category ID:</strong> </td>
                <td>{{ $order->cheque_category_id }} </td>
            </tr>

            <tr>
                <td><strong>Order Status:</strong> </td>
                <td>{{ $order->order_status }} </td>
            </tr>
            <tr>
                <td><strong>Balance Status:</strong> </td>
                <td>{{ $order->balance_status }}< </td>
            </tr>
            <tr>
                <td><strong>Reorder:</strong> </td>
                <td>{{ $order->reorder ? 'Yes' : 'No' }}</td>
            </tr>
        </tbody>

    </table>


    <p>Thank you for your order!</p>
</body>
</html>