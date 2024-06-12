<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register here</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #4facfe, #00f2fe);
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
            background: linear-gradient(to right, rgba(0, 242, 254, 0.5), rgba(79, 172, 254, 0.7));
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            z-index: -1;
        }
        .background:before,
        .background:after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            animation: float 10s infinite ease-in-out, drift 5s infinite ease-in-out;
            z-index: -1;
        }
        .background:before {
            top: 30%;
            left: 25%;
            animation-delay: 0s;
        }
        .background:after {
            bottom: 20%;
            right: 25%;
            animation-delay: 5s;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-140px); }
        }
        @keyframes drift {
            0%, 100% { transform: translateX(0); }
            50% { transform: translateX(140px); }
        }
        .container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 15px 25px rgba(0, 0, 0, 0.5);
            text-align: center;
            max-width: 600px; /* Adjust the max-width as needed */
            width: 100%;
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
            text-align: left;
        }
        input,
        select {
            width: calc(50% - 10px);
            padding: 10px;
            margin-bottom: 15px;
            border: 2px solid #ddd;
            border-radius: 5px;
            transition: border 0.3s ease;
            box-sizing: border-box;
        }
        input[type="checkbox"] {
            width: auto;
        }
        input:focus,
        select:focus {
            border: 2px solid #4facfe;
            outline: none;
        }
        button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #4facfe;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.9s ease;
        }
        button:hover {
            transform: translateY(-3px);
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.8);
        }
        .register-link {
            margin-top: 20px;
        }
        .register-link a {
            color: #4facfe;
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
        <h1>Register Here </h1>
        <form action="registration.php" method="post" enctype="multipart/form-data">
<div style="display: flex; flex-wrap: wrap; gap: 10px;">
    <div style="flex: 1;">
        <label for="username">Upload Your Picture</label>
        <input type="file" id="images" name="images" placeholder="upload your picture" required>
    </div>
    <div style="flex: 1;">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="Choose a username" required>
    </div>
</div>
<div style="display: flex; flex-wrap: wrap; gap: 10px;">
    <div style="flex: 1;">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Enter your email address" required>
    </div>
    <div style="flex: 1;">
        <label for="password">Password</label>
        <input type="password" id="passcode" name="passcode" placeholder="Create a password" required>
    </div>
</div>
<div style="display: flex; flex-wrap: wrap; gap: 10px;">
    <div style="flex: 1;">
        <label for="confirm-password">Confirm Password</label>
        <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm your password" required>
    </div>
    <div style="flex: 1;">
        <label for="dob">Date of Birth</label>
        <input type="date" id="dateofbirth" name="dateofbirth" required>
    </div>
</div>
<div style="display: flex; flex-wrap: wrap; gap: 10px;">
    <div style="flex: 1;">
        <label for="gender">Gender</label>
        <select id="gender" name="gender">
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="prefer-not-to-say">Prefer not to say</option>
        </select>
    </div>
    <div style="flex: 1;">
        <label for="phone">Phone Number</label>
        <input type="text" id="phonenumber" name="phonenumber" placeholder="Enter your phone number">
    </div>
</div>
<div style="display: flex; flex-wrap: wrap; gap: 10px;">
    <div style="flex: 1;">
        <label for="country">Country</label>
        <input type="text" name="country" id="country" required>
    </div>
    <div style="flex: 1;">
        <input type="checkbox" id="terms" name="terms" required>
        <label for="terms">I agree to the <a href="#">Terms and Conditions</a></label>
    </div>
</div>
<button type="submit">Join Now</button>
</form>
<div class="login-link">
    <p>Already have an account? <a href="login.php">Login here</a></p>
</div>
