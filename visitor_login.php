<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0; /* Set your desired background color */
        }

        .login-container {
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
    <div class="login-container">
        <?php
        session_start();
        include('db.php');
		include_once '../pw_xcon.php';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $sql = "SELECT username, password_hash FROM login_details WHERE username='$username'";
            $result = $conn->query($sql);

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                if (password_verify($password, $row['password_hash'])) {
                    $_SESSION["username"]=$username;
                    header("Location:index.php");
                    exit();
                } else {
                    echo "Invalid password.";
                }
            } else {
                echo "User not found.";
            }
        }

        $conn->close();
        ?>

        <h2>Login</h2>

        <form method="post" action="visitor_login.php">
            Username: <input type="text" name="username" required><br>
            Password: <input type="password" name="password" required><br>
            <a href='visitor_signup.php' class="navbar-button" >Sign Up</button>
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>
