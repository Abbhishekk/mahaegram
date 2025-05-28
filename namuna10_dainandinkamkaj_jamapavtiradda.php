<?php 
    require_once './include/auth_middleware.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php 
$title = "पावती रद्द करणे";
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
           $page = 'namuna10';
        $subpage = 'dainandin';
        include('include/sidebar.php');
       ?>
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <?php include('include/topbar.php'); ?>
                <!-- Topbar -->

                <!-- Container Fluid-->
                 <div class="container-fluid" id="container-wrapper" >
                     <div class="d-sm-flex align-items-center justify-content-between mb-4">
                             <h1 class="h3 mb-0 text-gray-800">पावती रद्द करणे</h1>
                             <ol class="breadcrumb">
                                 <li class="breadcrumb-item"><a href="./">माहईग्राम</a></li>
                                 <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 10</li>
                                 <li class="breadcrumb-item active" aria-current="page">मास्टर्स</li>
                                 <li class="breadcrumb-item active" aria-current="page">पावती रद्द करणे</li>
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
                                     <div class="container card-body border rounded p-3">
                                         <h5 class="fw-bold text-secondary mb-3">पावती रद्द करणे</h5>
                                         <form action="api/jama_pavati_radd.php" method="POST" id="pavati_radd_form">
                                             <div class="row mb-3">
                                                 <div class="col-md-3">
                                                     <label class="form-label fw-bold" for="book_no">बुक नंबर <span class="text-danger">*</span></label>
                                                     <select class="form-control  form-select border-primary" name="book_no" id="book_no" >
                                                         <option>--निवडा--</option>
                                                     </select>
                                                 </div>
                                                 <div class="col-md-3">
                                                     <label class="form-label fw-bold" for="receipt_no" >पावती नंबर <span class="text-danger">*</span></label>
                                                     <select class="form-control form-select border-primary" name="receipt_no" id="receipt_no">
                                                         <option>--निवडा--</option>
                                                     </select>
                                                 </div>
                                                 <div class="col-md-6">
                                                     <label class="form-label fw-bold" for="reason">पावती रद्द कारण <span class="text-danger">*</span></label>
                                                     <input type="text" class="form-control border-primary" name="reason" id="reason" placeholder="पावती रद्द कारण">
                                                 </div>
                                             </div>
                                             <div class="row mb-3">
                                                
                                                 <div class="d-grid gap-2 col-6 mx-auto">
                                                         <button class="btn btn-primary" name="add" id="add" type="submit">साठवा</button>
                                                         <button class="btn btn-primary" type="reset">रद्द करणे</button>
                                                 </div>
                                             </div>
                                         </form>
                                     
                                     
                                         <div class="table-responsive">
                                             <table class="table table-bordered">
                                                 <thead class="table-primary text-center">
                                                     <tr>
                                                         <th>अ क्रं</th>
                                                         <th>बुक नंबर</th>
                                                         <th>पावती नंबर</th>
                                                         <th>कारण</th>
                                                         <th>बदल</th>
                                                     </tr>
                                                 </thead>
                                                 <tbody>
                                                     <tr>
                                                         <td colspan="5" class="text-center">No records to display.</td>
                                                     </tr>
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
    <!-- Add this right after the opening <body> tag -->
<div id="fullScreenLoader" class="full-screen-loader">
    <div class="loader-content">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <p class="mt-3 text-white">पावती रद्द करत आहे... कृपया प्रतीक्षा करा</p>
    </div>
</div>

<style>
.full-screen-loader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    flex-direction: column;
    transition: opacity 0.3s ease;
    opacity: 0;
}

.full-screen-loader.show {
    opacity: 1;
    display: flex;
}

.loader-content {
    text-align: center;
    color: white;
}

.loader-content p {
    font-size: 1.2rem;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector('form');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Show loader with smooth transition
        const loader = document.getElementById('fullScreenLoader');
        loader.style.display = 'flex';
        setTimeout(() => loader.classList.add('show'), 10);
        
        // Create FormData object
        const formData = new FormData(this);
        
        // Submit via AJAX
        fetch(this.action, {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if(data.success) {
                // Show success message
                alert(data.message);
                // Reload the page or update table
                window.location.reload();
            } else {
                throw new Error(data.message || 'Unknown error occurred');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert(`त्रुटी: ${error.message}`);
        })
        .finally(() => {
            // Hide loader with smooth transition
            loader.classList.remove('show');
            setTimeout(() => loader.style.display = 'none', 300);
        });
    });
});
</script>
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