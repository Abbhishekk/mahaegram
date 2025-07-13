<?php 
    require_once './include/auth_middleware.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php 
$title = "वस्तूंची माहिती";
?>
<?php include('include/header.php'); ?>
<?php
    $materials = $fun->getMaterials($_SESSION['district_code']);
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
                        <h1 class="h3 mb-0 text-gray-800">वस्तूंची माहिती</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">पंचायत पोर्टल</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक ७</li>
                            <li class="breadcrumb-item active" aria-current="page">मास्टर्स</li>
                            <li class="breadcrumb-item active" aria-current="page">वस्तूंची माहिती</li>
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
                <form method="post" action="api/material.php" class="needs-validation" novalidate>
                    <input type="hidden" name="material_id" id="material_id" value="">
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" name="material_name" id="material_name" 
                                    class="form-control" placeholder="जिन्नसाचे नाव" required>
                                <label for="material_name">जिन्नसाचे नाव <span class="text-danger">*</span></label>
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
                                <th>जिन्नसाचे नाव</th>
                                <th>क्रिया</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if(mysqli_num_rows($materials) > 0) {
                                $i = 1;
                                while($material = mysqli_fetch_assoc($materials)) {
                            ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $material['material_name']; ?></td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-primary" onclick="fillMaterialData(
                                                    '<?php echo $material['id']; ?>',
                                                    '<?php echo $material['material_name']; ?>'
                                                )">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <a href="api/material.php?delete=<?php echo $material['id']; ?>"
                                                    class="btn btn-danger"
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
                                echo "<tr><td colspan='3' class='text-center'>वस्तूंची माहिती सापडली नाही</td></tr>";
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