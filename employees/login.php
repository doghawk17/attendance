<?php require_once 'core/dbConfig.php'; ?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <style>
      body {
        font-family: 'Poppins', sans-serif;
        background-image: url("photos/employee.jpg");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 100vh;
        margin: 0;
        padding: 0;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
      }
      html {
        height: 100%;
        margin: 0;
        padding: 0;
        overflow: hidden;
      }
      .login-container {
        width: 100%;
        max-width: 450px;
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-radius: 15px;
        border: 1px solid rgba(255, 255, 255, 0.18);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        overflow: hidden;
        transition: all 0.3s ease;
      }
      .login-header {
        background: rgba(255, 255, 255, 0.1);
        padding: 25px;
        text-align: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.18);
      }
      .login-header h2 {
        margin: 0;
        color: #fff;
        font-weight: 600;
        text-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        font-size: 1.8rem;
      }
      .login-body {
        padding: 30px;
      }
      .login-footer {
        padding: 20px 30px;
        text-align: right;
        border-top: 1px solid rgba(255, 255, 255, 0.18);
      }
      .form-group {
        margin-bottom: 25px;
        position: relative;
      }
      .form-group label {
        color: #fff;
        font-weight: 500;
        margin-bottom: 8px;
        display: block;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
      }
      .form-control {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        border-radius: 8px;
        padding: 12px 20px;
        padding-left: 45px;
        color: #fff;
        transition: all 0.3s;
      }
      .form-control:focus {
        background: rgba(255, 255, 255, 0.3);
        box-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
      }
      .form-control::placeholder {
        color: rgba(255, 255, 255, 0.7);
      }
      .input-icon {
        position: absolute;
        left: 15px;
        top: 42px;
        color: rgba(255, 255, 255, 0.8);
      }
      .btn-primary {
        background: linear-gradient(135deg, #3a8ffe 0%, #1a69ed 100%);
        border: none;
        border-radius: 8px;
        padding: 12px 30px;
        font-weight: 600;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(26, 105, 237, 0.3);
      }
      .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(26, 105, 237, 0.4);
      }
      .alert {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        border-radius: 8px;
      }
      .alert-success {
        background: rgba(40, 167, 69, 0.2);
        color: #fff;
      }
      .alert-danger {
        background: rgba(220, 53, 69, 0.2);
        color: #fff;
      }
      .register-link {
        margin-top: 15px;
        text-align: center;
      }
      .register-link a {
        color: #fff;
        text-decoration: underline;
        font-weight: 500;
        transition: all 0.3s;
      }
      .register-link a:hover {
        color: #3a8ffe;
      }
      @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
    </style>
    <title>Employee Login</title>
  </head>
  <body>
    <div class="container">
      <div class="login-container">
        <div class="login-header">
          <h2><i class="fas fa-user mr-2"></i>Employee Login</h2>
        </div>
        <form action="core/handleForms.php" method="POST">
          <div class="login-body">
            <?php  
            if (isset($_SESSION['message']) && isset($_SESSION['status'])) {
              if ($_SESSION['status'] == "200") {
                echo "<div class='alert alert-success'><i class='fas fa-check-circle mr-2'></i>{$_SESSION['message']}</div>";
              } else {
                echo "<div class='alert alert-danger'><i class='fas fa-exclamation-circle mr-2'></i>{$_SESSION['message']}</div>"; 
              }
            }
            unset($_SESSION['message']);
            unset($_SESSION['status']);
            ?>
            <div class="form-group">
              <label for="username">Username</label>
              <i class="fas fa-user input-icon"></i>
              <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <i class="fas fa-lock input-icon"></i>
              <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="register-link">
              <p>Don't have an account yet? <a href="register.php"><i class="fas fa-user-plus mr-1"></i>Register here!</a></p>
            </div>
          </div>
          <div class="login-footer">
            <button type="submit" class="btn btn-primary" name="loginUserBtn"><i class="fas fa-sign-in-alt mr-2"></i>Login</button>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>
