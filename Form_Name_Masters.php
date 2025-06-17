<?php
require_once './include/auth_middleware.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php
$title = "नवीन नाव नोंदणी";
?>
<?php include('include/header.php'); ?>
<?php
$newName = $fun->getNewName();
?>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php
        $page = 'namuna8';
        $subpage = 'malmatta';
        include('include/sidebar.php');
        ?>
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <?php include('include/topbar.php'); ?>
                <!-- Topbar -->

                <!-- Container Fluid-->
                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">नवीन नाव नोंदणी</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">माहईग्राम</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 8</li>
                            <li class="breadcrumb-item active" aria-current="page">मालमत्ता माहिती</li>
                            <li class="breadcrumb-item active" aria-current="page">नवीन नाव नोंदणी</li>
                        </ol>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="card mb-4">
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
                                <div class="card-body">
                                    <form method="post" action="api/newName.php">
                                        <div class="row">

                                            <div class="form-group col-md-4">
                                                <label for="person_name">व्यक्तिचे नाव <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" name="person_name"
                                                    id="person_name" aria-describedby="emailHelp"
                                                    placeholder="व्यक्तिचे नाव" required>



                                                <input type="number" value="" class="form-control d-none" name="update"
                                                    id="update" aria-describedby="emailHelp" placeholder="वॉर्डचे नाव">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="nickname">टोपणनाव
                                                </label>
                                                <input type="text" class="form-control" name="nickname" id="nickname"
                                                    aria-describedby="emailHelp" placeholder="टोपणनाव">


                                            </div>
                                            <div class="form-group col-md-4 mx-auto">
                                                <label for="gender">लिंग
                                                </label>
                                                <select class="form-control mb-3" name="gender" id="gender">
                                                    <option value="" selected>--निवडा--</option>
                                                    <option value="male">पुरुष</option>
                                                    <option value="female">महिला</option>
                                                    <option value="other">इतर</option>
                                                </select>

                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="mobile_no">मोबाईल क्रमांक
                                                </label>
                                                <input type="text" class="form-control" name="mobile_no" id="mobile_no"
                                                    aria-describedby="emailHelp" placeholder="मोबाईल क्रमांक">


                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="aadhar_no">आधार कार्ड क्रमांक
                                                </label>
                                                <input type="text" class="form-control" name="aadhar_no" id="aadhar_no"
                                                    aria-describedby="emailHelp" placeholder="आधार कार्ड क्रमांक">


                                            </div>


                                            <div class="form-group col-md-4 mx-auto">
                                                <label for="email">इ-मेल
                                                </label>
                                                <input type="text" class="form-control" name="email" id="email"
                                                    aria-describedby="emailHelp" placeholder="इ-मेल">


                                            </div>
                                        </div>


                                        <div class="w-100 mx-auto col-md-2">
                                            <button type="submit" name="add" class="btn btn-primary">साठवणे</button>
                                            <button type="reset" class="btn btn-secondary">रद्द करणे</button>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card p-5">

                                <div class="table-responsive">
                                    <table class="table align-items-center table-flush" id="dataTable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>अ.क्र.</th>
                                                <th>व्यक्तिचे नाव</th>
                                                <th>टोपणनाव</th>
                                                <th>मोबाईल क्रमांक</th>
                                                <th>आधार कार्ड क्रमांक</th>
                                                <th>इ-मेल</th>
                                                <th>लिंग</th>
                                                <th>बदल</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (mysqli_num_rows($newName) > 0) {
                                                $i = 1;
                                                while ($name = mysqli_fetch_assoc($newName)) {
                                                    // print_r($name);
                                                    ?>
                                                    <tr>
                                                        <td><a href="#"><?php echo $i++; ?></a></td>
                                                        <td><?php echo $name['person_name']; ?></td>
                                                        <td><?php echo $name['nickname']; ?></td>
                                                        <td><?php echo $name['mobile_no']; ?></td>
                                                        <td><?php echo $name['aadhar_no']; ?></td>
                                                        <td><?php echo $name['email']; ?></td>
                                                        <td><?php echo $name['gender']; ?></td>
                                                        <td>
                                                            <a href="#"
                                                                onclick="filldata('<?php echo $name['id']; ?>', '<?php echo $name['person_name']; ?>', '<?php echo $name['nickname']; ?>', '<?php echo $name['mobile_no']; ?>', '<?php echo $name['aadhar_no']; ?>', '<?php echo $name['email']; ?>', '<?php echo $name['gender']; ?>')">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                    fill="currentColor" class="bi bi-pencil-square"
                                                                    viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                                    <path fill-rule="evenodd"
                                                                        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                                                </svg>
                                                            </a>
                                                        </td>

                                                    </tr>
                                                    <?php
                                                }
                                            } else {
                                                echo "<tr><td colspan='4'>No data found</td></tr>";
                                            }
                                            ?>


                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer"></div>
                            </div>
                        </div>
                    </div>




                </div>
                <!---Container Fluid-->
            </div>
            <!-- Footer -->
            <?php include('include/footer.php'); ?>
            <!-- Footer -->
        </div>
    </div>

    <!-- Scroll to top -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php include('include/scripts.php'); ?>
    <script>
        function filldata(id, person_name, nickname, mobile_no, aadhar_no, email, gender) {
            console.log(id, person_name, nickname, mobile_no, aadhar_no, email, gender);

            document.getElementById('update').value = id;
            document.getElementById('person_name').value = person_name;
            document.getElementById('nickname').value = nickname;
            document.getElementById('mobile_no').value = mobile_no;
            document.getElementById('aadhar_no').value = aadhar_no;
            document.getElementById('email').value = email;
            document.getElementById('gender').value = gender;
        }


        document.addEventListener("DOMContentLoaded", function () {
            const decision_date = document.getElementById('decision_date');

            decision_date.value = new Date().toISOString().split('T')[0];

        });
    </script>
</body>

</html>