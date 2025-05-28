<?php 
    require_once './include/auth_middleware.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php 
$title = "ग्रामपंचायत नमुना 8 डाटा एन्ट्री";
?>
<?php include('include/header.php'); ?>
<style>
/* Style for the modal overlay */
.image-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.9);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
    cursor: zoom-out;
}

/* Style for the enlarged image */
.enlarged-image {
    max-width: 90%;
    max-height: 90%;
    object-fit: contain;
}

/* Style for thumbnail images */
.thumbnail-img {
    transition: transform 0.2s;
    border-radius: 4px;
    border: 1px solid #ddd;
}

.thumbnail-img:hover {
    transform: scale(1.05);
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
}

/* Close button style */
.close-btn {
    position: absolute;
    top: 20px;
    right: 30px;
    color: white;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
}

.close-btn:hover {
    color: #ccc;
}
</style>
<?php
    $malmattas = $fun->getAllMalmatta();
    $periods = $fun->getPeriodDetails($_SESSION['district_code']);
    $periodsWithReasons = $fun->getPeriodTotalPeriodsWithPeriodReason("नमुना नंबर 8 कालावधी", $_SESSION['district_code']);
    $revenueVillages = $fun->getRevenueVillages();
    $roadDetails = $fun->getRoad($_SESSION['district_code']);
    $wards = $fun->getWard($_SESSION['district_code']);
    $newNames = $fun->getNewName();
    $wifeNames = $fun->getNewName();
    $occupant_name = $fun->getNewName();
    $tapOwner = $fun->getNewName();
    $drainageTypes = $fun->getDrainageTypes();

    $incomeTypes = $fun->getIncomeType();
    $taxExempts = $fun->getTaxExempt();
    $malmattaUses = $fun->getMalmattaUse();
    $malmattataxTypes = $fun->getMalmattaTaxType();
    $redyrecs = $fun->getReadyrecInfo();
    $buildingFloors = $fun->getBuildingFloors();
$lgdVillages = $fun->getVillagesWithPanchayat($_SESSION['panchayat_code']);

?>

<body id="page-top">
    <!-- Full Screen Loader -->
<div id="fullScreenLoader" class="full-screen-loader">
    <div class="loader-content">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <p class="mt-3 text-white">प्रक्रिया सुरू आहे... कृपया प्रतीक्षा करा</p>
    </div>
</div>

<style>
.full-screen-loader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    flex-direction: column;
}

.loader-content {
    text-align: center;
    color: white;
}

