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
        $page = 'namuna9';
        $subpage = 'ahaval';
        include('include/sidebar.php');
       ?>
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <?php include('include/topbar.php'); ?>
                <!-- Topbar -->

                <!-- Container Fluid-->
<div class="container border rounded p-3">
    <h5 class="fw-bold text-secondary mb-3">वार्षिक कर मागणी</h5>

    <!-- मालमत्ता धारकाची माहिती -->
    <div class="border rounded p-3 mb-3">
        <h6 class="fw-bold">मालमत्ता धारकाची माहिती</h6>
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">वॉर्ड क्र</label>
                <select class="form-select form-control">
                    <option>निवडा</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">मालमत्ता क्रमांक</label>
                <select class="form-select form-control">
                    <option>--निवडा--</option>
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button class="btn btn-primary w-100">शोधा</button>
            </div>
           
        </div>
        <div class="border rounded p-3 mb-3">
       
        <div class="row mb-3">
           
            <div class="col-md-6">
                <label class="form-label">कर देणाऱ्याचे नाव</label>
                <select class="form-select form-control">
                    <option>--निवडा--</option>
                </select>
            </div>
            <div class="col-md-6 ">
                <label class="form-label">भोगवटा धारकाचे नाव</label>
                <select class="form-select form-control">
                    <option>--निवडा--</option>
                </select>
            </div>
        </div>
        <h6 class="fw-bold">मालमत्तेचे वर्णन </h6>
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">वॉर्ड क्रं</label>
                <select class="form-select  form-control">
                    <option>निवडा</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">मालमत्ता क्रमांक</label>
                <select class="form-select  form-control">
                    <option>--निवडा--</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">मालमत्ता धारकाचे नाव</label>
                <select class="form-select form-control">
                    <option>--निवडा--</option>
                </select>
            </div>
        </div>
    </div>

    <!-- कर टॅक्स कार्ड्स -->
    <div class="row gy-3">
        <!-- Each box is styled as a card -->
        <div class="col-md-3 mb-2">
            <div class="p-3 shadow-sm bg-white rounded">
                <h6 class="text-primary fw-bold">इमारतीवरील कर</h6>
                <label>मागील बाकी <span class="text-danger">*</span></label>
                <input type="text" class="form-control mb-1">
                <label>चालू कर</label>
                <input type="text" class="form-control mb-1">
                <label>एकूण रक्कम</label>
                <input type="text" class="form-control">
            </div>
        </div>

        <div class="col-md-3 mb-2">
            <div class="p-3 shadow-sm bg-white rounded">
                <h6 class="text-primary fw-bold">दिवाबत्ती कर</h6>
                <label>मागील बाकी <span class="text-danger">*</span></label>
                <input type="text" class="form-control mb-1">
                <label>चालू कर</label>
                <input type="text" class="form-control mb-1">
                <label>एकूण रक्कम</label>
                <input type="text" class="form-control">
            </div>
        </div>

        <div class="col-md-3 mb-2">
            <div class="p-3 shadow-sm bg-white rounded">
                <h6 class="text-primary fw-bold">आरोग्य कर </h6>
                <label>मागील बाकी</label>
                <input type="text" class="form-control mb-1">
                <label>चालू कर</label>
                <input type="text" class="form-control mb-1">
                <label>एकूण रक्कम</label>
                <input type="text" class="form-control">
            </div>
        </div>

        <div class="col-md-3 mb-2">
            <div class="p-3 shadow-sm bg-white rounded">
                <h6 class="text-primary fw-bold">सार्वजनिक पाणीपट्टी</h6>
                <label>मागील बाकी <span class="text-danger">*</span></label>
                <input type="text" class="form-control mb-1">
                <label>चालू कर</label>
                <input type="text" class="form-control mb-1">
                <label>एकूण रक्कम</label>
                <input type="text" class="form-control">
            </div>
        </div>

        <div class="col-md-3">
            <div class="p-3 shadow-sm bg-white rounded">
                <h6 class="text-primary fw-bold">पडसर कर</h6>
                <label>मागील बाकी <span class="text-danger">*</span></label>
                <input type="text" class="form-control mb-1">
                <label>चालू कर</label>
                <input type="text" class="form-control mb-1">
                <label>एकूण रक्कम</label>
                <input type="text" class="form-control">
            </div>
        </div>

        <div class="col-md-3">
            <div class="p-3 shadow-sm bg-white rounded">
                <h6 class="text-primary fw-bold">दंड</h6>
                <label>दंड मागील</label>
                <input type="text" class="form-control mb-1">
                <label>दंड चालू</label>
                <input type="text" class="form-control mb-1">
                <label>दंड एकूण</label>
                <input type="text" class="form-control">
            </div>
        </div>

        <div class="col-md-3">
            <div class="p-3 shadow-sm bg-white rounded">
                <h6 class="text-primary fw-bold">नोटीस-सूट (-)रक्कम</h6>
                <label>नोटीस फी</label>
                <input type="text" class="form-control mb-1">
                <label>सूट रक्कम</label>
                <input type="text" class="form-control mb-1">
                
            </div>
        </div>

        <div class="col-md-3">
            <div class="p-3 shadow-sm bg-white rounded">
                <h6 class="text-primary fw-bold">एकूण</h6>
                <label>एकूण मागील बाकी</label>
                <input type="text" class="form-control mb-1">
                <label>एकूण चालू कर</label>
                <input type="text" class="form-control mb-1">
                <label>एकूण रक्कम</label>
                <input type="text" class="form-control">
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-4 text-end">
        <button class="btn btn-success">साठवा</button>
        <button class="btn btn-secondary">रद्द करा</button>
        <button class="btn btn-primary">कर मागणी</button>
    </div>
    <div class="container-fluid mt-4">

