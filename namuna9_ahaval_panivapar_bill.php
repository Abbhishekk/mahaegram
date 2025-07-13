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
$periods = $fun->getPeriodTotalPeriodsWithPeriodReason("नमुना नंबर 8 कालावधी", $_SESSION['district_code']);
if (empty($periods)) {
    $_SESSION['message'] = "कालावधी उपलब्ध नाही.";
    $_SESSION['message_type'] = "danger";
}
$financialYears = $fun->getYearArray($periods);
$lgdVillages = $fun->getVillagesWithPanchayat($_SESSION['panchayat_code']);
$property_verifications = $fun->getPropertyVerificationsAccordingToPanchayat();
$wards = $fun->getWard($_SESSION['district_code']);
$roads = $fun->getRoad($_SESSION['district_code']);
?>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php
        $page = 'namuna9';
        $subpage = 'ahaval';
        ?>
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <?php include('include/topbar.php');
        include('include/sidebar.php'); ?>
                <!-- Topbar -->

                <!-- Container Fluid-->
                <div class="container-fluid border rounded p-3">
                    <div class="bg-light p-2 mb-3 border-bottom">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">कर मागणी बिल</h1>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./">पंचायत पोर्टल</a></li>
                                <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 9</li>
                                <li class="breadcrumb-item active" aria-current="page">मास्टर्स</li>
                                <li class="breadcrumb-item active" aria-current="page">कर मागणी बिल</li>
                            </ol>
                        </div>
                       
                    </div>

                    <form action="">
                        <div class="card p-4">
                            <?php
                            if (isset($_SESSION['message'])) {
                                echo "<div class='alert alert-{$_SESSION['message_type']}'>{$_SESSION['message']}</div>";
                                unset($_SESSION['message']);
                                unset($_SESSION['message_type']);
                            }
                            ?>
                          

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="me-3 col-md-3 fw-bold text-secondary" id="all_bill"><input
                                            type="radio" name="bill_type" class="me-1" value="all_bill" id="all_bill"
                                            checked> संपूर्ण बिल</label>
                                    <label class="me-3 col-md-3 fw-bold text-secondary" for="individual_bill"><input
                                            type="radio" name="bill_type" value="individual_bill" id="individual_bill"
                                            class="me-1"> वैयक्तिक बिल</label>
                                    
                                </div>
                            </div>

                            <div class="row mb-3">
                               
                                <div class="col-md-6 my-2">
                                    <label class="form-label fw-bold" for="financial_year">आर्थिक वर्ष :</label>
                                    <select class="form-control border-primary" name="financial_year"
                                        id="financial_year">
                                        <option value=""> --निवडा-- </option>
                                        <?php foreach ($financialYears as $year): ?>
                                            <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">दिनांक <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="date" id="date" value="2025-05-22">
                                </div>
                            </div>

                            <div class="row mb-3">
                               
                                <div class="col-md-4 my-2 ">
                                    <label class="form-label" for="malmatta_id">मालमत्ता क्रमांक</label>
                                    <select class="form-select form-control" name="malmatta_id" id="malmatta_id">
                                        <option value="">--निवडा--</option>
                                        <?php
                                        foreach ($property_verifications as $property) {
                                                $format = ($property['ward_name']!= "" ? $property['ward_name'] :"वॉर्ड नाव")." / ".($property['property_road_name'] != "" ? $property['property_road_name'] : "रस्त्याचे नाव")." / रजिस्टर नं- ".($property['register_no']!="" ? $property['register_no']:"0")." / खासरा नं- ".($property['khasara_no']!="" ? $property['khasara_no']:"0")." / मालमत्ता नं- ".$property['malmatta_no'];

                                            echo "<option value='{$property['malmatta_id']}'>{$format}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                              
                            </div>

                            <div class="row mb-3">
                                
                               <div class="col-md-4">
    <label class="form-label fw-bold">सरपंच सही</label>
    <input type="file" class="form-control" name="sarpanch_signature" id="sarpanch_signature" accept="image/*">
</div>
                                
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12 d-flex gap-2 justify-content-start">
                                    <button type="button" id="generatePdfBtn" class="ml-3 btn btn-primary"> बिल
                                        तयार करणे</button>
                                    <button class="ml-3 btn btn-secondary">रद्द करणे</button>
                                </div>
                            </div>
                        </div>
                    </form>

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
    </script>
    <script>
       $(document).ready(function() {
    $('#generatePdfBtn').click(async function() {
        // Get form values
        const financial_year = $('#financial_year').val();
        const malmatta_id = $('#malmatta_id').val() || null;
        const bill_type = $('input[name="bill_type"]:checked').val();
        const date = $('#date').val();
        const signatureFile = $('#sarpanch_signature')[0].files[0];

        // Validate required fields
        if (!financial_year) {
            alert('कृपया आर्थिक वर्ष निवडा');
            return;
        }

        if (!date) {
            alert('कृपया दिनांक निवडा');
            return;
        }

        // Create FormData for file upload
        const formData = new FormData();
        formData.append('financial_year', financial_year);
        formData.append('date', date);
        formData.append('bill_type', bill_type);
        if (malmatta_id) formData.append('malmatta_id', malmatta_id);
        if (signatureFile) formData.append('sarpanch_signature', signatureFile);

        try {
            const response = await fetch('pdf/namuna9_panni_bill_pavati.php', {
                method: 'POST',
                body: formData
            });
            
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            
            const html = await response.text();
            const printWindow = window.open('', '_blank');
            printWindow.document.open();
            printWindow.document.write(html);
            printWindow.document.close();
        } catch (error) {
            console.error('Error:', error);
            alert('बिल तयार करताना त्रुटी आली: ' + error.message);
        }
    });
});
    </script>
    <script>
        $('#malmatta_id').change(function() {
            const malmatta_id = $(this).val();

            if (malmatta_id) {
                $.ajax({
                    url: 'api/get_property_owners.php',
                    type: 'POST',
                    data: {
                        malmattaId: malmatta_id
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.success) {
                            $('#kardena_name').empty();
                            $('#kardena_name').attr('disabled', true);
                            $('#kardena_name').append('<option value="">--निवडा--</option>');

                            if (data.owner_name) {
                                $('#kardena_name').append(
                                    `<option value="${data.owner_name}" selected>${data.owner_name}</option>`
                                );
                            }


                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error: " + status + " - " + error);
                    }
                });
            } else {
                $('#kardena_name').empty();
                $('#kardena_name').append('<option value="">--निवडा--</option>');
            }
        });
        $('#ward').attr('disabled', true);
        $('#malmatta_id').attr('disabled', true);
        $('#kardena_name').attr('disabled', true);
        $('#ward_div').hide();
        $('#road_div').hide();

        // Show/hide fields based on selected criteria
        $('input[name="bill_type"]').change(function() {
            const criteria = $(this).val();



            // Show relevant fields based on criteria
            if (criteria === 'all_bill') {
                $('#ward').attr('disabled', true);
                $('#malmatta_id').attr('disabled', true);
                $('#kardena_name').attr('disabled', true);
                $('#ward_div').hide();
                $('#road_div').hide();

            } else if (criteria === 'individual_bill') {
                $('#malmatta_id').attr('disabled', false);
                $('#kardena_name').attr('disabled', false);
                $('#revenue_village').attr('disabled', false);
                $('#ward').attr('disabled', true);
                $('#ward_div').hide();
                $('#road_div').hide();

            } else if (criteria === 'ward_wise') {
                $('#malmatta_id').attr('disabled', true);
                $('#kardena_name').attr('disabled', true);
                $('#revenue_village').attr('disabled', false);
                $('#ward').attr('disabled', false);
                $('#ward_div').show();
                $('#road_div').hide();
            } else if (criteria === 'road_wise') {
                $('#malmatta_id').attr('disabled', true);
                $('#kardena_name').attr('disabled', true);
                $('#revenue_village').attr('disabled', false);
                $('#ward').attr('disabled', true);
                $('#ward_div').hide();
                $('#road_div').show();
            } else {
                $('#ward').attr('disabled', true);
                $('#malmatta_id').attr('disabled', true);
                $('#kardena_name').attr('disabled', true);
                $('#ward_div').hide();
                $('#road_div').hide();
            }
        });

        // Initialize field visibility
        $('input[name="criteria"]:checked').trigger('change');
    </script>
</body>

</html>