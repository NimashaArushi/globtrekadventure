<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - GlobeTrek</title>
    <style>
        body { font-family: 'Poppins', sans-serif; 
              background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), 
                    url('travel5.jpg');
                    background-size: cover;
      background-size: cover;
    background-position: center;  
    background-repeat: no-repeat; 
    min-height: 120vh; 
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0;
}

        .login-container {
             background: white;
              padding: 30px; 
              border-radius: 12px; 
              box-shadow: 0 8px 20px rgba(0,0,0,0.1); 
              width: 350px;
             }
        h2 {
             text-align: center;
              color: #007991; 
            }
        input {
             width: 100%; 
             padding: 12px; 
             margin: 10px 0; 
             border: 1px solid #ccc; 
             border-radius: 6px; 
             box-sizing: border-box;
             }
        button {
             width: 100%;
              padding: 12px;
               background: #007991;
                color: white;
                 border: none; 
                 border-radius: 6px;
                  cursor: pointer; 
                  font-size: 16px; 
                  width: 100%; 
                }
        button:hover { 
            background: #005f6b;
         }
        .error { 
            color: red; 
            font-size: 14px;
             text-align: center; 
            }
        .register-link {
             text-align: center;
              margin-top: 20px; 
              font-size: 14px; 
              border-top: 1px solid #eee;
               padding-top: 10px; 
            }
        .register-link a { 
            color: #007991;
             text-decoration: none;
              font-weight: bold;
             }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Admin Login</h2>
  <form action="verify_admin.php" method="POST" autocomplete="off">
    <input type="text" name="full_name" placeholder="Full Name" required autocomplete="new-password">
    <input type="email" name="email" placeholder="Email Address" required autocomplete="new-password">
    <input type="password" name="password" placeholder="Password" required autocomplete="new-password">
    <button type="submit" name="login">Login</button>
</form>
    
    <div class="register-link">
        <p>Don't have an account? <a href="register_admin.php">Register Here</a></p>
    </div>

    <?php if(isset($_GET['error'])) { echo '<p class="error">Invalid Details! ❌</p>'; } ?>
</div>

</body>
</html>