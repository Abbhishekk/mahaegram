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
                        <h1 class="h3 mb-0 text-gray-800">धनादेश (चेकबुक) माहिती</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">पंचायत पोर्टल</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक ७</li>
                            <li class="breadcrumb-item active" aria-current="page">मास्टर्स</li>
                            <li class="breadcrumb-item active" aria-current="page">धनादेश (चेकबुक) माहिती</li>
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
                            <!--Write Your text here-->
                        </label>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form method="post" action="api/checkbook.php" class="needs-validation" novalidate>
                    <input type="hidden" name="checkbook_id" id="checkbook_id" value="">
                    
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
                                <select class="form-select" name="bank_name" id="bank_name" required>
                                    <option value="">-- प्रथम योजना निवडा --</option>
                                </select>
                                <label for="bank_name">बँकेचे नाव <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" name="checkbook_no" id="checkbook_no" class="form-control" placeholder="चेकबुक क्रमांक" required>
                                <label for="checkbook_no">चेकबुक क्रमांक <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" name="first_check_no" id="first_check_no" class="form-control" placeholder="पहिला चेक क्रमांक" required>
                                <label for="first_check_no">पहिला चेक क्रमांक <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="number" name="check_no" id="check_no" class="form-control" placeholder="चेक संख्या" required>
                                <label for="check_no">चेक संख्या <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" name="last_check_no" id="last_check_no" class="form-control" placeholder="शेवटचा चेक क्रमांक" readonly required>
                                <label for="last_check_no">शेवटचा चेक क्रमांक <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="date" name="date" id="date" class="form-control" placeholder="दिनांक" required>
                                <label for="date">दिनांक <span class="text-danger">*</span></label>
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
                                <th>चेकबुक क्रमांक</th>
                                <th>पहिला चेक क्रमांक</th>
                                <th>चेक संख्या</th>
                                <th>शेवटचा चेक क्रमांक</th>
                                <th>दिनांक</th>
                                <th>क्रिया</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $checkbooks = $fun->getCheckbooks($_SESSION['district_code']);
                            if(mysqli_num_rows($checkbooks) > 0) {
                                $i = 1;
                                while($checkbook = mysqli_fetch_assoc($checkbooks)) {
                            ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $checkbook['plan_name']; ?></td>
                                        <td><?php echo $fun->getBankName($checkbook['bank_id']); ?></td>
                                        <td><?php echo $checkbook['checkbook_no']; ?></td>
                                        <td><?php echo $checkbook['first_check_no']; ?></td>
                                        <td><?php echo $checkbook['check_no']; ?></td>
                                        <td><?php echo $checkbook['last_check_no']; ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($checkbook['date'])); ?></td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-primary" onclick="fillCheckbookData(
                                                    '<?php echo $checkbook['id']; ?>',
                                                    '<?php echo $checkbook['plan_name']; ?>',
                                                    '<?php echo $checkbook['bank_id']; ?>',
                                                    '<?php echo $checkbook['checkbook_no']; ?>',
                                                    '<?php echo $checkbook['first_check_no']; ?>',
                                                    '<?php echo $checkbook['check_no']; ?>',
                                                    '<?php echo $checkbook['last_check_no']; ?>',
                                                    '<?php echo $checkbook['date']; ?>'
                                                )">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <a href="api/checkbook.php?delete=<?php echo $checkbook['id']; ?>"
                                                    class="btn btn-danger"
                                                    onclick="return confirm('तुम्हाला ही चेकबुक माहिती नक्की हटवायची आहे का?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                            <?php
                                    $i++;
                                }
                            } else {
                                echo "<tr><td colspan='9' class='text-center'>चेकबुक माहिती सापडली नाही</td></tr>";
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
    function fillCheckbookData(id, plan_name, bank_id, checkbook_no, first_check_no, check_no, last_check_no, date) {
        // Set the checkbook ID
        document.getElementById('checkbook_id').value = id;

        // Fill form fields
        document.getElementById('plan_name').value = plan_name;
        document.getElementById('bank_name').value = bank_id;
        document.getElementById('checkbook_no').value = checkbook_no;
        document.getElementById('first_check_no').value = first_check_no;
        document.getElementById('check_no').value = check_no;
        document.getElementById('last_check_no').value = last_check_no;
        document.getElementById('date').value = date;

        // Change button text
        document.querySelector('button[name="add"]').textContent = 'अपडेट करा';

        // Scroll to form
        document.getElementById('plan_name').scrollIntoView({
            behavior: 'smooth'
        });
    }

    // Reset form when cancel button is clicked
    document.querySelector('button[type="reset"]').addEventListener('click', function() {
        document.getElementById('checkbook_id').value = '';
        document.querySelector('button[name="add"]').textContent = 'साठवणे';
    });

    // Also reset when form is successfully submitted
    <?php if (isset($_SESSION['message']) && $_SESSION['message_type'] == 'success'): ?>
    document.getElementById('checkbook_id').value = '';
    document.querySelector('button[name="add"]').textContent = 'साठवणे';
    <?php endif; ?>

    document.getElementById('check_no').addEventListener('input', function() {
        var firstCheckNo = parseInt(document.getElementById('first_check_no').value);
        var checkNo = parseInt(document.getElementById('check_no').value);
        var lastCheckNo = firstCheckNo + checkNo - 1;
        document.getElementById('last_check_no').value = lastCheckNo;
    });
    </script>
    <script>
    // Function to load banks based on selected plan
    function loadBanksByPlan(planName) {
        if (!planName) {
            $('#bank_name').html('<option value="">-- निवडा --</option>');
            return;
        }

        $.ajax({
            url: 'api/checkbook.php?getBanksByPlan=1',
            type: 'GET',
            data: {
                plan_name: planName
            },
            dataType: 'json',
            success: function(response) {
                console.log(response);
                if (response) {
                    var options = '<option value="">-- निवडा --</option>';
                    $.each(response, function(index, bank) {
                        options += '<option value="' + bank.id + '">' + bank.bank_name +
                            '</option>';
                    });
                    $('#bank_name').html(options);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching banks:", error);
            }
        });
    }

    // Event listener for plan selection change
    $('#plan_name').change(function() {
        var selectedPlan = $(this).val();
        loadBanksByPlan(selectedPlan);
    });

    // Existing fillCheckbookData function with bank selection
    function fillCheckbookData(id, plan_name, bank_id, checkbook_no, first_check_no, check_no, last_check_no, date) {
        // Set the checkbook ID
        $('#checkbook_id').val(id);

        // First set the plan name
        $('#plan_name').val(plan_name).trigger('change');

        // After a small delay (to allow banks to load), set the bank
        setTimeout(function() {
            $('#bank_name').val(bank_id);
        }, 300);

        // Fill other form fields
        $('#checkbook_no').val(checkbook_no);
        $('#first_check_no').val(first_check_no);
        $('#check_no').val(check_no);
        $('#last_check_no').val(last_check_no);
        $('#date').val(date);

        // Change button text
        $('button[name="add"]').text('अपडेट करा');

        // Scroll to form
        $('html, body').animate({
            scrollTop: $('#plan_name').offset().top
        }, 500);
    }

    // Rest of your existing JavaScript...
    </script>
</body>

</html>