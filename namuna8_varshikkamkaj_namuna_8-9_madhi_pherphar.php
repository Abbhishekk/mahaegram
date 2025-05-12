<?php 
    require_once './include/auth_middleware.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php 
$title = "मालमत्ता माहिती प्रमाणिकरण";
?>
<?php include('include/header.php'); ?>
<?php
    $newName = $fun->getNewName();
    $periods = $fun->getPeriodDetails($_SESSION['district_code']);
?>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php 
        $page = 'namuna8';
        $subpage = 'varshik_kamkaj';
        include('include/sidebar.php');
       ?>
        <!-- Sidebar -->
        <!-- Container Fluid-->
        <div class="container-fluid bg-white p-4 border rounded">
            <!-- Header and Breadcrumb -->
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <div><strong>नमुना ८-९ मधील मिळकती मधील फरक शोधणे</strong></div>
                <div><a href="#"><i class="fa fa-home"></i> Home</a> / नमुना क्रमांक 9 / <strong>नमुना ८-९ मधील मिळकती
                        मधील फरक</strong></div>
            </div>

            <!-- Filter -->
            <div class="row mb-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label fw-bold">आर्थिक वर्ष:</label>
                    <select class="form-control">
                        <option selected>2025 - 2026</option>
                        <option>2024 - 2025</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="form-check mt-4">
                        <input class="form-check-input" type="radio" checked>
                        <label class="form-check-label fw-bold text-primary">
                            नमुना ८ व ९ मधील फरक
                        </label>
                    </div>
                </div>
            </div>

            <!-- Main Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-sm text-center">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>अ.क्र.</th>
                            <th>मिळकती क्रमांक</th>
                            <th>मिळकती धारक नाव</th>
                            <th>नमुना ८ रक्कम</th>
                            <th>नमुना ९ रक्कम</th>
                            <th>नमुना ८-९ मधील फरक रक्कम</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>4</td>
                            <td>दस्मा देव कॉलेज</td>
                            <td>677</td>
                            <td>1399</td>
                            <td>-722</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>57/1</td>
                            <td>मोहन मखुरे राठोड</td>
                            <td>170</td>
                            <td>0</td>
                            <td>170</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>119</td>
                            <td>रेंजना सुदु खोंडोजे</td>
                            <td>665</td>
                            <td>0</td>
                            <td>665</td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <nav>
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <!-- More pages as needed -->
                    </ul>
                </nav>
                <small class="text-muted">373 items in 38 pages</small>
            </div>

            <!-- Summary Inputs -->
            <div class="row mt-4">
                <div class="col-md-3">
                    <label>एकूण नमुना ८ एंट्री नोंद संख्या</label>
                    <input type="text" class="form-control" value="859">
                </div>
                <div class="col-md-3">
                    <label>नमुना क्रमांक ८ एकूण चालू रक्कम</label>
                    <input type="text" class="form-control" value="454318">
                </div>
                <div class="col-md-3">
                    <label>नमुना क्रमांक ९ एकूण नोंद संख्या</label>
                    <input type="text" class="form-control" value="467">
                </div>
                <div class="col-md-3">
                    <label>नमुना क्रमांक ९ एकूण चालू रक्कम दंड व सुट व्यतिरिक्त</label>
                    <input type="text" class="form-control" value="272226">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-3">
                    <label>नमुना क्रमांक ८ व ९ नोंदी फरक संख्या</label>
                    <input type="text" class="form-control" value="373">
                </div>
                <div class="col-md-3">
                    <label>नमुना क्रमांक ८ व ९ मधील फरक रक्कम</label>
                    <input type="text" class="form-control" value="182092">
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-4 d-flex gap-3">
                <button class="btn btn-primary"><i class="fa fa-print"></i> प्रिंट</button>
                <button class="btn btn-secondary">दुरुस्ती करणे </button>
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
    function filldata(id, person_name, nickname, mobile_no, aadhar_no, email, gender) {
        console.log(id, person_name, nickname, mobile_no, aadhar_no, email, gender);

        document.getElementById('update').value = id;
        document.getElementById('person_name').value = person_name;
        document.getElementById('nickname').value = nickname;
        document.getElementById('mobile_no').value = mobile_no;
        document.getElementById('aadhar_no').value = aadhar_no;
        document.getElementById('email').value = email;
        document.getElementById('gender').value = gender;
    }


    document.addEventListener("DOMContentLoaded", function() {
        const decision_date = document.getElementById('decision_date');

        decision_date.value = new Date().toISOString().split('T')[0];

    });
    </script>
</body>

</html>