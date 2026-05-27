<?php
session_start();

$conn = new mysqli("localhost", "root", "", "globetrek_db", 3308);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/* REGISTER */
if (isset($_POST['register'])) {

    $name = $_POST['full_name'];
    $country = $_POST['country'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if ($pass != $confirm) {
        echo "<script>alert('Passwords do not match!');</script>";
    } else {

        $check = $conn->query("SELECT * FROM users WHERE email='$email'");

        if ($check->num_rows > 0) {
            echo "<script>alert('Email already exists! Please login.');</script>";
        } else {
            $sql = "INSERT INTO users (full_name, country, email, password)
                    VALUES ('$name', '$country', '$email', '$pass')";

            if ($conn->query($sql) === TRUE) {

                  $_SESSION['user_id'] = $conn->insert_id;
                  $_SESSION['user_name'] = $name;

                echo "<script>
                        alert('Account created successfully!');
                        window.location.href='index.php';
                      </script>";
                exit();
            } else {
                echo "<script>alert('".$conn->error."');</script>";
            }
        }
    }
}

/* LOGIN */
if (isset($_POST['login'])) {

    $user_email = $_POST['user_email'];
    $user_pass = $_POST['user_pass'];

    $sql = "SELECT * FROM users WHERE email='$user_email' AND password='$user_pass'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user_data = $result->fetch_assoc();

        // සෙෂන් එකේ දත්ත සේව් කිරීම
        $_SESSION['user_id'] = $user_data['id'];
        $_SESSION['user_name'] = $user_data['full_name']; 

        // කෙලින්ම Dashboard එකට යවන්න
        header("Location: index.php");
        exit();

    } else {
        // ලොගින් වැරදුණොත් පෙන්වන මැසේජ් එක
        $failRedirect = "login.php?show=register";
        if (isset($_GET['redirect']) && $_GET['redirect'] == "second") {
            $failRedirect .= "&redirect=second";
        }

        echo "<script>
                alert('Invalid Email or Password! Please register.');
                window.location.href='$failRedirect';
              </script>";
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | GlobeTrek Adventures</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Syncopate:wght@700&family=Inter:wght@300;400;600&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: url('https://images.unsplash.com/photo-1502791451862-7bd8c1df43a7?q=80&w=1964&auto=format&fit=crop') no-repeat center center/cover;
            font-family: 'Inter', sans-serif;
            overflow: hidden;
        }

        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            z-index: 1;
        }

        .container {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .glass-box {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 40px;
            padding: 50px 40px;
            box-shadow: 0 25px 45px rgba(0,0,0,0.2);
            text-align: center;
        }

        .brand-name {
            font-family: 'Syncopate', sans-serif;
            color: #fff;
            font-size: 24px;
            letter-spacing: 5px;
            margin-bottom: 40px;
            text-transform: uppercase;
        }

        .input-wrap {
            margin-bottom: 25px;
            position: relative;
        }

        .input-wrap input, select {
            width: 100%;
            background: transparent;
            border: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            padding: 12px 5px;
            color: #fff;
            font-size: 16px;
            outline: none;
            transition: 0.4s;
        }

        select {
            cursor: pointer;
            appearance: none;
        }

        .input-wrap input:focus, select:focus {
            border-bottom: 1px solid #fff;
        }

        .input-wrap label {
            position: absolute;
            top: 12px;
            left: 5px;
            color: rgba(255, 255, 255, 0.5);
            pointer-events: none;
            transition: 0.4s;
        }

        .input-wrap input:focus ~ label,
        .input-wrap input:valid ~ label,
        .select-active label {
            top: -15px;
            font-size: 12px;
            color: #fff;
            letter-spacing: 1px;
        }

        .action-btn {
            width: 100%;
            padding: 16px;
            border-radius: 50px;
            border: none;
            background: #fff;
            color: #000;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 20px;
            transition: 0.3s ease;
        }

        .action-btn:hover {
            background: transparent;
            color: #fff;
            box-shadow: inset 0 0 0 2px #fff;
        }

        .footer-text {
            margin-top: 30px;
            color: rgba(255, 255, 255, 0.6);
            font-size: 13px;
        }

        .footer-text a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            cursor: pointer;
        }

        .hidden { display: none; }

        .form-content {
            max-height: 400px;
            overflow-y: auto;
            padding-right: 10px;
            text-align: left;
        }

        .form-content::-webkit-scrollbar { width: 3px; }
        .form-content::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 10px; }

        select option {
            background: #222;
            color: #fff;
        }
        
        optgroup {
            background: #222;
            color: #2ecc71;
            font-style: normal;
            font-weight: 600;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="glass-box">
            <div class="brand-name">GlobeTrek</div>
            <!-- Login Form -->
         <div id="login-form">
    <form method="POST" action="">
        <div class="input-wrap">
            <input type="email" name="user_email" required> 
            <label>Email</label>
        </div>
        <div class="input-wrap">
            <input type="password" name="user_pass" required> 
            <label>Password</label>
        </div>
    
        <button type="submit" name="login" class="action-btn">Sign In</button>
    </form>
</div>

            <!-- Register Form -->
          <div id="register-form" class="hidden">
    <form method="POST" action=""> 
        <div class="form-content">
            <div class="input-wrap">
                <input type="text" name="full_name" required> <label>Full Name</label>
            </div>

                    <div class="input-wrap select-active">
                        <label style="position: static; display: block; margin-bottom: 5px;">Country</label>
                       <select name="country" required>
                            <option value="" disabled selected>Select your destination</option>
                            <optgroup label="South Asia">
                                <option>Sri Lanka</option>
                                <option>India</option>
                                <option>Maldives</option>
                                <option>Nepal</option>
                                <option>Pakistan</option>
                            </optgroup>
                            <optgroup label="Europe">
                                <option>United Kingdom</option>
                                <option>France</option>
                                <option>Germany</option>
                                <option>Italy</option>
                                <option>Switzerland</option>
                                <option>Netherlands</option>
                            </optgroup>
                            <optgroup label="Asia Pacific">
                                <option>Japan</option>
                                <option>Australia</option>
                                <option>Singapore</option>
                                <option>Thailand</option>
                                <option>South Korea</option>
                                <option>China</option>
                            </optgroup>
                            <optgroup label="Americas">
                                <option>USA</option>
                                <option>Canada</option>
                                <option>Brazil</option>
                                <option>Mexico</option>
                            </optgroup>
                        </select>
                    </div>
<div class="input-wrap">
                <input type="email" name="email" required> <label>Email</label>
            </div>

            <div class="input-wrap">
                <input type="password" name="password" required> <label>Create Password</label>
            </div>
            
            <div class="input-wrap">
                <input type="password" name="confirm_password" required> <label>Confirm Password</label>
            </div>
        </div>

        <button type="submit" name="register" class="action-btn">Create Account</button>
    </form>
    <p class="footer-text">Back to <a onclick="toggle()">Login</a></p>
</div>
        </div>
    </div>
<script>
function toggle() {
    document.getElementById("login-form").classList.toggle("hidden");
    document.getElementById("register-form").classList.toggle("hidden");
}

window.onload = function () {
    const params = new URLSearchParams(window.location.search);

    if (params.get("show") === "register") {
        document.getElementById("login-form").classList.add("hidden");
        document.getElementById("register-form").classList.remove("hidden");
    }
}
</script>
 
</body>
</html>