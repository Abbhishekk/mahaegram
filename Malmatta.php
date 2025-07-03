<?php 
    require_once './include/auth_middleware.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php 
$title = "मालमत्ता माहिती";
?>
<?php include('include/header.php'); ?>
<?php
    $malmattas = $fun->getAllMalmatta();
    $periods = $fun->getPeriodDetails($_SESSION['district_code']);
    $revenueVillages = $fun->getRevenueVillages();
    $roadDetails = $fun->getRoad($_SESSION['district_code']);
    $wards = $fun->getWard($_SESSION['district_code']);
    $newNames = $fun->getNewName();
    $wifeNames = $fun->getNewName();
    $occupant_name = $fun->getNewName();
    $drainageTypes = $fun->getDrainageTypes();
?>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php 
        $page = 'namuna8';
        $subpage = 'malmatta';
       ?>
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <?php include('include/topbar.php'); 
        include('include/sidebar.php');?>
                <!-- Topbar -->

                <!-- Container Fluid-->
                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">मालमत्ता माहिती</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">पंचायत पोर्टलाम</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 8</li>
                            <li class="breadcrumb-item active" aria-current="page">मालमत्ता माहिती</li>
                            <li class="breadcrumb-item active" aria-current="page">मालमत्ता माहिती</li>
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
                                    <form method="post" action="api/Malmatta.php">
                                        <div class="row">

                                            <div class="form-group col-md-4">
                                                <label for="period">कालावधी<span class="text-danger">*</span>
                                                </label>
                                                <select name="period" id="period" class="form-control">
                                                    <option value="" selected>--निवडा--</option>
                                                    <?php
                                                        if(mysqli_num_rows($periods) > 0){
                                                            while($period = mysqli_fetch_assoc($periods)){
                                                                echo '<option value="'.$period['id'].'">'.$period['total_period'].'</option>';
                                                            }
                                                        }
                                                    ?>
                                                </select>

                                                <input type="number" value="" class="form-control d-none" name="update"
                                                    id="update" aria-describedby="emailHelp" placeholder="वॉर्डचे नाव">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="revenue_village">गावाचे नाव<span
                                                        class="text-danger">*</span>
                                                </label>
                                                <select name="revenue_village" id="revenue_village"
                                                    class="form-control">
                                                    <option value="" selected>--निवडा--</option>
                                                    <?php
                                                        if(mysqli_num_rows($revenueVillages) > 0){
                                                            while($revenueVillage = mysqli_fetch_assoc($revenueVillages)){
                                                                echo '<option value="'.$revenueVillage['id'].'">'.$revenueVillage['village_name'].'</option>';
                                                            }
                                                        }
                                                    ?>
                                                </select>

                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="road_name">गल्लीचे नाव/ अंतर्गत रस्त्याचे नाव<span
                                                        class="text-danger">*</span>
                                                </label>
                                                <select name="road_name" id="road_name" class="form-control">
                                                    <option value="" selected>--निवडा--</option>
                                                    <?php
                                                        if(mysqli_num_rows($roadDetails) > 0){
                                                            while($roadDetail = mysqli_fetch_assoc($roadDetails)){
                                                                echo '<option value="'.$roadDetail['id'].'">'.$roadDetail['road_name'].'</option>';
                                                            }
                                                        }
                                                    ?>
                                                </select>

                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="ward_name">वॉर्ड क्रं <span class="text-danger">*</span>
                                                </label>
                                                <select name="ward_name" id="ward_name" class="form-control">
                                                    <option value="" selected>--निवडा--</option>
                                                    <?php
                                                        if(mysqli_num_rows($wards) > 0){
                                                            while($ward = mysqli_fetch_assoc($wards)){
                                                                echo '<option value="'.$ward['id'].'">'.$ward['ward_name'].'</option>';
                                                            }
                                                        }
                                                    ?>
                                                </select>

                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="malmatta_no">मालमत्ता क्रमांक <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" name="malmatta_no"
                                                    id="malmatta_no" aria-describedby="emailHelp"
                                                    placeholder="मालमत्ता क्रमांक">


                                            </div>
                                            <div class="form-group col-md-5 mx-auto">
                                                <label for="owner_name">मालमत्ता धारकाचे नाव <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <select name="owner_name" id="owner_name" class="form-control">
                                                    <option value="" selected>--निवडा--</option>
                                                    <?php
                                                        if(mysqli_num_rows($newNames) > 0){
                                                            while($newName = mysqli_fetch_assoc($newNames)){
                                                                echo '<option value="'.$newName['id'].'">'.$newName['person_name'].'</option>';
                                                            }
                                                        }
                                                    ?>
                                                </select>

                                            </div>
                                            <div class="form-group col-md-2 d-flex align-items-end">
                                                <a href="Form_Name_Masters.php"> <button class="btn btn-primary"> नवीन
                                                        नाव नोंद </button></a>
                                            </div>

                                            <div class="form-group col-md-6 mx-auto">
                                                <label for="owner_wife_name">पत्नीचे नाव <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <select name="owner_wife_name" id="owner_wife_name" class="form-control"
                                                    required>
                                                    <option value="" selected>--निवडा--</option>
                                                    <?php
                                                        if(mysqli_num_rows($wifeNames) > 0){
                                                            while($newName = mysqli_fetch_assoc($wifeNames)){
                                                                echo '<option value="'.$newName['id'].'">'.$newName['person_name'].'</option>';
                                                            }
                                                        }
                                                    ?>
                                                </select>

                                            </div>

                                            <div class="form-group col-md-6 mx-auto">
                                                <label for="occupant_name">भोगवटा धारकाचे नाव <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <select name="occupant_name" id="occupant_name" class="form-control"
                                                    required>
                                                    <option value="" selected>--निवडा--</option>
                                                    <?php
                                                        if(mysqli_num_rows($occupant_name) > 0){
                                                            while($newName = mysqli_fetch_assoc($occupant_name)){
                                                                echo '<option value="'.$newName['id'].'">'.$newName['person_name'].'</option>';
                                                            }
                                                        }
                                                    ?>
                                                </select>

                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="mobile_no">मोबाईल क्रमांक <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" name="mobile_no" id="mobile_no"
                                                    aria-describedby="emailHelp" placeholder="मोबाईल क्रमांक" required>


                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="city_survey_no">सिटी सर्वे क्रमांक
                                                </label>
                                                <input type="text" class="form-control" name="city_survey_no"
                                                    id="city_survey_no" aria-describedby="emailHelp"
                                                    placeholder="सिटी सर्वे क्रमांक">


                                            </div>


                                            <div class="form-group col-md-4 mx-auto">
                                                <label for="group_number">गट क्रमांक / सर्व्हे क्रमांक
                                                </label>
                                                <input type="text" class="form-control" name="group_number"
                                                    id="group_number" aria-describedby="emailHelp"
                                                    placeholder="गट क्रमांक / सर्व्हे क्रमांक">


                                            </div>
                                            <div class="form-group col-md-4 mx-auto">
                                                <label for="drainage_type">पाणीवापर प्रकार <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <select name="drainage_type" id="drainage_type" class="form-control"
                                                    required>
                                                    <option value="" selected>--निवडा--</option>
                                                    <?php
                                                        if(mysqli_num_rows($drainageTypes) > 0){
                                                            while($drainageType = mysqli_fetch_assoc($drainageTypes)){
                                                                echo '<option value="'.$drainageType['drainage_type'].'">'.$drainageType['drainage_type'].'</option>';
                                                            }
                                                        }
                                                    ?>
                                                </select>

                                            </div>
                                            <div class="form-group col-md-4 mx-auto">
                                                <label for="toilet_available">शौचालय आहे
                                                </label>
                                                <select name="toilet_available" id="toilet_available"
                                                    class="form-control" required>
                                                    <option value="" selected>--निवडा--</option>
                                                    <option value="yes">आहे</option>
                                                    <option value="no">नाही</option>
                                                </select>

                                            </div>
                                            <div class="col-md-4 mx-auto d-flex align-items-end">
                                                <p>( मिळकत माहिती महा ई-ग्राम मोबाईल अँप वरती उपलब्ध होण्यासाठी कृपया
                                                    मिळकत धारकाचा मोबाईल क्रमांक अचूक नोंद करा.)</p>
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
                            <div class="card">

                                <div class="table-responsive">
                                    <table class="table align-items-center table-flush">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>अ.क्र.</th>
                                                <th>वॉर्डचे नाव</th>
                                                <th>मालमत्ता क्रमांक</th>
                                                <th>मालमत्ताधारक नाव</th>
                                                <th>भोगवटा धारक नाव</th>
                                                <th>मोबाईल क्रमांक</th>
                                                <th>सिटी सर्वे क्रमांक</th>
                                                <th>पाणीवापर प्रकार</th>
                                                <th>शौचालय</th>
                                                <th>कालावधी</th>
                                                <th>बदल</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
    if (mysqli_num_rows($malmattas) > 0) {
        $i = 1;
        while ($malmatta = mysqli_fetch_assoc($malmattas)) {
            // print_r($malmatta);
    ?>
                                            <tr>
                                                <td><a href="#"><?php echo $i++; ?></a></td>
                                                <td><?php echo $malmatta['ward_name']; ?></td>
                                                <td><?php echo $malmatta['malmatta_no']; ?></td>
                                                <td><?php echo $malmatta['owner']; ?></td>
                                                <td><?php echo $malmatta['occupant']; ?></td>
                                                <td><?php echo $malmatta['mobile_no']; ?></td>
                                                <td><?php echo $malmatta['city_survey_no']; ?></td>
                                                <td><?php echo $malmatta['drainage_type']; ?></td>
                                                <td><?php echo $malmatta['washroom_availbale']; ?></td>
                                                <td><?php echo $malmatta['total_period']; ?></td>
                                                <td>
                                                    <a href="#" onclick="filldata(
                    '<?php echo $malmatta['mt_id']; ?>',
                    '<?php echo $malmatta['ward']; ?>',
                    '<?php echo $malmatta['malmatta_no']; ?>',
                    '<?php echo $malmatta['owner_name']; ?>',
                    '<?php echo $malmatta['occupant_name']; ?>',
                    '<?php echo $malmatta['mobile_no']; ?>',
                    '<?php echo $malmatta['city_survey_no']; ?>',
                    '<?php echo $malmatta['drainage_type']; ?>',
                    '<?php echo $malmatta['washroom_availbale']; ?>',
                    '<?php echo $malmatta['period']; ?>',
                    '<?php echo $malmatta['village'] ?>',
                    '<?php echo $malmatta['road']; ?>',
                    '<?php echo $malmatta['wife_name'] ?>',
                    '<?php echo $malmatta['group_no'] ?>'
                )">
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
        echo "<tr><td colspan='11'>No data found</td></tr>";
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
    function filldata(id, ward, malmatta_no, owner_name, occupant_name, mobile_no, city_survey_no, drainage_type,
        washroom_available, period, village, road, wife_name, group_no) {
        console.log(id, ward, malmatta_no, owner_name, occupant_name, mobile_no, city_survey_no, drainage_type,
            washroom_available, period);

        document.getElementById('update').value = id;
        document.getElementById('ward_name').value = ward;
        document.getElementById('malmatta_no').value = malmatta_no;
        document.getElementById('owner_name').value = owner_name;
        document.getElementById('occupant_name').value = occupant_name;
        document.getElementById('mobile_no').value = mobile_no;
        document.getElementById('city_survey_no').value = city_survey_no;
        document.getElementById('drainage_type').value = drainage_type;
        document.getElementById('toilet_available').value = washroom_available;
        document.getElementById('period').value = period;
        document.getElementById('revenue_village').value = village;
        document.getElementById('road_name').value = road;
        document.getElementById('owner_wife_name').value = wife_name;
        document.getElementById('group_number').value = group_no;
    }



    document.addEventListener("DOMContentLoaded", function() {
        const decision_date = document.getElementById('decision_date');

        decision_date.value = new Date().toISOString().split('T')[0];

    });
    </script>
</body>

</html>