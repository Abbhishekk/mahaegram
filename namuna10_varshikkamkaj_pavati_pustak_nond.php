<?php 
require_once './include/auth_middleware.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php 
$title = "पावती पुस्तक नोंदणी";
?>
<?php include('include/header.php'); ?>
<?php
    $financialYears = $fun->getFinancialYears();
    $banks = $fun->getBanks();
    $materials = $fun ->getMaterials($_SESSION['district_code']);
    $periodsWithReasons = $fun->getPeriodTotalPeriodsWithPeriodReason("नमुना नंबर 8 कालावधी", $_SESSION['district_code']);
    $yearArray = $fun->getYearArray($periodsWithReasons);
    $currentYear = date('Y');
    $currentYearIndex = 0;
    for ($i = 0; $i < count($yearArray); $i++) {
        $yearRange = explode("-", $yearArray[$i]);
        $startYear = $yearRange[0];
        $endYear = $yearRange[1];
        if ($startYear <= $currentYear && $endYear >= $currentYear) {
            $currentYearIndex = $i;
            break;
        }
    }
    $pavati_pustak = $fun->getPavatiPustak($_SESSION['district_code']);
    // print_r($periodsWithReasons);
?>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php 
        $page = 'namuna10';
        $subpage = 'yearlyWork';
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
                        <h1 class="h3 mb-0 text-gray-800">पावती पुस्तक नोंदणी </h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">माहईग्राम</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 10</li>
                            <li class="breadcrumb-item active" aria-current="page">मास्टर्स</li>
                            <li class="breadcrumb-item active" aria-current="page">पावती पुस्तक नोंदणी</li>
                        </ol>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <?php
                                if (isset($_SESSION['message'])) {
                                    echo "<div class='alert alert-{$_SESSION['message_type']}'>{$_SESSION['message']}</div>";
                                    unset($_SESSION['message']);
                                    unset($_SESSION['message_type']);
                                }
                                ?>
                                <div class="card-header py-3 d-flex flex-row justify-content-center align-items-center gap-5 " >
                                    <div class="form-check form-check-inline d-flex justify-content-start align-items-center mx-5" >
                                        <input type="radio" name="pavati_actions" id="nondani" value="nondani"  checked>
                                        <label for="nondani" class="d-flex justify-content-start align-items-center h4" >पावती पुस्तक नोंदणी</label>
                                    </div>
                                    <div class="form-check form-check-inline  d-flex justify-content-start align-items-center mx-5 " >
 <input type="radio" name="pavati_actions" id="vitaran" value="vitaran"  >
                                    <label for="vitaran" class="d-flex justify-content-start align-items-center h4" >पुस्तक वितरण</label>
                                    </div>
                                   
                                </div>
                                <div class="card-body" id="nondani-form" >

                                    <form method="post" action="api/pavati_pustak.php">
                                        <input type="hidden" name="balance_id" id="balance_id" value="">



                                        <!-- Main Form Fields -->
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <label for="buying_date">खरेदी दिनांक :<span
                                                        class="text-danger">*</span></label>
                                                <input type="date" name="buying_date" id="buying_date"
                                                    class="form-control" value="<?= date('Y-m-d') ?>" required>
                                            </div>
                                            <div
                                                class="form-group col-md-8 d-flex justify-content-start align-items-center">
                                                <p class="font-weight-bold"> आर्थिक वर्ष :
                                                    <?php echo $yearArray[$currentYearIndex];  ?>
                                                </p>
                                                <input type="hidden" name="financial_year" id="financial_year"
                                                    class="form-control" value="<?php echo $yearArray[$currentYearIndex];  ?>"
                                                    >
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="material_type">पा.पु/समान प्रकार :</label>
                                                <select class="form-control" name="material_type" id="material_type">
                                                    <option value="">--निवडा--</option>
                                                    <?php
                                                        if(mysqli_num_rows($materials) > 0):
                                                            while($record = mysqli_fetch_assoc($materials)):
                                                    ?>
                                                            <option value="<?php echo $record['material_name']; ?>"><?php echo $record['material_name']; ?></option>
                                                    <?php
                                                            endwhile;
                                                        endif;
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="material_number">पं.स.बांधणी क्रमांक :<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="material_number" id="material_number"
                                                    class="form-control">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="total_number">पा.पु./समान संख्या :<span
                                                        class="text-danger">*</span></label>
                                                <input type="number" name="total_number" id="total_number"
                                                    class="form-control">
                                            </div>

                                        </div>

                                        <button type="submit" name="save" class="btn btn-primary">साठवणे</button>
                                        <button type="reset" class="btn btn-secondary">रद्द करणे</button>
                                    </form>
                                </div>
                                <div class="card-body" id="vitaran-form" >

                                    <form method="post" action="api/pavati_pustak_vitaran.php">
                                        <input type="hidden" name="distribution_id" id="distribution_id" value="">



                                        <!-- Main Form Fields -->
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="plan_name">फंडाचे नाव : <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-control" name="plan_name" id="plan_name" required>
                                                    <option value="">--निवडा--</option>
                                                    <option value="ग्रामनिधी">ग्रामनिधी</option>
                                                    <option value="ग्राम पाणीपुरवठा निधी">ग्राम पाणीपुरवठा निधी</option>
                                                </select>
                                            </div>
                                            <input type="hidden" name="financial_year" id="financial_year"
                                                    class="form-control" value="<?php echo $yearArray[$currentYearIndex];  ?>"
                                                    />
                                            <div class="form-group col-md-6">
                                                <label for="material_number_pavati">पा.पु/समान नों.क्रमांक : <span
                                                        class="text-danger">*</span> </label>
                                                <select class="form-control" name="material_number_pavati" id="material_number_pavati" required>
                                                    <option value="">--निवडा--</option>
                                                    <?php
                                                        if(mysqli_num_rows($pavati_pustak) > 0):
                                                            while($record = mysqli_fetch_assoc($pavati_pustak)):
                                                    ?>
                                                            <option value="<?php echo $record['id']; ?>"><?php echo $record['material_number']; ?></option>
                                                    <?php
                                                            endwhile;
                                                        endif;
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="namuna_number">बुक प्रकार: नमुना नं :</label>
                                                <select class="form-control" name="namuna_number" id="namuna_number">
                                                    <option value="">--निवडा--</option>
                                                    <option value="7">7</option>
                                                    <option value="10">10</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="pavati_number">साठी पावती संख्या :<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="pavati_number" id="pavati_number"
                                                    class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="given_person_name">दिलेल्या व्यक्तीचे नाव :<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="given_person_name" id="given_person_name"
                                                    class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="book_number">बुक नंबर :<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="book_number" id="book_number"
                                                    class="form-control" required readonly >
                                            </div>
                                            <div class="form-group col-md-6">
    <label for="pavati_pasun">पावती पासून :<span class="text-danger">*</span></label>
    <input type="number" name="pavati_pasun" id="pavati_pasun" class="form-control" required min="1">
