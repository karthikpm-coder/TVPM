<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Application</title>
    <link rel="stylesheet" href="style.css">
    <script src="invoice.js"></script>
    <script src="fetch_stock.js"></script>
    <style>
body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

.topnav {
  overflow: hidden;
  background-color: #333;
}

.topnav a {
  float: left;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: green;
  color: black;
}

.topnav a.active {
  background-color: green;
  color: white;
}
</style>
</head>
<body>
    <div class="container">
    <div class="topnav">
    <a href="../index.php">Home</a>
  <a class="active" href="billing.php">Billing</a>
  <a href="bill_view.php">Bill View</a>
  <a href="stock.php">Stock Inward</a>
  <a href="stock_view.php">Stock View</a>
  <a href="#">Stock Outward</a>
</div>



        <h2>Khadi Kraft Billing</h2>
        <form id="billingForm" method="post" action="bill_post1.php">
            <label for="customer_mobile">Customer Mobile Number</label>
            <input type="text" name="customer_mobile" id="customer_mobile" placeholder="Enter Customer Mobile Number" required>
            
            <div>
                <table id="productTable" border="1">
                    <thead>
                        <tr>
                            <th>Product Code</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>GST (%)</th>
                            <th>Discount (%)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="productRows">
                        <!-- Product rows will be added dynamically -->
                    </tbody>
                </table>
                <br>
                
                <br>
            </div>
            <br>
            <button type="button" id="addProductBtn">Add Product</button>
            <button type="submit">Generate Bill</button>
           
        </form>
        <br>
       
        

    </div>

    <script>
        let productIndex = 0;

        document.getElementById('addProductBtn').addEventListener('click', function() {
            addProductRow();
        });

        function addProductRow() {
            productIndex++;

            const tableBody = document.getElementById('productRows');
            const newRow = document.createElement('tr');

            newRow.innerHTML = `
                <td>
                    <input type="text" name="product_code[]" placeholder="Enter product code" id="product_code"  required>
                </td>
                <td>
                    <input type="number" name="qty[]" placeholder="Qty" id="qty" required>
                </td>
                <td>
                    <input type="number" name="price[]" placeholder="Price" step="0.01" id="price" id="price" required>
                </td>
                <td>
                    <input type="number" name="gst_per[]" placeholder="GST (%)" id="gst_per" step="0.01" required>
                </td>
                <td>
                    <input type="number" name="discount[]" placeholder="Discount (%)" step="0.01"  id="discount"required>
                </td>
                <td>
                    <button type="button" class="removeRowBtn">Remove</button>
                </td>
            `;

            tableBody.appendChild(newRow);

            // Add event listener to remove button
            newRow.querySelector('.removeRowBtn').addEventListener('click', function() {
                tableBody.removeChild(newRow);
            });
        }
    </script>
    <?php
if (isset($_GET['message'])) {
    echo "<div class='alert alert-success'>" . htmlspecialchars($_GET['message']) . "</div>";
}
?>
</body>
</html>
