<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "khadi");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emp_id = htmlspecialchars(trim($_POST['emp_id']));
    $emp_name = htmlspecialchars(trim($_POST['emp_name']));

    // Validate inputs
    if (empty($emp_id) || empty($emp_name)) {
        $message = "Employee ID and Name are required!";
    } elseif (!ctype_digit($emp_id)) {
        $message = "Employee ID must be numeric!";
    } else {
        // Check if user exists in the database
        $query = "SELECT * FROM employee_master WHERE emp_id = ? AND emp_name = ?";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            die("SQL Error: " . $conn->error);
        }

        $stmt->bind_param("is", $emp_id, $emp_name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            // Start session and redirect to dashboard
            session_start();
            session_regenerate_id(); // Prevent session fixation attacks
            $_SESSION['emp_id'] = $emp_id;
            $_SESSION['emp_name'] = $emp_name;


            header("Location: home.php"); // Redirect to dashboard
            exit;
        } else {
            $message = "Invalid Employee ID or Name!";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        .center {
            margin-left: auto;
            margin-right: auto;
        }

        body {
            background: url("./kpm.jpg");
            background-size: cover;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            display: flex;
            justify-content: center;
            margin-top: 150px;
        }

        .container {
            background-color: transparent;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 300px;
            padding: 30px;
            border: 6px solid rgba(255, 255, 255, 0.4);
            border-radius: 50px;

        }

        p {
            color: red;
        }

        input {
            padding: 10px;
            border: none;
            font-size: 20px;
        }



        button {
            width: 50%;
            padding: 5px;
            border: 3px solid white;
            border-radius: 15px;
            cursor: pointer;
            margin-top: 10px;
            font-size: 20px;
        }

        button:hover {
            width: 50%;
            padding: 5px;
            border: 3px solid green;
            border-radius: 15px;
            cursor: pointer;
            margin-top: 10px;
            font-size: 20px;
        }
    </style>
</head>

<body>
    <?php if (!empty($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <div class="container">

        <form method="POST" action="">
            <table class="center">
                <tr>
                    <td>
                        <h2>LOGIN</h2>
                    </td>
                </tr>
                <tr>
                    <td><label for="emp_id">User Name</label></td>
                </tr>
                <tr>
                    <td><input type="text" name="emp_id" id="emp_id" required></td>
                </tr>
                <tr>
                    <td><label for="emp_name">Password</label></td>
                </tr>
                <tr>
                    <td><input type="password" name="emp_name" id="emp_name" required></td>
                </tr>
                <tr>
                    <td><button type="submit">Login</button></td>
                </tr>
            </table>
        </form>
    </div>
</body>

</html>