</div>
<div class="form-group col-md-6">
    <label for="pavati_paryant">पावती पर्यंत :<span class="text-danger">*</span></label>
    <input type="number" name="pavati_paryant" id="pavati_paryant" class="form-control" required min="1">
</div>

                                        </div>

                                        <button type="submit" name="save" class="btn btn-primary">साठवणे</button>
                                        <button type="reset" class="btn btn-secondary">रद्द करणे</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Data Table -->
                      <div class="col-lg-12" id="nondani-table" >
    <div class="card">
        <div class="table-responsive">
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th>अ.क्र.</th>
                        <th>खरेदी दिनांक</th>
                        <th>आर्थिक वर्ष</th>
                        <th>पा.पु./सामान प्रकार</th>
                        <th>संख्या</th>
                        <th>पं.स. बांधणी क्रमांक</th>
                        <th>क्रिया</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $records = $fun->getPavatiPustak($_SESSION['district_code']);
                    if(mysqli_num_rows($records) > 0): 
                    ?>
                    <?php $i = 1; while($record = mysqli_fetch_assoc($records)): ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= date('d-m-Y', strtotime($record['buying_date'])) ?></td>
                        <td><?= $record['financial_year'] ?></td>
                        <td><?= $record['material_type'] ?></td>
                        <td><?= $record['total_number'] ?></td>
                        <td><?= $record['material_number'] ?></td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-primary" onclick="fillFormData(
                                    '<?= $record['id'] ?>',
                                    '<?= $record['buying_date'] ?>',
                                    '<?= $record['material_type'] ?>',
                                    '<?= $record['material_number'] ?>',
                                    '<?= $record['total_number'] ?>'
                                )">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <a href="api/pavati_pustak.php?delete=<?= $record['id'] ?>"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('तुम्हाला ही नोंद नक्की हटवायची आहे का?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php $i++; endwhile; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">नोंद सापडली नाही</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
                      <div class="col-lg-12" id="vitaran-table">
    <div class="card">
        <div class="table-responsive">
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th>अ.क्र.</th>
                        <th>फंडाचे नाव</th>
                        <th>आर्थिक वर्ष</th>
                        <th>बुक प्रकार: नमुना नं</th>
                        <th>बुक नंबर</th>
                        <th>पावती संख्या</th>
                        <th>बुक दिलेल्या व्यक्तीचे नाव</th>
                        <th>पावती पासून</th>
                        <th>पावती पर्यंत</th>
                        <th>क्रिया</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $distributions = $fun->getPavatiPustakVitaran($_SESSION['district_code']);
                    if(mysqli_num_rows($distributions) > 0): 
                    ?>
                    <?php $i = 1; while($record = mysqli_fetch_assoc($distributions)):
                            // print_r($record);
                        ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $record['plan_name'] ?></td>
                        <td><?= $record['financial_year'] ?></td>
                        <td><?= $record['namuna_number'] ?></td>
                        <td><?= $record['book_number'] ?></td>
                        <td><?= $record['pavati_number'] ?></td>
                        <td><?= $record['given_person_name'] ?></td>
                        <td><?= $record['pavati_pasun'] ?></td>
                        <td><?= $record['pavati_paryant'] ?></td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-primary" onclick="fillDistributionFormData(
                                    '<?= $record['id'] ?>',
                                    '<?= $record['plan_name'] ?>',
                                    '<?= $record['material_id'] ?>',
                                    '<?= $record['namuna_number'] ?>',
                                    '<?= $record['pavati_number'] ?>',
                                    '<?= $record['given_person_name'] ?>',
                                    '<?= $record['book_number'] ?>',
                                    '<?= $record['pavati_pasun'] ?>',
                                    '<?= $record['pavati_paryant'] ?>',
                                    '<?= $record['financial_year'] ?>'
                                )">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <a href="api/pavati_pustak_vitaran.php?delete=<?= $record['id'] ?>"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('तुम्हाला ही नोंद नक्की हटवायची आहे का?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php $i++; endwhile; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="10" class="text-center">वितरण नोंद सापडली नाही</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
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
// Fill registration form with existing data
function fillFormData(id, buyingDate, materialType, materialNumber, totalNumber) {
    // Set ID
    $('#balance_id').val(id);

    // Set form fields
    $('#buying_date').val(buyingDate);
    $('#material_type').val(materialType);
    $('#material_number').val(materialNumber);
    $('#total_number').val(totalNumber);

    // Change button text
    $('button[name="save"]').text('अपडेट करा');

    // Scroll to form
    $('html, body').animate({
        scrollTop: $('form').offset().top
    }, 500);
}

