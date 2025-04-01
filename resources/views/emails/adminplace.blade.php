<!DOCTYPE html>
<html>

<head>
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: sans-serif;
            line-height: 1.6;
            margin: 20px;
        }

        .header {
            background-color: #f0f0f0;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }

        .order-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .order-table th,
        .order-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .order-table th {
            background-color: #f2f2f2;
        }

        .status-pending {
            color: orange;
        }

        .status-processing {
            color: yellow;
        }

        .status-submitted {
            color: lightgreen;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Order Confirmation</h2>
        <p>Thank you for placing your order!</p>
    </div>

    <table class="order-table">
        <tr>
            <th colspan="2">
                <h3>Order Details:</h3>
            </th>
        </tr>
        <tr>
            <th>Customer ID:</th>
            <td>{{ $order->customer_id }}</td>
        </tr>
        <tr>
            <th>Quantity:</th>
            <td>{{ $order->quantity }}</td>
        </tr>
        <tr>
            <th>Cheque Name</th>
            <td>{{ $order->chequeCategory->chequeName }}</td>
        </tr>
        <tr>
            <th>Cheque Price</th>
            <td>${{ $order->chequeCategory->price  }}</td>
        </tr>
        <tr>
            <th>Color:</th>
            <td>{{ $order->color }}</td>
        </tr>
        <tr>
            <th>Company Info:</th>
            <td>{{ $order->company_info ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Cheque Start Number:</th>
            <td>{{ $order->cheque_start_number ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Cheque End Number:</th>
            <td>{{ $order->cheque_end_number ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Cart Quantity:</th>
            <td>{{ $order->cart_quantity }}</td>
        </tr>
        <tr>
            <th>Cheque Category ID:</th>
            <td>{{ $order->cheque_category_id }}</td>
        </tr>
        <tr>
            <th>Order Status:</th>
            <td class="
                    @if($order->order_status === 'pending') status-pending
                    @elseif($order->order_status === 'processing') status-processing
                    @elseif($order->order_status === 'submitted') status-submitted
                    @endif
                ">
                {{ $order->order_status }}
            </td>
        </tr>
        <tr>
            <th>Balance Status:</th>
            <td>{{ $order->balance_status }}</td>
        </tr>
        <tr>
            <th>Reorder:</th>
            <td>{{ $order->reorder ? 'Yes' : 'No' }}</td>
        </tr>
    </table>

    <p>We appreciate your business!</p>

</body>

</html>