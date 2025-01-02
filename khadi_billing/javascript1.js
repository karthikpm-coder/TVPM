    
        let totalNetAmount = 0;

        function addProduct() {

            const product_code = document.getElementById('product_code').value;
            const productPrice = parseFloat(document.getElementById('price').value);
            const qty = parseFloat(document.getElementById('qty').value);
            //const totalValue = parseFloat(document.getElementById('tvalue').value);
            const discount = parseFloat(document.getElementById('discount').value);
            const gst_per = parseFloat(document.getElementById('gst_per').value);

            if (!isNaN(productPrice) && !isNaN(qty) && !isNaN(discount) && !isNaN(gst_per) && product_code.trim(4) !== '') {
                // Calculate values
                const price = (productPrice * qty);
                const discountValue = (price * discount) / 100;
                const taxableValue = price - discountValue;
                const gstValue = (taxableValue * gst_per) / 100;
                const CGST = gstValue/2;
                const SGST = gstValue/2;
                const netPrice = taxableValue + gstValue;
                //const words = convertNumberToWords(netPrice);
            
                

                // Update total net price
                totalNetAmount += netPrice;

                // Append new product row to the table
                const productRow = `
                    <tr>
                        <td>${product_code}</td>
                        <td>${productPrice.toFixed(2)}</td>
                        <td>${qty.toFixed(2)}</td>
                        <td>${price.toFixed(2)}</td>
                        <td>${discountValue.toFixed(2)}</td>
                        <td>${taxableValue.toFixed(2)}</td>
                        <td>${CGST.toFixed(2)}</td>
                        <td>${SGST.toFixed(2)}</td>

                        <td>${netPrice.toFixed(2)}</td>
                    </tr>
                `;
                document.getElementById('productRows').insertAdjacentHTML('beforeend', productRow);
                document.getElementById('totalNetPrice').textContent = totalNetAmount.toFixed(2);

                // Show the print section
                document.getElementById('printSection').style.display = 'block';

                const today = new Date();
                const formattedDate = today.toLocaleDateString();
                const formattedTime = today.toLocaleTimeString();
                document.getElementById('billDate').textContent = formattedDate + ' ' + formattedTime;



                // Clear input fields for the next product
                document.getElementById('product_code').value = '';
                document.getElementById('price').value = '';
                document.getElementById('qty').value = '';
                document.getElementById('total').value = '';
                document.getElementById('discount').value = '';
                document.getElementById('gst_per').value = '';
            } else {
                window.alert('Please enter correct values');
            }
        }

        function printBill() {
            const printContent = document.getElementById('printSection').innerHTML;
            const originalContent = document.body.innerHTML;

            document.body.innerHTML = printContent;
            window.print();

            document.body.innerHTML = originalContent;
        }
    
