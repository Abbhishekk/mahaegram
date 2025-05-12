<?php 
    require_once './include/auth_middleware.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php 
$title = "मालमत्ता माहिती प्रमाणिकरण";
?>
<?php include('include/header.php'); ?>
<?php
    $newName = $fun->getNewName();
    $periods = $fun->getPeriodDetails($_SESSION['district_code']);
?>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php 
        $page = 'namuna8';
        $subpage = 'varshik_kamkaj';
        include('include/sidebar.php');
       ?>
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <?php include('include/topbar.php'); ?>
                <!-- Topbar -->

                <!-- Container Fluid-->
                <div class="container-fluid bg-light p-4 rounded">
                    <h5 class="mb-4 text-center font-weight-bold">
                        असेसमेंट रजिस्टर्स ( कर नोंद वही ) घोषणाद्वारा प्रमाणिकरण कर आकारणी नोंद वही कालावधी 2023 - 2027
                    </h5>

                    <!-- Section: Card Counters -->
                    <div class="row text-center mb-4">
                        <div class="col-md-4 mb-3">
                            <div class="bg-primary text-white p-4 rounded shadow-sm">
                                <h5 class="mb-2">उद्दिष्ट</h5>
                                <h3>859</h3>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="bg-success text-white p-4 rounded shadow-sm">
                                <h5 class="mb-2">पूर्तता</h5>
                                <h3>859</h3>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="bg-danger text-white p-4 rounded shadow-sm">
                                <h5 class="mb-2">प्रलंबित</h5>
                                <h3>0</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead class="bg-info text-white">
                                <tr>
                                    <th>तपशील</th>
                                    <th>कराची रक्कम</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>इमारत / पाडसर कर</td>
                                    <td>₹ 388031</td>
                                </tr>
                                <tr>
                                    <td>दिवाबत्ती कर</td>
                                    <td>₹ 16440</td>
                                </tr>
                                <tr>
                                    <td>आरोग्य कर</td>
                                    <td>₹ 16360</td>
                                </tr>
                                <tr>
                                    <td>सामान्य पाणीपुरवठा कर</td>
                                    <td>₹ 35025</td>
                                </tr>
                                <tr>
                                    <th>एकूण कर</th>
                                    <th>₹ 455856</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Declaration -->
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="confirmCheck" checked>
                        <label class="form-check-label" for="confirmCheck">
                            मी सन 2023 - 2027 कालावधीची कर नोंद वही (नमुना 8) घोषणाद्वारा प्रमाणित करत आहे.
                            घोषणाद्वारा प्रमाणित करण्यापूर्वी मी नमुना 8 च्या सर्व नोंदी प्रमाणित करून त्या अनुषंगाने
                            खात्री केली आहे.
                            घोषणाद्वारा प्रमाणित केल्यानंतर नमुना 8 मध्ये बदल करण्यासाठी फेरफार पर्याय वापरावा लागेल
                            याची मला जाणीव आहे.
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center">
                        <button class="btn btn-primary px-4 py-2">प्रमाणित</button>
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


    document.addEventListener("DOMContentLoaded", function() {
        const decision_date = document.getElementById('decision_date');

        decision_date.value = new Date().toISOString().split('T')[0];

    });
    </script>
</body>

</html>