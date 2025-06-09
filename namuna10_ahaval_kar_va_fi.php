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
$periods = $fun->getPeriodTotalPeriodsWithPeriodReason("नमुना नंबर 8 कालावधी", $_SESSION['district_code']);
if (empty($periods)) {
    $_SESSION['message'] = "कालावधी उपलब्ध नाही.";
    $_SESSION['message_type'] = "danger";

}
$financialYears = $fun->getYearArray($periods);
$wards = $fun->getWard($_SESSION['district_code']);
$karvasuli_records = $fun->getKarVasuliRecords();
$karvasuli = array();
if (mysqli_num_rows($karvasuli_records) > 0) {
    while ($karvasuli_record = mysqli_fetch_assoc($karvasuli_records)) {
        $karvasuli[] = $karvasuli_record;
    }
}

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
                                <label class="fw-bold col-md-3 text-secondary d-none">
                                    <input type="radio" name="bill_type" value="pavati_number_nusar" class="me-1"> पावती
                                    नंबर नुसार
                                </label>
                                <label class="fw-bold col-md-3 text-secondary  d-none">
                                    <input type="radio" name="bill_type" value="malmaat_nusar" class="me-1">
                                    मालमात्तेनुसार
                                </label>
                                <label class="fw-bold col-md-3 text-secondary d-none">
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
                                        <?php
                                        foreach ($karvasuli as $malmattaNumber) {
                                            echo '<option value="' . $malmattaNumber["malamatta_kramanak"] . '">' . $malmattaNumber["malamatta_kramanak"] . '</option>';
                                        }
                                        ?>
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
                                    <button type="submit" class="btn btn-primary me-2 mx-4" id="generatePdfBtn">तपशील
                                        पहा</button>
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
    <script>
    $(document).ready(function() {
        // Function to fetch and display data
        function fetchData() {
            const filterType = $('input[name="bill_type"]:checked').val();
            const financialYear = $('#financial_year').val();

            const formData = {
                filter_type: filterType,
                financial_year: financialYear
            };

            // Add additional filter data based on selected type
            switch (filterType) {
                case 'book_number':
                    formData.book_number = $('#book_number').val();
                    break;
                case 'vasul_dinanknusar':
                    formData.start_date = $('#vasul_date_pasun').val();
                    formData.end_date = $('#vasul_date_paryant').val();
                    break;
                case 'pavati_number_nusar':
                    formData.book_number = $('#book_number').val();
                    formData.start_receipt = $('#pavati_number_pasun').val();
                    formData.end_receipt = $('#pavati_number_paryant').val();
                    break;
                case 'malmaat_nusar':
                    formData.malmatta_number = $('#malmatta_number').val();
                    break;
                case 'according_to_person':
                    formData.person_name = $('#person_name').val();
                    break;
            }

            // Show loading state
            $('button[name="see_info"]').prop('disabled', true).html(
                '<i class="fas fa-spinner fa-spin"></i> लोड होत आहे...');

            $.ajax({
                url: 'api/fetch_karvasuli_records.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        populateTable(response.data);
                        calculateTotals(response.data);
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('त्रुटी: ' + error);
                },
                complete: function() {
                    $('button[name="see_info"]').prop('disabled', false).html('महिती दखवा');
                }
            });
        }

        // Function to populate the table with data
        function populateTable(data) {
            const tbody = $('table tbody');
            tbody.empty();
            if (data.length === 0) {
                tbody.append('<tr><td colspan="29">कोणतीही नोंद आढळली नाही</td></tr>');
                return;
            }

            data.forEach((record, index) => {
                const filterType = $('input[name="bill_type"]:checked').val();
                const financialYear = $('#financial_year').val();
                const row = `
                <tr>
                    <td>${index + 1}</td>
                    <td>${record.financial_year || ''}</td>
                    <td>${record.malamatta_kramanak || ''}</td>
                    <td>${record.kar_denaryache_nav || ''}</td>
                    <td>${record.pustak_kramanak || ''}</td>
                    <td>${record.pavati_kramanak || ''}</td>
                    <td>${record.vasul_dinank || ''}</td>
                    <td>${record.previous_vasul_building_tax || '0.00'}</td>
                    <td>${record.current_vasul_building_tax || '0.00'}</td>
                    <td>${(parseFloat(record.previous_vasul_building_tax || 0) + parseFloat(record.current_vasul_building_tax || 0)).toFixed(2)}</td>
                    <td>${record.previous_vasul_health_tax || '0.00'}</td>
                    <td>${record.current_vasul_health_tax || '0.00'}</td>
                    <td>${(parseFloat(record.previous_vasul_health_tax || 0) + parseFloat(record.current_vasul_health_tax || 0)).toFixed(2)}</td>
                    <td>${record.previous_vasul_divabatti_tax || '0.00'}</td>
                    <td>${record.current_vasul_divabatti_tax || '0.00'}</td>
                    <td>${(parseFloat(record.previous_vasul_divabatti_tax || 0) + parseFloat(record.current_vasul_divabatti_tax || 0)).toFixed(2)}</td>
                    <td>${record.previous_vasul_padsar_tax || '0.00'}</td>
                    <td>${record.current_vasul_padsar_tax || '0.00'}</td>
                    <td>${(parseFloat(record.previous_vasul_padsar_tax || 0) + parseFloat(record.current_vasul_padsar_tax || 0)).toFixed(2)}</td>
                    <td>${record.previous_vasul_panniyojana_tax || '0.00'}</td>
                    <td>${record.current_vasul_panniyojana_tax || '0.00'}</td>
                    <td>${(parseFloat(record.previous_vasul_panniyojana_tax || 0) + parseFloat(record.current_vasul_panniyojana_tax || 0)).toFixed(2)}</td>
                    <td>${record.total_notice_fee || '0.00'}</td>
                    <td>${record.total_dand_tax || '0.00'}</td>
                    <td>${record.total_amount || '0.00'}</td>
                    <td>${getPaymentTypeText(record.payment_type)}</td>
                    <td><button type="button" class="btn btn-sm btn-primary print-receipt" data-id="${record.id}">पावती</button></td>
                    <td><button class="btn btn-sm btn-info reprint-receipt" data-id="${record.id}">पावती काढणे</button></td>
                    <td><button class="btn btn-sm btn-danger cancel-receipt" data-id="${record.id}">पावती रद्द करणे</button></td>
                </tr>
            `;
                tbody.append(row);
            });
        }

        // Function to calculate and display totals
        function calculateTotals(data) {
            let magilGharpatti = 0;
            let chaluGharpatti = 0;
            let sutGharpatti = 0;
            let magilAarogya = 0;
            let chaluAarogya = 0;
            let magilDivabatti = 0;
            let chaluDivabatti = 0;
            let magilPaanipatti = 0;
            let chaluPaanipatti = 0;
            let notisFee = 0;

            data.forEach(record => {
                magilGharpatti += parseFloat(record.previous_vasul_building_tax || 0);
                chaluGharpatti += parseFloat(record.current_vasul_building_tax || 0);
                sutGharpatti += parseFloat(record.current_vasul_sut_tax || 0);
                magilAarogya += parseFloat(record.previous_vasul_health_tax || 0);
                chaluAarogya += parseFloat(record.current_vasul_health_tax || 0);
                magilDivabatti += parseFloat(record.previous_vasul_divabatti_tax || 0);
                chaluDivabatti += parseFloat(record.current_vasul_divabatti_tax || 0);
                magilPaanipatti += parseFloat(record.previous_vasul_panniyojana_tax || 0);
                chaluPaanipatti += parseFloat(record.current_vasul_panniyojana_tax || 0);
                notisFee += parseFloat(record.total_dand_tax || 0);
            });

            // Update the summary fields
            $('#magil_gharpatti').val(magilGharpatti.toFixed(2));
            $('#chalu_gharpatti').val(chaluGharpatti.toFixed(2));
            $('#sut_gharpatti').val(sutGharpatti.toFixed(2));
            $('#total_amount').val((magilGharpatti + chaluGharpatti - sutGharpatti).toFixed(2));

            $('#magil_aarogya').val(magilAarogya.toFixed(2));
            $('#chalu_aarogya').val(chaluAarogya.toFixed(2));
            $('#aarogya_total_amount').val((magilAarogya + chaluAarogya).toFixed(2));

            $('#magil_divabatti').val(magilDivabatti.toFixed(2));
            $('#chalu_divabatti').val(chaluDivabatti.toFixed(2));
            $('#total_amount_divabatti').val((magilDivabatti + chaluDivabatti).toFixed(2));

            $('#magil_paanipatti').val(magilPaanipatti.toFixed(2));
            $('#chalu_paanipatti').val(chaluPaanipatti.toFixed(2));
            $('#total_amount_pannipatti').val((magilPaanipatti + chaluPaanipatti).toFixed(2));

            $('#notis_fee').val(notisFee.toFixed(2));
        }

        // Helper function to get payment type text
        function getPaymentTypeText(type) {
            const types = {
                'cash': 'रोख',
                'cheque': 'चेक',
                'neft': 'NEFT',
                'rtgs': 'RTGS',
                'card': 'कार्ड'
            };
            return types[type] || type;
        }

        // Handle form submission
        $('form').submit(function(e) {
            e.preventDefault();
            fetchData();
        });

        // Load book numbers when financial year changes
        $('#financial_year').change(function() {
            const year = $(this).val();
            if (year) {
                $.ajax({
                    url: 'api/get_book_numbers.php',
                    type: 'POST',
                    data: {
                        financial_year: year
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            const select = $('#book_number');
                            select.empty().append('<option value="">--निवडा--</option>');
                            response.data.forEach(book => {
                                console.log(book);
                                select.append(
                                    `<option value="${book.pustak_kramanak}">${book.pustak_kramanak}</option>`
                                );
                            });
                        }
                    }
                });

                // Also load malmatta numbers and person names
                loadMalmattaNumbers(year);
                loadPersonNames(year);
            }
        });

        // Function to load malmatta numbers
        function loadMalmattaNumbers(year) {
            $.ajax({
                url: 'api/get_malmatta_numbers.php',
                type: 'POST',
                data: {
                    financial_year: year
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        const select = $('#malmatta_number');
                        select.empty().append('<option value="">--निवडा--</option>');
                        response.data.forEach(malmatta => {
                            select.append(
                                `<option value="${malmatta.id}">${malmatta.number}</option>`
                            );
                        });
                    }
                }
            });
        }

        // Function to load person names
        function loadPersonNames(year) {
            $.ajax({
                url: 'api/get_person_names.php',
                type: 'POST',
                data: {
                    financial_year: year
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        const select = $('#person_name');
                        select.empty().append('<option value="">--निवडा--</option>');
                        response.data.forEach(person => {
                            select.append(`<option value="${person}">${person}</option>`);
                        });
                    }
                }
            });
        }

        // Load receipt numbers when book number changes
        $('#book_number').change(function() {
            const bookNumber = $(this).val();
            if (bookNumber) {
                $.ajax({
                    url: 'api/get_receipt_numbers.php',
                    type: 'POST',
                    data: {
                        book_number: bookNumber
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            const startSelect = $('#pavati_number_pasun');
                            const endSelect = $('#pavati_number_paryant');

                            startSelect.empty().append(
                                '<option value="">--निवडा--</option>');
                            endSelect.empty().append('<option value="">--निवडा--</option>');

                            response.data.forEach(receipt => {


                                startSelect.append(
                                    `<option value="${receipt}">${receipt}</option>`
                                );
                                endSelect.append(
                                    `<option value="${receipt}">${receipt}</option>`
                                );
                            });
                        }
                    }
                });
            }
        });

        // Handle receipt print buttons
        $(document).on('click', '.print-receipt', function() {
            const recordId = $(this).data('id');
            window.open(
                `pdf/individual_pavati_namuna10.php?id=${recordId}`,
                '_blank');
        });

        $(document).on('click', '.reprint-receipt', function() {
            const recordId = $(this).data('id');
            window.open(`pdf/individual_pavati_namuna10.php?id=${recordId}`, '_blank');
        });

        $(document).on('click', '.cancel-receipt', function() {
            const recordId = $(this).data('id');
            if (confirm('तुम्हाला ही पावती रद्द करायची आहे का?')) {
                $.ajax({
                    url: 'api/cancel_receipt.php',
                    type: 'POST',
                    data: {
                        id: recordId
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert('पावती यशस्वीरित्या रद्द केली गेली आहे');
                            fetchData(); // Refresh data
                        } else {
                            alert(response.message);
                        }
                    }
                });
            }
        });
    });

    // Add this to your existing script
    $(document).on('click', '#generatePdfBtn', async function() {
        const financialYear = $('#financial_year').val();
        const filterType = $('input[name="bill_type"]:checked').val();

        // Validate required fields
        if (!financialYear) {
            alert('कृपया आर्थिक वर्ष निवडा');
            return;
        }

        // Construct URL with parameters
        let url = `pdf/namuna_10_pavti.php?financial_year=${financialYear}&filter_type=${filterType}`;

        // Add additional filter parameters based on selected type
        switch (filterType) {
            case 'book_number':
                const bookNumber = $('#book_number').val();
                if (bookNumber) url += `&book_number=${bookNumber}`;
                break;

            case 'vasul_dinanknusar':
                const startDate = $('#vasul_date_pasun').val();
                const endDate = $('#vasul_date_paryant').val();
                if (startDate) url += `&start_date=${startDate}`;
                if (endDate) url += `&end_date=${endDate}`;
                break;

            case 'pavati_number_nusar':
                const bookNum = $('#book_number').val();
                const startReceipt = $('#pavati_number_pasun').val();
                const endReceipt = $('#pavati_number_paryant').val();
                if (bookNum) url += `&book_number=${bookNum}`;
                if (startReceipt) url += `&start_receipt=${startReceipt}`;
                if (endReceipt) url += `&end_receipt=${endReceipt}`;
                break;

            case 'malmaat_nusar':
                const malmattaNumber = $('#malmatta_number').val();
                if (malmattaNumber) url += `&malmatta_number=${malmattaNumber}`;
                break;

            case 'according_to_person':
                const personName = $('#person_name').val();
                if (personName) url += `&person_name=${encodeURIComponent(personName)}`;
                break;
        }

        const res = await fetch(
            url, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            });
        const html = await res.text();
        const printWindow = window.open('', '_blank');
        printWindow.document.open();
        printWindow.document.write(`
            <html>
            <head>
            <title>नमुना 10</title>
            <style>
        body {
            font-family: 'Mangal', 'Noto Sans Devanagari', 'Arial', sans-serif;
            margin: 20px;
            color: #000;
        }

        h1,
        h2,
        h3 {
            text-align: center;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px 6px;
            text-align: center;
        }

        th {
            background-color: #f0f0f0;
        }

        .header-note {
            text-align: center;
            margin-top: 10px;
            font-weight: bold;
        }

        @media print {
            @page {
                size: landscape;
            }
        }
        </style>
            </head>
            <body onload="window.print()">
            ${html}
            </body>
            </html>
    `);
        printWindow.document.close();
    });
    </script>
</body>

</html>