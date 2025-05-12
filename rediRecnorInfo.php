<?php 
    require_once './include/auth_middleware.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php 
$title = "रेडीरेकनर दर माहिती";
?>
<?php include('include/header.php'); ?>
<?php
    $readyRecInfo = $fun->getReadyrecInfo();
    $readyRecParts = $fun->getReadyrecParts();
$financialYears = $fun->getFinancialYears();
$lgdVillages = $fun->getVillagesWithDistrict($_SESSION['district_code']);
?>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php 
        $page = 'namuna8';
        $subpage = 'wardMaster';
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
                        <h1 class="h3 mb-0 text-gray-800">रेडीरेकनर दर माहिती</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">माहईग्राम</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 8</li>
                            <li class="breadcrumb-item active" aria-current="page">मास्टर्स</li>
                            <li class="breadcrumb-item active" aria-current="page">रेडीरेकनर दर माहिती</li>
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
                                    <form method="post" action="api/readyRec.php">
                                        <div class="row">

                                            <div class="form-group col-md-4">
                                                <label for="drainageType">आर्थिक वर्ष <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-control mb-3" name="financialYear"
                                                    id="financialYear">

                                                    <?php
                                                            if(mysqli_num_rows($financialYears) > 0){
                                                                while($financialYear = mysqli_fetch_assoc($financialYears)){
                                                                    echo "<option value='".$financialYear['year']."'>".$financialYear['year']."</option>";
                                                                }
                                                            }
                                                        ?>
                                                </select>

                                                <input type="number" value="" class="form-control d-none" name="update"
                                                    id="update" aria-describedby="emailHelp" placeholder="वॉर्डचे नाव">
                                            </div>
                                            <div class="form-group col-md-4 mx-auto">
                                                <label for="village_name">महसूल गावाचे नाव <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <select class="form-control select2-single-placeholder mb-3"
                                                    name="village_name" id="village_name">
                                                    <option value="" selected>--निवडा.--</option>
                                                    <?php
                                                            if(mysqli_num_rows($lgdVillages) > 0){
                                                                while($village = mysqli_fetch_assoc($lgdVillages)){
                                                                    echo "<option value='".$village['Village_Code']."'>".$village['Village_Name']."</option>";
                                                                }
                                                            }
                                                        ?>
                                                </select>

                                            </div>

                                            <div class="form-group col-md-4 mx-auto">
                                                <label for="readyrec_part">रेडीरेकनर प्रमाणे भाग/उपविभाग <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <select class="form-control mb-3" name="readyrec_part"
                                                    id="readyrec_part">
                                                    <option value="" selected>--निवडा.--</option>
                                                    <?php
                                                            if(mysqli_num_rows($readyRecParts) > 0){
                                                                while($readyRecPart = mysqli_fetch_assoc($readyRecParts)){
                                                                    echo "<option value='".$readyRecPart['readyrec_part']."'>".$readyRecPart['readyrec_part']."</option>";
                                                                }
                                                            }
                                                        ?>
                                                </select>

                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="land_type">जमिनीचा प्रकार
                                                </label>
                                                <input type="text" class="form-control" name="land_type" id="land_type"
                                                    aria-describedby="emailHelp" placeholder="जमिनीचा प्रकार">


                                            </div>

                                            <div class="col-md-4 my-3">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="recording1" name="recording"
                                                        value="जमिनीचे वार्षिक मूल्य दर नोंद करणे"
                                                        class="custom-control-input">
                                                    <label class="custom-control-label" for="recording1">जमिनीचे वार्षिक
                                                        मूल्य दर नोंद करणे</label>
                                                </div>

                                            </div>
                                            <div class="col-md-4 my-3">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="recording2" name="recording"
                                                        value="इमारतीचे वार्षिक मूल्य दर नोंद करणे"
                                                        class="custom-control-input">
                                                    <label class="custom-control-label" for="recording2">इमारतीचे
                                                        वार्षिक मूल्य दर नोंद करणे</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 my-3">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="recording3" name="recording"
                                                        value="ऑफिस वार्षिक मूल्य दर नोंद करणे"
                                                        class="custom-control-input">
                                                    <label class="custom-control-label" for="recording3">ऑफिस वार्षिक
                                                        मूल्य दर नोंद करणे</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 my-3">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="recording4" name="recording"
                                                        value="दुकान वार्षिक मूल्य दर नोंद करणे"
                                                        class="custom-control-input">
                                                    <label class="custom-control-label" for="recording4">दुकान वार्षिक
                                                        मूल्य दर नोंद करणे</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 my-3">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="recording5" name="recording"
                                                        value="औद्योगिक वार्षिक मूल्य दर नोंद करणे"
                                                        class="custom-control-input">
                                                    <label class="custom-control-label" for="recording5">औद्योगिक
                                                        वार्षिक मूल्य दर नोंद करणे</label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="yearly_tax">वार्षिक मूल्य दर <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" name="yearly_tax"
                                                    id="yearly_tax" aria-describedby="emailHelp"
                                                    placeholder="वार्षिक मूल्य दर" required>


                                            </div>

                                        </div>

                                        <p class="text-warning col-md-6 my-5 text-center mx-auto">टीप : नमुना क्रमांक ८
                                            स्वयं:निर्मित ( Auto Generate ) करण्याकरिता रेडीरेकनर दर फक्त एकदाच नोंद
                                            करता येणार आहे,तरी ग्रामपंचायतीने ठरवलेला अचूक दर नोंद करण्यात यावा.</p>
                                        <div class="w-100 mx-auto col-md-2">
                                            <button type="submit" name="add" class="btn btn-primary">साठवणे</button>
                                            <button type="reset" class="btn btn-secondary">रद्द करणे</button>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">

                                <div class="table-responsive">
                                    <table class="table align-items-center table-flush">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>अ.क्र.</th>
                                                <th>आर्थिक वर्ष</th>
                                                <th>महसूल गावाचे नाव</th>
                                                <th>रेडीरेकनर प्रमाणे भाग/उपविभाग</th>
                                                <th>जमिनीचा प्रकार</th>
                                                <th>वार्षिक मूल्य दर</th>
                                                <th>बदल</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if(mysqli_num_rows($readyRecInfo) > 0){
                                                    $i = 1;
                                                    while($readyRec = mysqli_fetch_assoc($readyRecInfo)){
                                                        // print_r($readyRec);
                                             ?>
                                            <tr>
                                                <td><a href="#"><?php echo $i; ?></a></td>
                                                <td><?php echo $readyRec['financial_years']; ?></td>
                                                <td><?php echo $readyRec['Village_Name']; ?></td>
                                                <td><?php echo $readyRec['readyrec_type']; ?></td>
                                                <td><?php echo $readyRec['land_type']; ?></td>
                                                <td><?php echo $readyRec['yearly_tax']; ?></td>
                                                <td>
                                                    <a href="#"
                                                        onclick="filldata('<?php echo $readyRec['id']; ?>', '<?php echo $readyRec['financial_years']; ?>', '<?php echo $readyRec['revenue_village']; ?>', '<?php echo $readyRec['readyrec_type']; ?>', '<?php echo $readyRec['land_type']; ?>', '<?php echo $readyRec['yearly_tax']; ?>', '<?php echo $readyRec['recordings']; ?>')">

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
                                            $i++;
                                                    }
                                                }else{
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
    function filldata(id, financialYear, revenueVillage, readyrecPart, landType, yearlyTax, recordings) {
        document.getElementById('update').value = id;
        document.getElementById('financialYear').value = financialYear;
        document.getElementById('village_name').value = revenueVillage;
        document.getElementById('readyrec_part').value = readyrecPart;
        document.getElementById('land_type').value = landType;
        document.getElementById('yearly_tax').value = yearlyTax;

        if (recordings) {
            const radioButton = document.querySelector(`input[name="recording"][value="${recordings}"]`);
            if (radioButton) {
                radioButton.checked = true;
            }
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        const decision_date = document.getElementById('decision_date');
        const redirecSelect = document.getElementById('readyrec_part');
        const land_type = document.getElementById('land_type');

        redirecSelect.addEventListener('change', function() {
            const selectedValue = redirecSelect.value;
            land_type.value = selectedValue;
        });
        decision_date.value = new Date().toISOString().split('T')[0];



    });
    </script>
</body>

</html>