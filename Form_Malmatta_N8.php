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
$other_occupant_name = $fun->getNewName();
$tapOwner = $fun->getNewName();
$drainageTypes = $fun->getDrainageTypes();

$incomeTypes = $fun->getIncomeType();
$taxExempts = $fun->getTaxExempt();
$malmattaUses = $fun->getMalmattaUse();
$malmattataxTypes = $fun->getMalmattaTaxType();
$redyrecs = $fun->getReadyrecInfo();
$buildingFloors = $fun->getBuildingFloors();
$lgdVillages = $fun->getVillagesWithPanchayat($_SESSION['panchayat_code']);


$allMalmattaEnteries = $fun->getMalmattaWithPropertiesAccordingToAll(1, 1);
if (isset($_GET['edit_id'])) {
    $editId = $_GET['edit_id'];
    $malmattaData = $fun->getMalmattaWithPropertiesWithIdNotApproved($editId, $_SESSION['district_code']);
    // print_r($malmattaData);
    if ($malmattaData && !empty($malmattaData[0])) {
        $isEditMode = true;
        $malmatta = $malmattaData[0];
        $properties = isset($malmattaData[0]['properties']) ? $malmattaData[0]['properties'] : [];
        // print_r($malmatta);
        // Prepare properties data for JavaScript
        $propertiesJson = json_encode($properties, JSON_HEX_APOS | JSON_HEX_QUOT);
    } else {
        $_SESSION['message'] = "मालमत्ता क्रमांक उपलब्ध नाही.";
        $_SESSION['message_type'] = "danger";
        $isEditMode = false;
    }
} else {
    $isEditMode = false;
    $propertiesJson = '[]';
}

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
                            <li class="breadcrumb-item"><a href="./">पंचायत पोर्टल</a></li>
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
                                    <form method="post" id="malmattaForm" action="api/newMalmatta.php"
                                        enctype="multipart/form-data">
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
                                                        if (mysqli_num_rows($periodsWithReasons) > 0) {
                                                            while ($periodsWithReason = mysqli_fetch_assoc($periodsWithReasons)) {
                                                                echo '<option value="' . $periodsWithReason['id'] . '">' . $periodsWithReason['total_period'] . '</option>';
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
                                                        if (mysqli_num_rows($lgdVillages) > 0) {
                                                            while ($village = mysqli_fetch_assoc($lgdVillages)) {
                                                                echo "<option value='" . $village['Village_Code'] . "'>" . $village['Village_Name'] . "</option>";
                                                            }
                                                        }
                                                        ?>
                                                    </select>

                                                </div>
                                                <input type="hidden" name="is_edit"
                                                    value="<?= $isEditMode ? '1' : '0' ?>">
                                                <input type="hidden" name="edit_id"
                                                    value="<?= $isEditMode ? $editId : '' ?>">
                                                <div class="form-group col-md-4">
                                                    <label for="road_name">गल्लीचे नाव/ अंतर्गत रस्त्याचे नाव<span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <select name="road_name" id="road_name" class="form-control">
                                                        <option value="" selected>--निवडा--</option>
                                                        <?php
                                                        if (mysqli_num_rows($roadDetails) > 0) {
                                                            while ($roadDetail = mysqli_fetch_assoc($roadDetails)) {
                                                                echo '<option value="' . $roadDetail['id'] . '">' . $roadDetail['road_name'] . '</option>';
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
                                                        if (mysqli_num_rows($wards) > 0) {
                                                            while ($ward = mysqli_fetch_assoc($wards)) {
                                                                echo '<option value="' . $ward['id'] . '">' . $ward['ward_name'] . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>

                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="malmatta_no">मालमत्ता क्रमांक <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="malmatta_no"
                                                        id="malmatta_no" aria-describedby="emailHelp"
                                                        placeholder="मालमत्ता क्रमांक" required>
                                                    <small id="malmattaNoHelp" class="form-text text-muted"></small>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="khasara_no">खसारा क्रमांक </label>
                                                    <input type="text" class="form-control" name="khasara_no"
                                                        id="khasara_no" aria-describedby="emailHelp"
                                                        placeholder="खसारा क्रमांक">
                                                    <!-- <small id="malmattaNoHelp" class="form-text text-muted"></small> -->
                                                </div>
                                                <div class="form-group col-md-3 mx-auto">
                                                    <label for="owner_name">मालमत्ता धारकाचे नाव <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <select name="owner_name" id="owner_name"
                                                        class="form-control select2-single-placeholder">
                                                        <option value="" selected>--निवडा--</option>
                                                        <?php
                                                        if (mysqli_num_rows($newNames) > 0) {
                                                            while ($newName = mysqli_fetch_assoc($newNames)) {
                                                                echo '<option value="' . $newName['id'] . '">' . $newName['person_name'] . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>

                                                </div>
                                                <div class="form-group col-md-2 d-flex align-items-end">
                                                    <a href="Form_Name_Masters.php"
                                                        class="btn btn-primary bg-gradient-success">
                                                        नवीन
                                                        नाव नोंद </a>
                                                </div>

                                                <div class="form-group col-md-3 mx-auto">
                                                    <label for="owner_wife_name">पत्नीचे नाव
                                                    </label>
                                                    <select name="owner_wife_name" id="owner_wife_name"
                                                        class="form-control select2-single-placeholder">
                                                        <option value="" selected>--निवडा--</option>
                                                        <?php
                                                        if (mysqli_num_rows($wifeNames) > 0) {
                                                            while ($newName = mysqli_fetch_assoc($wifeNames)) {
                                                                echo '<option value="' . $newName['id'] . '">' . $newName['person_name'] . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>

                                                </div>

                                                <div class="form-group col-md-3 mx-auto">
                                                    <label for="occupant_name">भोगवटा धारकाचे नाव <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <select name="occupant_name" id="occupant_name"
                                                        class="form-control select2-single-placeholder" required>
                                                        <option value="">--निवडा--</option>
                                                        <?php
                                                        if (mysqli_num_rows($occupant_name) > 0) {
                                                            while ($newName = mysqli_fetch_assoc($occupant_name)) {
                                                                echo '<option value="' . $newName['id'] . '">' . $newName['person_name'] . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>

                                                </div>
                                                <div class="form-group col-md-3 mx-auto">
                                                    <label for="other_occupant_name">इतर भोगवटा धारकाचे नाव <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <select name="other_occupant_name[]" multiple="multiple"
                                                        id="other_occupant_name" class="form-control select2-multiple"
                                                        required>
                                                        <option value="" selected>--निवडा--</option>
                                                        <?php
                                                        if (mysqli_num_rows($other_occupant_name) > 0) {
                                                            while ($newName = mysqli_fetch_assoc($other_occupant_name)) {
                                                                echo '<option value="' . $newName['person_name'] . '">' . $newName['person_name'] . '</option>';
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
                                                <div class="form-group col-md-4 mx-auto">
                                                    <label for="address">Address</label>
                                                    <textarea name="address" id="address" class="form-control"
                                                        placeholder="Address"></textarea>
                                                </div>
                                                <div class="col-md-4 mx-auto d-flex align-items-end">
                                                    <p>( मिळकत माहिती ऑनलाइन पोर्टल वरती उपलब्ध होण्यासाठी
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
                                                            if (mysqli_num_rows($incomeTypes) > 0) {
                                                                while ($incomeType = mysqli_fetch_assoc($incomeTypes)) {
                                                                    echo '<option value="' . $incomeType['income_type'] . '">' . $incomeType['income_type'] . '</option>';
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
                                                            if (mysqli_num_rows($taxExempts) > 0) {
                                                                while ($taxExempt = mysqli_fetch_assoc($taxExempts)) {
                                                                    echo '<option value="' . $taxExempt['tax_exempt'] . '">' . $taxExempt['tax_exempt'] . '</option>';
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
                                                            if (mysqli_num_rows($malmattaUses) > 0) {
                                                                while ($malmattaUse = mysqli_fetch_assoc($malmattaUses)) {
                                                                    echo '<option value="' . $malmattaUse['malmatta_use'] . '">' . $malmattaUse['malmatta_use'] . '</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>

                                                    </div>
                                                    <div class="form-group col-md-4 mx-auto">
                                                        <label for="tax_type">मालमत्ता/जमिनीचा कर प्रकार

                                                        </label>
                                                        <select name="tax_type" id="tax_type" class="form-control">
                                                            <option value="" selected>--निवडा--</option>
                                                            <?php
                                                            if (mysqli_num_rows($redyrecs) > 0) {
                                                                while ($redyrec = mysqli_fetch_assoc($redyrecs)) {
                                                                    echo '<option value="' . $redyrec['rid'] . '">' . $redyrec['land_type'] . '</option>';
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
                                                        <label for="redirecenarDar">दर

                                                        </label>
                                                        <textarea name="redirecenarDar" class="form-control"
                                                            id="redirecenarDar" readonly></textarea>



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
                                                            if (mysqli_num_rows($buildingFloors) > 0) {
                                                                while ($buildingFloor = mysqli_fetch_assoc($buildingFloors)) {
                                                                    echo '<option value="' . $buildingFloor['floor_name'] . '">' . $buildingFloor['floor_name'] . '</option>';
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
                                                            aria-describedby="emailHelp" placeholder="0" >
                                                        <small id="areaUnit" class="form-text text-muted">फूट (Square
                                                            Feet)</small>
                                                    </div>

                                                    <div class="form-group col-md-4 mx-auto">
                                                        <label for="converted_area">रूपांतरित क्षेत्रफळ (Converted
                                                            Area)</label>
                                                        <input type="number" class="form-control" name="converted_area"
                                                            id="converted_area" aria-describedby="emailHelp"
                                                            placeholder="0"     >
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
                                                            <th>दर</th>
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
                                                            if (mysqli_num_rows($drainageTypes) > 0) {
                                                                while ($drainageType = mysqli_fetch_assoc($drainageTypes)) {
                                                                    echo '<option value="' . $drainageType['drainage_type'] . '">' . $drainageType['drainage_type'] . '</option>';
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
                                                    <div class="form-group col-md-3 mx-auto" id="meter_reading_div" style="display: none;" >
                                                        <label for="meter_reading">नळ मीटर रीडिंग
                                                        </label>
                                                        <input type="number" class="form-control" name="meter_reading"
                                                            id="meter_reading" aria-describedby="emailHelp"
                                                            placeholder="नळ मीटर रीडिंग" value="0">


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
                                                            class="form-control select2-single-placeholder">
                                                            <option value="">--निवडा--</option>
                                                            <?php
                                                            if (mysqli_num_rows($tapOwner) > 0) {
                                                                while ($tapOwners = mysqli_fetch_assoc($tapOwner)) {
                                                                    echo '<option value="' . $tapOwners['id'] . '">' . $tapOwners['person_name'] . '</option>';
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
                                            <button type="submit" name="<?= $isEditMode ? 'update' : 'add' ?>"
                                                class="btn btn-primary bg-gradient-primary">
                                                <?= $isEditMode ? 'अद्यतनित करा' : 'साठवणे' ?>
                                            </button>
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




                    <div class="col-lg-12">
                        <div class="card py-5 px-5">

                            <div class="table-responsive">
                                <table class="table align-items-center table-flush" id="dataTable">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>अ.क्र.</th>
                                            <th>वॉर्डचे नाव</th>
                                            <th>रस्त्याचे नाव</th>
                                            <th>मि नं.</th>
                                            <th>खसारा नं.</th>
                                            <th>गट /सर्वे नं</th>
                                            <th>मालमत्ता धारकाचे नाव</th>
                                            <th>भोगवटा धारकाचे नाव</th>
                                            <th>इतर भोगवटा धारकाचे नाव</th>
                                            <th>भोगवटाधारक</th>

                                            <th>मालमत्ता</th>
                                            <th>बदल</th>
                                            <!-- <th>जमिन दर</th>
                                                        <th>बांधकाम दर</th> -->

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (count($allMalmattaEnteries) > 0) {
                                            $i = 1;
                                            foreach ($allMalmattaEnteries as $name) {
                                                // print_r($name);
                                                // echo "<br>";
                                        
                                                $malmatta_use_tax = [
                                                    "रहिवाशी" => 1,
                                                    "वाणिज्य/व्यापार" => 1.25,
                                                    "औद्योगिक" => 1.2
                                                ];
                                                // $bharank = $malmatta_use_tax[$name["malmatta_use"]];
                                                ?>
                                                <tr>
                                                    <td><a href="#"><?php echo $i++; ?></a></td>
                                                    <td><?php echo $name['ward_name']; ?></td>
                                                    <td><?php echo $name['road_name']; ?></td>
                                                    <td><?php echo $name['malmatta_no']; ?></td>
                                                    <td><?php echo $name['khasara_no']; ?></td>
                                                    <td><?php echo $name['group_no'] . "/" . $name['city_survey_no']; ?></td>
                                                    <td><?php echo $name['owner_name']; ?></td>
                                                    <td><?php echo $name['occupant_name']; ?></td>
                                                    <td><?php echo $name['other_occupant_name']; ?></td>
                                                    <td><?php echo $name['occupant_name']; ?></td>


                                                    <td>
                                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                                            data-target="#modal<?php echo $name['malmatta_id'] ?>"
                                                            id="#modalCenter<?php echo $name['malmatta_id'] ?>">View
                                                            Properties</button>
                                                        <div class="modal fade" id="modal<?php echo $name['malmatta_id'] ?>"
                                                            tabindex="-1" role="dialog"
                                                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered" role="document"
                                                                style="width: 90% !important;">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalCenterTitle">
                                                                            Property
                                                                            Details
                                                                        </h5>
                                                                        <button type="button" class="close" data-dismiss="modal"
                                                                            aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="table-responsive mt-4">
                                                                            <table id="propertyTable"
                                                                                class="table table-bordered table-striped text-center align-middle">
                                                                                <thead class="bg-primary text-white">
                                                                                    <tr>
                                                                                        <th>अ क्र</th>
                                                                                        <th>मालमत्ता क्र.</th>
                                                                                        <th>मालमत्ता प्रकार</th>
                                                                                        <th>मजला</th>
                                                                                        <th>लांबी</th>
                                                                                        <th>रुंदी</th>
                                                                                        <th>क्षेत्रफळ(Foot)</th>
                                                                                        <th>क्षेत्रफळ(mt)</th>
                                                                                        <th>बांधकाम वर्ष</th>
                                                                                        <th>रेडीरेकनर दर</th>
                                                                                        <th>बांधकाम दर</th>
                                                                                        <th>घसारा दर</th>
                                                                                        <th>भारांक</th>
                                                                                        <th>भांडवली मुल्यांकन</th>
                                                                                        <th>मिळकत कर दर</th>
                                                                                        <th>इमारत कर</th>
                                                                                        <th>फोटो</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <?php
                                                                                    if (isset($name['properties'])) {
                                                                                        $sr = 1;
                                                                                        $allModals = ""; // Collect modals here
                                                                                        foreach ($name['properties'] as $property) {
                                                                                            // print_r($property);
                                                                                            $photoCell = $property['property_photo_path'] ?
                                                                                                '<td><img src="' . $property['property_photo_path'] . '" alt="Property Photo"
                     width="50" height="50" 
                     class="thumbnail-img"
                     style="cursor: pointer;"
                     data-toggle="modal"
                     data-target="#modal' . md5($property['property_photo_path']) . '"></td>' :
                                                                                                '<td>No photo</td>';

                                                                                            // Store modal for later rendering
                                                                                            if ($property['property_photo_path']) {
                                                                                                $modalId = md5($property['property_photo_path']); // safe ID
                                                                                                $allModals .= '<div class="modal fade" id="modal' . $modalId . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Property Photo</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-center">
                                    <img src="' . $property['property_photo_path'] . '" alt="Property Photo" class="enlarged-image img-fluid">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>';
                                                                                            }

                                                                                            ?>
                                                                                            <tr>
                                                                                                <td><?php echo $sr++; ?></td>
                                                                                                <td><?php echo $name['malmatta_no']; ?>
                                                                                                </td>
                                                                                                <td><?php echo $property['property_use']; ?>
                                                                                                </td>
                                                                                                <td><?php echo $property['floor']; ?>
                                                                                                </td>
                                                                                                <td><?php echo $property['lenght']; ?>
                                                                                                </td>
                                                                                                <td><?php echo $property['width']; ?>
                                                                                                </td>
                                                                                                <td><?php echo $property['areaInFoot']; ?>
                                                                                                </td>
                                                                                                <td><?php echo $property['areaInMt']; ?>
                                                                                                </td>
                                                                                                <td><?php echo $property['construction_year']; ?>
                                                                                                </td>
                                                                                                <td><?php echo $property['yearly_tax']; ?>
                                                                                                </td>
                                                                                                <td><?php echo $property['construction_tax']; ?>
                                                                                                </td>
                                                                                                <td><?php echo $property['ghasara_tax']; ?>
                                                                                                </td>
                                                                                                <td><?php echo $property['bharank']; ?>
                                                                                                </td>
                                                                                                <td><?php echo $property['bhandavali']; ?>
                                                                                                </td>
                                                                                                <td><?php echo $property['milkat_fixed_tax']; ?>
                                                                                                </td>
                                                                                                <td><?php echo $property['building_value']; ?>
                                                                                                </td>
                                                                                                <?php echo $photoCell; ?>
                                                                                            </tr>
                                                                                            <?php
                                                                                        }
                                                                                    } else {
                                                                                        ?>
                                                                                        <tr>
                                                                                            <td colspan="16">No data found</td>
                                                                                        </tr>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </tbody>

                                                                                <!-- Echo all modals here, outside the table -->
                                                                                <?php echo $allModals; ?>

                                                                            </table>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="form_n8.php?edit_id=<?php echo $name['malmatta_id']; ?>">
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
                        </div>
                        <!---Container Fluid-->
                    </div>
                    <div class="card-footer"></div>
                </div>
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

        $("#drainage_type").change(function () {
            var selectedValue = $(this).val();
            if (selectedValue === "वापर नाही") {
                $("#tap_numbers").prop("disabled", true);
                $("#tap_numbers").val();
                $("#tap_numbers").prop("required", false);

                $("#tap_width").prop("disabled", true);
                $("#tap_width").val();
                $("#tap_width").prop("required", false);

                $("#tap_owner_name").prop("disabled", true);
                $("#tap_owner_name").val();
                $("#tap_owner_name").prop("required", false);

            }else if(selectedValue === "विशेष पाणीपट्टी (मीटर रीडिंग अनुसार)" || selectedValue === "विशेष पाणीपट्टी (मीटर रीडिंग अनुसार) (विशेष)"){
                $("#meter_reading").prop("disabled", false);
                $("#meter_reading").prop("required", true);
                $("#meter_reading_div").show();
            }
            
            else {
                $("#tap_numbers").prop("disabled", false);
                $("#tap_numbers").prop("required", true);
                $("#tap_width").prop("disabled", false);
                $("#tap_width").prop("required", true);
                $("#tap_owner_name").prop("disabled", false);
                $("#tap_owner_name").prop("required", true);
                $("#meter_reading").prop("disabled", true);
               
                $("#meter_reading").prop("required", false);
                $("#meter_reading_div").hide();
            }
        });

        // In your JavaScript, check if we're in edit mode
        document.addEventListener("DOMContentLoaded", function () {
            const urlParams = new URLSearchParams(window.location.search);
            const editId = urlParams.get('edit_id');

            if (editId) {
                // Fetch existing data and populate the form
                fetch(`api/get_malmatta_for_edit.php?id=${editId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Populate main form
                            console.log(data, "data");

                            document.getElementById('period').value = data.malmatta.period;
                            document.getElementById('revenue_village').value = data.malmatta.village_name;
                            document.getElementById('road_name').value = data.malmatta.road_id;
                            document.getElementById('ward_name').value = data.malmatta.ward_no;
                            document.getElementById('malmatta_no').value = data.malmatta.malmatta_id;
                            document.getElementById('owner_name').value = data.malmatta.owner_id;
                            document.getElementById('owner_wife_name').value = data.malmatta.wife_id;
                            document.getElementById('occupant_name').value = data.malmatta.occupant_id;
                            document.getElementById('city_survey_no').value = data.malmatta.city_survey_no;
                            document.getElementById('group_number').value = data.malmatta.group_no;
                            document.getElementById('toilet_available').value = data.malmatta
                                .washroom_available;
                            document.getElementById('drainage_type').value = data.waterTax.water_usage_type;
                            document.getElementById('tap_numbers').value = data.waterTax.no_of_taps;
                            document.getElementById('tap_width').value = data.waterTax.tap_width;
                            document.getElementById('tap_owner_name').value = data.waterTax.tap_owner_name;
                            document.getElementById('remarks').value = data.malmatta.remarks;
                            const taxType = document.getElementById('tax_type');
                            taxType.value = data.malmatta.property_tax_type || '';
                            console.log(data.malmatta.property_tax_type, taxType.value);

                            const taxTypeValue = taxType.value.trim();
                            const taxTypeText = taxType.options[taxType.selectedIndex].text;

                            // Populate properties table
                            data.properties.forEach(prop => {
                                console.log(prop);

                                incomeEntries.push({
                                    taxTypeId: prop.property_tax_type,
                                    area: prop.measuring_unit === 'foot' ? prop.areaInFoot :
                                        prop.areaInMt,
                                    incomeType: prop.property_tax_type,
                                    incomeOtherInfo: prop.directions,
                                    taxableLand: prop.tax_exempt,
                                    propertyUse: prop.malmatta_use,
                                    taxType: taxTypeText,
                                    redirecenarParts: prop.redirecconar_parts,
                                    constructionYear: prop.construction_year,
                                    buildingAge: prop.construction_year,
                                    construction_year_type: prop.construction_year_type,
                                    age: prop.construction_year,
                                    floors: prop.floor,
                                    selectedUnit: prop.measuring_unit,
                                    ft: prop.areaInFoot,
                                    meter: prop.areaInMt,
                                    height: prop.lenght,
                                    width: prop.width,
                                    area: prop.measuring_unit === 'foot' ? prop.areaInFoot :
                                        prop.areaInMt,
                                    convertedArea: prop.measuring_unit === 'mt' ? prop
                                        .areaInMt : prop.areaInFoot,
                                    propertyPhoto: prop.property_photo_path,
                                    photoName: prop.property_photo_path,
                                    redirecenarDar: prop.yearly_tax

                                });
                            });

                            renderIncomeTable();
                        }
                        document.getElementById("income_data").value = JSON.stringify(incomeEntries);
                        console.log(incomeEntries);
                    });
            }
        });
        document.addEventListener("DOMContentLoaded", function () {
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
                        document.getElementById('redirecenarDar').value = data.yearly_tax || 'No data found';
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
        document.addEventListener("DOMContentLoaded", function () {
            const urlParams = new URLSearchParams(window.location.search);
            const editId = urlParams.get('edit_id');

            // Check if we have properties data from PHP
            const propertiesData = <?php echo $propertiesJson; ?>;

            if (editId && propertiesData.length > 0) {
                // Populate main form fields
                document.getElementById('period').value = '<?php echo $malmatta['period'] ?? ''; ?>';
                document.getElementById('revenue_village').value = '<?php echo $malmatta['village_name'] ?? ''; ?>';
                document.getElementById('road_name').value = '<?php echo $malmatta['road_name'] ?? ''; ?>';
                document.getElementById('ward_name').value = '<?php echo $malmatta['ward_no'] ?? ''; ?>';
                document.getElementById('malmatta_no').value = '<?php echo $malmatta['malmatta_no'] ?? ''; ?>';

                document.getElementById('owner_name').value = '<?php echo $malmatta['owner_id'] ?? ''; ?>';
                document.getElementById('owner_wife_name').value = '<?php echo $malmatta['wife_id'] ?? ''; ?>';
                document.getElementById('occupant_name').value = '<?php echo $malmatta['occupant_id'] ?? ''; ?>';
                document.getElementById('city_survey_no').value =
                    '<?php echo $malmatta['city_survey_no'] ?? ''; ?>';
                document.getElementById('group_number').value = '<?php echo $malmatta['group_no'] ?? ''; ?>';
                document.getElementById('toilet_available').value =
                    '<?php echo $malmatta['toilet_available'] ?? ''; ?>';
                document.getElementById('drainage_type').value = '<?php echo $malmatta['drainage_type'] ?? ''; ?>';
                document.getElementById('tap_numbers').value = '<?php echo $malmatta['tap_numbers'] ?? '0'; ?>';
                document.getElementById('tap_width').value = '<?php echo $malmatta['tap_width'] ?? ''; ?>';
                document.getElementById('tap_owner_name').value =
                    '<?php echo $malmatta['tap_owner_name'] ?? ''; ?>';
                document.getElementById('remarks').value = `<?php echo addslashes($malmatta['remarks'] ?? ''); ?>`;

                // Populate properties table
                propertiesData.forEach(prop => {
                    incomeEntries.push({
                        incomeType: prop.income_type || '',
                        incomeOtherInfo: prop.income_other_info || '',
                        taxableLand: prop.taxable_land || '',
                        propertyUse: prop.property_use || '',
                        taxTypeId: prop.tax_type || '',
                        taxType: prop.tax_type_name || '',
                        redirecenarParts: prop.redirecenar_parts || '',
                        redirecenarDar: prop.redirecenar_dar || '',
                        construction_year_type: prop.construction_year ? 'construction_year' :
                            'building_age',
                        age: prop.construction_year || prop.building_age || '',
                        floors: prop.floors || '',
                        selectedUnit: prop.measuring_unit || 'foot',
                        height: prop.height || '',
                        width: prop.width || '',
                        area: prop.area || '',
                        convertedArea: prop.converted_area || '',
                        propertyPhoto: prop.property_photo || null,
                        photoName: prop.property_photo ? 'property_photo.jpg' : null
                    });
                });

                // Render the properties table
                renderIncomeTable();

                // Set radio buttons based on first property (assuming all properties have same units)
                if (propertiesData.length > 0) {
                    const firstProp = propertiesData[0];
                    if (firstProp.measuring_unit === 'meter') {
                        document.getElementById('meter').checked = true;
                    } else {
                        document.getElementById('ft').checked = true;
                    }
                }
            }
        });
        document.addEventListener("DOMContentLoaded", function () {
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

            footRadio.addEventListener("change", function () {
                if (this.checked) {
                    calculateAndDisplayAreas();
                }
            });

            meterRadio.addEventListener("change", function () {
                if (this.checked) {
                    calculateAndDisplayAreas();
                }
            });

            // Initialize with foot selected
            calculateAndDisplayAreas();
        });


        document.getElementById('malmattaForm').addEventListener('submit', function (e) {
            e.preventDefault();

            // Update the hidden input with latest data
            document.getElementById("income_data").value = JSON.stringify(incomeEntries);

            // Create FormData object
            const formData = new FormData(this);

            // Add property photos separately
            incomeEntries.forEach((entry, index) => {
                if (entry.propertyPhoto && typeof entry.propertyPhoto === 'string' && entry.propertyPhoto
                    .startsWith('data:')) {
                    // Convert base64 to blob
                    const blob = dataURLtoBlob(entry.propertyPhoto);
                    formData.append(`property_photos[${index}]`, blob, entry.photoName ||
                        `property_${index}.jpg`);
                }
            });

            // Add the appropriate action parameter
            if (<?php echo $isEditMode ? 'true' : 'false'; ?>) {
                formData.append("update", "yes");
                formData.append("edit_id", "<?php echo $editId ?? ''; ?>");
            } else {
                formData.append("add", "yes");
            }
            if (confirm("तुमची खात्री आहे की तुम्ही हा फॉर्म सबमिट करू इच्छिता?")) {
                fetch(this.action, {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log("Form submitted successfully:", data);
                            const pathName = window.location.pathname;
                            const baseURL = window.location.origin;
                            const redirectURL = data.redirect ? `${baseURL}/${data.redirect}` :
                                baseURL;

                            // Show success message
                            alert(data.message || 'Form submitted successfully');

                            // Redirect to appropriate page
                            if (data.redirect) {
                                window.location.href = redirectURL;
                            }

                        } else {
                            alert(data.message || 'Error occurred');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error submitting form');
                    });
            } else {
                console.log("Form submission cancelled");
                return;
            }
            // Submit via AJAX

        });

        function dataURLtoBlob(dataurl) {
            var arr = dataurl.split(','),
                mime = arr[0].match(/:(.*?);/)[1],
                bstr = atob(arr[1]),
                n = bstr.length,
                u8arr = new Uint8Array(n);
            for (var i = 0; i < n; i++) {
                u8arr[i] = bstr.charCodeAt(i);
            }
            return new Blob([u8arr], {
                type: mime
            });
        }
    </script>

    <script>
        let incomeEntries = [];
        document.getElementById('add_property').onclick = function () {
            addIncomeType();
        };

        function addIncomeType() {
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
            const redirecenarParts = document.getElementById('tax_type');
            const redirecenarPartsValue = redirecenarParts.value.trim();
            const constructionYear = document.getElementById('construction_year');
            const constructionYearValue = constructionYear.value.trim();
            const buildingAge = document.getElementById('building_age');
            const buildingAgeValue = buildingAge.value.trim();
            const selectedConstructionType = document.querySelector('input[name="construction_year_type"]:checked');
            const redirecenarDar = document.getElementById('redirecenarDar');

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
                        photoName: photoFile.name,
                        redirecenarDar: redirecenarDar.value.trim()
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
                    photoName: null,
                    redirecenarDar: redirecenarDar.value.trim()
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
            redirecenarDar.value = "";


            // Store in hidden input
            document.getElementById("income_data").value = JSON.stringify(incomeEntries);
            console.log(incomeEntries);

            fileInput.value = '';
        }

        function renderIncomeTable() {
            const tbody = document.getElementById("income_table").querySelector("tbody");
            tbody.innerHTML = "";
            console.log("entries:", incomeEntries);

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
            <td>${entry.redirecenarDar}</td>
            <td>${entry.age}</td>
            <td>${entry.floors}</td>
            <td>${entry.selectedUnit}</td>
            <td>${entry.height}</td>
            <td>${entry.width}</td>
            <td>${entry.area}</td>
            <td>${entry.convertedArea}</td>
            ${photoCell}
            <td>
                <button type="button" class="btn btn-primary btn-sm" onclick="editIncomeType(${index})">
                    <i class="fas fa-edit"></i>
                </button>
                <button type="button" class="btn btn-danger btn-sm" onclick="removeIncomeType(${index})">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
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
            overlay.onclick = function () {
                document.body.removeChild(overlay);
            };

            // Create image element
            const fullImg = document.createElement('img');
            fullImg.src = fullImgUrl;
            fullImg.style.maxWidth = '90%';
            fullImg.style.maxHeight = '90%';
            fullImg.style.objectFit = 'contain';

            // Prevent clicks on image from closing the modal
            fullImg.onclick = function (e) {
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
            closeBtn.onclick = function () {
                document.body.removeChild(overlay);
            };

            overlay.appendChild(fullImg);
            overlay.appendChild(closeBtn);
            document.body.appendChild(overlay);
        }

        function removeIncomeType(index) {
            // Check if we're removing the entry currently being edited
            const currentEditIndex = document.getElementById('update').value;
            if (currentEditIndex && parseInt(currentEditIndex) === index) {
                resetFormAndRender();
            }

            incomeEntries.splice(index, 1);
            renderIncomeTable();
            document.getElementById("income_data").value = JSON.stringify(incomeEntries);
        }

        function editIncomeType(index) {
            const entry = incomeEntries[index];

            // Fill the form with the selected entry's data
            document.getElementById('income_type').value = entry.incomeType;
            document.getElementById('income_other_info').value = entry.incomeOtherInfo;
            document.getElementById('taxable_land').value = entry.taxableLand;
            document.getElementById('property_use').value = entry.propertyUse;
            document.getElementById('tax_type').value = entry.taxTypeId;
            document.getElementById('redirecenarParts').value = entry.redirecenarParts;
            document.getElementById('redirecenarDar').value = entry.redirecenarDar;

            // Set construction year/age radio button
            if (entry.construction_year_type === 'construction_year') {
                document.getElementById('construction_year').checked = true;
            } else if (entry.construction_year_type === 'building_age') {
                document.getElementById('building_age').checked = true;
            }

            document.getElementById('age').value = entry.age;
            document.getElementById('floors').value = entry.floors;

            // Set measuring unit radio button
            if (entry.selectedUnit === 'foot') {
                document.getElementById('ft').checked = true;
            } else if (entry.selectedUnit === 'meter') {
                document.getElementById('meter').checked = true;
            }

            document.getElementById('height').value = entry.height;
            document.getElementById('width').value = entry.width;
            document.getElementById('area').value = entry.area;
            document.getElementById('converted_area').value = entry.convertedArea;

            // Store the index being edited in a hidden field
            document.getElementById('update').value = index;

            // Change the add button text to indicate editing
            document.getElementById('add_property').textContent = 'Update';
            document.getElementById('add_property').onclick = function () {
                updateIncomeType(index);
            };

            // Scroll to the form section
            document.querySelector('.card-body').scrollIntoView({
                behavior: 'smooth'
            });
        }

        function updateIncomeType(index) {
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
            const redirecenarParts = document.getElementById('tax_type');
            const redirecenarPartsValue = redirecenarParts.value.trim();
            const constructionYear = document.getElementById('construction_year');
            const constructionYearValue = constructionYear.value.trim();
            const buildingAge = document.getElementById('building_age');
            const buildingAgeValue = buildingAge.value.trim();
            const selectedConstructionType = document.querySelector('input[name="construction_year_type"]:checked');
            const redirecenarDar = document.getElementById('redirecenarDar');

            const fileInput = document.querySelector('.property-photo-input');
            const photoFile = fileInput.files[0];
            let photoData = incomeEntries[index].propertyPhoto; // Keep existing photo if not changed
            let construction_year_type = "";

            if (selectedConstructionType) {
                construction_year_type = selectedConstructionType.value;
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
                    // Update the entry
                    incomeEntries[index] = {
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
                        photoName: photoFile.name || incomeEntries[index].photoName,
                        redirecenarDar: redirecenarDar.value.trim()
                    };
                    resetFormAndRender();
                };
                reader.readAsDataURL(photoFile);
            } else {
                // Update the entry without changing the photo
                incomeEntries[index] = {
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
                    propertyPhoto: incomeEntries[index].propertyPhoto,
                    photoName: incomeEntries[index].photoName,
                    redirecenarDar: redirecenarDar.value.trim()
                };
                resetFormAndRender();
            }
        }

        function resetFormAndRender() {
            // Clear form
            document.getElementById('income_type').value = "";
            document.getElementById('income_other_info').value = "";
            document.getElementById('taxable_land').value = "";
            document.getElementById('property_use').value = "";
            document.getElementById('tax_type').value = "";
            document.getElementById('redirecenarParts').value = "";
            document.getElementById('redirecenarDar').value = "";
            document.getElementById('age').value = "";
            document.getElementById('floors').value = "";
            document.getElementById('height').value = "";
            document.getElementById('width').value = "";
            document.getElementById('area').value = "";
            document.getElementById('converted_area').value = "";
            document.querySelector('.property-photo-input').value = '';

            // Reset add button
            document.getElementById('add_property').textContent = 'Add';
            document.getElementById('add_property').onclick = function () {
                addIncomeType();
            };

            // Clear update index
            document.getElementById('update').value = "";

            // Re-render table
            renderIncomeTable();

            // Update hidden input
            document.getElementById("income_data").value = JSON.stringify(incomeEntries);
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const malmattaNoInput = document.getElementById('malmatta_no');
            const districtCode = '<?php echo $_SESSION['district_code']; ?>';

            // Update the checkMalmattaAvailability function
            function checkMalmattaAvailability(malmattaNo) {
                const helpText = document.getElementById('malmattaNoHelp');

                if (!malmattaNo) {
                    helpText.textContent = '';
                    malmattaNoInput.setCustomValidity('');
                    return;
                }

                fetch(`api/check_malmatta_no.php?malmatta_no=${malmattaNo}&district_code=${districtCode}`)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.available) {
                            helpText.textContent = data.message;
                            helpText.className = 'form-text text-danger';
                            malmattaNoInput.setCustomValidity(data.message);
                        } else {
                            helpText.textContent = 'मालमत्ता क्रमांक उपलब्ध आहे';
                            helpText.className = 'form-text text-success';
                            malmattaNoInput.setCustomValidity('');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }

            // Check on blur (when user leaves the field)
            malmattaNoInput.addEventListener('blur', function () {
                checkMalmattaAvailability(this.value);
            });

            // Also check before form submission
            document.getElementById('malmatta_no').addEventListener('change', function (e) {
                if (malmattaNoInput.value) {
                    // For immediate feedback, you might want to do a synchronous check here
                    // or disable the submit button until validation is complete

                    checkMalmattaAvailability(malmattaNoInput.value);
                }
            });
        });
    </script>

</body>

</html>