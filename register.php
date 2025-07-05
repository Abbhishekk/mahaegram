<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<?php
$title = "Panchayat Portal Register";
?>
<?php include('include/header.php'); ?>
<?php
$states = $fun->getUniqueStates();
?>

<head>
  <style>
    :root {
      --govt-blue: #002244;
      --govt-green: #006400;
      --govt-gold: #D4AF37;
      --govt-light: #f5f9ff;
    }
    
    .bg-gradient-login {
      background: linear-gradient(135deg, #e6f2ff, #cce6ff);
      min-height: 100vh;
      padding: 2rem 0;
    }
    
    .registration-container {
      max-width: 1200px;
      margin: 0 auto;
    }
    
    .registration-card {
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
      border: none;
    }
    
    .registration-header {
      background: linear-gradient(to right, var(--govt-blue), #003366);
      color: white;
      padding: 1.5rem;
      text-align: center;
    }
    
    .registration-header h1 {
      font-size: 1.8rem;
      margin-bottom: 0;
    }
    
    .registration-body {
      padding: 2rem;
      background-color: white;
    }
    
    .form-section {
      margin-bottom: 2rem;
    }
    
    .form-section-title {
      color: var(--govt-blue);
      font-weight: 600;
      margin-bottom: 1.5rem;
      padding-bottom: 0.5rem;
      border-bottom: 2px solid var(--govt-gold);
    }
    
    .form-row {
      display: flex;
      flex-wrap: wrap;
      margin: 0 -15px;
    }
    
    .form-group {
      flex: 0 0 50%;
      padding: 0 15px;
      margin-bottom: 1.5rem;
    }
    
    .form-group label {
      display: block;
      margin-bottom: 0.5rem;
      color: var(--govt-blue);
      font-weight: 500;
    }
    
    .form-control {
      width: 100%;
      padding: 0.75rem 1rem;
      border: 1px solid #ddd;
      border-radius: 6px;
      transition: all 0.3s ease;
    }
    
    .form-control:focus {
      border-color: var(--govt-blue);
      box-shadow: 0 0 0 3px rgba(0, 34, 68, 0.1);
      outline: none;
    }
    
    .select2-container .select2-selection--single {
      height: 45px;
      padding: 0.75rem 1rem;
      border: 1px solid #ddd;
      border-radius: 6px;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__arrow {
      height: 43px;
    }
    
    .btn-register {
      background-color: var(--govt-blue);
      color: white;
      border: none;
      padding: 0.75rem 2rem;
      font-weight: 600;
      border-radius: 6px;
      transition: all 0.3s ease;
      display: block;
      width: 200px;
      margin: 2rem auto 0;
      text-align: center;
    }
    
    .btn-register:hover {
      background-color: #003366;
      transform: translateY(-2px);
    }
    
    .alert {
      border-radius: 6px;
      margin-bottom: 1.5rem;
    }
    
    @media (max-width: 768px) {
      .form-group {
        flex: 0 0 100%;
      }
      
      .registration-body {
        padding: 1.5rem;
      }
    }
  </style>
</head>

<body class="bg-gradient-login">
    <!-- Register Content -->
    <div class="registration-container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card registration-card">
                    <div class="registration-header">
                        <h1>Panchayat Portal Registration</h1>
                    </div>
                    <div class="card-body registration-body">
                        <?php
                        if (isset($_SESSION['message'])) {
                            $message = $_SESSION['message'];
                            $message_type = $_SESSION['message_type'];
                            $user_id = $_SESSION['user_id'] ?? 'N/A';
                            echo "<div class='alert alert-$message_type'>$message</div>";
                            echo "<div class='alert alert-$message_type'>User Id: $user_id</div>";

                            unset($_SESSION['message']);
                            unset($_SESSION['message_type']);
                            unset($_SESSION['user_id']);
                        }
                        ?>
                        
                        <form method="post" action="api/register_user.php" class="user">
                            <!-- Personal Information Section -->
                            <div class="form-section">
                                <h3 class="form-section-title">Personal Information</h3>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Enter Full Name" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Mobile</label>
                                        <input type="text" class="form-control" id="mobile" name="mobile"
                                            placeholder="Enter Mobile Number" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" id="exampleInputEmail" name="email"
                                            aria-describedby="emailHelp" required placeholder="Enter Email Address">
                                    </div>
                                    <div class="form-group">
                                        <label>Designation</label>
                                        <input type="text" class="form-control" id="designation" name="designation"
                                            aria-describedby="emailHelp" required placeholder="Enter Designation">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Location Information Section -->
                            <div class="form-section">
                                <h3 class="form-section-title">Location Information</h3>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="state">State</label>
                                        <select class="select2-single-placeholder form-control" required
                                            name="state" id="state">
                                            <option value="">Select State</option>
                                            <?php
                                            if ($states->num_rows > 0) {
                                                while ($row = $states->fetch_assoc()) {
                                                    echo '<option value="' . htmlspecialchars($row['state']) . '">' . htmlspecialchars($row['state']) . '</option>';
                                                }
                                            } else {
                                                echo '<option value="">No States Found</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="district">District</label>
                                        <select class="select2-single-placeholder form-control" required
                                            name="district" id="district">
                                            <option value="">Select District</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="block">Block</label>
                                        <select class="select2-single-placeholder form-control" required
                                            name="block" id="block">
                                            <option value="">Select Block</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="district">Panchayat</label>
                                        <select class="select2-single-placeholder form-control" required
                                            name="panchayat" id="panchayat">
                                            <option value="">Select Panchayat</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="village">Village</label>
                                        <select class="select2-single-placeholder form-control" required
                                            name="village" id="village">
                                            <option value="">Select Village</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <!-- Empty div for alignment -->
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Account Information Section -->
                            <div class="form-section">
                                <h3 class="form-section-title">Account Information</h3>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" required name="password"
                                            id="exampleInputPassword" placeholder="Create Password">
                                    </div>
                                    <div class="form-group">
                                        <label>Repeat Password</label>
                                        <input type="password" class="form-control" required name="password_repeat"
                                            id="exampleInputPasswordRepeat" placeholder="Confirm Password">
                                    </div>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-register">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>
    <script src="vendor/select2/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.select2-single').select2();

            // Select2 Single  with Placeholder
            $('.select2-single-placeholder').select2({
                placeholder: "Select a Province",
                allowClear: true
            });

            // Select2 Multiple
            $('.select2-multiple').select2();
            $('#state').on('change', function () {
                var state = $(this).val();
                $.ajax({
                    url: 'api/get_district.php',
                    type: 'POST',
                    data: {
                        state: state
                    },
                    success: function (data) {
                        $('#district').html(data);
                        $('#village').html('<option value="">Select Village</option>');
                    }
                });
            });

            $('#district').on('change', function () {
                var district = $(this).val();
                $.ajax({
                    url: 'api/get_block.php',
                    type: 'POST',
                    data: {
                        district: district
                    },
                    success: function (data) {
                        $('#block').html(data);
                        $('#village').html('<option value="">Select Village</option>');
                    }
                });
            });
            $('#block').on('change', function () {
                var district = $(this).val();
                $.ajax({
                    url: 'api/get_panchayat.php',
                    type: 'POST',
                    data: {
                        district: district
                    },
                    success: function (data) {
                        $('#panchayat').html(data);
                        $('#village').html('<option value="">Select Village</option>');
                    }
                });
            });

            $('#panchayat').on('change', function () {
                var district = $(this).val();
                $.ajax({
                    url: 'api/get_villages.php',
                    type: 'POST',
                    data: {
                        district: district
                    },
                    success: function (data) {
                        $('#village').html(data);
                    }
                });
            });
        });
    </script>
</body>
</html>