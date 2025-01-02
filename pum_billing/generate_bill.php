<?php
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

    // Start a transaction to ensure all database operations are handled atomically
    mysqli_begin_transaction($conn);

    try {
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

            // Insert individual product into the bills table with the same invoice number
            $sql = "INSERT INTO bills (invoice_number, customer_mobile, product_code, qty, price, gst_percentage, discount_percentage, total, taxable_value, cgst, sgst, net_amount)
                    VALUES ('$invoice_number', '$customer_mobile', '$product_code', '$qty', '$price', '$gst_per', '$discount', '$total', '$taxable_value', '$cgst', '$sgst', '$net_amount')";

            if ($conn->query($sql) !== TRUE) {
                throw new Exception("Error inserting product $product_code: " . $conn->error);
            }

            // Add the product's net amount to the total bill
            $total_bill_amount += $net_amount;

            // Update stock quantity (reduce stock by sold quantity)
            $update_sql = "UPDATE Stock SET qty = qty - $qty WHERE product_code = '$product_code'";

            // Ensure stock quantity is updated only if sufficient stock is available
            $check_stock_sql = "SELECT qty FROM Stock WHERE product_code = '$product_code' LIMIT 1";
            $check_result = $conn->query($check_stock_sql);

            if ($check_result && $check_result->num_rows > 0) {
                $stock = $check_result->fetch_assoc();
                if ($stock['qty'] < $qty) {
                    throw new Exception("Insufficient stock for product code $product_code.");
                }
            } else {
                throw new Exception("Product code $product_code not found in stock.");
            }

            if ($conn->query($update_sql) !== TRUE) {
                throw new Exception("Error updating stock for product $product_code: " . $conn->error);
            }
        }

        // Insert total bill amount into the total_bills table
        $sql_total_bill = "INSERT INTO total_bills (invoice_number, customer_mobile, total_amount) 
                           VALUES ('$invoice_number', '$customer_mobile', '$total_bill_amount')";

        if ($conn->query($sql_total_bill) !== TRUE) {
            throw new Exception("Error inserting total bill: " . $conn->error);
        }

        // Commit the transaction after all operations are successful
        mysqli_commit($conn);

        // Close the database connection
        $conn->close();

        // Redirect to index with success message
        header("Location: index.php?success=1&message=Bill%20generated%20successfully");
        exit;

    } catch (Exception $e) {
        // Rollback the transaction in case of any error
        mysqli_rollback($conn);
        echo "Error: " . $e->getMessage();
    }
}
?>
