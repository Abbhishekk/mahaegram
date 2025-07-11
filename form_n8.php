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
    $malmattaData = $fun->getMalmattaWithPropertiesWithId($editId, $_SESSION['district_code']);
 
    if ($malmattaData && !empty($malmattaData[0])) {
        $isEditMode = true;
        $malmatta = $malmattaData[0];

        $properties = isset($malmattaData[0]['properties']) ? $malmattaData[0]['properties'] : [];
        $waterTariff = $fun->getMalmattaWaterTaxByMalmattaId($editId); // New function to fetch water tariff
        $waterTariff = mysqli_fetch_assoc($waterTariff);
        $propertiesJson = json_encode($properties, JSON_HEX_APOS | JSON_HEX_QUOT);
    } else {
        $_SESSION['message'] = "मालमत्ता क्रमांक उपलब्ध नाही.";
        $_SESSION['message_type'] = "danger";
        $isEditMode = false;
    }
} else {
    $isEditMode = false;
    $propertiesJson = '[]';
    $waterTariff = [];
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
        ?>
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <?php include('include/topbar.php');
        include('include/sidebar.php'); ?>
                <!-- Topbar -->

                <!-- Container Fluid-->
                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">ग्रामपंचायत नमुना 8 डाटा एन्ट्री</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">पंचायत पोर्टल</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 8</li>
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
                                    unset($_SESSION['message']);
                                    unset($_SESSION['message_type']);
                                }
                                ?>
                                <div class="card-body">
                                    <form method="post" id="malmattaForm" action="api/newMalmatta.php"
                                        enctype="multipart/form-data">
                                        <div>
                                            <h5 class="bg-gradient-primary text-white py-3 px-5 w-25 rounded-pill">
                                                मालमत्ता माहिती</h5>
                                            <div class="row">
                                                <div class="form-group col-md-4">
                                                    <label for="period">कालावधी<span
                                                            class="text-danger">*</span></label>
                                                    <select name="period" id="period" class="form-control" required>
                                                        <option value="" selected>--निवडा--</option>
                                                        <?php
                                                        if (mysqli_num_rows($periodsWithReasons) > 0) {
                                                            while ($periodsWithReason = mysqli_fetch_assoc($periodsWithReasons)) {
                                                                $selected = ($isEditMode && $malmatta['period'] == $periodsWithReason['id']) ? 'selected' : '';
                                                                echo '<option value="' . $periodsWithReason['id'] . '" ' . $selected . '>' . $periodsWithReason['total_period'] . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <input type="hidden"
                                                        value="<?php echo $isEditMode ? $editId : ''; ?>"
                                                        class="form-control" name="update_id" id="update_id">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="revenue_village">गावाचे नाव<span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-control select2-single-placeholder mb-3"
                                                        name="revenue_village" id="revenue_village">
                                                        <option value="" selected>--निवडा.--</option>
                                                        <?php
                                                        if (mysqli_num_rows($lgdVillages) > 0) {
                                                            while ($village = mysqli_fetch_assoc($lgdVillages)) {
                                                                $selected = ($isEditMode && $malmatta['village_name'] == $village['Village_Code']) ? 'selected' : '';
                                                                echo "<option value='" . $village['Village_Code'] . "' $selected>" . $village['Village_Name'] . "</option>";
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
                                                    <label for="road_name">गल्लीचे नाव/ अंतर्गत रस्त्याचे नाव</label>
                                                    <select name="road_name" id="road_name" class="form-control"
                                                        >
                                                        <option value="" selected>--निवडा--</option>
                                                        <?php
                                                        if (mysqli_num_rows($roadDetails) > 0) {
                                                            while ($roadDetail = mysqli_fetch_assoc($roadDetails)) {
                                                                $selected = ($isEditMode && $malmatta['road_name'] == $roadDetail['road_name']) ? 'selected' : '';
                                                                echo '<option value="' . $roadDetail['id'] . '" ' . $selected . '>' . $roadDetail['road_name'] . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="ward_name">वॉर्ड क्रं </label>
                                                    <select name="ward_name" id="ward_name" class="form-control"
                                                        >
                                                        <option value="">--निवडा--</option>
                                                        <?php
                                                        if (mysqli_num_rows($wards) > 0) {
                                                            while ($ward = mysqli_fetch_assoc($wards)) {
                                                                $selected = ($isEditMode && $malmatta['ward_name'] == $ward['ward_name']) ? 'selected' : '';
                                                                echo '<option value="' . $ward['id'] . '" ' . $selected . '>' . $ward['ward_name'] . '</option>';
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
                                                        placeholder="मालमत्ता क्रमांक"
                                                        value="<?php echo $isEditMode ? htmlspecialchars($malmatta['malmatta_no']) : ''; ?>"
                                                        required>
                                                    <small id="malmattaNoHelp" class="form-text text-muted"></small>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="khasara_no">खसारा क्रमांक </label>
                                                   <select name="khasara_no" id="khasara_no"
                                                        class="form-control">
                                                        <option value="" >--निवडा--</option>
                                                        <?php
                                                        $khasaraNos = $fun->getKhasaraWard();
                                                        if (mysqli_num_rows($khasaraNos) > 0) {
                                                            while ($ward = mysqli_fetch_assoc($khasaraNos)) {
                                                                // print_r($ward['khasara_no']);
                                                                // echo $isEditMode ? "true" : 'false';
                                                                // print_r($malmatta['khasara_no']);
                                                                if(!$isEditMode){
                                                                    
                                                                    echo '<option value="' . $ward['khasara_no'] . '">' . $ward['khasara_no'] . '</option>';
                                                                }
                                                                else{
                                                                    $selected = ($malmatta['khasara_no'] == $ward['khasara_no']) ? 'selected' : '';
                                                                   
                                                                    
                                                                    echo '<option value="' . $ward['khasara_no'] . '" ' . $selected . '>' . $ward['khasara_no'] . '</option>';
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                      </div>
                                                <div class="form-group col-md-3 mx-auto">
                                                    <label for="owner_name">मालमत्ता धारकाचे नाव <span
                                                            class="text-danger">*</span></label>
                                                    <select name="owner_name" id="owner_name"
                                                        class="form-control select2-single-placeholder" required>
                                                        <option value="" selected>--निवडा--</option>
                                                        <?php
                                                        if (mysqli_num_rows($newNames) > 0) {
                                                            while ($newName = mysqli_fetch_assoc($newNames)) {
                                                                $selected = ($isEditMode && $malmatta['owner_name'] == $newName['person_name']) ? 'selected' : '';
                                                                echo '<option value="' . $newName['id'] . '" ' . $selected . '>' . $newName['person_name'] . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-2 d-flex align-items-end">
                                                    <a href="Form_Name_Masters.php"
                                                        class="btn btn-primary bg-gradient-success">नवीन नाव नोंद </a>
                                                </div>
                                                <div class="form-group col-md-3 mx-auto">
                                                    <label for="owner_wife_name">पत्नीचे नाव</label>
                                                    <select name="owner_wife_name" id="owner_wife_name"
                                                        class="form-control select2-single-placeholder">
                                                        <option value="" selected>--निवडा--</option>
                                                        <?php
                                                        if (mysqli_num_rows($wifeNames) > 0) {
                                                            while ($newName = mysqli_fetch_assoc($wifeNames)) {
                                                                $selected = ($isEditMode && $malmatta['wife_name'] == $newName['person_name']) ? 'selected' : '';
                                                                echo '<option value="' . $newName['id'] . '" ' . $selected . '>' . $newName['person_name'] . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-3 mx-auto">
                                                    <label for="occupant_name">भोगवटा धारकाचे नाव <span
                                                            class="text-danger">*</span></label>
                                                    <select name="occupant_name" id="occupant_name"
                                                        class="form-control select2-single-placeholder" >
                                                        <option value="" selected>--निवडा--</option>
                                                        <?php
                                                        if (mysqli_num_rows($occupant_name) > 0) {
                                                            while ($newName = mysqli_fetch_assoc($occupant_name)) {
                                                                $selected = ($isEditMode && $malmatta['occupant_name'] == $newName['person_name']) ? 'selected' : '';
                                                                echo '<option value="' . $newName['id'] . '" ' . $selected . '>' . $newName['person_name'] . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-3 mx-auto">
                                                    <label for="other_occupant_name">इतर भोगवटा धारकाचे नाव <span
                                                            class="text-danger">*</span></label>
                                                    <select name="other_occupant_name[]" multiple="multiple"
                                                        id="other_occupant_name" class="form-control select2-multiple"
                                                        >
                                                        <option value="" >--निवडा--</option>
                                                        <?php
                                                        if (mysqli_num_rows($other_occupant_name) > 0) {
                                                            $otherOccupants = $isEditMode && !empty($malmatta['other_occupant_name']) ? explode(',', $malmatta['other_occupant_name']) : [];
                                                            while ($newName = mysqli_fetch_assoc($other_occupant_name)) {
                                                                $selected = in_array($newName['person_name'], $otherOccupants) ? 'selected' : '';
                                                                echo '<option value="' . $newName['person_name'] . '" ' . $selected . '>' . $newName['person_name'] . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="city_survey_no">सिटी सर्वे क्रमांक</label>
                                                    <input type="text" class="form-control" name="city_survey_no"
                                                        id="city_survey_no" aria-describedby="emailHelp"
                                                        placeholder="सिटी सर्वे क्रमांक"
                                                        value="<?php echo $isEditMode ? htmlspecialchars($malmatta['city_survey_no']) : ''; ?>">
                                                </div>
                                                <div class="form-group col-md-4 mx-auto">
                                                    <label for="group_number">गट क्रमांक / सर्व्हे क्रमांक</label>
                                                    <input type="text" class="form-control" name="group_number"
                                                        id="group_number" aria-describedby="emailHelp"
                                                        placeholder="गट क्रमांक / सर्व्हे क्रमांक"
                                                        value="<?php echo $isEditMode ? htmlspecialchars($malmatta['group_no']) : ''; ?>">
                                                </div>
                                                <div class="form-group col-md-4 mx-auto">
                                                    <label for="toilet_available">शौचालय आहे <span
                                                            class="text-danger">*</span></label>
                                                    <select name="toilet_available" id="toilet_available"
                                                        class="form-control" required>
                                                        <option value="">--निवडा--</option>
                                                        <option value="yes" <?php echo $isEditMode && $malmatta['washroom_available'] == 'yes' ? 'selected' : ''; ?>>
                                                            आहे</option>
                                                        <option value="no" <?php echo $isEditMode && $malmatta['washroom_available'] == 'no' ? 'selected' : ''; ?>>
                                                            नाही</option>
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
                                                        <label for="income_type">मिळकत प्रकार</label>
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
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="income_other_info"
                                                            id="income_other_info" aria-describedby="emailHelp"
                                                            placeholder="पूर्व, पश्चिम, उत्तर, दक्षिण">
                                                    </div>
                                                    <div class="form-group col-md-4 mx-auto">
                                                        <label for="taxable_land">करातून सुट/करपात्र असणाऱ्या जमिनी व
                                                            इमारती <span class="text-danger">*</span></label>
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
                                                        <label for="property_use">मालमत्ता वापर</label>
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
                                                        <label for="tax_type">मालमत्ता/जमिनीचा कर प्रकार</label>
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
                                                        <label for="redirecenarParts">रेडिरेकनर प्रमाणे भाग /
                                                            उपविभाग</label>
                                                        <textarea name="redirecenarParts" class="form-control"
                                                            id="redirecenarParts" readonly></textarea>
                                                    </div>
                                                    <div class="form-group col-md-4 mx-auto">
                                                        <label for="redirecenarDar">दर</label>
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
                                                        <label for="floors">मजला</label>
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
                                                        <label for="height">लांबी</label>
                                                        <input type="number" class="form-control" name="height"
                                                            id="height" aria-describedby="emailHelp" placeholder="0">
                                                    </div>
                                                    <div class="form-group col-md-4 mx-auto">
                                                        <label for="width">रुंदी</label>
                                                        <input type="number" class="form-control" name="width"
                                                            id="width" aria-describedby="emailHelp" placeholder="0">
                                                    </div>
                                                    <div class="form-group col-md-4 mx-auto">
                                                        <label for="area">क्षेत्रफळ (Area)</label>
                                                        <input type="number" class="form-control" name="area" id="area"
                                                            aria-describedby="emailHelp" placeholder="0">
                                                        <small id="areaUnit" class="form-text text-muted">फूट (Square
                                                            Feet)</small>
                                                    </div>
                                                    <div class="form-group col-md-4 mx-auto">
                                                        <label for="converted_area">रूपांतरित क्षेत्रफळ (Converted
                                                            Area)</label>
                                                        <input type="number" class="form-control" name="converted_area"
                                                            id="converted_area" aria-describedby="emailHelp"
                                                            placeholder="0">
                                                        <small id="convertedAreaUnit" class="form-text text-muted">मीटर
                                                            (Square Meters)</small>
                                                    </div>
                                                    <div class="form-group col-md-4 mx-auto">
                                                        <label for="property_photo">मालमत्ता फोटो</label>
                                                        <input type="file" class="form-control property-photo-input"
                                                            name="property_photos[]" multiple>
                                                    </div>
                                                </div>
                                                <button type="button" name="add_property" id="add_property"
                                                    class="btn btn-primary bg-gradient-primary">Add</button>
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
                                                पाणीवापर</h5>
                                            <div class="w-75 col-12 card row py-5 px-4 my-5 mx-auto">
                                                <div class="row">
                                                    <div class="form-group col-md-3 mx-auto">
                                                        <label for="drainage_type">पाणीवापर प्रकार <span
                                                                class="text-danger">*</span></label>
                                                        <select name="drainage_type" id="drainage_type"
                                                            class="form-control" required>
                                                            <option value="" selected>--निवडा--</option>
                                                            <?php
                                                            if (mysqli_num_rows($drainageTypes) > 0) {
                                                                while ($drainageType = mysqli_fetch_assoc($drainageTypes)) {
                                                                    $selected = ($isEditMode && !empty($waterTariff) && $waterTariff['water_usage_type'] == $drainageType['drainage_type']) ? 'selected' : '';
                                                                    echo '<option value="' . $drainageType['drainage_type'] . '" ' . $selected . '>' . $drainageType['drainage_type'] . '</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-3 mx-auto">
                                                        <label for="tap_numbers">नळ संख्या</label>
                                                        <input type="number" class="form-control" name="tap_numbers"
                                                            id="tap_numbers" aria-describedby="emailHelp"
                                                            placeholder="नळ संख्या" <?php echo $isEditMode && !empty($waterTariff) && $waterTariff['water_usage_type'] == "वापर नाही" ? 'disabled' : ''; ?>
                                                            value="<?php echo $isEditMode && !empty($waterTariff) ? htmlspecialchars($waterTariff['no_of_taps']) : '0'; ?>">
                                                    </div>
                                                    <div class="form-group col-md-3 mx-auto">
                                                        <label for="tap_width">नळ व्यास</label>
                                                        <select name="tap_width" id="tap_width" class="form-control"  <?php echo $isEditMode && !empty($waterTariff) && $waterTariff['water_usage_type'] == "वापर नाही" ? 'disabled' : ''; ?>
                                                            >
                                                            <option value="" selected>--निवडा--</option>
                                                            <option value="1/2" <?php echo $isEditMode && !empty($waterTariff) && $waterTariff['tap_width'] == '1/2' ? 'selected' : ''; ?>>
                                                                1/2</option>
                                                            <option value="1" <?php echo $isEditMode && !empty($waterTariff) && $waterTariff['tap_width'] == '1' ? 'selected' : ''; ?>>
                                                                1</option>
                                                            <option value="3/4" <?php echo $isEditMode && !empty($waterTariff) && $waterTariff['tap_width'] == '3/4' ? 'selected' : ''; ?>>
                                                                3/4</option>
                                                        </select>
                                                    </div>
                                                                                    <div class="form-group col-md-3 mx-auto" id="meter_reading_div" style="display: <?php echo $isEditMode && !empty($waterTariff) && $waterTariff['water_usage_type'] == "विशेष पाणीपट्टी (मीटर रीडिंग अनुसार)" || $waterTariff['water_usage_type'] == "विशेष पाणीपट्टी (मीटर रीडिंग अनुसार) (विशेष)" ? 'none' : ''; ?>;" >
                                                        <label for="meter_reading">नळ मीटर रीडिंग
                                                        </label>
                                                        <input type="number" class="form-control" name="meter_reading"
                                                            id="meter_reading" aria-describedby="emailHelp"
                                                            placeholder="नळ मीटर रीडिंग" value="<?php echo $isEditMode && !empty($waterTariff) ? htmlspecialchars($waterTariff['meter_reading']) : '0'; ?>" <?php echo $isEditMode && !empty($waterTariff) && $waterTariff['water_usage_type'] == "वापर नाही" ? 'disabled' : ''; ?>>


                                                    </div>
                                                    <div class="form-group col-md-3 mx-auto" id="meter_no_div"
                                                        style="display: <?php echo $isEditMode && !empty($waterTariff) && $waterTariff['water_usage_type'] == "विशेष पाणीपट्टी (मीटर क्रमांक अनुसार)" || $waterTariff['water_usage_type'] == "विशेष पाणीपट्टी (मीटर क्रमांक अनुसार) (विशेष)" ? 'none' : ''; ?>;">
                                                        <label for="meter_no">नळ मीटर क्रमांक
                                                        </label>
                                                        <input type="text" class="form-control" name="meter_no"
                                                            id="meter_no" aria-describedby="emailHelp"
                                                            placeholder="नळ मीटर क्रमांक" value="<?php echo $isEditMode && !empty($waterTariff) ? htmlspecialchars($waterTariff['meter_no']) : '0'; ?>" <?php echo $isEditMode && !empty($waterTariff) && $waterTariff['water_usage_type'] == "वापर नाही" ? 'disabled' : ''; ?>>


                                                    </div>
                                                    <div class="form-group col-md-3 mx-auto">
                                                        <label for="tap_owner_name">नळ धारकाचे नाव</label>
                                                        <select name="tap_owner_name" id="tap_owner_name"
                                                            class="form-control select2-single-placeholder" <?php echo $isEditMode && !empty($waterTariff) && $waterTariff['water_usage_type'] == "वापर नाही" ? 'disabled' : ''; ?>>
                                                            <option value="" selected>--निवडा--</option>
                                                            <?php
                                                            if (mysqli_num_rows($tapOwner) > 0) {
                                                                while ($tapOwners = mysqli_fetch_assoc($tapOwner)) {
                                                                    $selected = ($isEditMode && !empty($waterTariff) && $waterTariff['tap_owner_name'] == $tapOwners['id']) ? 'selected' : '';
                                                                    echo '<option value="' . $tapOwners['id'] . '" ' . $selected . '>' . $tapOwners['person_name'] . '</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <h5 class="bg-gradient-primary text-white py-3 px-5 w-25 rounded-pill">शेरा
                                                / बोजा नोंद</h5>
                                            <div class="w-75 col-12 card row py-5 px-4 my-5 mx-auto">
                                                <div class="row">
                                                    <div class="form-group col-md-12 mx-auto">
                                                        <label for="remarks">शेरा / बोजा</label>
                                                        <textarea name="remarks" id="remarks" class="form-control"
                                                            placeholder="शेरा / बोजा नोंद"><?php echo $isEditMode ? htmlspecialchars($malmatta['remarks']) : ''; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="w-100 mx-auto col-md-2">
                                            <button type="submit" name="<?= $isEditMode ? 'update' : 'add' ?>"
                                                class="btn btn-primary bg-gradient-primary"><?= $isEditMode ? 'अद्यतनित करा' : 'साठवणे' ?></button>
                                            <button type="reset" class="btn btn-secondary bg-gradient-secondary">रद्द
                                                करणे</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
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
                let incomeEntries = [];
                <?php if ($isEditMode && !empty($properties)): ?>
                    incomeEntries = <?php echo $propertiesJson; ?>.map(prop => ({
                        property_id: prop.property_id || null,
                        taxTypeId: prop.property_use || '',
                        incomeType: prop.property_use || '',
                        incomeOtherInfo: prop.directions || '',
                        taxableLand: prop.tax_exempt || '',
                        propertyUse: prop.malmatta_use || '',
                        taxType: prop.property_tax_type || '',
                        taxTypeName: prop.property_tax_type_name || '',
                        redirecenarParts: prop.redirecconar_parts || '',
                        redirecenarPartsName: prop.redirecconar_parts_name || '',
                        redirecenarDar: prop.redirecenar_dar || '',
                        construction_year_type: prop.construction_year ? 'construction_year' : 'building_age',
                        age: prop.construction_year || prop.building_age || '',
                        floors: prop.floor || '',
                        selectedUnit: prop.measuring_unit || 'foot',
                        height: prop.lenght || '',
                        width: prop.width || '',
                        area: prop.areaInFoot || '',
                        convertedArea: prop.areaInMt || '',
                        propertyPhoto: prop.property_photo_path || null,
                        photoName: prop.property_photo_path ? 'property_photo.jpg' : null
                    }));
                    renderIncomeTable();
                    console.log(incomeEntries);

                <?php endif; ?>

                document.getElementById('add_property').onclick = function () {
                    addIncomeType();
                };

                function addIncomeType() {
                    const incomeType = document.getElementById('income_type').value.trim();
                    const incomeOtherInfo = document.getElementById('income_other_info').value.trim();
                    const taxableLand = document.getElementById('taxable_land').value.trim();
                    const propertyUse = document.getElementById('property_use').value.trim();
                    const taxType = document.getElementById('tax_type');
                    const taxTypeValue = taxType.value.trim();
                    const taxTypeText = taxType.options[taxType.selectedIndex]?.text || '';
                    const redirecenarParts = document.getElementById('redirecenarParts').value.trim();
                    const redirecenarDar = document.getElementById('redirecenarDar').value.trim();
                    const constructionYearType = document.querySelector('input[name="construction_year_type"]:checked')
                        ?.value || '';
                    const age = document.getElementById('age').value.trim();
                    const floors = document.getElementById('floors').value.trim();
                    const selectedUnit = document.querySelector('input[name="measuring_unit"]:checked')?.value || 'foot';
                    const height = document.getElementById('height').value.trim();
                    const width = document.getElementById('width').value.trim();
                    const area = document.getElementById('area').value.trim();
                    const convertedArea = document.getElementById('converted_area').value.trim();
                    const fileInput = document.querySelector('.property-photo-input');
                    const photoFile = fileInput.files[0];

                    let entry = {
                        property_id: null,
                        taxTypeId: taxTypeValue,
                        incomeType,
                        incomeOtherInfo,
                        taxableLand,
                        propertyUse,
                        taxType: taxTypeText,
                        taxTypeName: taxTypeText,
                        redirecenarParts,
                        redirecenarPartsName: redirecenarParts,
                        redirecenarDar,
                        construction_year_type: constructionYearType,
                        age,
                        floors,
                        selectedUnit,
                        height,
                        width,
                        area,
                        convertedArea,
                        propertyPhoto: null,
                        photoName: null
                    };

                    if (photoFile) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            entry.propertyPhoto = e.target.result;
                            entry.photoName = photoFile.name;
                            incomeEntries.push(entry);
                            renderIncomeTable();
                            resetPropertyForm();
                        };
                        reader.readAsDataURL(photoFile);
                    } else {
                        incomeEntries.push(entry);
                        renderIncomeTable();
                        resetPropertyForm();
                    }

                    document.getElementById("income_data").value = JSON.stringify(incomeEntries);
                }

                function renderIncomeTable() {
                    const tbody = document.getElementById("income_table").querySelector("tbody");
                    tbody.innerHTML = "";
                    console.log(incomeEntries);
                    
                    incomeEntries.forEach((entry, index) => {
                        const photoCell = entry.propertyPhoto ?
                            `<td><img src="${entry.propertyPhoto}" width="50" height="50" class="thumbnail-img" style="cursor: pointer;" data-fullimg="${entry.propertyPhoto}" onclick="showFullImage(this)"></td>` :
                            `<td>No photo</td>`;
                        const row = `<tr>
            <td>${entry.incomeType}</td>
            <td>${entry.incomeOtherInfo}</td>
            <td>${entry.taxableLand}</td>
            <td>${entry.propertyUse}</td>
            <td>${entry.taxTypeName}</td>
            <td>${entry.redirecenarPartsName}</td>
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
                    const overlay = document.createElement('div');
                    overlay.className = 'image-modal';
                    const fullImg = document.createElement('img');
                    fullImg.src = fullImgUrl;
                    fullImg.className = 'enlarged-image';
                    fullImg.onclick = (e) => e.stopPropagation();
                    const closeBtn = document.createElement('span');
                    closeBtn.innerHTML = '×';
                    closeBtn.className = 'close-btn';
                    closeBtn.onclick = () => document.body.removeChild(overlay);
                    overlay.appendChild(fullImg);
                    overlay.appendChild(closeBtn);
                    overlay.onclick = () => document.body.removeChild(overlay);
                    document.body.appendChild(overlay);
                }

                function removeIncomeType(index) {
                    incomeEntries.splice(index, 1);
                    renderIncomeTable();
                    document.getElementById("income_data").value = JSON.stringify(incomeEntries);
                }

                function editIncomeType(index) {
                    const entry = incomeEntries[index];
                    document.getElementById('income_type').value = entry.incomeType;
                    document.getElementById('income_other_info').value = entry.incomeOtherInfo;
                    document.getElementById('taxable_land').value = entry.taxableLand;
                    document.getElementById('property_use').value = entry.propertyUse;
                    document.getElementById('tax_type').value = entry.taxType;
                    document.getElementById('redirecenarParts').value = entry.redirecenarPartsName;
                    document.getElementById('redirecenarDar').value = entry.redirecenarDar;
                    document.getElementById(entry.construction_year_type).checked = true;
                    document.getElementById('age').value = entry.age;
                    document.getElementById('floors').value = entry.floors;
                    document.getElementById(entry.selectedUnit === 'foot' ? 'ft' : 'meter').checked = true;
                    document.getElementById('height').value = entry.height;
                    document.getElementById('width').value = entry.width;
                    document.getElementById('area').value = entry.area;
                    document.getElementById('converted_area').value = entry.convertedArea;

                    document.getElementById('add_property').textContent = 'Update';
                    document.getElementById('add_property').onclick = () => updateIncomeType(index);
                    document.getElementById('update_id').value = index;
                }

                function updateIncomeType(index) {
                    const incomeType = document.getElementById('income_type').value.trim();
                    const incomeOtherInfo = document.getElementById('income_other_info').value.trim();
                    const taxableLand = document.getElementById('taxable_land').value.trim();
                    const propertyUse = document.getElementById('property_use').value.trim();
                    const taxType = document.getElementById('tax_type');
                    const taxTypeValue = taxType.value.trim();
                    const taxTypeText = taxType.options[taxType.selectedIndex]?.text || '';
                    const redirecenarParts = document.getElementById('redirecenarParts').value.trim();
                    const redirecenarDar = document.getElementById('redirecenarDar').value.trim();
                    const constructionYearType = document.querySelector('input[name="construction_year_type"]:checked')
                        ?.value || '';
                    const age = document.getElementById('age').value.trim();
                    const floors = document.getElementById('floors').value.trim();
                    const selectedUnit = document.querySelector('input[name="measuring_unit"]:checked')?.value || 'foot';
                    const height = document.getElementById('height').value.trim();
                    const width = document.getElementById('width').value.trim();
                    const area = document.getElementById('area').value.trim();
                    const convertedArea = document.getElementById('converted_area').value.trim();
                    const fileInput = document.querySelector('.property-photo-input');
                    const photoFile = fileInput.files[0];

                    let entry = {
                        property_id: incomeEntries[index].property_id,
                        taxTypeId: taxTypeValue,
                        incomeType,
                        incomeOtherInfo,
                        taxableLand,
                        propertyUse,
                         taxType: taxTypeText,
                        taxTypeName: taxTypeText,
                        redirecenarParts,
                        redirecenarPartsName: redirecenarParts,
                        redirecenarDar,
                        construction_year_type: constructionYearType,
                        age,
                        floors,
                        selectedUnit,
                        height,
                        width,
                        area,
                        convertedArea,
                        propertyPhoto: incomeEntries[index].propertyPhoto,
                        photoName: incomeEntries[index].photoName
                    };

                    if (photoFile) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            entry.propertyPhoto = e.target.result;
                            entry.photoName = photoFile.name;
                            incomeEntries[index] = entry;
                            resetPropertyForm();
                            renderIncomeTable();
                        };
                        reader.readAsDataURL(photoFile);
                    } else {
                        incomeEntries[index] = entry;
                        resetPropertyForm();
                        renderIncomeTable();
                    }

                    document.getElementById("income_data").value = JSON.stringify(incomeEntries);
                }

                function resetPropertyForm() {
                    document.getElementById('income_type').value = '';
                    document.getElementById('income_other_info').value = '';
                    document.getElementById('taxable_land').value = '';
                    document.getElementById('property_use').value = '';
                    document.getElementById('tax_type').value = '';
                    document.getElementById('redirecenarParts').value = '';
                    document.getElementById('redirecenarDar').value = '';
                    document.getElementById('age').value = '';
                    document.getElementById('floors').value = '';
                    document.getElementById('height').value = '';
                    document.getElementById('width').value = '';
                    document.getElementById('area').value = '';
                    document.getElementById('converted_area').value = '';
                    document.querySelector('.property-photo-input').value = '';
                    document.getElementById('ft').checked = true;
                    document.getElementById('add_property').textContent = 'Add';
                    document.getElementById('add_property').onclick = addIncomeType;
                    document.getElementById('update_id').value = '';
                }

                document.getElementById('malmattaForm').addEventListener('submit', function (e) {
                    e.preventDefault();
                    document.getElementById("income_data").value = JSON.stringify(incomeEntries);
                    const formData = new FormData(this);

                    incomeEntries.forEach((entry, index) => {
                        if (entry.propertyPhoto && typeof entry.propertyPhoto === 'string' && entry
                            .propertyPhoto.startsWith('data:')) {
                            const blob = dataURLtoBlob(entry.propertyPhoto);
                            formData.append(`property_photos[${index}]`, blob, entry.photoName ||
                                `property_${index}.jpg`);
                        }
                    });

                    if (<?php echo $isEditMode ? 'true' : 'false'; ?>) {
                        formData.append("update", "yes");
                        formData.append("edit_id", "<?php echo $editId ?? ''; ?>");
                    } else {
                        formData.append("add", "yes");
                    }

                    if (confirm("तुमची खात्री आहे की तुम्ही हा फॉर्म सबमिट करू इच्छिता?")) {
                        document.getElementById('fullScreenLoader').style.display = 'flex';
                        fetch(this.action, {
                            method: 'POST',
                            body: formData
                        })
                            .then(response => response.json())
                            .then(data => {
                                document.getElementById('fullScreenLoader').style.display = 'none';
                                if (data.success) {
                                    alert(data.message || 'Form submitted successfully');
                                    window.location.href = data.redirect || window.location.origin;
                                } else {
                                    alert(data.message || 'Error occurred');
                                }
                            })
                            .catch(error => {
                                document.getElementById('fullScreenLoader').style.display = 'none';
                                console.error('Error:', error);
                                alert('Error submitting form');
                            });
                    }
                });

                function dataURLtoBlob(dataurl) {
                    const arr = dataurl.split(','),
                        mime = arr[0].match(/:(.*?);/)[1],
                        bstr = atob(arr[1]);
                    let n = bstr.length,
                        u8arr = new Uint8Array(n);
                    while (n--) u8arr[n] = bstr.charCodeAt(n);
                    return new Blob([u8arr], {
                        type: mime
                    });
                }

                document.addEventListener("DOMContentLoaded", function () {
                    const heightInput = document.getElementById("height");
                    const widthInput = document.getElementById("width");
                    const areaInput = document.getElementById("area");
                    const convertedAreaInput = document.getElementById("converted_area");
                    const areaUnitLabel = document.getElementById("areaUnit");
                    const convertedAreaUnitLabel = document.getElementById("convertedAreaUnit");
                    const footRadio = document.getElementById("ft");
                    const meterRadio = document.getElementById("meter");

                    function convertArea(area, fromUnit, toUnit) {
                        if (fromUnit === 'foot' && toUnit === 'meter') return area * 0.092903;
                        if (fromUnit === 'meter' && toUnit === 'foot') return area * 10.7639;
                        return area;
                    }

                    function calculateAndDisplayAreas() {
                        const height = parseFloat(heightInput.value) || 0;
                        const width = parseFloat(widthInput.value) || 0;
                        let area = height * width;
                        if (meterRadio.checked) {
                            areaInput.value = area.toFixed(2);
                            areaUnitLabel.textContent = "मीटर (Square Meters)";
                            convertedAreaInput.value = convertArea(area, 'meter', 'foot').toFixed(2);
                            convertedAreaUnitLabel.textContent = "फूट (Square Feet)";
                        } else {
                            areaInput.value = area.toFixed(2);
                            areaUnitLabel.textContent = "फूट (Square Feet)";
                            convertedAreaInput.value = convertArea(area, 'foot', 'meter').toFixed(2);
                            convertedAreaUnitLabel.textContent = "मीटर (Square Meters)";
                        }
                    }

                    heightInput.addEventListener("input", calculateAndDisplayAreas);
                    widthInput.addEventListener("input", calculateAndDisplayAreas);
                    footRadio.addEventListener("change", calculateAndDisplayAreas);
                    meterRadio.addEventListener("change", calculateAndDisplayAreas);
                    calculateAndDisplayAreas();

                    const taxType = document.getElementById("tax_type");
                    taxType.addEventListener("change", function () {
                        if (!this.value) return;
                        fetch(`api/getRedirecenarParts.php?tax_type=${this.value}`)
                            .then(response => response.json())
                            .then(data => {
                                document.getElementById('redirecenarParts').value = data
                                    .readyrec_type || 'No data found';
                                document.getElementById('redirecenarDar').value = data.yearly_tax ||
                                    'No data found';
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                document.getElementById('redirecenarParts').value =
                                    'Error fetching data';
                            });
                    });

                    const malmattaNoInput = document.getElementById('malmatta_no');
                    const districtCode = '<?php echo $_SESSION['district_code']; ?>';
                    const editId = '<?php echo $isEditMode ? $editId : ''; ?>';

                    function checkMalmattaAvailability(malmattaNo) {
                        if (!malmattaNo) {
                            document.getElementById('malmattaNoHelp').textContent = '';
                            malmattaNoInput.setCustomValidity('');
                            return;
                        }
                        fetch(
                            `api/check_malmatta_no.php?malmatta_no=${malmattaNo}&district_code=${districtCode}&edit_id=${editId}`
                        )
                            .then(response => response.json())
                            .then(data => {
                                const helpText = document.getElementById('malmattaNoHelp');
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
                            .catch(error => console.error('Error:', error));
                    }

                    // malmattaNoInput.addEventListener('blur', () => checkMalmattaAvailability(malmattaNoInput
                    //     .value));

                    $("#drainage_type").change(function () {
                        const selectedValue = $(this).val();
                        if (selectedValue === "वापर नाही") {
                            $("#tap_numbers").prop("disabled", true).val('').prop("required", false);
                            $("#tap_width").prop("disabled", true).val('').prop("required", false);
                            $("#tap_owner_name").prop("disabled", true).val('').prop("required", false);
                        }else if(selectedValue === "विशेष पाणीपट्टी (मीटर रीडिंग अनुसार)" || selectedValue === "विशेष पाणीपट्टी (मीटर रीडिंग अनुसार) (विशेष)"){
                $("#meter_reading").prop("disabled", false);
                $("#meter_reading").prop("required", true);
                $("#meter_reading_div").show();
                $("#meter_no_div").show();

                 $("#tap_numbers").prop("disabled", false).prop("required", true).prop('readonly', false);
                            $("#tap_width").prop("disabled", false).prop("required", true).prop('readonly', false);
                            $("#tap_owner_name").prop("disabled", false).prop("required", true).prop('readonly', false);
            }
            
            else {
                            $("#tap_numbers").prop("disabled", false).prop("required", true).prop('readonly', false);
                            $("#tap_width").prop("disabled", false).prop("required", true).prop('readonly', false);
                            $("#tap_owner_name").prop("disabled", false).prop("required", true).prop('readonly', false);
                            $("#meter_reading").prop("disabled", true);
               
                $("#meter_reading").prop("required", false);
                $("#meter_reading_div").hide();
                $("#meter_no_div").hide();

                        }
                    });
                });
            </script>
</body>

</html>