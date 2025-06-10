<?php
require_once './include/auth_middleware.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php
$title = "जमा पावती";
?>
<?php include('include/header.php'); ?>
<?php
$financialYears = $fun->getFinancialYears();
$banks = $fun->getBanks();
$banks2 = $fun->getBanks();
$materials = $fun->getMaterials($_SESSION['district_code']);
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
        $page = 'namuna7';
        $subpage = 'dainandin';
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
                        <h1 class="h3 mb-0 text-gray-800">जमा पावती </h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">माहईग्राम</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 7</li>
                            <li class="breadcrumb-item active" aria-current="page">दैनंदिन कामकाज</li>
                            <li class="breadcrumb-item active" aria-current="page">जमा पावती</li>
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


                                <div class="card-body">
                                    <form id="jamaForm">
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="plan_name">फंडाचे नाव : <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-control" name="plan_name" id="plan_name" required>
                                                    <option value="">--निवडा--</option>
                                                    <option value="ग्रामनिधी">ग्रामनिधी</option>
                                                    <option value="ग्राम पाणीपुरवठा निधी">ग्राम पाणीपुरवठा निधी</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="deposit_date">जमा दिनांक <span>*</span></label>
                                                <input type="date" class="form-control" name="deposit_date" id="deposit_date" required>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="deposit_type">जमा प्रकार <span>*</span></label>
                                                <select class="form-control" name="deposit_type" id="deposit_type">
                                                    <option value="other">इतर</option>
                                                    <option value="deposit">अनामत</option>
                                                    <option value="loan">कर्ज</option>
                                                </select>
                                            </div>


                                            <div class="form-group col-md-6">
                                                <label for="bank_name">बँकेचे नाव <span class="text-danger">*</span></label>
                                                <select class="form-control mb-3" name="bank_name" id="bank_name" required>
                                                    <option value=""> -- प्रथम योजना निवडा -- </option>
                                                    <?php foreach ($banks2["data"] as $bank) : ?>
                                                        <option value="<?php echo $bank['id']; ?>"><?php echo $bank['bank_name']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="vasul_type">वसूल प्रकार : <span>*</span></label>
                                                <select class="form-control" name="vasul_type" id="vasul_type">
                                                    <option value="other">इतर</option>
                                                    <option value="deposit">अनामत</option>
                                                    <option value="loan">कर्ज</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 my-2">
                                                <label class="form-label" for="pustak_kramanak">पुस्तक क्रमांक: <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-control" name="pustak_kramanak" id="pustak_kramanak" required>
                                                    <option value="">--निवडा--</option>
                                                    <!-- Will be populated by JavaScript -->
                                                </select>
                                            </div>
                                            <div class="col-md-3 my-2">
                                                <label class="form-label" for="pavati_kramanak">पावती क्रमांक:</label>
                                                <select class="form-control" name="pavati_kramanak" id="pavati_kramanak" required>
                                                    <option value="">--प्रथम पुस्तक निवडा--</option>
                                                </select>
                                                <small id="pavati-feedback" class="form-text"></small>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="kacchi_pavasti_pustak">कच्ची पावती पुस्तक <span>*</span></label>
                                                <input type="text" class="form-control" name="kacchi_pavasti_pustak" readonly id="kacchi_pavasti_pustak">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="kacchi_pavati_kramank">कच्ची पावती क्रमांक <span>*</span></label>
                                                <input type="text" name="kacchi_pavati_kramank" id="kacchi_pavati_kramank" readonly class="form-control">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="jama_karyana">जमा करणाऱ्यांचे नाव :<span>*</span></label>
                                                <input type="text" class="form-control" name="jama_karyana" id="jama_karyana" required>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="jama_rakkam">जमा रक्कम : <span>*</span></label>
                                                <input type="number" class="form-control" name="jama_rakkam" id="jama_rakkam" required>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="check_bank_name">चेक जमा बॅंकेचे नाव</label>
                                                <select class="form-control mb-3" name="check_bank_name" id="check_bank_name" required>
                                                    <option value=""> -- निवडा -- </option>
                                                    <?php foreach ($banks["data"] as $bank) : ?>
                                                        <option value="<?php echo $bank['id']; ?>"><?php echo $bank['bank_name']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="check_date">चेक दिनांक</label>
                                                <input type="date" name="check_date" id="check_date" class="form-control">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>बॅंकेचे नाव</label>
                                                <input type="text" name="bank_name" id="bank_name" class="form-control">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="check_number">चेक नं :</label>
                                                <input type="text" name="check_number" id="check_number" class="form-control">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="neft_rtgs_ref_1">NEFT/RTGS REF 1</label>
                                                <input type="text" class="form-control" name="neft_rtgs_ref_1" id="neft_rtgs_ref_1">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="neft_rtgs_ref_2">NEFT/RTGS REF 2</label>
                                                <input type="text" class="form-control" name="neft_rtgs_ref_2" id="neft_rtgs_ref_2">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">साठवणे</button>
                                        <button type="reset" class="btn btn-secondary">रद्द करणे</button>
                                    </form>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-12" id="vitaran-table">
                            <div class="card mt-4">
                                <div class="card-body table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>अ.क्र.</th>
                                                <th>जमा करण्याचे नाव</th>
                                                <th>जमा रक्सम</th>
                                                <th>जमा दिनांक</th>
                                                <th>पुस्तक क्रमांक</th>
                                                <th>फंडेचे नाव</th>
                                                <th>खाते नाव</th>
                                                <th>बान पावती</th>
                                                <th>चेक दिनांक</th>
                                                <th>चेक नं.</th>
                                                <th>बॅंके नाव</th>
                                                <th>पावती</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="12" class="text-center">No records to display.</td>
                                            </tr>
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
        // Function to load banks based on selected plan
        function loadBanksByPlan(planName) {
            if (!planName) {
                $('#bank_name').html('<option value="">-- निवडा --</option>').prop('disabled', true);
                return;
            }

            $.ajax({
                url: 'api/bank_bharane.php?getBanksByPlan=1',
                type: 'GET',
                data: {
                    plan_name: planName
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        var options = '<option value="">-- निवडा --</option>';
                        $.each(response.data, function(index, bank) {
                            options += '<option value="' + bank.id + '">' + bank.bank_name +
                                '</option>';
                        });
                        $('#bank_name').html(options).prop('disabled', false);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching banks:", error);
                    $('#bank_name').html('<option value="">-- Error loading banks --</option>');
                }
            });
        }

        $('#account_balance').prop('disabled', true);
        $('#balance_inhand').prop('disabled', true);
        $('#total_amount').prop('disabled', true);
        // Event listener for plan selection change
        $('#plan_name').change(function() {
            var selectedPlan = $(this).val();
            loadBanksByPlan(selectedPlan);
        });

        $(document).ready(function() {
            function populateBookReceiptDropdowns() {
                $.ajax({
                    url: 'api/get_book_receipt_numbers.php?namuna_number=7',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data.success) {
                            // Populate pustak_kramanak (x values)
                            $('#pustak_kramanak').empty();
                            $('#pustak_kramanak').append('<option value="">--निवडा--</option>');
                            data.books.forEach(function(book) {
                                $('#pustak_kramanak').append('<option value="' + book + '">' +
                                    book + '</option>');
                            });
                            const pavati_total = parseInt(data.pavatiNumber);
                            // When pustak_kramanak changes, populate pavati_kramanak (y values)
                            $('#pustak_kramanak').change(function() {
                                var selectedX = $(this).val();
                                $('#pavati_kramanak').empty();
                                $('#pavati_kramanak').append(
                                    '<option value="">--निवडा--</option>');


                                for (let y = 1; y <= pavati_total; y++) {
                                    $('#pavati_kramanak').append('<option value="' + y +
                                        '">' + y + '</option>');
                                }

                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error: " + status + " - " + error);
                    }
                });
            }

            // Call the function on page load
            populateBookReceiptDropdowns();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#jamaForm').submit(function(e) {
                e.preventDefault();

                // Collect form data
                var formData = {
                    plan_name: $('#plan_name').val(),
                    deposit_date: $('#deposit_date').val(),
                    deposit_type: $('#deposit_type').val(),
                    bank_name: $('#bank_name').val(),
                    vasul_type: $('#vasul_type').val(),
                    pustak_kramanak: $('#pustak_kramanak').val(),
                    pavati_kramanak: $('#pavati_kramanak').val(),
                    kacchi_pavasti_pustak: $('#kacchi_pavasti_pustak').val(),
                    kacchi_pavati_kramank: $('#kacchi_pavati_kramank').val(),
                    jama_karyana: $('#jama_karyana').val(),
                    jama_rakkam: $('#jama_rakkam').val(),
                    check_bank_name: $('#check_bank_name').val(),
                    check_date: $('#check_date').val(),
                    check_bank_name_text: $('#check_bank_name option:selected').text(),
                    check_number: $('#check_number').val(),
                    neft_rtgs_ref_1: $('#neft_rtgs_ref_1').val(),
                    neft_rtgs_ref_2: $('#neft_rtgs_ref_2').val()
                };

                // Submit via AJAX
                $.ajax({
                    url: 'api/jama_pavati_api.php',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(formData),
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            $('#jamaForm')[0].reset();
                            // Optionally refresh the table
                            loadJamaPavatiRecords();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('त्रुटी: ' + error);
                    }
                });
            });

            // Function to load records in the table
            function loadJamaPavatiRecords() {
                $.ajax({
                    url: 'api/jama_pavati_api.php?get_records=1',
                    type: 'GET',
                    data: {
                        panchayat_code: '<?php echo $_SESSION["panchayat_code"]; ?>'
                    },
                    success: function(response) {
                        if (response.success) {
                            var tbody = $('#vitaran-table tbody');
                            tbody.empty();

                            if (response.data.length > 0) {
                                $.each(response.data, function(index, record) {
                                    var row = `<tr>
                                <td>${index + 1}</td>
                                <td>${record.jama_karyana}</td>
                                <td>${record.jama_rakkam}</td>
                                <td>${record.deposit_date}</td>
                                <td>${record.pustak_kramanak}</td>
                                <td>${record.bank_name}</td>
                                <td>${record.account_name}</td>
                                <td>${record.pavati_kramanak}</td>
                                <td>${record.check_date || ''}</td>
                                <td>${record.check_number || ''}</td>
                                <td>${record.check_bank_name || ''}</td>
                                <td><button class="btn btn-sm btn-primary print-receipt" data-id="${record.id}">पावती</button></td>
                            </tr>`;
                                    tbody.append(row);
                                });
                            } else {
                                tbody.append('<tr><td colspan="12" class="text-center">No records to display.</td></tr>');
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading records:', error);
                    }
                });
            }

            // Load records on page load
            loadJamaPavatiRecords();
        });
    </script>
</body>

</html>