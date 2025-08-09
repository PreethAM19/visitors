<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Form</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0; /* Set your desired background color */
        }

        .signup-container {
            background-color: #3498db; /* Blue color for the container */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            color: white;
        }

        form {
            margin-top: 20px;
        }

        input {
            padding: 10px;
            margin: 5px;
            width: 100%;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #2980b9; /* Blue color for the submit button */
            color: white;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <h2>Signup</h2>

        <?php
        include('db.php');
		include_once '../pw_xcon.php';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $email = $_POST['email'];
            $mobile = $_POST['mobile'];
            $sql = "INSERT INTO login_details (username, password_hash, mobile, email) VALUES ('$username', '$password', '$mobile', '$email')";

            if ($conn->query($sql) === TRUE) {
                header("Location:visitor_login.php");
                echo "User registered successfully.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        $conn->close();
        ?>

        <form method="post" action="visitor_signup.php">
            Username: <input type="text" name="username" required><br>
            Password: <input type="password" name="password" required><br>
            Email: <input type="email" name="email" required><br>
            Mobile: <input type="text" name="mobile" required><br>
            <input type="submit" value="Sign Up">
        </form>
    </div>
</body>
</html>
