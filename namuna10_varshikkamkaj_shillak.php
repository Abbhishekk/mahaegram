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
    $materials = $fun->getMaterials($_SESSION['district_code']);
$financialYears = $fun->getFinancialYears();
    $banks = $fun->getBanks();

?>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php 
        $page = 'namuna10';
        $subpage = 'master';
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
                        <h1 class="h3 mb-0 text-gray-800">वर्षाच्या सुरवातीची शिल्लक</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">माहईग्राम</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 10</li>
                            <li class="breadcrumb-item active" aria-current="page">मास्टर्स</li>
                            <li class="breadcrumb-item active" aria-current="page">वर्षाच्या सुरवातीची शिल्लक</li>
                        </ol>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <?php
                                if (isset($_SESSION['message'])) {
                                    $message = $_SESSION['message'];
                                    $message_type = $_SESSION['message_type'];

                                    echo "<div class='alert alert-$message_type'>$message</div>";

                                    // Unset the message so it doesn't persist after refresh
                                    unset($_SESSION['message']);
                                    unset($_SESSION['message_type']);
                                }
                                ?>
                                <div class="card-body">
                                    <form method="post" action="api/year_start_remaining.php">
                                        <input type="hidden" name="material_id" id="material_id" value="">
                                        <div class="row">
                                            <div class="col-md-3 my-3">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="deposit_type1" name="deposit_type"
                                                        value="जमिनीचे वार्षिक मूल्य दर नोंद करणे"
                                                        class="custom-control-input">
                                                    <label class="custom-control-label" for="deposit_type1">हात शिल्लक
                                                    </label>
                                                </div>

                                            </div>
                                            <div class="col-md-3 my-3">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="deposit_type2" name="deposit_type"
                                                        value="इमारतीचे वार्षिक मूल्य दर नोंद करणे"
                                                        class="custom-control-input">
                                                    <label class="custom-control-label" for="deposit_type2">बँक
                                                        शिल्लक</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 my-3">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="deposit_type1" name="deposit_type"
                                                        value="जमिनीचे वार्षिक मूल्य दर नोंद करणे"
                                                        class="custom-control-input">
                                                    <label class="custom-control-label" for="deposit_type1">पोस्ट शिल्लक
                                                    </label>
                                                </div>

                                            </div>
                                            <div class="col-md-3 my-3">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="deposit_type2" name="deposit_type"
                                                        value="इमारतीचे वार्षिक मूल्य दर नोंद करणे"
                                                        class="custom-control-input">
                                                    <label class="custom-control-label" for="deposit_type2">ठेवी
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="drainageType">आर्थिक वर्ष <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-control mb-3" name="financialYear"
                                                    id="financialYear">

                                                    <?php
                                                            if(mysqli_num_rows($financialYears) > 0){
                                                                while($financialYear = mysqli_fetch_assoc($financialYears)){
                                                                    echo "<option value='".$financialYear['year']."'>".$financialYear['year']."</option>";
                                                                }
                                                            }
                                                        ?>
                                                </select>


                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="plan_name">योजनेचे नाव <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-control mb-3" name="plan_name" id="plan_name"
                                                    required>
                                                    <option value=""> -- निवडा -- </option>
                                                    <option value="ग्रामनिधी">ग्रामनिधी</option>
                                                    <option value="ग्राम पाणीपुरवठा निधी">ग्राम पाणीपुरवठा निधी</option>
                                                </select>

                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="bank_name">बँकेचे नाव <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-control mb-3" name="bank_name" id="bank_name"
                                                    required>
                                                    <option value=""> -- निवडा -- </option>
                                                    <?php foreach ($banks['data'] as $bank) { ?>
                                                    <option value="<?php echo $bank['id']; ?>">
                                                        <?php echo $bank['bank_name']; ?></option>
                                                    <?php } ?>
                                                </select>

                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="remaining_amount">शिल्लक रक्कम :<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="remaining_amount" id="remaining_amount"
                                                    class="form-control" placeholder="शिल्लक रक्कम" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="post_name">पोस्टाचे नाव:<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="post_name" id="post_name" class="form-control"
                                                    placeholder="पोस्टाचे नाव" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="post_branch">पोस्टाची शाखा:<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="post_branch" id="post_branch"
                                                    class="form-control" placeholder="पोस्टाची शाखा" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="account_no">खाते क्रमांक:<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="account_no" id="account_no"
                                                    class="form-control" placeholder="खाते क्रमांक" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="ifsc_code">IFSC कोड:<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="ifsc_code" id="ifsc_code" class="form-control"
                                                    placeholder="IFSC कोड:" required>
                                            </div>
                                        </div>

                                        <button type="submit" name="add" class="btn btn-primary">साठवणे</button>
                                        <button type="reset" class="btn btn-secondary">रद्द करणे</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="table-responsive">
                                    <table class="table align-items-center table-flush">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>अ.क्र.</th>
                                                <th>फंडाचे नाव</th>
                                                <th>शिल्लक रक्कम</th>
                                                <th>आर्थिक वर्ष</th>
                                                <th>हात शिल्लक /बँक शिल्लक</th>
                                                <th>बँकेचे नाव</th>
                                                <th>पोस्टाचे नाव</th>
                                                <th>ठेव योजनेचे नाव</th>
                                                <th>क्रिया</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if(mysqli_num_rows($materials) > 0){
                                                $i = 1;
                                                while($material = mysqli_fetch_assoc($materials)){
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $material['material_name']; ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="#" class="btn btn-sm btn-primary" onclick="fillMaterialData(
                                                                '<?php echo $material['id']; ?>',
                                                                '<?php echo $material['material_name']; ?>'
                                                            )">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="api/material.php?delete=<?php echo $material['id']; ?>"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('तुम्हाला ही वस्तू नक्की हटवायची आहे का?')">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                                $i++;
                                                }
                                            } else {
                                                echo "<tr><td colspan='3' class='text-center'>वर्षाच्या सुरवातीची शिल्लक सापडली नाही</td></tr>";
                                            }
                                            ?>
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
    function fillMaterialData(id, material_name) {
        // Set the material ID
        document.getElementById('material_id').value = id;

        // Fill form fields
        document.getElementById('material_name').value = material_name;

        // Change button text
        document.querySelector('button[name="add"]').textContent = 'अपडेट करा';

        // Scroll to form
        document.getElementById('material_name').scrollIntoView({
            behavior: 'smooth'
        });
    }

    // Reset form when cancel button is clicked
    document.querySelector('button[type="reset"]').addEventListener('click', function() {
        document.getElementById('material_id').value = '';
        document.querySelector('button[name="add"]').textContent = 'साठवणे';
    });

    // Also reset when form is successfully submitted
    <?php if (isset($_SESSION['message']) && $_SESSION['message_type'] == 'success'): ?>
    document.getElementById('material_id').value = '';
    document.querySelector('button[name="add"]').textContent = 'साठवणे';
    <?php endif; ?>
    </script>
</body>

</html>