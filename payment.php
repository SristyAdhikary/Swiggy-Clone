<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Decode the JSON cart data
    $cart_items = json_decode($_POST['cart_items'], true);
    $subtotal = floatval($_POST['subtotal']);
    $tax = floatval($_POST['tax']);
    $delivery_fee = floatval($_POST['delivery_fee']);
    $total = floatval($_POST['total']);
    $address = htmlspecialchars($_POST['address']);
    $save_address = isset($_POST['save_address']) ? 'Yes' : 'No';
    $payment_method = htmlspecialchars($_POST['payment_method']);

    // Handle the payment processing based on the selected method
    $payment_status = 'Pending'; // Default payment status

    // Check if the payment method is 'cash_on_delivery'
    if (strtolower($payment_method) === 'cash_on_delivery') {
        $payment_status = 'Cash on Delivery'; // No actual payment processing for COD
    } else {
        // For other payment methods, assume payment is successful for demonstration
        $payment_status = 'Successful'; // Update to 'Failed' if payment fails
    }

    // Generate a unique order ID (for demonstration, use a random unique ID)
    $order_id = uniqid(); // Replace this with actual database storage logic

    // Here, you would typically save the order details into a database
    // For example: saveOrderToDatabase($order_id, $cart_items, $subtotal, $tax, $delivery_fee, $total, $address, $payment_status);

    // Create a simple receipt or confirmation message
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Swiggy Payment Confirmation</title>
    <link rel="icon" href="./assests/logo.avif" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            margin: 0;
            padding: 0;
        }
        .confirmation-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .details {
            margin-bottom: 20px;
        }
        .details p {
            margin: 10px 0;
            font-size: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .details p.line {
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        .address-section {
            margin-top: 20px;
        }
        .address-section h3 {
            margin-bottom: 10px;
        }
        .img {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 40px;
        }
        .img img {
            max-width: 100%;
            height: auto;
        }
        .text-center a {
            color: green;
            font-weight: bold;
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
        }

        
        .icon {
            margin-left: 8px; /* Space between text and icon */
            animation: bounce 0.5s infinite alternate; /* Animation for icon */
        }
        @keyframes bounce {
            0% { transform: translateY(0); }
            100% { transform: translateY(-3px); }
        }
    </style>
</head>
<body>
    <div class="img">
        <img src="./assests/Screenshot 2024-09-09 210419.png" alt="">
    </div>
    <div class="confirmation-container">
        <h2>Payment Confirmation</h2>
        <div class="details">
            <h3>Order Summary</h3>
            <p><strong>Subtotal:</strong> ₹<?php echo number_format($subtotal, 2); ?></p>
            <p><strong>Tax:</strong> ₹<?php echo number_format($tax, 2); ?></p>
            <p><strong>Delivery Fee:</strong> ₹<?php echo number_format($delivery_fee, 2); ?></p>
            <p><strong>Total:</strong> ₹<?php echo number_format($total, 2); ?></p>
            <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($payment_method); ?></p>
            <p><strong>Payment Status:</strong> <?php echo $payment_status; ?></p>
        </div>
        
        <div class="address-section">
            <h3>Delivery Address</h3>
            <p><?php echo nl2br($address); ?></p>
            <p><strong>Save Address:</strong> <?php echo $save_address; ?></p>
        </div>

        <div class="text-center">
            <a href="order_tracking.php?order_id=<?php echo $order_id; ?>" class="button">Track Your Order <i class="fas fa-utensils icon"></i></a>
        </div>
    </div>
</body>
</html>
<?php
} else {
    // If accessed directly, redirect to the home page or show an error
    header("Location: index.php");
    exit;
}
?>