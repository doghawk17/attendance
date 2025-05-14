<?php require_once 'core/dbConfig.php'; ?>
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
      background-image: url("photos/admin.jpg");
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      min-height: 100vh;
      margin: 0;
      padding: 20px 0;
      display: flex;
      align-items: center;
    }
    .card {
      background: rgba(255, 255, 255, 0.25);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border-radius: 15px;
      border: 1px solid rgba(255, 255, 255, 0.18);
      box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
      overflow: hidden;
    }
    .card-header {
      background: rgba(255, 255, 255, 0.1);
      border-bottom: 1px solid rgba(255, 255, 255, 0.18);
      padding: 25px;
      text-align: center;
    }
    .card-header h2 {
      margin: 0;
      color: #fff;
      font-weight: 600;
      text-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }
    .card-body {
      padding: 30px;
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
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
  </style>
  <title>Hello, world!</title>
</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8 p-4">
        <div class="card">
          <div class="card-header">
            <h2><i class="fas fa-user-shield mr-2"></i>Admin Registration</h2>
          </div>
          <form action="core/handleForms.php" method="POST">
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="first_name">First Name</label>
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter first name" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter last name" required>
                  </div>
                </div>
              </div>
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
                <i class="fas fa-id-card input-icon"></i>
                <input type="text" class="form-control" id="username" name="username" placeholder="Choose a username" required>
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <i class="fas fa-lock input-icon"></i>
                <input type="password" class="form-control" id="password" name="password" placeholder="Create a password" required>
              </div>
              <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <i class="fas fa-lock input-icon"></i>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
              </div>
              <div class="text-right mt-4">
                <button type="submit" class="btn btn-primary" name="insertNewUserBtn">
                  <i class="fas fa-user-plus mr-2"></i>Register
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script>
    // $('#registrationForm').on('submit', function (event) {
    //   event.preventDefault();

    //   var formData = {
    //     first_name: $('#first_name').val(),
    //     last_name: $('#last_name').val(),
    //     username: $('#username').val(),
    //     password: $('#password').val(),
    //     createNewUser: 1,
    //   };

    //   if (formData.first_name != "" && formData.last_name != "" && formData.username != "") {
    //     $.ajax({
    //       type:"POST",
    //       url:"core/handleForms.php",
    //       data: formData,
    //       success: function (data) {
    //         console.log(data);
    //       },
    //       error: function (xhr, status, error) {
    //         console.log(error);
    //       }
    //     })
    //   }
    //   else {
    //     alert("Make sure no input fields are empty!")
    //   }
    // })
  </script>
</body>
</html>