.loader-content p {
    font-size: 1.2rem;
}
</style>
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
                        <h1 class="h3 mb-0 text-gray-800">ग्रामपंचायत नमुना 8 डाटा एन्ट्री</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">माहईग्राम</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 8</li>
                            <li class="breadcrumb-item active" aria-current="page">ग्रामपंचायत नमुना 8 डाटा एन्ट्री</li>
                            <li class="breadcrumb-item active" aria-current="page">ग्रामपंचायत नमुना 8 डाटा एन्ट्री</li>
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
                                    <form method="post" id="malmattaForm" action="api/newMalmatta.php" enctype="multipart/form-data">
                                        <div>
                                            <h5 class="bg-gradient-primary text-white py-3 px-5 w-25 rounded-pill">
                                                मालमत्ता
                                                माहिती
                                            </h5>
                                            <div class="row">

                                                <div class="form-group col-md-4">
                                                    <label for="period">कालावधी<span class="text-danger">*</span>
                                                    </label>
                                                    <select name="period" id="period" class="form-control">
                                                        <option value="" selected>--निवडा--</option>
                                                        <?php
                                                            if(mysqli_num_rows($periodsWithReasons) > 0){
                                                                while($periodsWithReason = mysqli_fetch_assoc($periodsWithReasons)){
                                                                    echo '<option value="'.$periodsWithReason['id'].'">'.$periodsWithReason['total_period'].'</option>';
                                                                }
                                                            }
                                                        ?>
                                                    </select>

                                                    <input type="number" value="" class="form-control d-none"
                                                        name="update" id="update" aria-describedby="emailHelp"
                                                        placeholder="वॉर्डचे नाव">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="revenue_village">गावाचे नाव<span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <select class="form-control select2-single-placeholder mb-3"
                                                        name="revenue_village" id="revenue_village">
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
                                                    <a href="Form_Name_Masters.php"> <button
                                                            class="btn btn-primary bg-gradient-success">
                                                            नवीन
                                                            नाव नोंद </button></a>
                                                </div>

                                                <div class="form-group col-md-6 mx-auto">
                                                    <label for="owner_wife_name">पत्नीचे नाव <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <select name="owner_wife_name" id="owner_wife_name"
                                                        class="form-control" required>
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
                                                <!-- <div class="form-group col-md-4">
                                                    <label for="mobile_no">मोबाईल क्रमांक <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control" name="mobile_no"
                                                        id="mobile_no" aria-describedby="emailHelp"
                                                        placeholder="मोबाईल क्रमांक" required>


                                                </div> -->
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
                                                    <label for="toilet_available">शौचालय आहे <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <select name="toilet_available" id="toilet_available"
                                                        class="form-control" required>
                                                        <option value="" selected>--निवडा--</option>
                                                        <option value="yes">आहे</option>
                                                        <option value="no">नाही</option>
                                                    </select>

                                                </div>
                                                <div class="col-md-4 mx-auto d-flex align-items-end">
                                                    <p>( मिळकत माहिती महा ई-ग्राम मोबाईल अँप वरती उपलब्ध होण्यासाठी
                                                        कृपया
                                                        मिळकत धारकाचा मोबाईल क्रमांक अचूक नोंद करा.)</p>
                                                </div>
                                            </div>


                                            <div class="w-75 col-12 card row py-5 px-4 my-5 mx-auto">
                                                <div class="row">

                                                    <div class="form-group col-md-4 mx-auto">
                                                        <label for="income_type">मिळकत प्रकार
                                                        </label>
                                                        <select name="income_type" id="income_type"
                                                            class="form-control">
                                                            <option value="" selected>--निवडा--</option>
                                                            <?php
                                                                if(mysqli_num_rows($incomeTypes) > 0){
                                                                    while($incomeType = mysqli_fetch_assoc($incomeTypes)){
                                                                        echo '<option value="'.$incomeType['income_type'].'">'.$incomeType['income_type'].'</option>';
                                                                    }
                                                                }
                                                            ?>
                                                        </select>

                                                    </div>
                                                    <div class="form-group col-md-4 mx-auto">
                                                        <label for="income_other_info">मिळकत इतर माहिती चतु:सीमा <span
                                                                class="text-danger">*</span>
                                                        </label>
                                                        <input type="text" class="form-control" name="income_other_info"
                                                            id="income_other_info" aria-describedby="emailHelp"
                                                            placeholder="पूर्व, पश्चिम, उत्तर, दक्षिण ">


                                                    </div>
                                                    <div class="form-group col-md-4 mx-auto">
                                                        <label for="taxable_land">करातून सुट/करपात्र असणाऱ्या जमिनी व
                                                            इमारती
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <select name="taxable_land" id="taxable_land"
                                                            class="form-control">
                                                            <option value="" selected>--निवडा--</option>
                                                            <?php
                                                                if(mysqli_num_rows($taxExempts) > 0){
                                                                    while($taxExempt = mysqli_fetch_assoc($taxExempts)){
                                                                        echo '<option value="'.$taxExempt['tax_exempt'].'">'.$taxExempt['tax_exempt'].'</option>';
                                                                    }
                                                                }
                                                            ?>
                                                        </select>

                                                    </div>
                                                    <div class="form-group col-md-4 mx-auto">
                                                        <label for="property_use">मालमत्ता वापर

                                                        </label>
                                                        <select name="property_use" id="property_use"
                                                            class="form-control">
                                                            <option value="" selected>--निवडा--</option>
                                                            <?php
                                                                if(mysqli_num_rows($malmattaUses) > 0){
                                                                    while($malmattaUse = mysqli_fetch_assoc($malmattaUses)){
                                                                        echo '<option value="'.$malmattaUse['malmatta_use'].'">'.$malmattaUse['malmatta_use'].'</option>';
                                                                    }
                                                                }
                                                            ?>
                                                        </select>

                                                    </div>
                                                    <div class="form-group col-md-4 mx-auto">
                                                        <label for="tax_type">मालमत्ता कर प्रकार

                                                        </label>
                                                        <select name="tax_type" id="tax_type" class="form-control">
                                                            <option value="" selected>--निवडा--</option>
                                                            <?php
                                                                if(mysqli_num_rows($redyrecs) > 0){
                                                                    while($redyrec = mysqli_fetch_assoc($redyrecs)){
                                                                        echo '<option value="'.$redyrec['rid'].'">'.$redyrec['land_type'].'</option>';
                                                                    }
                                                                }
                                                            ?>
                                                        </select>

                                                    </div>
                                                    <div class="form-group col-md-4 mx-auto">
                                                        <label for="redirecenarParts">रेडिरेकनर प्रमाणे भाग / उपविभाग

                                                        </label>
                                                        <textarea name="redirecenarParts" class="form-control"
                                                            id="redirecenarParts" readonly></textarea>



                                                    </div>
                                                    <div class="form-group col-md-4 mx-auto">
                                                        <div>
                                                            <input type="radio" name="construction_year_type"
                                                                id="construction_year" value="construction_year">
                                                            <label for="construction_year">बांधकाम वर्ष</label>
                                                            <input type="radio" name="construction_year_type"
                                                                id="building_age" value="building_age">
                                                            <label for="building_age">वय</label>

                                                        </div>
                                                        <input type="text" class="form-control" name="age" id="age"
                                                            aria-describedby="emailHelp" placeholder="">


                                                    </div>
                                                    <div class="form-group col-md-4 mx-auto">
                                                        <label for="floors">मजला

                                                        </label>
                                                        <select name="floors" id="floors" class="form-control">
                                                            <option value="" selected>--निवडा--</option>
                                                            <?php
                                                                if(mysqli_num_rows($buildingFloors) > 0){
                                                                    while($buildingFloor = mysqli_fetch_assoc($buildingFloors)){
                                                                        echo '<option value="'.$buildingFloor['floor_name'].'">'.$buildingFloor['floor_name'].'</option>';
                                                                    }
                                                                }
                                                            ?>
                                                        </select>

                                                    </div>

                                                    <div class="form-group col-md-4 mx-auto my-auto">
                                                        <label for="">इमारतीचे क्षेत्रफळ :</label>
                                                        <div>
                                                            <input type="radio" name="measuring_unit" id="ft"
                                                                value="foot" checked>
                                                            <label for="ft">फूट (Foot)</label>
                                                            <input type="radio" name="measuring_unit" id="meter"
                                                                value="meter">
                                                            <label for="meter">मीटर (Meter)</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-4 mx-auto">
                                                        <label for="height">लांबी
                                                        </label>
                                                        <input type="number" class="form-control" name="height"
                                                            id="height" aria-describedby="emailHelp" placeholder="0">


                                                    </div>

                                                    <div class="form-group col-md-4 mx-auto">
                                                        <label for="width">रुंदी
                                                        </label>
                                                        <input type="number" class="form-control" name="width"
                                                            id="width" aria-describedby="emailHelp" placeholder="0">


                                                    </div>
                                                    <div class="form-group col-md-4 mx-auto">
                                                        <label for="area">क्षेत्रफळ (Area)</label>
                                                        <input type="number" class="form-control" name="area" id="area"
                                                            aria-describedby="emailHelp" placeholder="0" readonly>
                                                        <small id="areaUnit" class="form-text text-muted">फूट (Square
                                                            Feet)</small>
                                                    </div>

                                                    <div class="form-group col-md-4 mx-auto">
                                                        <label for="converted_area">रूपांतरित क्षेत्रफळ (Converted
                                                            Area)</label>
                                                        <input type="number" class="form-control" name="converted_area"
                                                            id="converted_area" aria-describedby="emailHelp"
                                                            placeholder="0" readonly>
                                                        <small id="convertedAreaUnit" class="form-text text-muted">मीटर
                                                            (Square Meters)</small>
                                                    </div>
                                                    <!-- Change the file input in your dynamic property section -->
                                                    <div class="form-group col-md-4 mx-auto">
                                                        <label for="property_photo">मालमत्ता फोटो</label>
                                                        <input type="file" class="form-control property-photo-input"
                                                            name="property_photos[]" multiple>
                                                    </div>
                                                    <!-- <div class="form-group col-md-4 mx-auto my-auto">
                                                        <button class="btn btn-primary bg-gradient-primary">
                                                            ADD</button>
                                                    </div> -->
                                                </div>
                                                <button type="button" name="add_property" id="add_property"
                                                    class="btn btn-primary bg-gradient-primary">add</button>

                                                <input type="hidden" name="income_data" id="income_data" />
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table align-items-center table-flush" id="income_table"
                                                    border="1">
                                                    <thead>
                                                        <tr>
                                                            <th>मिळकत प्रकार</th>
                                                            <th>मिळकत इतर माहिती चतु:सीमा</th>
                                                            <th>करातून सुट/करपात्र असणाऱ्या जमिनी व इमारती</th>
                                                            <th>मालमत्ता वापर</th>
                                                            <th>मालमत्ता कर प्रकार</th>
                                                            <th>रेडिरेकनर प्रमाणे भाग / उपविभाग</th>
                                                            <th>बांधकाम वर्ष/वय</th>
                                                            <th>मजला</th>
                                                            <th>इमारतीचे क्षेत्रफळ :</th>
                                                            <th>लांबी</th>
                                                            <th>रुंदी</th>
                                                            <th>क्षेत्रफळ (Area)</th>
                                                            <th>रूपांतरित क्षेत्रफळ (Converted Area)</th>
                                                            <th>मालमत्ता फोटो</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div>
                                            <h5 class="bg-gradient-primary text-white py-3 px-5 w-25 rounded-pill">
                                                पाणीवापर
                                            </h5>
                                            <div class="w-75 col-12 card row py-5 px-4 my-5 mx-auto">
                                                <div class="row">

                                                    <div class="form-group col-md-3 mx-auto">
                                                        <label for="drainage_type">पाणीवापर प्रकार <span
                                                                class="text-danger">*</span>
                                                        </label>
                                                        <select name="drainage_type" id="drainage_type"
                                                            class="form-control" required>
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
                                                    <div class="form-group col-md-3 mx-auto">
                                                        <label for="tap_numbers">नळ संख्या
                                                        </label>
                                                        <input type="number" class="form-control" name="tap_numbers"
                                                            id="tap_numbers" aria-describedby="emailHelp"
                                                            placeholder="नळ संख्या" value="0">


                                                    </div>
                                                    <div class="form-group col-md-3 mx-auto">
                                                        <label for="tap_width">नळ व्यास

                                                        </label>
                                                        <select name="tap_width" id="tap_width" class="form-control"
                                                            required>
                                                            <option value="" selected>--निवडा--</option>
                                                            <option value="1/2">1/2</option>
                                                            <option value="1">1</option>
                                                            <option value="3/4">3/4</option>
                                                        </select>

                                                    </div>
                                                    <div class="form-group col-md-3 mx-auto">
                                                        <label for="tap_owner_name">नळ धारकाचे नाव

                                                        </label>
                                                        <select name="tap_owner_name" id="tap_owner_name"
                                                            class="form-control">
                                                            <option value="" selected>--निवडा--</option>
                                                            <?php
                                                                if(mysqli_num_rows($tapOwner) > 0){
                                                                    while($tapOwners = mysqli_fetch_assoc( $tapOwner)){
                                                                        echo '<option value="'.$tapOwners['id'].'">'.$tapOwners['person_name'].'</option>';
                                                                    }
                                                                }
                                                            ?>
                                                        </select>

                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <h5 class="bg-gradient-primary text-white py-3 px-5 w-25 rounded-pill">
                                                शेरा / बोजा नोंद
                                            </h5>
                                            <div class="w-75 col-12 card row py-5 px-4 my-5 mx-auto">
                                                <div class="row">

                                                    <div class="form-group col-md-12 mx-auto">
                                                        <label for="remarks">शेरा / बोजा
                                                        </label>
                                                        <textarea name="remarks" id="remarks" class="form-control"
                                                            placeholder="शेरा / बोजा नोंद"></textarea>

                                                    </div>



                                                </div>
                                            </div>
                                        </div>


                                        <div class="w-100 mx-auto col-md-2">
                                            <button type="submit" name="add"
                                                class="btn btn-primary bg-gradient-primary">साठवणे</button>
                                            <button type="reset" class="btn btn-secondary bg-gradient-secondary">रद्द
                                                करणे</button>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 d-none">
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
    ?>
                                            <tr>
                                                <td><a href="#"><?php echo $i++; ?></a></td>
                                                <td><?php echo $malmatta['ward']; ?></td>
                                                <td><?php echo $malmatta['malmatta_no']; ?></td>
                                                <td><?php echo $malmatta['owner_name']; ?></td>
                                                <td><?php echo $malmatta['occupant_name']; ?></td>
                                                <td><?php echo $malmatta['mobile_no']; ?></td>
                                                <td><?php echo $malmatta['city_survey_no']; ?></td>
                                                <td><?php echo $malmatta['drainage_type']; ?></td>
                                                <td><?php echo $malmatta['washroom_availbale']; ?></td>
                                                <td><?php echo $malmatta['period']; ?></td>
                                                <td>
                                                    <a href="#" onclick="filldata(
                    '<?php echo $malmatta['id']; ?>',
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
        const heightInput = document.getElementById("height");
        const widthInput = document.getElementById("width");
        const areaInput = document.getElementById("area");
        const redyrecInfo = document.getElementById("tax_type");
        const redyrecParts = document.getElementById("redirecenarParts");

        redyrecInfo.addEventListener("change", fetchRedirecenarParts);

        function fetchRedirecenarParts() {
            const taxType = document.getElementById('tax_type').value;

            if (!taxType) return;

            fetch(`api/getRedirecenarParts.php?tax_type=${taxType}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data);

                    document.getElementById('redirecenarParts').value = data.readyrec_type ||
                        'No data found';
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('redirecenarParts').value = 'Error fetching data';
                });
        }

        function calculateArea() {
            const height = parseFloat(heightInput.value) || 0;
            const width = parseFloat(widthInput.value) || 0;
            const area = height * width;
            areaInput.value = area;
        }

        heightInput.addEventListener("input", calculateArea);
        widthInput.addEventListener("input", calculateArea);
    });
    document.addEventListener("DOMContentLoaded", function() {
        const heightInput = document.getElementById("height");
        const widthInput = document.getElementById("width");
        const areaInput = document.getElementById("area");
        const convertedAreaInput = document.getElementById("converted_area");
        const areaUnitLabel = document.getElementById("areaUnit");
        const convertedAreaUnitLabel = document.getElementById("convertedAreaUnit");
        const footRadio = document.getElementById("ft");
        const meterRadio = document.getElementById("meter");

        // Function to convert between units
        function convertArea(area, fromUnit, toUnit) {
            if (fromUnit === 'foot' && toUnit === 'meter') {
                return area * 0.092903; // 1 sq ft = 0.092903 sq m
            } else if (fromUnit === 'meter' && toUnit === 'foot') {
                return area * 10.7639; // 1 sq m = 10.7639 sq ft
            }
            return area;
        }

        // Function to calculate and display areas
        function calculateAndDisplayAreas() {
            const height = parseFloat(heightInput.value) || 0;
            const width = parseFloat(widthInput.value) || 0;
            let area = height * width;

            if (meterRadio.checked) {
                // Original input is in meters
                areaInput.value = area.toFixed(2);
                areaUnitLabel.textContent = "मीटर (Square Meters)";

                // Convert to feet
                const convertedArea = convertArea(area, 'meter', 'foot');
                convertedAreaInput.value = convertedArea.toFixed(2);
                convertedAreaUnitLabel.textContent = "फूट (Square Feet)";
            } else {
                // Original input is in feet
                areaInput.value = area.toFixed(2);
                areaUnitLabel.textContent = "फूट (Square Feet)";

                // Convert to meters
                const convertedArea = convertArea(area, 'foot', 'meter');
                convertedAreaInput.value = convertedArea.toFixed(2);
                convertedAreaUnitLabel.textContent = "मीटर (Square Meters)";
            }
        }

        // Event listeners
        heightInput.addEventListener("input", calculateAndDisplayAreas);
        widthInput.addEventListener("input", calculateAndDisplayAreas);

        footRadio.addEventListener("change", function() {
            if (this.checked) {
                calculateAndDisplayAreas();
            }
        });

        meterRadio.addEventListener("change", function() {
            if (this.checked) {
                calculateAndDisplayAreas();
            }
        });

        // Initialize with foot selected
        calculateAndDisplayAreas();
    });


    document.getElementById('malmattaForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Update the hidden input with latest data
    document.getElementById("income_data").value = JSON.stringify(incomeEntries);
    
    // Create FormData object
    const formData = new FormData(this);
    
    // Add property photos separately
    incomeEntries.forEach((entry, index) => {
        if (entry.propertyPhoto) {
            // Convert base64 to blob
            const blob = dataURLtoBlob(entry.propertyPhoto);
            formData.append(`property_photos[${index}]`, blob, entry.photoName || `property_${index}.jpg`);
        }
    });
    formData.append("add", "yes");
    
    // Submit via AJAX
    fetch(this.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            console.log(data);
            const baseURL = window.location.origin;
            const redirectURL = data.redirect ? `${baseURL}/mahaegram-master/${data.redirect}` : baseURL;
            alert(data.message || 'Form submitted successfully');
            console.log(redirectURL);
            
            
            // window.location.href = `/mahaegram-master/${data.redirect}` || window.location.href;
        } else {
            alert(data.message || 'Error occurred');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error submitting form');
    });
});

function dataURLtoBlob(dataurl) {
    var arr = dataurl.split(','), mime = arr[0].match(/:(.*?);/)[1],
        bstr = atob(arr[1]), n = bstr.length, u8arr = new Uint8Array(n);
    for (var i = 0; i < n; i++) {
        u8arr[i] = bstr.charCodeAt(i);
    }
    return new Blob([u8arr], {type:mime});
}
    </script>

    <script>
    let incomeEntries = [];

    document.getElementById("add_property").addEventListener("click", () => {
        const incomeType = document.getElementById('income_type');
        const incomeTypeValue = incomeType.value.trim();
        const incomeOtherInfo = document.getElementById('income_other_info');
        const incomeOtherInfoValue = incomeOtherInfo.value.trim();
        const taxableLand = document.getElementById('taxable_land');
        const taxableLandValue = taxableLand.value.trim();
        const propertyUse = document.getElementById('property_use');
        const propertyUseValue = propertyUse.value.trim();
        const taxType = document.getElementById('tax_type');
        const taxTypeValue = taxType.value.trim();
        const taxTypeText = taxType.options[taxType.selectedIndex].text;
        const redirecenarParts = document.getElementById('redirecenarParts');
        const redirecenarPartsValue = redirecenarParts.value.trim();
        const constructionYear = document.getElementById('construction_year');
        const constructionYearValue = constructionYear.value.trim();
        const buildingAge = document.getElementById('building_age');
        const buildingAgeValue = buildingAge.value.trim();
        const selectedConstructionType = document.querySelector('input[name="construction_year_type"]:checked');

        const fileInput = document.querySelector('.property-photo-input');
        const photoFile = fileInput.files[0];
        let photoData = null;
        let construction_year_type = "";
        if (selectedConstructionType) {
            construction_year_type = selectedConstructionType.value;
            console.log("Selected:", construction_year_type); // either "construction_year" or "building_age"
        } else {
            construction_year_type = "";
            console.log("No option selected");
        }

        const age = document.getElementById('age');
        const ageValue = age.value.trim();
        const floors = document.getElementById('floors');
        const floorsValue = floors.value.trim();
        const ft = document.getElementById('ft');
        const ftValue = ft.value.trim();
        const meter = document.getElementById('meter');
        const meterValue = meter.value.trim();

        const selectedUnit = document.querySelector('input[name="measuring_unit"]:checked');
        let selectedUnitValue = "";
        if (selectedUnit) {
            selectedUnitValue = selectedUnit.value;
            console.log("Selected unit:", selectedUnitValue); // "foot" or "meter"
        } else {
            selectedUnitValue = "";
            console.log("No unit selected");
        }

        const height = document.getElementById('height');
        const heightValue = height.value.trim();
        const width = document.getElementById('width');
        const widthValue = width.value.trim();
        const area = document.getElementById('area');
        const areaValue = area.value.trim();
        const convertedArea = document.getElementById('converted_area');
        const convertedAreaValue = convertedArea.value.trim();


        if (photoFile) {
            const reader = new FileReader();
            reader.onload = (e) => {
                photoData = e.target.result;
                // Add to entries
                incomeEntries.push({
                    taxTypeId: taxTypeValue,
                    area: area,
                    incomeType: incomeTypeValue,
                    incomeOtherInfo: incomeOtherInfoValue,
                    taxableLand: taxableLandValue,
                    propertyUse: propertyUseValue,
                    taxType: taxTypeText,
                    redirecenarParts: redirecenarPartsValue,
                    constructionYear: constructionYearValue,
                    buildingAge: buildingAgeValue,
                    construction_year_type: construction_year_type,
                    age: ageValue,
                    floors: floorsValue,
                    selectedUnit: selectedUnitValue,
                    ft: ftValue,
                    meter: meterValue,
                    height: heightValue,
                    width: widthValue,
                    area: areaValue,
                    convertedArea: convertedAreaValue,
                    propertyPhoto: photoData,
                    photoName: photoFile.name
                });
                renderIncomeTable();
            };
            reader.readAsDataURL(photoFile);
        } else {
            incomeEntries.push({
                taxTypeId: taxTypeValue,
                area: area,
                incomeType: incomeTypeValue,
                incomeOtherInfo: incomeOtherInfoValue,
                taxableLand: taxableLandValue,
                propertyUse: propertyUseValue,
                taxType: taxTypeText,
                redirecenarParts: redirecenarPartsValue,
                constructionYear: constructionYearValue,
                buildingAge: buildingAgeValue,
                construction_year_type: construction_year_type,
                age: ageValue,
                floors: floorsValue,
                selectedUnit: selectedUnitValue,
                ft: ftValue,
                meter: meterValue,
                height: heightValue,
                width: widthValue,
                area: areaValue,
                convertedArea: convertedAreaValue,
                propertyPhoto: null,
                photoName: null
            });
            renderIncomeTable();

        }


        // Clear inputs
        incomeType.value = "";
        incomeOtherInfo.value = "";
        taxableLand.value = "";
        propertyUse.value = "";
        taxType.value = "";
        redirecenarParts.value = "";
        age.value = "";
        floors.value = "";
        ft.value = "";
        meter.value = "";
        height.value = "";
        width.value = "";
        area.value = "";
        convertedArea.value = "";


        // Store in hidden input
        document.getElementById("income_data").value = JSON.stringify(incomeEntries);
        console.log(incomeEntries);

        fileInput.value = '';
    });

    function renderIncomeTable() {
        const tbody = document.getElementById("income_table").querySelector("tbody");
        tbody.innerHTML = "";

        incomeEntries.forEach((entry, index) => {
            const photoCell = entry.propertyPhoto ?
                `<td><img src="${entry.propertyPhoto}" 
                 width="50" height="50" 
                 class="thumbnail-img"
                 style="cursor: pointer;"
                 data-fullimg="${entry.propertyPhoto}"
                 onclick="showFullImage(this)"></td>` :
                `<td>No photo</td>`;

            const row = `<tr>
            <td>${entry.incomeType}</td>
            <td>${entry.incomeOtherInfo}</td>
            <td>${entry.taxableLand}</td>
            <td>${entry.propertyUse}</td>
            <td>${entry.taxType}</td>
            <td>${entry.redirecenarParts}</td>
            <td>${entry.age}</td>
            <td>${entry.floors}</td>
            <td>${entry.selectedUnit}</td>
            <td>${entry.height}</td>
            <td>${entry.width}</td>
            <td>${entry.area}</td>
            <td>${entry.convertedArea}</td>
            ${photoCell}
            <td><button type="button" class="btn btn-danger" onclick="removeIncomeType(${index})">Remove</button></td>
        </tr>`;
            tbody.innerHTML += row;
        });
    }

    function showFullImage(imgElement) {
        const fullImgUrl = imgElement.getAttribute('data-fullimg');

        // Create modal overlay
        const overlay = document.createElement('div');
        overlay.style.position = 'fixed';
        overlay.style.top = '0';
        overlay.style.left = '0';
        overlay.style.width = '100%';
        overlay.style.height = '100%';
        overlay.style.backgroundColor = 'rgba(0,0,0,0.8)';
        overlay.style.zIndex = '1000';
        overlay.style.display = 'flex';
        overlay.style.justifyContent = 'center';
        overlay.style.alignItems = 'center';
        overlay.style.cursor = 'pointer';
        overlay.onclick = function() {
            document.body.removeChild(overlay);
        };

        // Create image element
        const fullImg = document.createElement('img');
        fullImg.src = fullImgUrl;
        fullImg.style.maxWidth = '90%';
        fullImg.style.maxHeight = '90%';
        fullImg.style.objectFit = 'contain';

        // Prevent clicks on image from closing the modal
        fullImg.onclick = function(e) {
            e.stopPropagation();
        };

        // Add close button
        const closeBtn = document.createElement('span');
        closeBtn.innerHTML = '&times;';
        closeBtn.style.position = 'absolute';
        closeBtn.style.top = '20px';
        closeBtn.style.right = '30px';
        closeBtn.style.color = 'white';
        closeBtn.style.fontSize = '40px';
        closeBtn.style.fontWeight = 'bold';
        closeBtn.style.cursor = 'pointer';
        closeBtn.onclick = function() {
            document.body.removeChild(overlay);
        };

        overlay.appendChild(fullImg);
        overlay.appendChild(closeBtn);
        document.body.appendChild(overlay);
    }

    function removeIncomeType(index) {
        incomeEntries.splice(index, 1);
        renderIncomeTable();
        document.getElementById("income_data").value = JSON.stringify(incomeEntries);
    }
    </script>

</body>

</html>