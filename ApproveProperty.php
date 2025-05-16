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
    $periods = $fun->getPeriodDetailsLastValueByPeriodReason("नमुना नंबर 8 कालावधी",$_SESSION['district_code']);
    // $malmatta_data_entries = $fun->getMalmattaDataEntry($_SESSION['district_code']);
    // print_r($periods);
?>
<?php
$selected_period = null;
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['period']) && $_POST['period'] !== '') {
    $selected_period = $_POST['period'];
    // You can filter malmatta data here based on $selected_period
    $malmatta_data_entries = $fun->getMalmattaDataEntryByPeriod($_SESSION['district_code'], $selected_period);
} else {
    $malmatta_data_entries = null;
}
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
                        <h1 class="h3 mb-0 text-gray-800">मालमत्ता माहिती प्रमाणिकरण</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">माहईग्राम</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 8</li>
                            <li class="breadcrumb-item active" aria-current="page">मालमत्ता माहिती</li>
                            <li class="breadcrumb-item active" aria-current="page">मालमत्ता माहिती प्रमाणिकरण</li>
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
                                    <form method="post">
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <label for="period">कालावधी<span class="text-danger">*</span>
                                                </label>
                                                <select name="period" id="period" class="form-control"
                                                    onchange="this.form.submit()">
                                                    <option value="" disabled
                                                        <?= $selected_period === null ? 'selected' : '' ?>>--निवडा--
                                                    </option>
                                                    <?php
    if (count($periods) > 0) {
     
        
            $selected = ($selected_period == $periods['id']) ? 'selected' : '';
            echo '<option value="'.$periods['id'].'" '.$selected.'>'.$periods['total_period'].'</option>';
        
    }
    ?>
                                                </select>


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
                        <?php if ($selected_period && $malmatta_data_entries && mysqli_num_rows($malmatta_data_entries) > 0): ?>
                        <div class="col-lg-12">
                            <div class="card">

                                <div class="table-responsive">
                                    <table class="table align-items-center table-flush">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>अ.क्र.</th>
                                                <th>वॉर्डचे नाव</th>
                                                <th>रस्त्याचे नाव</th>
                                                <th>मि नं.</th>
                                                <th>गट /सर्वे नं</th>
                                                <th>मालमत्ता धारकाचे नाव</th>
                                                <th>भोगवटाधारक</th>
                                                <th>मालमता प्रकार</th>
                                                <th>अधिक माहिती</th>
                                                <th>मजला</th>
                                                <th>Measuring Unit</th>
                                                <th>लांबी</th>
                                                <th>रुंदी</th>
                                                <th>क्षेत्रफळ</th>
                                                <th>बा.वर्ष</th>
                                                <th>भारांक</th>
                                                <!-- <th>जमिन दर</th>
                                                <th>बांधकाम दर</th> -->
                                                <th>प्रमाणित</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if(mysqli_num_rows($malmatta_data_entries) > 0){
                                                    $i = 1;
                                                    while($name = mysqli_fetch_assoc($malmatta_data_entries)){
                                                        //    print_r($name);
                                                        //    echo "<br>";
                                                        $malmatta_period_details = $fun->getMalmattaDetailsAll($name['malmatta_id'], $name["village_name"]);
                                                        // print_r($malmatta_period_details);
                                                        // echo "<br>";
                                                          $malmatta_use_tax = [
            "रहिवाशी" => 1,
            "वाणिज्य/व्यापार" => 1.2,
            "औद्योगिक" => 1.5
        ];
                                                        $bharank = $malmatta_use_tax[$name["malmatta_use"]];
                                             ?>
                                            <tr>
                                                <td><a href="#"><?php echo $i; ?></a></td>
                                                <td><?php echo $name['ward_name']; ?></td>
                                                <td><?php echo $name['road_name']; ?></td>
                                                <td><?php echo $name['malmatta_no']; ?></td>
                                                <td><?php echo $name['group_no']."/".$name['city_survey_no']; ?></td>
                                                <td><?php echo $name['owner_name']; ?></td>
                                                <td><?php echo $name['occupant_name']; ?></td>
                                                <td><?php echo $name['tax_exempt']; ?></td>
                                                <td><?php echo $name['directions']; ?></td>
                                                <td><?php echo $name['floor']; ?></td>
                                                <td><?php echo $name['measuring_unit']; ?></td>
                                                <td><?php echo $name['lenght']; ?></td>
                                                <td><?php echo $name['width']; ?></td>
                                                <td><?php echo $name['area']; ?></td>
                                                <td><?php echo $name['construction_year']; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                                        data-target="#modal<?php echo $name['malmatta_id']?>"
                                                        id="#modalCenter<?php echo $name['malmatta_id'] ?>">View
                                                        Properties</button>
                                                    <div class="modal fade" id="modal<?php echo $name['malmatta_id']?>"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document"
                                                            style="width: 90% !important;">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="exampleModalCenterTitle">Property Details
                                                                    </h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
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
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                        if (isset($malmatta_period_details["info"][0]['properties'])) {
                                            $i = 1;
                                            foreach ($malmatta_period_details["info"][0]['properties'] as $property) {
                                                // print_r($property);
                                                ?>
                                                                                <tr>
                                                                                    <td><?php echo $i++; ?></td>
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

                                                                                </tr>

                                                                                <?php
                                                                                $i++;
                                            }
                                        } else {
                                            ?>
                                                                                <tr>
                                                                                    <td colspan="15">No data found</td>
                                                                                </tr>
                                                                                <?php
                                        }
                                    ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td>
                                                    <form method="POST" action="api/pramanit.php"
                                                        onsubmit="return confirm('प्रमाणित करायचे आहे का?');">
                                                        <input type="hidden" name="malmatta_id"
                                                            value="<?php echo $name['malmatta_id']; ?>">
                                                        <button type="submit" class="btn btn-success btn-sm"
                                                            title="प्रमाणित करा">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" fill="currentColor"
                                                                class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                                <path
                                                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                                <path fill-rule="evenodd"
                                                                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </td>


                                            </tr>
                                            <?php
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
                        <?php elseif ($selected_period): ?>
                        <div class="alert alert-info">माहिती उपलब्ध नाही.</div>
                        <?php endif; ?>
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