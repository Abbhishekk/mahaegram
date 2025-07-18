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
$materials = $fun->getMaterials($_SESSION['district_code']);
$periodsWithReasons = $fun->getPeriodTotalPeriodsWithPeriodReason("नमुना नंबर 8 कालावधी", $_SESSION['district_code']);
$disabled = '';
if (mysqli_num_rows($periodsWithReasons) == 0) {
    $_SESSION['message'] = "कालावधी नोंदणी केलेली नाही. कृपया कालावधी नोंदणी करा.";
    $_SESSION['message_type'] = 'danger';
    $disabled = 'disabled';
} else {
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
    $disabled = '';
}
$pavati_pustak = $fun->getPavatiPustak($_SESSION['district_code']);

?>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php
        $page = 'namuna7';
        $subpage = 'dainandin';
        
        ?>
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <?php include('include/topbar.php');
                include('include/sidebar.php');?>
                <!-- Topbar -->

                <!-- Container Fluid-->
                <div class="container-fluid border rounded p-3" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">पावती पुस्तक नोंदणी</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">पंचायत पोर्टल</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक ७</li>
                            <li class="breadcrumb-item active" aria-current="page">दैनंदिन कामकाज</li>
                            <li class="breadcrumb-item active" aria-current="page">पावती पुस्तक नोंदणी</li>
                        </ol>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="card mb-4 shadow-sm">
                                <?php
                                if (isset($_SESSION['message'])) {
                                    echo "<div class='alert alert-{$_SESSION['message_type']} text-center'>{$_SESSION['message']}</div>";
                                    unset($_SESSION['message']);
                                    unset($_SESSION['message_type']);
                                }
                                ?>
                                <div class="card-header py-3 bg-primary text-white">
                                    <div class="d-flex justify-content-center">
                                        <div class="form-check form-check-inline mx-4">
                                            <input class="form-check-input" type="radio" name="pavati_actions" id="nondani" value="nondani" checked>
                                            <label class="form-check-label h5 mb-0" for="nondani">
                                                <i class="fas fa-book me-2"></i>पावती पुस्तक नोंदणी
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline mx-4">
                                            <input class="form-check-input" type="radio" name="pavati_actions" id="vitaran" value="vitaran">
                                            <label class="form-check-label h5 mb-0" for="vitaran">
                                                <i class="fas fa-share-square me-2"></i>पुस्तक वितरण
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card-body" id="nondani-form">
                                    <form method="post" action="api/pavati_pustak.php" class="needs-validation" novalidate>
                                        <input type="hidden" name="balance_id" id="balance_id" value="">

                                        <div class="row g-3">
                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                    <input type="date" name="buying_date" id="buying_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
                                                    <label for="buying_date">खरेदी दिनांक <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-8 d-flex align-items-center">
                                                <div class="form-floating flex-grow-1">
                                                    <input type="text" class="form-control-plaintext" value="<?php echo $yearArray[$currentYearIndex ?? 0] ?? '';  ?>" readonly>
                                                    <label>आर्थिक वर्ष</label>
                                                </div>
                                                <input type="hidden" name="financial_year" id="financial_year" value="<?php echo $yearArray[$currentYearIndex ?? 0] ?? '';  ?>">
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                    <select class="form-select" name="material_type" id="material_type">
                                                        <option value="">--निवडा--</option>
                                                        <?php
                                                        if (mysqli_num_rows($materials) > 0):
                                                            while ($record = mysqli_fetch_assoc($materials)):
                                                        ?>
                                                                <option value="<?php echo $record['material_name']; ?>">
                                                                    <?php echo $record['material_name']; ?></option>
                                                        <?php
                                                            endwhile;
                                                        endif;
                                                        ?>
                                                    </select>
                                                    <label for="material_type">पा.पु/समान प्रकार</label>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                    <input type="text" name="material_number" id="material_number" class="form-control" required>
                                                    <label for="material_number">पं.स.बांधणी क्रमांक <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                    <input type="number" name="total_number" id="total_number" class="form-control" required>
                                                    <label for="total_number">पा.पु./समान संख्या <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            
                                            <div class="col-12 text-center mt-3">
                                                <button type="submit" name="save" class="btn btn-primary px-4 me-2" <?php echo $disabled ?>>
                                                    <i class="fas fa-save me-2"></i>साठवणे
                                                </button>
                                                <button type="reset" class="btn btn-outline-secondary px-4">
                                                    <i class="fas fa-times me-2"></i>रद्द करणे
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                
                                <div class="card-body" id="vitaran-form" style="display: none;">
                                    <form method="post" action="api/pavati_pustak_vitaran.php" class="needs-validation" novalidate>
                                        <input type="hidden" name="distribution_id" id="distribution_id" value="">

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <select class="form-select" name="plan_name" id="plan_name" required>
                                                        <option value="">--निवडा--</option>
                                                        <option value="ग्रामनिधी">ग्रामनिधी</option>
                                                        <option value="ग्राम पाणीपुरवठा निधी">ग्राम पाणीपुरवठा निधी</option>
                                                    </select>
                                                    <label for="plan_name">फंडाचे नाव <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <select class="form-select" name="material_number_pavati" id="material_number_pavati" required>
                                                        <option value="">--निवडा--</option>
                                                        <?php
                                                        if (mysqli_num_rows($pavati_pustak) > 0):
                                                            while ($record = mysqli_fetch_assoc($pavati_pustak)):
                                                        ?>
                                                                <option value="<?php echo $record['id']; ?>">
                                                                    <?php echo $record['material_number']; ?></option>
                                                        <?php
                                                            endwhile;
                                                        endif;
                                                        ?>
                                                    </select>
                                                    <label for="material_number_pavati">पा.पु/समान नों.क्रमांक <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            
                                            <input type="hidden" name="financial_year" id="financial_year" value="<?php echo $yearArray[$currentYearIndex];  ?>" />
                                            
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <select class="form-select" name="namuna_number" id="namuna_number">
                                                        <option value="">--निवडा--</option>
                                                        <option value="7">7</option>
                                                        <option value="10">10</option>
                                                    </select>
                                                    <label for="namuna_number">बुक प्रकार: नमुना नं</label>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="text" name="pavati_number" id="pavati_number" class="form-control" required>
                                                    <label for="pavati_number">साठी पावती संख्या <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="text" name="given_person_name" id="given_person_name" class="form-control" required>
                                                    <label for="given_person_name">दिलेल्या व्यक्तीचे नाव <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="text" name="book_number" id="book_number" class="form-control" required readonly>
                                                    <label for="book_number">बुक नंबर <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="number" name="pavati_pasun" id="pavati_pasun" class="form-control" required min="1">
                                                    <label for="pavati_pasun">पावती पासून <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="number" name="pavati_paryant" id="pavati_paryant" class="form-control" required min="1" readonly>
                                                    <label for="pavati_paryant">पावती पर्यंत <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            
                                            <div class="col-12 text-center mt-3">
                                                <button type="submit" name="save" class="btn btn-primary px-4 me-2">
                                                    <i class="fas fa-save me-2"></i>साठवणे
                                                </button>
                                                <button type="reset" class="btn btn-outline-secondary px-4">
                                                    <i class="fas fa-times me-2"></i>रद्द करणे
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Data Tables -->
                        <div class="col-lg-12" id="nondani-table">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between align-items-center bg-primary text-white">
                                    <h6 class="m-0 font-weight-bold">पावती पुस्तक नोंदणी यादी</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
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
                                                if (mysqli_num_rows($records) > 0):
                                                ?>
                                                    <?php $i = 1;
                                                    while ($record = mysqli_fetch_assoc($records)): ?>
                                                        <tr>
                                                            <td><?= $i ?></td>
                                                            <td><?= date('d-m-Y', strtotime($record['buying_date'])) ?></td>
                                                            <td><?= $record['financial_year'] ?></td>
                                                            <td><?= $record['material_type'] ?></td>
                                                            <td><?= $record['total_number'] ?></td>
                                                            <td><?= $record['material_number'] ?></td>
                                                            <td>
                                                                <div class="btn-group btn-group-sm">
                                                                    <button class="btn btn-primary" onclick="fillFormData(
                                        '<?= $record['id'] ?>',
                                        '<?= $record['buying_date'] ?>',
                                        '<?= $record['material_type'] ?>',
                                        '<?= $record['material_number'] ?>',
                                        '<?= $record['total_number'] ?>'
                                    )">
                                                                        <i class="fas fa-edit"></i>
                                                                    </button>
                                                                    <a href="api/pavati_pustak.php?delete=<?= $record['id'] ?>"
                                                                        class="btn btn-danger"
                                                                        onclick="return confirm('तुम्हाला ही नोंद नक्की हटवायची आहे का?')">
                                                                        <i class="fas fa-trash"></i>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php $i++;
                                                    endwhile; ?>
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
                        </div>
                        
                        <div class="col-lg-12" id="vitaran-table" style="display: none;">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between align-items-center bg-primary text-white">
                                    <h6 class="m-0 font-weight-bold">पुस्तक वितरण यादी</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
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
                                                if (mysqli_num_rows($distributions) > 0):
                                                ?>
                                                    <?php $i = 1;
                                                    while ($record = mysqli_fetch_assoc($distributions)):
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
                                                                <div class="btn-group btn-group-sm">
                                                                    <button class="btn btn-primary" onclick="fillDistributionFormData(
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
                                                                        class="btn btn-danger"
                                                                        onclick="return confirm('तुम्हाला ही नोंद नक्की हटवायची आहे का?')">
                                                                        <i class="fas fa-trash"></i>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php $i++;
                                                    endwhile; ?>
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
            // When material or namuna number changes in vitaran form
            $('#material_number_pavati, #namuna_number').on('change', function() {
                var materialId = $('#material_number_pavati').val();
                var namunaNumber = $('#namuna_number').val();

                if (materialId && namunaNumber) {
                    generateBookNumber(materialId, namunaNumber, function(response) {
                        if (response.success) {
                            $('#book_number').val(response.next_book);

                            // Set max values for pavati inputs based on remaining receipts
                            // You might need to adjust this based on your requirements
                            $('#pavati_pasun').attr('max', response.total_books *
                                100); // Assuming 100 receipts per book
                            $('#pavati_paryant').attr('max', response.total_books * 100);
                        } else {
                            alert(response.message);
                            $('#book_number').val('');
                        }
                    });
                }
            });

            // Validate pavati numbers
            $('#pavati_pasun').on('change', function() {
                var start = parseInt($(this).val());
                var end = $('#pavati_paryant');
                var limit = $("#pavati_number").val();
                if (isNaN(start) || start < 1) {
                    alert('पावती संख्या 1 पेक्षा कमी असू शकत नाही');
                    $(this).val('');
                    return;
                }
                console.log(start, "Start Value");
                console.log(limit, "Limit Value");
                console.log(start + parseInt(limit) - 1, "Calculated End Value");
                var final_value = start + parseInt(limit) - 1;

                end.val(final_value);
                console.log(end.val(), "End Value");
            });

            $('#pavati_paryant').on('change', function() {
                var start = parseInt($('#pavati_pasun').val());
                var end = parseInt($(this).val());

                if (isNaN(end) || end < 1) {
                    alert('पावती संख्या 1 पेक्षा कमी असू शकत नाही');
                    $(this).val('');
                    return;
                }

                if (!isNaN(start) && end < start) {
                    alert('पावती संख्या पासूनच्या संख्येपेक्षा कमी असू शकत नाही');
                    $(this).val('');
                    return;
                }
            });

            // Auto-calculate pavati_paryant when pavati_number changes
            $('#pavati_number').on('change', function() {
                var start = parseInt($('#pavati_pasun').val());
                var count = parseInt($(this).val());

                if (!isNaN(start) && !isNaN(count) && count > 0) {
                    $('#pavati_paryant').val(start + count - 1);
                }
            });
        });

        function generateBookNumber(materialId, namunaNumber, callback) {
            $.ajax({
                url: 'api/generateBookNumber.php',
                type: 'POST',
                data: {
                    material_id: materialId,
                    namuna_number: namunaNumber
                },
                dataType: 'json',
                success: function(response) {
                    callback(response);
                },
                error: function() {
                    callback({
                        success: false,
                        message: 'Error generating book number'
                    });
                }
            });
        }
    </script>
</body>
</html>