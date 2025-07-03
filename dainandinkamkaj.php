<?php 
    require_once './include/auth_middleware.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php 
$title = "Dashboard";
?>
<?php include('include/header.php'); ?>
<head>


</head>
<body id="page-top">
    <div id="wrapper">
       
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <?php include('include/topbar.php'); ?>
                <!-- Topbar -->
                 <!-- Sidebar -->
<?php include('include/sidebar.php'); ?>
 
 

               <!-- Sidebar -->

                <!-- Welcome Content Start -->
                <div class="container-fluid " style="">
                    <div class="card shadow mb-4">
                        <div class="card-body " style="background: linear-gradient(135deg, #e0f7fa, #80deea);height:78vh;padding-top:100px">
                            <h2 class="text-center text-primary font-weight-bold">🌿 पंचायत पोर्टल मध्ये आपले हार्दिक स्वागत आहे 🌿</h2>
                            <p class="text-center mt-4" style="font-size: 18px;">
                                ही प्रणाली ग्रामपंचायतमधील सर्व कामकाज, अहवाल व माहितीचे व्यवस्थापन सुलभ करण्यासाठी विकसित करण्यात आली आहे.
                                <br> कृपया पुढे जाण्यासाठी संबंधित विभाग निवडा.
                            </p>
                            
                        </div>
                        
                    </div>
                </div>
                <!-- Welcome Content End -->
            </div>
        </div>
    </div>


               

    <!-- Scroll to top -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php include('include/scripts.php'); ?>
</body>

</html> 