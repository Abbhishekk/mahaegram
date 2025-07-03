<?php
session_start();
if (isset($_SESSION['user_id'])) {
    // User is already logged in, redirect to dashboard
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
  <?php 
$title = "Mahaegram Login";
?>
<?php include('include/header.php'); ?>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Glassmorphism Login Page</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: linear-gradient(135deg, #cceeff, #b3e0ff);
    }

    .login-box {
      width: 650px;
      padding: 40px;
      background: rgba(255, 255, 255, 0.25);
      border-radius: 15px;
      backdrop-filter: blur(12px);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
      border: 2px solid rgba(255, 255, 255, 0.6);
      color: #000;
    }

    .login-box h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #000;
    }

    .login-box .input-group {
      margin-bottom: 20px;
    }

    .login-box .input-group label {
      display: block;
      margin-bottom: 5px;
      color: #000;
    }

    .login-box .input-group input {
      width: 100%;
      padding: 10px;
      background: rgba(255, 255, 255, 0.5);
      border: 1.5px solid #aaa;
      border-radius: 8px;
      color: #000;
      outline: none;
    }

    .login-box .input-group input::placeholder {
      color: #666;
    }

    .login-box button {
      width: 100%;
      padding: 12px;
      background: #00bfff;
      border: none;
      border-radius: 8px;
      color: #000;
      font-weight: 600;
      cursor: pointer;
      border: 2px solid #009acc;
      transition: background 0.3s ease, color 0.3s ease;
    }

    .login-box button:hover {
      background: #009acc;
      color: #fff;
    }

    @media (max-width: 400px) {
      .login-box {
        width: 90%;
        padding: 30px;
      }
    }
  </style>
</head>
<body>

  <div class="login-box">
     <?php
          if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            $message_type = $_SESSION['message_type'];
          
            echo "<div class='alert alert-$message_type'>$message</div>";
        
            // Unset the message so it doesn't persist after refresh
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
            
        }
    ?>
    <h2>Login</h2>
    <form   method="post" action="api/login.php">
      <div class="input-group">
        <label>User Id</label>
        <input type="text" id="user_id" name="user_id" placeholder="Enter User Id" required />
      </div>
      <div class="input-group">
  <label>Password</label>
  <input type="password" id="password" name="password" placeholder="Enter password" required />
  <div style="margin-top: 8px;">
     <label for="showPassword">Show Password</label><input type="checkbox" id="showPassword" onclick="togglePassword()" />
   
  </div>
</div>
      <button type="submit">Login</button>
    </form>
    <hr>
    <div class="text-center">
        <a class="font-weight-bold small" href="register.php">Create an Account!</a>
    </div>
    <div class="text-center">
  </div>
   <!-- Login Content -->
    <script>
  function togglePassword() {
    var pwd = document.getElementById("password");
    pwd.type = (pwd.type === "password") ? "text" : "password";
  }
</script>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>
</body>
</html>
