<?php 
require_once './include/auth_middleware.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php 
$title = "बँक भरणा";
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
                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">बँक भरणा </h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">पंचायत पोर्टल</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 7</li>
                            <li class="breadcrumb-item active" aria-current="page">दैनंदिन कामकाज</li>
                            <li class="breadcrumb-item active" aria-current="page">बँक भरणा</li>
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

                                    <form method="post" action="api/bank_bharane.php">
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
                                                <label for="payer_name">पैसे भरणाऱ्याचे नाव : <span
                                                        class="text-danger">*</span> </label>
                                                <input type="text" name="payer_name" id="payer_name"
                                                    class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="account_balance">खात्यातील शिल्लक रक्कम :</label>
                                                <input type="text" name="account_balance" id="account_balance"
                                                    class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="balance_inhand">हात शिल्लक :</label>
                                                <input type="text" name="balance_inhand" id="balance_inhand"
                                                    class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="amount_to_pay">भरावयाची रक्कम :<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="amount_to_pay" id="amount_to_pay"
                                                    class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="total_amount">एकूण रक्कम :</label>
                                                <input type="text" name="total_amount" id="total_amount"
                                                    class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="shera">शेरा:<span class="text-danger">*</span></label>
                                                <input type="text" name="shera" id="shera" class="form-control"
                                                    required>
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
                                                <th>फंडाचे नाव</th>
                                                <th>दिनांक</th>
                                                <th>बॅंकेचे नाव</th>
                                                <th>जमा रक्कम</th>
                                                <th>भरणा-याचे नाव</th>
                                                <th>शेरा</th>
                                                <th>क्रिया</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                    $records = $fun->getBankBharane($_SESSION['district_code']);
                    if(mysqli_num_rows($records) > 0): 
                    ?>
                                            <?php $i = 1; while($record = mysqli_fetch_assoc($records)): ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= $record['plan_name'] ?></td>
                                                <td><?= date('d-m-Y', strtotime($record['date'])) ?></td>
                                                <td><?= $fun->getBankName($record['bank_id']) ?></td>
                                                <td><?= number_format($record['amount_to_pay'], 2) ?></td>
                                                <td><?= $record['payer_name'] ?></td>
                                                <td><?= $record['shera'] ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-primary" onclick="fillBankBharaneData(
                                    '<?= $record['id'] ?>',
                                    '<?= $record['plan_name'] ?>',
                                    '<?= $record['financial_year'] ?>',
                                    '<?= $record['date'] ?>',
                                    '<?= $record['bank_id'] ?>',
                                    '<?= $record['payer_name'] ?>',
                                    '<?= $record['account_balance'] ?>',
                                    '<?= $record['balance_inhand'] ?>',
                                    '<?= $record['amount_to_pay'] ?>',
                                    '<?= $record['total_amount'] ?>',
                                    '<?= $record['shera'] ?>'
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
                                                <td colspan="8" class="text-center">नोंद सापडली नाही</td>
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
    $('#bank_name').change(function() {
        var selectedBank = $(this).val();
        var planName = $('#plan_name').val();


        // Load account balance and other data if needed
        // Example: You can make an AJAX call to fetch account balance based on selected bank
        $.ajax({
            url: 'api/bank_bharane.php?getAccountBalance=1',
            type: 'GET',
            data: {
                plan_name: planName,
                selectedBank: selectedBank
            },
            dataType: 'json',
            success: function(response) {
                console.log("Response from server:");

                console.log(response);

                if (response.success) {
                    console.log("Account balance data loaded successfully");

                    $('#account_balance').val(response.data.bank_balance);
                    $('#balance_inhand').val(response.data.hand_balance);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching banks:", error);
                $('#bank_name').html('<option value="">-- Error loading banks --</option>');
            }
        });
    });

    // Calculate total amount automatically
    $('#amount_to_pay, #account_balance, #balance_inhand').on('input', function() {
        var amountToPay = parseFloat($('#amount_to_pay').val()) || 0;
        var accountBalance = parseFloat($('#account_balance').val()) || 0;
        var balanceInhand = parseFloat($('#balance_inhand').val()) || 0;

        var totalAmount = accountBalance + balanceInhand + amountToPay;
        $('#total_amount').val(totalAmount.toFixed(2));
    });

    // Fill form with existing data
    function fillBankBharaneData(id, planName, financialYear, date, bankId, payerName,
        accountBalance, balanceInhand, amountToPay, totalAmount, shera) {
        // Set ID
        $('#bank_bharane_id').val(id);

        // First set the plan name and load banks
        $('#plan_name').val(planName).trigger('change');

        // After a small delay (to allow banks to load), set the bank
        setTimeout(function() {
            $('#bank_name').val(bankId);
        }, 300);

        // Fill other form fields
        $('#financial_year').val(financialYear);
        $('#date').val(date);
        $('#payer_name').val(payerName);
        $('#account_balance').val(accountBalance);
        $('#balance_inhand').val(balanceInhand);
        $('#amount_to_pay').val(amountToPay);
        $('#total_amount').val(totalAmount);
        $('#shera').val(shera);

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
        $('#bank_name').html('<option value="">-- प्रथम योजना निवडा --</option>').prop('disabled', true);
        $('button[name="save"]').text('साठवणे');
        $('#date').val('<?= date('Y-m-d') ?>');
    });

    // Initialize form
    $(document).ready(function() {
        $('#bank_name').prop('disabled', true);
    });
    </script>
</body>

</html>