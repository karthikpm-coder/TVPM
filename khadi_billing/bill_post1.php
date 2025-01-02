<?php
include 'db_connection.php';

// Database connection
$conn = mysqli_connect("localhost", "root", "", "khadi");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_mobile = $_POST['customer_mobile'];

    // Generate a unique invoice number (e.g., timestamp-based or auto-increment)
    $invoice_number = time();

    // Arrays for multiple products
    $product_codes = $_POST['product_code'];
    $quantities = $_POST['qty'];
    $prices = $_POST['price'];
    $gst_percentages = $_POST['gst_per'];
    $discounts = $_POST['discount'];

    // Variable to store total bill amount
    $total_bill_amount = 0;

    // Loop through products to calculate the individual total and sum them up
    foreach ($product_codes as $index => $product_code) {
        $qty = intval($quantities[$index]);
        $price = floatval($prices[$index]);
        $gst_per = floatval($gst_percentages[$index]);
        $discount = floatval($discounts[$index]);

        // Validate inputs
        if (empty($customer_mobile) || empty($product_code) || $qty <= 0 || $price <= 0 || $gst_per < 0 || $discount < 0) {
            echo "Invalid input for product at index $index. Please check your data.";
            continue; // Skip this iteration
        }

        // Calculate bill values for each product
        $total = $price * $qty;
        $discount_value = ($total * $discount) / 100;
        $taxable_value = $total - $discount_value;
        $gst_value = ($taxable_value * $gst_per) / 100;
        $cgst = $gst_value / 2;
        $sgst = $gst_value / 2;
        $net_amount = $taxable_value + $gst_value;

        // Insert individual product into database with the same invoice number
        $sql = "INSERT INTO bills (invoice_number, customer_mobile, product_code, qty, price, gst_percentage, discount_percentage, total, taxable_value, cgst, sgst, net_amount)
                VALUES ('$invoice_number', '$customer_mobile', '$product_code', '$qty', '$price', '$gst_per', '$discount', '$total', '$taxable_value', '$cgst', '$sgst', '$net_amount')";

        if ($conn->query($sql) !== TRUE) {
            echo "Error inserting product $product_code: " . $conn->error;
        }

        // Add the product's net amount to the total bill
        $total_bill_amount += $net_amount;
    }

    // Insert total bill amount into the total_bills table with the same invoice number
    $sql_total_bill = "INSERT INTO total_bills (invoice_number, customer_mobile, total_amount) 
                       VALUES ('$invoice_number', '$customer_mobile', '$total_bill_amount')";

    

    $conn->close();

    // Redirect with a success message
    
    header("Location: index.php?success=1&message=Bill%20generated%20successfully");
    exit;
}
?>
