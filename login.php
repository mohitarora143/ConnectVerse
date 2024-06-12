<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #ff9a9e, #fad0c4, #fad0c4, #ffdde1);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
            position: relative;
        }
        .background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, rgba(255, 154, 158, 0.5), rgba(250, 208, 196, 0.5), rgba(250, 208, 196, 0.5), rgba(255, 221, 225, 0.5));
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            z-index: -1;
        }
        .background:before,
        .background:after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            animation: float 10s infinite ease-in-out, drift 7s infinite ease-in-out;
            z-index: -1;
        }
        .background:before {
            top: 10%;
            left: 25%;
            animation-delay: 0s;
        }
        .background:after {
            bottom: 10%;
            right: 25%;
            animation-delay: 5s;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        @keyframes drift {
            0%, 100% { transform: translateX(0); }
            50% { transform: translateX(20px); }
        }
        .container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 15px 25px rgba(0, 0, 0, 0.5);
            text-align: center;
            width: 300px;
            position: relative;
            z-index: 1;
        }
        .container h1 {
            margin-bottom: 20px;
            color: #333;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            color: #333;
        }
        input {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 2px solid #ddd;
            border-radius: 5px;
            transition: border 0.3s ease;
        }
        input:focus {
            border: 2px solid #ff9a9e;
            outline: none;
        }
        button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #ff9a9e;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        button:hover {
            transform: translateY(-3px);
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.3);
        }
        .register-link {
            margin-top: 20px;
        }
        .register-link a {
            color: #ff9a9e;
            text-decoration: none;
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>
</head>
<body>
    <div class="background"></div>
    <div class="container">
        <h1>Welcome Back!</h1>
        <?php
        session_start();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            include 'common/databaseconn.php';
            $email = $_POST['email'];
            $passcode = $_POST['passcode'];

            $stmt = $conn->prepare("SELECT images, passcode, username FROM registration WHERE email = ?");
            if ($stmt === false) {
                die("Prepare failed: " . $conn->error);
            }

            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($image, $stored_password, $username);
            $stmt->fetch();

            if ($passcode === $stored_password) {
                // Set session variables
                $_SESSION['email'] = $email;
                $_SESSION['username'] = $username;
                $_SESSION['images'] = $image;
                echo "<p class='success'>Login successful!</p>";
                header("Location: functions/mainpage.php");
                exit();
            } else {
                echo "<p class='error'>Invalid email or password.</p>";
            }

            $stmt->close();
            $conn->close();
        }
        ?>
        <form action="login.php" method="post">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email address" required>
            <label for="passcode">Password</label>
            <input type="password" id="passcode" name="passcode" placeholder="Enter your password" required>
            <button type="submit">Login</button>
        </form>
        <div class="register-link">
            <p>Don't have an account? <a href="registration.php">Register here</a></p>
        </div>
    </div>
</body>
</html>
