
    
    // onkeyup event will occur when the user 
		// release the key and calls the function 
		// assigned to this event 
		function GetDetail(str) { 
			if (str.length == 0) { 
				document.getElementById("price").value = ""; 
                document.getElementById("gst_per").value = "";
				
				return; 
			} 
			else { 

				// Creates a new XMLHttpRequest object 
				var xmlhttp = new XMLHttpRequest(); 
				xmlhttp.onreadystatechange = function () { 

					// Defines a function to be called when 
					// the readyState property changes 
					if (this.readyState == 4 && 
							this.status == 200) { 
						
						// Typical action to be performed 
						// when the document is ready 
						var myObj = JSON.parse(this.responseText); 

						// Returns the response data as a 
						// string and store this array in 
						// a variable assign the value 
						// received to first name input field 
						
						document.getElementById 
							("price").value = myObj[0]; 
						
						// Assign the value received to 
						// last name input field 
						document.getElementById( 
							"gst_per").value = myObj[1]; 
					} 
				}; 

				// xhttp.open("GET", "filename", true); 
				xmlhttp.open("GET", "db_connection.php?product_code=" + str, true); 
				
				// Sends the request to the server 
				xmlhttp.send(); 


                
			} 
		} 
	
