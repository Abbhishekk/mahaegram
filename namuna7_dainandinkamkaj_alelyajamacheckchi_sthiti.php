<?php 
    require_once './include/auth_middleware.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php 
$title = "आलेल्या (जमा) चेकची स्थिती";
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

?>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php 
        $page = 'namuna7';
        $subpage = 'dainandin';
       
       ?>
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <?php include('include/topbar.php'); 
                 include('include/sidebar.php');?>
                <!-- Topbar -->

                <!-- Container Fluid-->
                <div class="container-fluid border rounded p-3">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">आलेल्या (जमा) चेकची स्थिती</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">पंचायत पोर्टल</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 7</li>
                            <li class="breadcrumb-item active" aria-current="page">दैनंदिन कामकाज
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">आलेल्या (जमा) चेकची स्थिती</li>
                        </ol>
                    </div>
                    <!-- <h5 class="fw-bold text-secondary mb-3">आलेल्या (जमा) चेकची स्थिती</h5> -->
                    <form action="api/jamacheckchi_sthiti.php" method="POST" id="checkStatusForm">
                        <div class="card px-5 py-3">
                            <div class="row mb-3">
                                <div class="col-md-3 my-2">
                                    <label class="form-label fw-bold">आर्थिक वर्ष :</label>
                                    <select class="form-control border-primary" name="financial_year"
                                        id="financial_year">
                                        <option value=""> --निवडा-- </option>
                                        <?php foreach ($financialYears as $year): ?>
                                        <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3 my-2">
                                    <label class="form-label fw-bold" for="plan_name">फंडाचे नाव <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" name="plan_name" id="plan_name" required>
                                        <option value="">--निवडा--</option>
                                        <option value="ग्रामनिधी">ग्रामनिधी</option>
                                        <option value="ग्राम पाणीपुरवठा निधी">ग्राम पाणीपुरवठा निधी</option>
                                    </select>
                                </div>
                                <div class="col-md-3 my-2">
                                    <label class="form-label fw-bold">दिनांक :</label>
                                    <input type="date" class="form-control border-primary" name="date" id="date">
                                </div>
                                <div class="col-md-3 my-2">
                                    <label class="form-label fw-bold">चेक क्रमांक <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control form-select border-primary" name="check_number"
                                        id="check_number">
                                        <option>निवडा</option>
                                        <?php
                                            $cheques = $fun->getCheckbooks($_SESSION['district_code']);
                                            if(mysqli_num_rows($cheques) > 0) {
                                                while($row = mysqli_fetch_assoc($cheques)) {
                                                    echo "<option value='{$row['id']}'>{$row['checkbook_no']}</option>";
                                                }
                                            } else {
                                                echo "<option value=''>No Cheques Available</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-3 my-2">
                                    <label class="form-label fw-bold">चेक मिळालेली दिनांक :</label>
                                    <input type="date" class="form-control border-primary" name="check_received_date"
                                        id="check_received_date" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3 my-2">
                                    <label class="form-label fw-bold">बँक नाव</label>
                                    <input type="text" class="form-control border-primary" name="bank_name"
                                        id="bank_name" placeholder="बँक नाव" readonly>
                                </div>
                                <div class="col-md-3 my-2">
                                    <label class="form-label fw-bold">चेकची रक्कम</label>
                                    <input type="text" class="form-control border-primary" name="check_amount"
                                        id="check_amount" placeholder="चेकची रक्कम">
                                </div>
                                <div class="col-md-3 my-2">
                                    <label class="form-label fw-bold">चेक जमा केलेल्या बँकेचे नाव <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control form-select border-primary" name="bank_deposited"
                                        id="bank_deposited">
                                        <option>--निवडा--</option>
                                        <?php
                                            $banks = $fun->getBanks();
                                            if($banks["success"]) {
                                                foreach($banks["data"] as $row) {
                                                    
                                                    echo "<option value='{$row['id']}'>{$row['bank_name']}</option>";
                                                }
                                            } else {
                                                echo "<option value=''>No Banks Available</option>";
                                            }
                                            ?>
                                    </select>
                                </div>
                                <div class="col-md-3 my-2">
                                    <label class="form-label fw-bold">चेक स्थिती <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control form-select border-primary" name="check_status"
                                        id="check_status">
                                        <option>निवडा</option>
                                        <option value="जमा">जमा</option>
                                        <option value="रद्द">रद्द</option>
                                    </select>
                                </div>
                                <div class="col-md-3 my-2">
                                    <label class="form-label fw-bold">मिळलेली दिनांक :</label>
                                    <input type="date" class="form-control border-primary" name="received_date"
                                        id="received_date">
                                </div>
                                <div class="col-md-3 my-2">
                                    <label class="form-label" for="pustak_kramanak">पुस्तक क्रमांक: <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" name="pustak_kramanak" id="pustak_kramanak" required>
                                        <option value="">--निवडा--</option>
                                        <!-- Will be populated by JavaScript -->
                                    </select>
                                </div>

                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3 my-2">
                                    <label class="form-label" for="pavati_kramanak">पावती क्रमांक:</label>
                                    <select class="form-control" name="pavati_kramanak" id="pavati_kramanak" required>
                                        <option value="">--प्रथम पुस्तक निवडा--</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">पावती रद्द कारण <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control border-primary" name="reason" id="reason"
                                        placeholder="पावती रद्द कारण">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="d-grid gap-2 col-6 mx-auto">
                                    <button class="btn btn-primary" type="submit">साठवा</button>
                                    <button class="btn btn-secondary" type="reset">रद्द करणे</button>
                                </div>
                            </div>


                        </div>
                    </form>
                </div>
                <div class=" px-5 py-3 container-fluid">
                    <div class="table-responsive card">
                        <table class="table table-bordered">
                            <thead class="table-primary text-center">
                                <tr>
                                    <th>अ क्रं</th>
                                    <th>आर्थिक वर्ष</th>
                                    <th>चेक मिळालेचा दिनांक</th>
                                    <th>खात्यात</th>
                                    <th>बँक नाव</th>
                                    <th>चेक क्रमांक</th>
                                    <th>चेक स्थिती</th>
                                    <th>चेकची रक्कम</th>
                                    <th>चेक जमा केलेल्या बँकेचे नाव</th>
                                    <th>बदल</th>
                                    <th>पावती</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $checkStatusRecords = $fun->getCheckStatus();
                                    if(mysqli_num_rows($checkStatusRecords) > 0) {
                                        $i = 1;
                                        while($row = mysqli_fetch_assoc($checkStatusRecords)) {
                                            echo "<tr>";
                                            echo "<td>{$i}</td>";
                                            echo "<td>{$row['financial_year']}</td>";
                                            echo "<td>{$row['date']}</td>";
                                            echo "<td>{$row['check_received_date']}</td>";
                                            echo "<td>{$row['bank_name']}</td>";
                                            echo "<td>{$row['checkbook_no']}</td>";
                                            echo "<td>{$row['check_status']}</td>";
                                            echo "<td>" . number_format($row['check_amount'], 2) . "</td>";
                                            echo "<td>{$row['bank_deposited_name']}</td>";
                                            echo "<td><a href='edit_check_status.php?id={$row['id']}' class='btn btn-warning'>बदल</a></td>";
                                            echo "<td><a href='pavati.php?id={$row['id']}' class='btn btn-info'>पावती</a></td>";
                                            echo "</tr>";
                                            $i++;
                                        }
                                    } else {
                                        echo "<tr><td colspan='11' class='text-center'>कोणतेही रेकॉर्ड नाही</td></tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
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
    $(document).ready(function() {
        // Function to populate book and receipt dropdowns
        function populateBookReceiptDropdowns() {
            $.ajax({
                url: 'api/get_book_receipt_numbers.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        // Populate pustak_kramanak (x values)
                        $('#pustak_kramanak').empty();
                        $('#pustak_kramanak').append('<option value="">--निवडा--</option>');
                        data.books.forEach(function(book) {
                            $('#pustak_kramanak').append('<option value="' + book.x + '">' +
                                book.x + '</option>');
                        });

                        // When pustak_kramanak changes, populate pavati_kramanak (y values)
                        $('#pustak_kramanak').change(function() {
                            var selectedX = $(this).val();
                            $('#pavati_kramanak').empty();
                            $('#pavati_kramanak').append(
                                '<option value="">--निवडा--</option>');

                            if (selectedX) {
                                console.log(selectedX);

                                var selectedBook = data.books.find(book => book.x ==
                                    selectedX);
                                console.log(selectedBook);
                                if (selectedBook) {
                                    for (let y = 1; y <= selectedBook.max_y; y++) {
                                        $('#pavati_kramanak').append('<option value="' + y +
                                            '">' + y + '</option>');
                                    }
                                }
                            }
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: " + status + " - " + error);
                }
            });
        }

        // Call the function on page load
        populateBookReceiptDropdowns();
    });
    $(document).ready(function() {
        // When check_number is selected
        $('#check_number').change(function() {
            const checkbookId = $(this).val();
            if (!checkbookId) return;

            // Fetch checkbook details
            $.ajax({
                url: 'api/getCheckbookDetails.php',
                type: 'POST',
                data: {
                    checkbook_id: checkbookId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        const checkbook = response.data;
                        console.log('Checkbook Details:', checkbook);

                        // Populate fields with checkbook details
                        $('#check_received_date').val(checkbook.date || '');
                        $('#bank_name').val(checkbook.bank_name || '');

                        // You can populate other fields as needed
                    } else {
                        alert(response.message || 'Error fetching checkbook details');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    alert('An error occurred while fetching checkbook details');
                }
            });
        });

        // Form submission handler
        $('#checkStatusForm').on('submit', function(e) {
            e.preventDefault();

            // Validate form
            if (!$('#financial_year').val() || !$('#plan_name').val() || !$('#check_number').val()) {
                alert('Please fill all required fields');
                return;
            }

            // Submit form via AJAX
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert('Check status saved successfully');
                        // Refresh the table or redirect
                        location.reload();
                    } else {
                        alert(response.message || 'Error saving check status');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    alert('An error occurred while saving data');
                }
            });
        });

        // Populate book and receipt dropdowns (existing code)
        populateBookReceiptDropdowns();
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