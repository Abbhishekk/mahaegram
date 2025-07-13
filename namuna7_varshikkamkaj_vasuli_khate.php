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
        $page = 'namuna7';
        $subpage = 'yearlyWork';
        
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
                        <h1 class="h3 mb-0 text-gray-800">वसूल खाते ठरवणे</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">पंचायत पोर्टल</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक ७</li>
                            <li class="breadcrumb-item active" aria-current="page">वार्षिक कामकाज</li>
                            <li class="breadcrumb-item active" aria-current="page">वसूल खाते ठरवणे</li>
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
                        <label class="form-check-label h5 mb-0" for="nondani">
                            <!--Write Your text here-->
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <form method="post" action="api/vasul_khate.php" class="needs-validation" novalidate>
                    <input type="hidden" name="balance_id" id="balance_id" value="">
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" name="tax_type" id="tax_type" required>
                                    <option value="">--निवडा--</option>
                                    <option value="निवासी इमारती वरीत मालमत्ता कर">निवासी इमारती वरीत मालमत्ता कर</option>
                                    <option value="आरोग्य कर">आरोग्य कर</option>
                                    <option value="दिवाबत्ती कर">दिवाबत्ती कर</option>
                                    <option value="सामान्य पाणीपट्टी">सामान्य पाणीपट्टी</option>
                                    <option value="खुल्या जागेवरील कर / पडसर">खुल्या जागेवरील कर / पडसर</option>
                                    <option value="दंड रक्कम">दंड रक्कम</option>
                                    <option value="सूट">सूट</option>
                                </select>
                                <label for="tax_type">कर प्रकार <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" name="account_name" id="account_name" required>
                                    <option value="">--निवडा--</option>
                                    <option value="मालमत्ता कर, जमिनी व इमारती यावरील कर">मालमत्ता कर, जमिनी व इमारती यावरील कर</option>
                                    <option value="दिवाबत्ती कर">दिवाबत्ती कर</option>
                                    <option value="स्वच्छता / आरोग्य कर">स्वच्छता / आरोग्य कर</option>
                                    <option value="सेवा कर">सेवा कर</option>
                                    <option value="इतर कर (सुट एक (अ) कर)">इतर कर (सुट एक (अ) कर)</option>
                                    <option value="पाणीपट्टी">पाणीपट्टी</option>
                                    <option value="दंड">दंड</option>
                                </select>
                                <label for="account_name">खाते नाव: <span class="text-danger">*</span></label>
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

    <!-- Data Table -->
    <div class="col-lg-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                     <div class="card-header py-3 bg-primary text-white">
                <div class="d-flex justify-content-center">
                    <div class="form-check form-check-inline mx-4">
                        <label class="form-check-label h5 mb-0" for="nondani">
                            <!--Write Your text here-->
                        </label>
                    </div>
                </div>
            </div>
                    <table class="table table-bordered table-hover">
                        <thead class="table-primary">
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
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-primary" onclick="fillFormData(
                                                '<?= $record['id'] ?>',
                                                '<?= $record['tax_type'] ?>',
                                                '<?= $record['account_name'] ?>'
                                            )">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <a href="api/vasul_khate.php?delete=<?= $record['id'] ?>"
                                                class="btn btn-danger"
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