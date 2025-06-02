<?php 
require_once './include/auth_middleware.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php 
$title = "बँक खाते टू बँक खाते भरणा";
?>
<?php include('include/header.php'); ?>
<?php
    $financialYears = $fun->getFinancialYears();
    $banks = $fun->getBanks();
    $checkbooks = $fun->getCheckBooks($_SESSION['district_code']);
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
                        <h1 class="h3 mb-0 text-gray-800">बँक खाते टू बँक खाते भरणा </h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">माहईग्राम</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 7</li>
                            <li class="breadcrumb-item active" aria-current="page">दैनंदिन कामकाज
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">बँक खाते टू बँक खाते भरणा</li>
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


                                <div class="card-body" id="vitaran-form">

                                    <form method="post" action="api/khate_transfer.php">
                                        <input type="hidden" name="bank_bharane_id" id="bank_bharane_id" value="">



                                        <!-- Main Form Fields -->
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="plan_name">योजनेचे नाव: <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-control" name="plan_name" id="plan_name" required>
                                                    <option value="">--निवडा--</option>
                                                    <option value="ग्रामनिधी">ग्रामनिधी</option>
                                                    <option value="ग्राम पाणीपुरवठा निधी">ग्राम पाणीपुरवठा निधी</option>
                                                </select>
                                            </div>
                                            <input type="hidden" name="financial_year" id="financial_year"
                                                class="form-control"
                                                value="<?php echo $yearArray[$currentYearIndex];  ?>" />
                                            <div class="form-group col-md-6">
                                                <label for="date"> दिनांक :<span class="text-danger">*</span></label>
                                                <input type="date" name="date" id="date" class="form-control"
                                                    value="<?= date('Y-m-d') ?>" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="bank_name">बँकेचे नाव <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-control mb-3" name="bank_name" id="bank_name"
                                                    required>
                                                    <option value=""> -- प्रथम योजना निवडा -- </option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="account_balance">खात्यातील शिल्लक रक्कम :</label>
                                                <input type="text" name="account_balance" id="account_balance"
                                                    class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="check_book_no">चेक बूक नंबर: <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-control" name="check_book_no" id="check_book_no"
                                                    required>
                                                    <option value="">--निवडा--</option>
                                                    <?php  
                                                            if(mysqli_num_rows($checkbooks) > 0){
                                                                while($row = mysqli_fetch_assoc($checkbooks)){
                                                                    echo "<option value='{$row['id']}'>{$row['checkbook_no']}</option>";
                                                                }
                                                            }
                                                        ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="new_date"> दिनांक :<span
                                                        class="text-danger">*</span></label>
                                                <input type="date" name="new_date" id="new_date" class="form-control"
                                                    value="<?= date('Y-m-d') ?>" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="check_no">चेक नंबर : <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="check_no" id="check_no" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="amount_to_pay">भरावयाची रक्कम :<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="amount_to_pay" id="amount_to_pay"
                                                    class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="bank_name2">बँकेचे नाव <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-control mb-3" name="bank_name_to_deposit"
                                                    id="bank_name2" required>
                                                    <option value=""> -- प्रथम योजना निवडा -- </option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="to_deposit_account_balance">खात्यातील शिल्लक रक्कम :</label>
                                                <input type="text" name="to_deposit_account_balance"
                                                    id="to_deposit_account_balance" class="form-control">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="payer_name">पैसे भरणाऱ्याचे नाव : <span
                                                        class="text-danger">*</span> </label>
                                                <input type="text" name="payer_name" id="payer_name"
                                                    class="form-control" required>
                                            </div>

                                        </div>

                                        <button type="submit" name="save" class="btn btn-primary">साठवणे</button>
                                        <button type="reset" class="btn btn-secondary">रद्द करणे</button>
                                    </form>
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
                                                <th>योजनेचे नाव</th>
                                                <th>दिनांक</th>
                                                <th>बँकेचे नाव (From)</th>
                                                <th>चेक बुक नंबर</th>
                                                <th>चेक नंबर</th>
                                                <th>रक्कम</th>
                                                <th>बँकेचे नाव (To)</th>
                                                <th>भरणाऱ्याचे नाव</th>
                                                <th>क्रिया</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                    $transfers = $fun->getBankToBankTransfers($_SESSION['district_code']);
                    if(mysqli_num_rows($transfers) > 0): 
                    ?>
                                            <?php $i = 1; while($record = mysqli_fetch_assoc($transfers)): ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= $record['plan_name'] ?></td>
                                                <td><?= date('d-m-Y', strtotime($record['date'])) ?></td>
                                                <td><?= $fun->getBankName($record['from_bank_id']) ?></td>
                                                <td><?= $record['check_book_no'] ?></td>
                                                <td><?= $record['check_no'] ?></td>
                                                <td><?= number_format($record['amount'], 2) ?></td>
                                                <td><?= $fun->getBankName($record['to_bank_id']) ?></td>
                                                <td><?= $record['payer_name'] ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-primary" onclick="fillBankTransferData(
                                    '<?= $record['id'] ?>',
                                    '<?= $record['plan_name'] ?>',
                                    '<?= $record['financial_year'] ?>',
                                    '<?= $record['date'] ?>',
                                    '<?= $record['from_bank_id'] ?>',
                                    '<?= $record['check_book_no'] ?>',
                                    '<?= $record['check_no'] ?>',
                                    '<?= $record['amount'] ?>',
                                    '<?= $record['to_bank_id'] ?>',
                                    '<?= $record['payer_name'] ?>'
                                )">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <a href="api/bank_bharane.php?delete=<?= $record['id'] ?>"
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
                                                <td colspan="10" class="text-center">नोंद सापडली नाही</td>
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
    // Function to load banks based on selected plan
    function loadBanksByPlan(planName, targetElement) {
        if (!planName) {
            $(targetElement).html('<option value="">-- निवडा --</option>').prop('disabled', true);
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
                    $(targetElement).html(options).prop('disabled', false);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching banks:", error);
                $(targetElement).html('<option value="">-- Error loading banks --</option>');
            }
        });
    }

    // Event listeners for plan selection changes
    $('#plan_name').change(function() {
        var selectedPlan = $(this).val();
        loadBanksByPlan(selectedPlan, '#bank_name');
        loadBanksByPlan(selectedPlan, '#bank_name2');
    });

    // Load account balance when from bank is selected
    $('#bank_name').change(function() {
        var selectedBank = $(this).val();
        var planName = $('#plan_name').val();

        if (!selectedBank || !planName) return;

        $.ajax({
            url: 'api/bank_bharane.php?getAccountBalance=1',
            type: 'GET',
            data: {
                plan_name: planName,
                selectedBank: selectedBank
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#account_balance').val(response.data.bank_balance);
                    $('#balance_inhand').val(response.data.hand_balance);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching account balance:", error);
            }
        });
    });

    // Load account balance when to bank is selected
    $('#bank_name2').change(function() {
        var selectedBank = $(this).val();
        var planName = $('#plan_name').val();

        if (!selectedBank || !planName) return;

        $.ajax({
            url: 'api/bank_bharane.php?getAccountBalance=1',
            type: 'GET',
            data: {
                plan_name: planName,
                selectedBank: selectedBank
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#to_deposit_account_balance').val(response.data.bank_balance);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching account balance:", error);
            }
        });
    });

    // Fill form with existing data
    function fillBankTransferData(id, planName, financialYear, date, fromBankId, checkBookNo,
        checkNo, amount, toBankId, payerName) {
        // Set ID
        $('#bank_bharane_id').val(id);

        // First set the plan name and load banks
        $('#plan_name').val(planName).trigger('change');

        // After a small delay (to allow banks to load), set the banks
        setTimeout(function() {
            $('#bank_name').val(fromBankId);
            $('#bank_name2').val(toBankId);
        }, 300);

        // Fill other form fields
        $('#financial_year').val(financialYear);
        $('#date').val(date);
        $('#check_book_no').val(checkBookNo);
        $('#check_no').val(checkNo);
        $('#amount_to_pay').val(amount);
        $('#payer_name').val(payerName);

        // Change button text
        $('button[name="save"]').text('अपडेट करा');

        // Scroll to form
        $('html, body').animate({
            scrollTop: $('#plan_name').offset().top
        }, 500);
    }

    // Reset form when cancel button is clicked
    $('button[type="reset"]').click(function() {
        $('#bank_bharane_id').val('');
        $('#bank_name, #bank_name2').html('<option value="">-- प्रथम योजना निवडा --</option>').prop('disabled',
            true);
        $('button[name="save"]').text('साठवणे');
        $('#date, #new_date').val('<?= date('Y-m-d') ?>');
    });

    // Initialize form
    $(document).ready(function() {
        $('#bank_name, #bank_name2').prop('disabled', true);
        $('#account_balance, #balance_inhand, #to_deposit_account_balance').prop('disabled', true);
    });
    </script>

</body>

</html>