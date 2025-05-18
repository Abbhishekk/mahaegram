<?php 
require_once './include/auth_middleware.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php 
$title = "वसूल खाते ठरवणे";
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
                        <h1 class="h3 mb-0 text-gray-800">वसूल खाते ठरवणे</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">माहईग्राम</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 10</li>
                            <li class="breadcrumb-item active" aria-current="page">मास्टर्स</li>
                            <li class="breadcrumb-item active" aria-current="page">वसूल खाते ठरवणे</li>
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
                                    <form method="post" action="api/vasul_khate.php">
                                        <input type="hidden" name="balance_id" id="balance_id" value="">



                                        <!-- Main Form Fields -->
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <label for="tax_type">कर प्रकार<span
                                                        class="text-danger">*</span></label>
                                                <select class="form-control" name="tax_type" id="tax_type" required>
                                                    <option value="">--निवडा--</option>
                                                    <option value="निवासी इमारती वरीत मालमत्ता कर">निवासी इमारती वरीत
                                                        मालमत्ता कर</option>
                                                    <option value="आरोग्य कर">आरोग्य कर</option>
                                                    <option value="दिवाबत्ती कर">दिवाबत्ती कर</option>
                                                    <option value="सामान्य पाणीपट्टी">सामान्य पाणीपट्टी</option>
                                                    <option value="खुल्या जागेवरील कर / पडसर">खुल्या जागेवरील कर / पडसर
                                                    </option>
                                                    <option value="दंड रक्कम">दंड रक्कम</option>
                                                    <option value="सूट">सूट</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="account_name">खाते नाव: <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-control" name="account_name" id="account_name"
                                                    required>
                                                    <option value="">--निवडा--</option>
                                                    <option value="मालमत्ता कर, जमिनी व इमारती यावरील कर">मालमत्ता कर,
                                                        जमिनी व इमारती यावरील कर</option>
                                                    <option value="दिवाबत्ती कर">दिवाबत्ती कर</option>
                                                    <option value="स्वच्छता / आरोग्य कर">स्वच्छता / आरोग्य कर</option>
                                                    <option value="सेवा कर">सेवा कर</option>
                                                    <option value="इतर कर (सुट एक (अ) कर)">इतर कर (सुट एक (अ) कर)
                                                    </option>
                                                    <option value="पाणीपट्टी">पाणीपट्टी</option>
                                                    <option value="दंड">दंड</option>
                                                </select>
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
                                                <th>कर प्रकार</th>
                                                <th>खाते नाव</th>
                                                <th>क्रिया</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                    $vasulKhate = $fun->getVasulKhate($_SESSION['district_code']);
                    if(mysqli_num_rows($vasulKhate) > 0): 
                    ?>
                                            <?php $i = 1; while($record = mysqli_fetch_assoc($vasulKhate)): ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= $record['tax_type'] ?></td>
                                                <td><?= $record['account_name'] ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-primary" onclick="fillFormData(
                                    '<?= $record['id'] ?>',
                                    '<?= $record['tax_type'] ?>',
                                    '<?= $record['account_name'] ?>'
                                )">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <a href="api/vasul_khate.php?delete=<?= $record['id'] ?>"
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
                                                <td colspan="4" class="text-center">नोंद सापडली नाही</td>
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
    // Fill form with existing data
    function fillFormData(id, taxType, accountName) {
        // Set ID
        $('#balance_id').val(id);

        // Set form fields
        $('#tax_type').val(taxType);
        $('#account_name').val(accountName);

        // Change button text
        $('button[name="save"]').text('अपडेट करा');

        // Scroll to form
        $('html, body').animate({
            scrollTop: $('form').offset().top
        }, 500);
    }

    // Reset form when cancel button is clicked
    $('button[type="reset"]').click(function() {
        $('#balance_id').val('');
        $('button[name="save"]').text('साठवणे');
    });

    // Also reset when form is successfully submitted
    <?php if (isset($_SESSION['message']) && $_SESSION['message_type'] == 'success'): ?>
    $('#balance_id').val('');
    $('button[name="save"]').text('साठवणे');
    <?php endif; ?>
    </script>
</body>

</html>