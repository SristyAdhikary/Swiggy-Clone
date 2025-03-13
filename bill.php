<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Decode the JSON cart data
    $cart_items = json_decode($_POST['cart_items'], true);
    $subtotal = floatval($_POST['subtotal']);

    // Calculate any additional charges (e.g., tax, delivery fees)
    $tax_rate = 0.05; // 5% tax
    $tax = $subtotal * $tax_rate;
    $delivery_fee = 50; // Flat delivery fee
    $total = $subtotal + $tax + $delivery_fee;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Swiggy Bill</title>
    <link rel="icon" href="./assests/logo.avif" type="image/png">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .bill-container {
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
            color: #333;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .bill-details, .ordered-items {
            margin-top: 20px;
        }
        .bill-details h3, .ordered-items h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .bill-details p, .ordered-items p {
            margin: 10px 0;
            font-size: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .bill-details p.line, .ordered-items p.line {
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        .address-section, .payment-section {
            margin-top: 20px;
        }
        .address-section h3, .payment-section h3 {
            margin-bottom: 10px;
        }
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            margin-bottom: 10px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        input[type="checkbox"] {
            margin-right: 5px;
        }
        .proceed-btn {
            display: block;
            padding: 12px 20px;
            background-color: #ff8c00;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            text-align: center;
            transition: background-color 0.3s ease;
        }
        .proceed-btn:hover {
            background-color: #e57b00;
        }
        .payment-options {
            margin-top: 10px;
        }
        .payment-option {
            margin-bottom: 10px;
        }
        .payment-option input {
            margin-right: 10px;
        }
    </style>
</head>
<body>


    <div class="bill-container">
        <h2>Your Bill</h2>
        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart_items as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                        <td>₹<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="bill-details">
            <h3>Bill Details</h3>
            <p class="line"><span>Item Total</span> <span>₹<?php echo number_format($subtotal, 2); ?></span></p>
            <p class="line"><span>Delivery Fee | 1.4 kms</span> <span>₹41.00</span></p>
            <p class="line"><span>Platform Fee</span> <span>₹27.01</span></p>
            <p class="line"><span>GST and Restaurant Charges</span> <span>₹18.53</span></p>
            <p><strong>TO PAY</strong> <strong>₹<?php echo number_format($total, 2); ?></strong></p>
        </div>
        
        <div class="address-section">
            <h3>Delivery Address</h3>
            <form action="payment.php" method="POST">
                <textarea id="address" name="address" rows="4" placeholder="Enter your delivery address" required></textarea>
                <div class="form-group">
                    <input type="checkbox" id="save-address" name="save_address">
                    <label for="save-address">Save this address for future orders</label>
                </div>
                
                <!-- Payment Section -->
                <div class="payment-section">
                    <h3>Select Payment Method</h3>
                    <div class="payment-options">
                        <div class="payment-option">
                            <input type="radio" id="cash-on-delivery" name="payment_method" value="cash_on_delivery" required>
                            <label for="cash-on-delivery">Cash on Delivery</label>
                        </div>
                        <div class="payment-option">
                            <input type="radio" id="credit-card" name="payment_method" value="credit_card">
                            <label for="credit-card">Credit Card</label>
                        </div>
                        <div class="payment-option">
                            <input type="radio" id="debit-card" name="payment_method" value="debit_card">
                            <label for="debit-card">Debit Card</label>
                        </div>
                        <div class="payment-option">
                            <input type="radio" id="paypal" name="payment_method" value="paypal">
                            <label for="paypal">PayPal</label>
                        </div>
                    </div>
                </div>

                <!-- Hidden inputs to pass cart data to the next step -->
                <input type="hidden" name="cart_items" value='<?php echo json_encode($cart_items); ?>'>
                <input type="hidden" name="subtotal" value="<?php echo $subtotal; ?>">
                <input type="hidden" name="tax" value="<?php echo $tax; ?>">
                <input type="hidden" name="delivery_fee" value="<?php echo $delivery_fee; ?>">
                <input type="hidden" name="total" value="<?php echo $total; ?>">
                <!-- Proceed Button -->
                <button type="submit" class="proceed-btn">Proceed to Payment</button>
            </form>
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