<!-- इतर मिळकतीची माहिती -->
<h6 class="fw-bold">इतर मिळकतीची माहिती</h6>
<div class="table-responsive mb-3">
    <table class="table table-bordered table-sm">
        <thead class="table-primary">
            <tr>
                <th>अ.क्र.</th>
                <th>मू. क्रमांक</th>
                <th>वॉर्ड. क्र.</th>
                <th>मू. क्रमांक</th>
                <th>कर धारकाचे नाव</th>
                <th>आर्थिक वर्ष</th>
                <th>घर मालमत्ता</th>
                <th>घर चापू</th>
                <th>दिवाळी मागणी</th>
                <th>दिवाळी चापू</th>
                <th>आरोग्य मागणी</th>
                <th>आरोग्य चापू</th>
                <th>पाणी मागणी</th>
                <th>पाणी चापू</th>
                <th>पखंर/खूली मागणी</th>
                <th>पखंर/खूली चापू</th>
                <th>दंड मागणी</th>
                <th>दंड चापू</th>
                <th>नोटीस फी</th>
                <th>बदल</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="20" class="text-center">No records to display.</td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Tax Input Form -->
<div class="row g-2 mb-4">
    <div class="col-md-2 m-2">
        <input type="text" class="form-control" placeholder="इमारत कर">
    </div>
    <div class="col-md-2 m-2">
        <input type="text" class="form-control" placeholder="दिवाबत्ती कर">
    </div>
    <div class="col-md-2 m-2">
        <input type="text" class="form-control" placeholder="आरोग्य कर">
    </div>
    <div class="col-md-2 m-2">
        <input type="text" class="form-control" placeholder="सामान्य पाणीपट्टी">
    </div>
    <div class="col-md-2 m-2">
        <input type="text" class="form-control" placeholder="पडसर/खुली जागा">
    </div>
    <div class="col-md-2 m-2">
        <input type="text" class="form-control" placeholder="दंड रक्कम">
    </div>
    <div class="col-md-2 m-2">
        <input type="text" class="form-control" placeholder="नोटीस फी">
    </div>
    <div class="col-md-2 m-2">
        <input type="text" class="form-control" placeholder="सूट रक्कम">
    </div>
    <div class="col-md-2 m-2">
        <input type="text" class="form-control" placeholder="एकूण देय रक्कम">
    </div>
    </div>
<div class="container text-center my-4">
    <div class="d-flex justify-content-center align-items-center">
        <button class="btn btn-primary mr-3">साठवा</button>
        <button class="btn btn-secondary">रद्द करा</button>
    </div>
</div>


<!-- वार्षिक कर मागणी यादी -->
<h6 class="fw-bold">वार्षिक कर मागणी यादी</h6>
<div class="table-responsive">
    <table class="table table-bordered table-sm">
        <thead class="table-primary">
            <tr>
                <th>अ.क्र.</th>
                <th>मू. क्रमांक</th>
                <th>कर धारकाचे नाव</th>
                <th>आर्थिक वर्ष</th>
                <th>घर मालमत्ता</th>
                <th>घर चापू</th>
                <th>दिवाळी मागणी</th>
                <th>दिवाळी चापू</th>
                <th>आरोग्य मागणी</th>
                <th>आरोग्य चापू</th>
                <th>पाणी मागणी</th>
                <th>पाणी चापू</th>
                <th>पखंर/खूली मागणी</th>
                <th>पखंर/खूली चापू</th>
                <th>दंड मागणी</th>
                <th>दंड चापू</th>
                <th>नोटीस फी</th>
                <th>बदल</th>
            </tr>
        </thead>
        <tbody>
            <!-- Sample Row -->
            <tr>
                <td>1</td>
                <td>५४३</td>
                <td>दीपक अशोक कोळे</td>
                <td>2025 - 2026</td>
                <td>0</td>
                <td>491</td>
                <td>0</td>
                <td>20</td>
                <td>0</td>
                <td>20</td>
                <td>0</td>
                <td>75</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td><a href="#"><i class="fa fa-pen text-primary"></i></a></td>
            </tr>
            <!-- Add more rows as needed -->
        </tbody>
    </table>
</div>

<!-- Pagination (static for now) -->
<div class="d-flex justify-content-between align-items-center mt-2">
    <div>
        <nav>
            <ul class="pagination pagination-sm mb-0">
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <!-- Add more as needed -->
            </ul>
        </nav>
    </div>
    <div>
        <span class="text-muted">840 items in 84 pages</span>
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