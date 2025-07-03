<?php
require_once './include/auth_middleware.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php
$title = "वर्षाच्या सुरवातीची शिल्लक";
?>
<?php include('include/header.php'); ?>
<?php
$balances = $fun->getYearStartBalances($_SESSION['district_code']);
$financialYears = $fun->getFinancialYears();
$banks = $fun->getBanks();
$periodsWithReasons = $fun->getPeriodTotalPeriodsWithPeriodReason("नमुना नंबर 8 कालावधी", $_SESSION['district_code']);
$yearArray = $fun->getYearArray($periodsWithReasons);
// print_r($periodsWithReasons);
?>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php
        $page = 'namuna7';
        $subpage = 'master';
        
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
                        <h1 class="h3 mb-0 text-gray-800">वर्षाच्या सुरवातीची शिल्लक</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">पंचायत पोर्टल</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 7</li>
                            <li class="breadcrumb-item active" aria-current="page">मास्टर्स</li>
                            <li class="breadcrumb-item active" aria-current="page">वर्षाच्या सुरवातीची शिल्लक</li>
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
                                    <form method="post" action="api/year_start_balance.php">
                                        <input type="hidden" name="balance_id" id="balance_id" value="">

                                        <!-- Balance Type Selection -->
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="balance_type1" name="balance_type"
                                                        value="हात शिल्लक" class="custom-control-input" required>
                                                    <label class="custom-control-label" for="balance_type1">हात
                                                        शिल्लक</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="balance_type2" name="balance_type"
                                                        value="बँक शिल्लक" class="custom-control-input">
                                                    <label class="custom-control-label" for="balance_type2">बँक
                                                        शिल्लक</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="balance_type3" name="balance_type"
                                                        value="पोस्ट शिल्लक" class="custom-control-input">
                                                    <label class="custom-control-label" for="balance_type3">पोस्ट
                                                        शिल्लक</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="balance_type4" name="balance_type"
                                                        value="ठेवी" class="custom-control-input">
                                                    <label class="custom-control-label" for="balance_type4">ठेवी</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Main Form Fields -->
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <label for="financial_year">आर्थिक वर्ष <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-control" name="financial_year" id="financial_year"
                                                    required>
                                                    <option value="">--निवडा--</option>
                                                    <?php foreach ($yearArray as $year): ?>
                                                        <option value="<?= $year ?>"><?= $year ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="plan_name">फंडाचे नाव : <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-control" name="plan_name" id="plan_name" required>
                                                    <option value="">--निवडा--</option>
                                                    <option value="ग्रामनिधी">ग्रामनिधी</option>
                                                    <option value="ग्राम पाणीपुरवठा निधी">ग्राम पाणीपुरवठा निधी</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-6 bank-fields" style="display:none;">
                                                <label for="bank_id">बँकेचे नाव</label>
                                                <select class="form-control" name="bank_id" id="bank_id">
                                                    <option value="">--निवडा--</option>
                                                    <?php foreach ($banks['data'] as $bank): ?>
                                                        <option value="<?= $bank['id'] ?>"><?= $bank['bank_name'] ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-6 post-fields" style="display:none;">
                                                <label for="post_name">पोस्टाचे नाव</label>
                                                <input type="text" class="form-control" name="post_name" id="post_name"
                                                    placeholder="पोस्टाचे नाव">
                                            </div>

                                            <div class="form-group col-md-6 post-fields" style="display:none;">
                                                <label for="post_branch">पोस्टाची शाखा</label>
                                                <input type="text" class="form-control" name="post_branch"
                                                    id="post_branch" placeholder="पोस्टाची शाखा">
                                            </div>

                                            <div class="form-group col-md-6 post-fields" style="display:none;">
                                                <label for="account_no">खाते क्रमांक</label>
                                                <input type="text" class="form-control" name="account_no"
                                                    id="account_no" placeholder="खाते क्रमांक">
                                            </div>

                                            <div class="form-group col-md-6 post-fields" style="display:none;">
                                                <label for="ifsc_code">IFSC कोड</label>
                                                <input type="text" class="form-control" name="ifsc_code" id="ifsc_code"
                                                    placeholder="IFSC कोड">
                                            </div>
                                            <div class="form-group col-md-6" id="theve_yojana" style="display:none;">
                                                <label for="theve_yojana_name">ठेव योजनेचे नाव:</label>
                                                <input type="text" class="form-control" name="theve_yojana_name"
                                                    id="theve_yojana_name" placeholder="ठेव योजनेचे नाव">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="amount">शिल्लक रक्कम (₹) <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" step="0.01" name="amount" id="amount"
                                                    class="form-control" placeholder="शिल्लक रक्कम" required>
                                            </div>
                                        </div>

                                        <button type="submit" name="save" class="btn btn-primary">साठवणे</button>
                                        <button type="reset" class="btn btn-secondary">रद्द करणे</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Data Table -->
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="table-responsive">
                                    <table class="table align-items-center table-flush">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>अ.क्र.</th>
                                                <th>फंडाचे नाव</th>
                                                <th>आर्थिक वर्ष</th>
                                                <th>हात शिल्लक /बँक शिल्लक</th>
                                                <th>शिल्लक रक्कम</th>
                                                <th>बँकेचे नाव</th>
                                                <th>पोस्टाचे नाव</th>
                                                <th>ठेव योजनेचे नाव</th>
                                                <th>क्रिया</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (mysqli_num_rows($balances) > 0): ?>
                                                <?php $i = 1;
                                                while ($balance = mysqli_fetch_assoc($balances)): ?>
                                                    <tr>
                                                        <td><?= $i ?></td>
                                                        <td><?= $balance['plan_name'] ?></td>
                                                        <td><?= $balance['financial_year'] ?></td>
                                                        <td><?= $balance['balance_type'] ?></td>
                                                        <td>₹<?= number_format($balance['amount'], 2) ?></td>
                                                        <td> <?= $fun->getBankName($balance['bank_id']) == "" ? "-" : $fun->getBankName($balance['bank_id']) ?>
                                                        </td>
                                                        <td>

                                                            <?= $balance['post_name'] == "" ? "-" : $balance['post_name'] ?>

                                                        </td>
                                                        <td><?= $balance['thev_yojana_name'] == "" ? "-" : $balance['thev_yojana_name'] ?>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button class="btn btn-sm btn-primary" onclick="fillBalanceData(
                                                                    '<?= $balance['id'] ?>',
                                                                    '<?= $balance['balance_type'] ?>',
                                                                    '<?= $balance['financial_year'] ?>',
                                                                    '<?= $balance['plan_name'] ?>',
                                                                    '<?= $balance['bank_id'] ?>',
                                                                    '<?= $balance['post_name'] ?>',
                                                                    '<?= $balance['post_branch'] ?>',
                                                                    '<?= $balance['account_no'] ?>',
                                                                    '<?= $balance['ifsc_code'] ?>',
                                                                    '<?= $balance['amount'] ?>'
                                                                )">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                                <a href="api/year_start_balance.php?delete=<?= $balance['id'] ?>"
                                                                    class="btn btn-sm btn-danger"
                                                                    onclick="return confirm('तुम्हाला ही शिल्लक माहिती नक्की हटवायची आहे का?')">
                                                                    <i class="fas fa-trash"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php $i++; endwhile; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="8" class="text-center">शिल्लक माहिती सापडली नाही</td>
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
        // Show/hide fields based on balance type selection
        $('input[name="balance_type"]').change(function () {
            $('.bank-fields, .post-fields').hide();
            $('.bank-fields select, .post-fields input').removeAttr('required');
            $('#theve_yojana').hide();
            if ($(this).val() === 'हात शिल्लक') {
                $('.bank-fields, .post-fields').hide();
                $('.bank-fields select, .post-fields input').removeAttr('required');
                $('#theve_yojana').hide();

            } else if ($(this).val() === 'बँक शिल्लक') {
                $('.bank-fields').show();
                $('.bank-fields select').attr('required', 'required');
                $('#theve_yojana').hide();

            } else if ($(this).val() === 'पोस्ट शिल्लक') {
                $('.post-fields').show();
                $('.post-fields input').attr('required', 'required');
                $('#theve_yojana').hide();

            } else if ($(this).val() === 'ठेवी') {
                $('#theve_yojana').show();
                $('#theve_yojana input').attr('required', 'required');
            } else {
                $('#theve_yojana').hide();
            }
        });

        // Fill form with existing balance data
        function fillBalanceData(id, balanceType, financialYear, planName, bankId, postName, postBranch, accountNo,
            ifscCode, amount) {
            // Set ID
            $('#balance_id').val(id);

            // Set basic fields
            $(`input[name="balance_type"][value="${balanceType}"]`).prop('checked', true).trigger('change');
            $('#financial_year').val(financialYear);
            $('#plan_name').val(planName);
            $('#amount').val(amount);

            // Set bank/post fields based on type
            if (bankId) $('#bank_id').val(bankId);
            if (postName) $('#post_name').val(postName);
            if (postBranch) $('#post_branch').val(postBranch);

            // Set common fields
            $('#account_no').val(accountNo);
            $('#ifsc_code').val(ifscCode);

            // Change button text
            $('button[name="save"]').text('अपडेट करा');

            // Scroll to form
            $('html, body').animate({
                scrollTop: $('form').offset().top
            }, 500);
        }

        // Reset form when cancel button is clicked
        $('button[type="reset"]').click(function () {
            $('#balance_id').val('');
            $('button[name="save"]').text('साठवणे');
            $('.bank-fields, .post-fields').hide();
            $('input[name="balance_type"]').prop('checked', false);
        });

        // Also reset when form is successfully submitted
        <?php if (isset($_SESSION['message']) && $_SESSION['message_type'] == 'success'): ?>
            $('#balance_id').val('');
            $('button[name="save"]').text('साठवणे');
            $('.bank-fields, .post-fields').hide();
            $('input[name="balance_type"]').prop('checked', false);
        <?php endif; ?>
    </script>
</body>

</html>