<?php 
    require_once './include/auth_middleware.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php 
$title = "बँकांची माहिती";
?>
<?php include('include/header.php'); ?>
<?php
    $banks = $fun->getBanks();

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
                <div class="container-fluid border rounded p-3" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">बँकांची माहिती</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">पंचायत पोर्टल</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक ७</li>
                            <li class="breadcrumb-item active" aria-current="page">मास्टर्स</li>
                            <li class="breadcrumb-item active" aria-current="page">बँकांची माहिती</li>
                        </ol>
                    </div>

                   <div class="row mb-3">
    <div class="col-lg-12">
        <div class="card mb-4 shadow-sm">
            <?php
            if (isset($_SESSION['message'])) {
                $message = $_SESSION['message'];
                $message_type = $_SESSION['message_type'];
                echo "<div class='alert alert-$message_type text-center'>$message</div>";
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
            }
            ?>
             <div class="card-header py-3 bg-primary text-white">
                <div class="d-flex justify-content-center">
                    <div class="form-check form-check-inline mx-4">
                        <label class="form-check-label h5 mb-0" for="nondani">
                            टीप-आपण एका योजने अंतर्गत ५ बँकेचे नाव प्रविष्ठ करू शकता
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <!--<h5 class="text-center mb-4 font-weight-bold text-primary">टीप-आपण एका योजने अंतर्गत ५ बँकेचे नाव प्रविष्ठ करू शकता</h5>-->
                
                <form method="post" action="api/bank.php" class="needs-validation" novalidate>
                    <input type="hidden" name="bank_id" id="bank_id" value="">
                    
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="form-floating">
                                <select class="form-select" name="plan_name" id="plan_name" required>
                                    <option value="">-- निवडा --</option>
                                    <option value="ग्रामनिधी">ग्रामनिधी</option>
                                    <option value="ग्राम पाणीपुरवठा निधी">ग्राम पाणीपुरवठा निधी</option>
                                </select>
                                <label for="plan_name">योजनेचे नाव <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" name="bank_name" id="bank_name" class="form-control" placeholder="बँकेचे नाव" required>
                                <label for="bank_name">बँकेचे नाव <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" name="bank_branch" id="bank_branch" class="form-control" placeholder="बँक शाखा" required>
                                <label for="bank_branch">बँक शाखा <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" name="bank_address" id="bank_address" class="form-control" placeholder="बँक पत्ता" required>
                                <label for="bank_address">बँक पत्ता <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" name="bank_no" id="bank_no" class="form-control" placeholder="खाते क्रमांक" required>
                                <label for="bank_no">खाते क्रमांक <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" name="bank_ifsc_code" id="bank_ifsc_code" class="form-control" placeholder="आय फ एस सि कोड" required>
                                <label for="bank_ifsc_code">आय फ एस सि कोड <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        
                        <div class="col-12 text-center mt-3">
                            <button type="submit" name="add" class="btn btn-primary px-4 me-2">
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
                                <th>योजनेचे नाव</th>
                                <th>बँकेचे नाव</th>
                                <th>बँक शाखा</th>
                                <th>बँक पत्ता</th>
                                <th>खाते क्रमांक</th>
                                <th>आय फ एस सि कोड</th>
                                <th>क्रिया</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $banks = $fun->getBanks();
                            if(isset($banks['data']) && count($banks['data']) > 0) {
                                $i = 1;
                                while($bank = array_shift($banks['data'])) {
                            ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $bank['plan_name']; ?></td>
                                        <td><?php echo $bank['bank_name']; ?></td>
                                        <td><?php echo $bank['bank_branch']; ?></td>
                                        <td><?php echo $bank['bank_address']; ?></td>
                                        <td><?php echo $bank['account_no']; ?></td>
                                        <td><?php echo $bank['ifsc_code']; ?></td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-primary" onclick="fillBankData(
                                                    '<?php echo $bank['id']; ?>',
                                                    '<?php echo $bank['plan_name']; ?>',
                                                    '<?php echo $bank['bank_name']; ?>',
                                                    '<?php echo $bank['bank_branch']; ?>',
                                                    '<?php echo $bank['bank_address']; ?>',
                                                    '<?php echo $bank['account_no']; ?>',
                                                    '<?php echo $bank['ifsc_code']; ?>'
                                                )">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <a href="api/bank.php?delete=<?php echo $bank['id']; ?>"
                                                    class="btn btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this bank?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                            <?php
                                    $i++;
                                }
                            } else {
                                echo "<tr><td colspan='8' class='text-center'>No bank records found</td></tr>";
                            }
                            ?>
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
    function fillBankData(id, plan_name, bank_name, bank_branch, bank_address, account_no, ifsc_code) {
        // Set the bank ID
        document.getElementById('bank_id').value = id;

        // Fill form fields
        document.getElementById('plan_name').value = plan_name;
        document.getElementById('bank_name').value = bank_name;
        document.getElementById('bank_branch').value = bank_branch;
        document.getElementById('bank_address').value = bank_address;
        document.getElementById('bank_no').value = account_no;
        document.getElementById('bank_ifsc_code').value = ifsc_code;

        // Change button text
        document.getElementById('submitBtn').textContent = 'Update';

        // Scroll to form
        document.getElementById('plan_name').scrollIntoView({
            behavior: 'smooth'
        });
    }
    // Reset form when cancel button is clicked
    document.querySelector('button[type="reset"]').addEventListener('click', function() {
        document.getElementById('bank_id').value = '';
        document.getElementById('submitBtn').textContent = 'साठवणे';
    });

    // Also reset when form is successfully submitted
    <?php if (isset($_SESSION['message']) && $_SESSION['message_type'] == 'success'): ?>
    document.getElementById('bank_id').value = '';
    document.getElementById('submitBtn').textContent = 'साठवणे';
    <?php endif; ?>
    </script>
</body>

</html>