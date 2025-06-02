<?php 
    require_once './include/auth_middleware.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php 
$title = "नमुना नं.10 कर व फी पावती अहवाल";
?>
<?php include('include/header.php'); ?>
<?php
    $newName = $fun->getNewName();
    $periods = $fun->getPeriodTotalPeriodsWithPeriodReason("नमुना नंबर 8 कालावधी",$_SESSION['district_code']);
    if (empty($periods)) {
        $_SESSION['message'] = "कालावधी उपलब्ध नाही.";
        $_SESSION['message_type'] = "danger";
      
    }
    $financialYears = $fun->getYearArray($periods);
    $wards = $fun->getWard($_SESSION['district_code']);

?>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php 
        $page = 'namuna10';
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

                <div class="container-fluid border rounded p-3" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">नमुना नं.10 कर व फी पावती अहवाल</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">माहईग्राम</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 10</li>
                            <li class="breadcrumb-item active" aria-current="page">अहवाल</li>
                            <li class="breadcrumb-item active" aria-current="page">नमुना नं.10 कर व फी पावती अहवाल</li>
                        </ol>
                    </div>
                    <form action="">
                        <?php
                                if (isset($_SESSION['message'])) {
                                    echo "<div class='alert alert-{$_SESSION['message_type']}'>{$_SESSION['message']}</div>";
                                    unset($_SESSION['message']);
                                    unset($_SESSION['message_type']);
                                }
                                ?>
                        <div class=" card row p-4">
                            <div class="col-md-12 mb-3">
                                <label class="me-4 col-md-3 fw-bold text-secondary d-inline-block me-3">
                                    <input type="radio" name="bill_type" value="all_register" checked class="me-1">
                                    संपूर्ण रजिस्टर
                                </label>
                                <label class="me-4 col-md-3 fw-bold text-secondary d-inline-block me-3">
                                    <input type="radio" name="bill_type" value="book_number" class="me-1"> बुक नंबर
                                    नुसार
                                </label>
                                <label class="fw-bold col-md-3 text-secondary d-inline-block">
                                    <input type="radio" name="bill_type" value="vasul_dinanknusar" class="me-1"> वसूल
                                    दिनांकानुसार
                                </label>
                                <label class="fw-bold col-md-3 text-secondary d-inline-block">
                                    <input type="radio" name="bill_type" value="pavati_number_nusar" class="me-1"> पावती
                                    नंबर नुसार
                                </label>
                                <label class="fw-bold col-md-3 text-secondary d-inline-block">
                                    <input type="radio" name="bill_type" value="malmaat_nusar" class="me-1">
                                    मालमात्तेनुसार
                                </label>
                                <label class="fw-bold col-md-3 text-secondary d-inline-block">
                                    <input type="radio" name="bill_type" value="according_to_person" class="me-1">
                                    व्यक्तीनुसार
                                </label>
                            </div>


                            <div class="row">

                                <div class="col-md-4 my-2">
                                    <label class="form-label fw-bold">आर्थिक वर्ष :</label>
                                    <select class="form-control border-primary" name="financial_year"
                                        id="financial_year">
                                        <option value=""> --निवडा-- </option>
                                        <?php foreach ($financialYears as $year): ?>
                                        <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-3 my-2" id="book_number_div">
                                    <label for="book_number">बुक नंबर : <span class="text-danger">*</span></label>
                                    <select class="form-control" name="book_number" id="book_number">
                                        <option value="">--निवडा--</option>

                                    </select>
                                </div>
                                <div class="form-group col-md-3 my-2" id="malmatta_number_div">
                                    <label for="malmatta_number">मालमत्ता क्रमांक :<span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" name="malmatta_number" id="malmatta_number">
                                        <option value="">--निवडा--</option>

                                    </select>
                                </div>
                                <div class="form-group col-md-3 my-2" id="person_name_div">
                                    <label for="person_name">व्यक्तिचे नाव :<span class="text-danger">*</span></label>
                                    <select class="form-control" name="person_name" id="person_name">
                                        <option value="">--निवडा--</option>

                                    </select>
                                </div>
                                <div class="form-group col-md-3 my-2" id="pavati_number_pasun_div">
                                    <label for="pavati_number_pasun">पावती नंबर पासून : <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" name="pavati_number_pasun" id="pavati_number_pasun">
                                        <option value="">--निवडा--</option>

                                    </select>
                                </div>
                                <div class="form-group col-md-3 my-2" id="pavati_number_paryant_div">
                                    <label for="pavati_number_paryant">पावती नंबर पर्यत : <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" name="pavati_number_paryant"
                                        id="pavati_number_paryant">
                                        <option value="">--निवडा--</option>

                                    </select>
                                </div>
                                <div class="form-group col-md-3 my-2" id="vasul_date_pasun_div">
                                    <label for="vasul_date_pasun">वसूल दिनांक पासून : <span
                                            class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="vasul_date_pasun"
                                        id="vasul_date_pasun" />

                                </div>
                                <div class="form-group col-md-3 my-2" id="vasul_date_paryant_div">
                                    <label for="vasul_date_paryant">पर्यत : <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="vasul_date_paryant"
                                        id="vasul_date_paryant" />

                                </div>
                            </div>

                            <div class="col-md-12 mb-3 d-flex justify-content-center  ">
                                <button type="submit" name="see_info" class="btn btn-primary me-2 mx-4">महिती
                                    दखवा</button>
                            </div>
                        </div>
                    </form>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive mt-4">
                                <table class="table table-bordered table-striped text-center align-middle">
                                    <thead class="bg-primary text-white">
                                        <tr class="text-xs">
                                            <th>अ क्रं</th>
                                            <th>आर्थिक वर्ष</th>
                                            <th>मिळकत क्रमांक</th>
                                            <!-- <th>गृ. नं.</th> -->
                                            <th>रक्कम जमा करणाऱ्याचे नाव</th>
                                            <th>बुक नंबर</th>
                                            <th>पावती नंबर</th>
                                            <th>पावती दिनांक</th>
                                            <th>घर मागील</th>
                                            <th>घर चालु</th>
                                            <th>घर एकुण</th>
                                            <th>आरोग्य मागील</th>
                                            <th>आरोग्य चालु</th>
                                            <th>आरोग्य एकुण</th>
                                            <th>दिवबत्ती मागील</th>
                                            <th>दिवाबत्ती चालु</th>
                                            <th>दिवाबत्ती एकुण</th>
                                            <th>पडसर मागील</th>
                                            <th>पडसर चालु</th>
                                            <th>पडसर एकुण</th>
                                            <th>पाणीपट्टी मागील</th>
                                            <th>पाणीपट्टी चालु</th>
                                            <th>पाणीपट्टी एकुण</th>
                                            <th>नोटीस फी</th>
                                            <th>दंड</th>
                                            <th>जमा रक्कम</th>
                                            <th>वसूल प्रकार </th>
                                            <th>पावती</th>
                                            <th>पावती काढणे</th>
                                            <th>पावती रद्द करणे</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-md-2">
                                    <p>घरपट्टी</p>

                                    <div>
                                        <label for="magil_gharpatti">मागील</label>
                                        <input type="text" name="magil_gharpatti" id="magil_gharpatti" readonly
                                            class="form-control" value="0">
                                    </div>
                                    <div>
                                        <label for="chalu_gharpatti">चालु</label>
                                        <input type="text" name="chalu_gharpatti" id="chalu_gharpatti" readonly
                                            class="form-control" value="0">
                                    </div>
                                    <div>
                                        <label for="sut_gharpatti">सुट</label>
                                        <input type="text" name="sut_gharpatti" id="sut_gharpatti" readonly
                                            class="form-control" value="0">
                                    </div>
                                    <div>
                                        <label for="total_amount">एकुण रक्कम</label>
                                        <input type="text" name="total_amount" id="total_amount" readonly
                                            class="form-control" value="0">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <p>आरोग्य कर</p>

                                    <div>
                                        <label for="magil_aarogya">मागील</label>
                                        <input type="text" name="magil_aarogya" id="magil_aarogya" readonly
                                            class="form-control" value="0">
                                    </div>
                                    <div>
                                        <label for="chalu_aarogya">चालु</label>
                                        <input type="text" name="chalu_aarogya" id="chalu_aarogya" readonly
                                            class="form-control" value="0">
                                    </div>

                                    <div>
                                        <label for="aarogya_total_amount">एकुण रक्कम</label>
                                        <input type="text" name="aarogya_total_amount" id="aarogya_total_amount"
                                            readonly class="form-control" value="0">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <p>दिवाबत्ती कर</p>

                                    <div>
                                        <label for="magil_divabatti">मागील</label>
                                        <input type="text" name="magil_divabatti" id="magil_divabatti" readonly
                                            class="form-control" value="0">
                                    </div>
                                    <div>
                                        <label for="chalu_divabatti">चालु</label>
                                        <input type="text" name="chalu_divabatti" id="chalu_divabatti" readonly
                                            class="form-control" value="0">
                                    </div>

                                    <div>
                                        <label for="total_amount_divabatti">एकुण रक्कम</label>
                                        <input type="text" name="total_amount_divabatti" id="total_amount_divabatti"
                                            readonly class="form-control" value="0">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <p>पाणीपट्टी</p>

                                    <div>
                                        <label for="magil_paanipatti">मागील</label>
                                        <input type="text" name="magil_paanipatti" id="magil_paanipatti" readonly
                                            class="form-control" value="0">
                                    </div>
                                    <div>
                                        <label for="chalu_paanipatti">चालु</label>
                                        <input type="text" name="chalu_paanipatti" id="chalu_paanipatti" readonly
                                            class="form-control" value="0">
                                    </div>

                                    <div>
                                        <label for="total_amount_pannipatti">एकुण रक्कम</label>
                                        <input type="text" name="total_amount_pannipatti" id="total_amount_pannipatti"
                                            readonly class="form-control" value="0">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <p>नोटीस फी/ दंड</p>

                                    <div>
                                        <!-- <label for="notis_fee">मागील</label> -->
                                        <input type="text" name="notis_fee" id="notis_fee" readonly class="form-control"
                                            value="0">
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-12 mb-3 d-flex justify-content-center  ">

                                <div class="col-md-12 mb-3 d-flex justify-content-center  ">
                                    <button type="submit" class="btn btn-primary me-2 mx-4">तपशील पहा</button>
                                    <button class="btn btn-danger">रद्द करणे</button>
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

    $(document).ready(function() {
        $("#book_number_div").hide();
        $("#pavati_number_pasun_div").hide();
        $("#pavati_number_paryant_div").hide();
        $("#vasul_date_pasun_div").hide();
        $("#vasul_date_paryant_div").hide();
        $("#malmatta_number_div").hide();
        $("#person_name_div").hide();

        $('input[name="bill_type"]').change(function() {
            if ($(this).val() === 'all_register') {
                $('#book_number_div').hide();
                $('#pavati_number_pasun_div').hide();
                $('#pavati_number_paryant_div').hide();
                $('#vasul_date_pasun_div').hide();
                $('#vasul_date_paryant_div').hide();
                $('#malmatta_number_div').hide();
                $('#person_name_div').hide();
            } else if ($(this).val() === 'book_number') {
                $('#book_number_div').show();
                $('#pavati_number_pasun_div').hide();
                $('#pavati_number_paryant_div').hide();
                $('#vasul_date_pasun_div').hide();
                $('#vasul_date_paryant_div').hide();
                $('#malmatta_number_div').hide();
                $('#person_name_div').hide();
            } else if ($(this).val() === 'vasul_dinanknusar') {
                $('#vasul_date_pasun_div').show();
                $('#vasul_date_paryant_div').show();
                $('#book_number_div').hide();
                $('#pavati_number_pasun_div').hide();
                $('#pavati_number_paryant_div').hide();
                $('#malmatta_number_div').hide();
                $('#person_name_div').hide();
            } else if ($(this).val() === 'pavati_number_nusar') {
                $('#pavati_number_pasun_div').show();
                $('#pavati_number_paryant_div').show();
                $('#vasul_date_pasun_div').hide();
                $('#vasul_date_paryant_div').hide();
                $('#book_number_div').show();
                $('#malmatta_number_div').hide();
                $('#person_name_div').hide();
            } else if ($(this).val() === 'according_to_person') {
                $('#book_number_div').hide();
                $('#pavati_number_pasun_div').hide();
                $('#pavati_number_paryant_div').hide();
                $('#vasul_date_pasun_div').hide();
                $('#vasul_date_paryant_div').hide();
                $('#malmatta_number_div').hide();
                $('#person_name_div').show();
            } else if ($(this).val() === 'malmaat_nusar') {
                $('#book_number_div').hide();
                $('#pavati_number_pasun_div').hide();
                $('#pavati_number_paryant_div').hide();
                $('#vasul_date_pasun_div').hide();
                $('#vasul_date_paryant_div').hide();
                $('#malmatta_number_div').show();
                $('#person_name_div').hide();
            } else {
                $('#book_number_div').hide();
                $('#pavati_number_pasun_div').hide();
                $('#pavati_number_paryant_div').hide();
                $('#vasul_date_pasun_div').hide();
                $('#vasul_date_paryant_div').hide();
                $('#malmatta_number_div').show();
                $('#person_name_div').hide();
            }

        });
    });
    </script>
</body>

</html>