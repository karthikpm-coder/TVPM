<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Khadi & Poompuhar Billing System</title>
    <style>
      body {
        background: url('background.jpg') no-repeat center center fixed;
        background-size: cover;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
        margin: 0;
        color: white;
      }

      .container {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.5);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.8);
      }

      h2 {
        margin-bottom: 20px;
      }

      .button {
        display: flex;
        gap: 20px;
      }

      button {
        border: none;
        background: none;
        cursor: pointer;
        outline: none;
        transition: transform 0.3s ease, border 0.3s ease;
      }

      button:hover {
        transform: scale(1.1);
        border: solid 4px #f0bb78;
      }

      img {
        width: 150px;
        height: auto;
        border-radius: 8px;
      }

      @media (max-width: 600px) {
        img {
          width: 100px;
        }

        h2 {
          font-size: 1.5rem;
          text-align: center;
        }

        .button {
          flex-direction: column;
        }
      }
    </style>
  </head>
  <body>
    <div class="container">
      <h2>Please Select a Store</h2>
      <div class="button">
        <!-- Button to open Poompuhar Billing -->
        <button onclick="openPage('pum_billing/billing.php')" aria-label="Poompuhar Billing">
          <img src="poom.jpg" alt="Poompuhar Store Logo" />
        </button>
        <!-- Button to open Khadi Billing -->
        <button onclick="openPage('khadi_billing/billing.php')" aria-label="Khadi Billing">
          <img src="khadi.jpg" alt="Khadi Store Logo" />
        </button>
      </div>
    </div>
    <script>
      function openPage(url) {
        // Use window.location.href to navigate in the same tab
        window.location.href = url;
      }
    </script>
  </body>
</html>
