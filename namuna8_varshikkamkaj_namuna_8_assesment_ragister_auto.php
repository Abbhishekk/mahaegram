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
       ?>
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <?php include('include/topbar.php');
        include('include/sidebar.php'); ?>
                <!-- Topbar -->

                <!-- Container Fluid-->
                <!-- Timeline Progress Section -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="border-end px-3">
                            <!-- Step 1 -->
                            <div class="d-flex align-items-start mb-4">
                                <i class="fa fa-briefcase text-secondary me-3 mt-1"></i>
                                <span class="text-danger fw-bold">मागील आर्थिक वर्षाचा व्यवहार पूर्ण करणे.</span>
                            </div>
                            <!-- Step 2 -->
                            <div class="d-flex align-items-start mb-4">
                                <i class="fa fa-check-square text-secondary me-3 mt-1"></i>
                                <span class="text-danger fw-bold">मिळकत कर दर ठरवणे.</span>
                            </div>
                            <!-- Step 3 -->
                            <div class="d-flex align-items-start mb-4">
                                <i class="fa fa-check-square text-secondary me-3 mt-1"></i>
                                <span class="text-danger fw-bold">आरोग्य व दिवाबत्ती कर दर ठरवणे.</span>
                            </div>
                            <!-- Step 4 -->
                            <div class="d-flex align-items-start mb-4">
                                <i class="fa fa-briefcase text-secondary me-3 mt-1"></i>
                                <span class="text-danger fw-bold">सामान्य पाणीपुरवठी दर ठरवणे.</span>
                            </div>
                            <!-- Step 5 -->
                            <div class="d-flex align-items-start">
                                <i class="fa fa-check-square text-secondary me-3 mt-1"></i>
                                <span class="text-danger fw-bold">रेडिरेटनर दर माहिती भरणे.</span>
                            </div>
                        </div>
                    </div>

                    <!-- Notice Section -->
                    <div class="col-md-8">
                        <div class="d-flex gap-2 mb-3">
                            <button class="btn btn-danger">प्रलंबित</button>
                            <button class="btn btn-warning">अंशतः</button>
                            <button class="btn btn-success">पूर्ण</button>
                        </div>

                        <h5 class="fw-bold mb-2">२०२४-२०२५ नमुना ८ एकत्र नोंदणी :</h5>
                        <div>
                            <p class="mb-2"><strong>सूचना :</strong> नमुना क्र. ८ कर आकारणी नोंद वही स्वयं:निर्मिती
                                प्रक्रिया</p>
                            <ol>
                                <li>नमुना क्र ८ माहिती संग्रहित झालेली नाही तरी आपण साठवणे बटन क्लिक करून माहिती
                                    संग्रहित करावी.</li>
                                <li>सन २०२४-२०२५ कालावधी साठी नमुना क्रमांक ८ स्वयं:निर्मिती प्रक्रिया यशस्वीरीत्या
                                    झाल्यानंतर ३ दिवसांतकर आकारणी नोंद वही गोषवारा पडताळणी करणे अनिवार्य आहे.</li>
                            </ol>
                            <button class="btn btn-primary mt-3">साठवा</button>
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


    document.addEventListener("DOMContentLoaded", function() {
        const decision_date = document.getElementById('decision_date');

        decision_date.value = new Date().toISOString().split('T')[0];

    });
    </script>
</body>

</html>