// Fill distribution form with existing data
function fillDistributionFormData(id, planName, materialId, namunaNumber, pavatiNumber, 
                                givenPersonName, bookNumber, pavatiPasun, pavatiParyant, financial_year) {
    // Set ID
    $('#distribution_id').val(id);

    // Set form fields
    $('#plan_name').val(planName);
    $('#material_number_pavati').val(materialId);
    console.log(materialId);
    
    
    $('#namuna_number').val(namunaNumber);
    $('#pavati_number').val(pavatiNumber);
    $('#given_person_name').val(givenPersonName);
    $('#book_number').val(bookNumber);
    $('#pavati_pasun').val(pavatiPasun);
    $('#pavati_paryant').val(pavatiParyant);
    $('#financial_year').val(financial_year);

    // Change button text
    $('button[name="save"]', '#vitaran-form').text('अपडेट करा');

    // Scroll to form
    $('html, body').animate({
        scrollTop: $('#vitaran-form').offset().top
    }, 500);
}

// Reset forms when cancel button is clicked
$('button[type="reset"]').click(function() {
    $('#balance_id').val('');
    $('#distribution_id').val('');
    $('#buying_date').val('<?= date('Y-m-d') ?>');
    $('button[name="save"]').text('साठवणे');
});

// Show/hide forms and tables based on selected radio button
$(document).ready(function() {
    $('#vitaran-form').hide();
    $('#vitaran-table').hide();
    
    $('input[name="pavati_actions"]').on('change', function() {
        if ($(this).val() == 'nondani') {
            $('#nondani-form').show();
            $('#vitaran-form').hide();
            $('#nondani-table').show();
            $('#vitaran-table').hide();
        } else {
            $('#nondani-form').hide();
            $('#vitaran-form').show();
            $('#nondani-table').hide();
            $('#vitaran-table').show();
        }
    });
});
// Add this script in your JavaScript section
$(document).ready(function() {
    // When material is selected in vitaran form
    $('#material_number_pavati').on('change', function() {
        var materialId = $(this).val();
        if (materialId) {
            // Fetch material details
            $.ajax({
                url: 'api/getPavatiPustakDetails.php',
                type: 'POST',
                data: {id: materialId},
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Generate book number
                        generateBookNumber(materialId, function(bookNumber) {
                            $('#book_number').val(bookNumber);
                        });
                        
                        // Set max values for pavati inputs
                        $('#pavati_pasun').attr('data-max', response.total_number);
                        $('#pavati_paryant').attr('data-max', response.total_number);
                    }
                }
            });
        }
    });
    
    // Validate pavati numbers
    $('#pavati_pasun, #pavati_paryant').on('change', function() {
        var max = parseInt($(this).attr('data-max'));
        var value = parseInt($(this).val());
        
        if (value > max) {
            alert('पावती संख्या ' + max + ' पेक्षा जास्त असू शकत नाही');
            $(this).val('');
        }
        
        // Ensure paryant is >= pasun
        if ($(this).attr('id') === 'pavati_pasun') {
            var paryant = parseInt($('#pavati_paryant').val());
            if (paryant && value > paryant) {
                $('#pavati_paryant').val(value);
            }
        } else if ($(this).attr('id') === 'pavati_paryant') {
            var pasun = parseInt($('#pavati_pasun').val());
            if (pasun && value < pasun) {
                $('#pavati_pasun').val(value);
            }
        }
    });
});

function generateBookNumber(materialId, callback) {
    $.ajax({
        url: 'api/generateBookNumber.php',
        type: 'POST',
        data: {material_id: materialId},
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                callback(response.book_number);
            }
        }
    });
}
</script>

</body>

</html>