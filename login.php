<?php
session_start();
if (isset($_SESSION['user_id'])) {
    // User is already logged in, redirect to dashboard
    header("Location: index.php");
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
  <title>Mahaegram - Government Login Portal</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&family=Noto+Sans:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

  <style>
    :root {
      --govt-blue: #002244;
      --govt-green: #006400;
      --govt-gold: #D4AF37;
      --govt-light: #f5f9ff;
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', 'Noto Sans', sans-serif;
    }

    body {
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: linear-gradient(135deg, #e6f2ff, #cce6ff);
      background-image: url('img/govt-bg.jpg');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
    }

    .login-container {
      width: 100%;
      max-width: 1200px;
      display: flex;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .login-info {
      flex: 1;
      background: linear-gradient(135deg, var(--govt-blue), #003366);
      color: white;
      padding: 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .login-info h1 {
      font-size: 2.2rem;
      margin-bottom: 20px;
      font-weight: 600;
    }

    .login-info p {
      margin-bottom: 30px;
      line-height: 1.6;
    }

    .govt-features {
      list-style: none;
    }

    .govt-features li {
      margin-bottom: 15px;
      display: flex;
      align-items: center;
    }

    .govt-features i {
      margin-right: 10px;
      color: var(--govt-gold);
    }

    .login-box {
      width: 450px;
      padding: 50px 40px;
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(5px);
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .login-logo {
      text-align: center;
      margin-bottom: 30px;
    }

    .login-logo img {
      height: 80px;
      margin-bottom: 15px;
    }

    .login-logo h2 {
      color: var(--govt-blue);
      font-weight: 600;
      margin-bottom: 5px;
    }

    .login-logo p {
      color: #555;
      font-size: 0.9rem;
    }

    .login-box .alert {
      margin-bottom: 20px;
    }

    .input-group {
      margin-bottom: 20px;
    }

    .input-group label {
      display: block;
      margin-bottom: 8px;
      color: var(--govt-blue);
      font-weight: 500;
    }

    .input-group input {
      width: 100%;
      padding: 12px 15px;
      border: 1px solid #ddd;
      border-radius: 6px;
      background: rgba(255, 255, 255, 0.8);
      transition: all 0.3s ease;
    }

    .input-group input:focus {
      border-color: var(--govt-blue);
      box-shadow: 0 0 0 3px rgba(0, 34, 68, 0.1);
      outline: none;
    }

    .password-toggle {
      display: flex;
      align-items: center;
      margin-top: 8px;
    }

    .password-toggle input[type="checkbox"] {
      width: auto;
      margin-right: 8px;
    }

    .password-toggle label {
      margin-bottom: 0;
      font-size: 0.9rem;
      color: #555;
    }

    .login-btn {
      width: 100%;
      padding: 12px;
      background: var(--govt-blue);
      border: none;
      border-radius: 6px;
      color: white;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 10px;
    }

    .login-btn:hover {
      background: #003366;
      transform: translateY(-2px);
    }

    .login-footer {
      text-align: center;
      margin-top: 25px;
      padding-top: 20px;
      border-top: 1px solid #eee;
    }

    .login-footer a {
      color: var(--govt-blue);
      font-weight: 500;
      text-decoration: none;
      transition: all 0.3s ease;
    }

    .login-footer a:hover {
      color: var(--govt-green);
      text-decoration: underline;
    }
        @keyframes bounce {
      0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
      }
      40% {
        transform: translateY(-20px);
      }
      60% {
        transform: translateY(-10px);
      }
    }
    
    .bounce {
      animation: bounce 2s infinite;
    }


    @media (max-width: 992px) {
      .login-container {
        flex-direction: column;
        max-width: 500px;
      }
      
      .login-info {
        display: none;
      }
      
      .login-box {
        width: 100%;
      }
    }

    @media (max-width: 576px) {
      .login-box {
        padding: 30px 20px;
      }
      
      .login-logo img {
        height: 60px;
      }
    }
  </style>
</head>
<body>

  <div class="login-container">
    <!-- Government Information Section -->
    <div class="login-info">
      <h1 class="bounce">Panchayat Portal</h1>
      <p>The Panchayat Portal is not merely a technological tool; it is a catalyst for transforming access, accountability, and equity within agency governance. By leveraging digital innovation, it aims to empower organizations, enhance service delivery, and foster active citizen participation in governance processes</p>
      
      <ul class="govt-features">
        <li><i class="fas fa-shield-alt"></i> Secure Governance authentication</li>
        <li><i class="fas fa-file-alt"></i> Access official documents</li>
        <li><i class="fas fa-users"></i> Citizen services portal</li>
        <li><i class="fas fa-lock"></i> Encrypted data transmission</li>
      </ul>
    </div>
    
    <!-- Login Form Section -->
    <div class="login-box">
      <div class="login-logo">
        <!-- Replace with your government logo -->
        <img src="img/portal_logo.png" alt="Government Logo">
        <h2>Login to Panchayat</h2>
        <p>Official Panchayat Administration Portal</p>
      </div>
      
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
      
      <form method="post" action="api/login.php">
        <div class="input-group">
          <label for="user_id">User ID</label>
          <input type="text" id="user_id" name="user_id" placeholder="Enter your Agency ID" required />
        </div>
        
        <div class="input-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Enter your password" required />
          <div class="password-toggle">
            <input type="checkbox" id="showPassword" onclick="togglePassword()">
            <label for="showPassword">Show Password</label>
          </div>
        </div>
        
        <button type="submit" class="login-btn">Login <i class="fas fa-sign-in-alt ml-2"></i></button>
      </form>
      
      <div class="login-footer">
        <a href="register.php">Create an Account</a> 
      </div>
    </div>
  </div>

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