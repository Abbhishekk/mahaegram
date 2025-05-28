<?php 
    require_once './include/auth_middleware.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php 
$title = "नमुना १० पावती काढणे";
?>
<?php include('include/header.php'); ?>
<?php
    $newName = $fun->getNewName();
    $periods = $fun->getPeriodDetails($_SESSION['district_code']);
    $banks = $fun->getBanks();
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
                             <h1 class="h3 mb-0 text-gray-800">नमुना १० पावती काढणे</h1>
                             <ol class="breadcrumb">
                                 <li class="breadcrumb-item"><a href="./">माहईग्राम</a></li>
                                 <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 10</li>
                                 <li class="breadcrumb-item active" aria-current="page">मास्टर्स</li>
                                 <li class="breadcrumb-item active" aria-current="page">नमुना १० पावती काढणे</li>
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
    <h5 class="fw-bold text-secondary mb-3">पावती काढणे</h5>
    <form action="api/jama_pavati_kadhane.php" method="POST">
        <div class="row mb-3">
            <div class="col-md-3">
                <label class="form-label fw-bold" for="book_number" >बुक नंबर <span class="text-danger">*</span></label>
                <select class="form-control form-select border-primary" name="book_number" id="book_number">
                    <option>--निवडा--</option>
                    <option value="1">1</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold" for="receipt_number">पावती नंबर <span class="text-danger">*</span></label>
                <select class="form-control form-select border-primary" name="receipt_number" id="receipt_number">
                    <option>--निवडा--</option>
                    <option value="1">1</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold" for="collection_date">वसुल दिनांक <span class="text-danger">*</span></label>
                <input type="date" class="form-control border-primary" name="collection_date" id="collection_date" value="2025-05-23">
            </div>
        </div>
    
        <div class="row mb-3">
            <div class="col-md-3">
                <label class="form-label fw-bold" for="owner_name">मिळकत धारकाचे नाव</label>
                <input type="text" name="owner_name" id="owner_name" class="form-control border-primary">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold" for="amount">वसूल रक्कम</label>
                <input type="text" name="amount" id="amount" class="form-control border-primary">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold" for="property_number">मिळकत क्रमांक</label>
                <input type="text" name="property_number" id="property_number" class="form-control border-primary">
            </div>
        </div>
    
        <div class="row mb-3">
            <div class="col-md-3">
                <label class="form-label fw-bold" for="bank_name" >बँकेचे नाव <span class="text-danger">*</span></label>
                <select class="form-control form-select border-primary" name="bank_name" id="bank_name">
                    <option>--निवडा--</option>
                    <?php
                        if ($banks && count($banks) > 0) {
                            // print_r($banks);
                            foreach ($banks["data"] as $bank) {
                                
                                echo '<option value="'.$bank['id'].'">'.$bank['bank_name'].'</option>';
                            }
                        } else {
                            echo '<option>कोणतीही बँक सापडली नाही</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold" for="check_number">चेक क्रमांक</label>
                <input type="text" name="check_number" id="check_number" class="form-control border-primary">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold" for="check_date">दिनांक <span class="text-danger">*</span></label>
                <input type="date" name="check_date" id="check_date" class="form-control border-primary" value="2025-05-23">
            </div>
        </div>
    
        <div class="row mb-3">
            <div class="col-md-12 text-center">
                <button class="btn btn-primary me-2">काढणे</button>
                <button class="btn btn-secondary">रद्द करणे</button>
            </div>
        </div>

    </form>

    <div class="table-responsive">
    <table class="table table-bordered table-hover table-striped" id="receiptTable">
        <thead class="table-primary">
            <tr>
                <th width="5%" class="text-center">अ.क्र.</th>
                <th width="15%" class="text-center">बुक नंबर</th>
                <th width="15%" class="text-center">पावती नंबर</th>
                <th width="20%" class="text-center">मिळकत धारक</th>
                <th width="15%" class="text-center">रक्कम</th>
                <th width="15%" class="text-center">दिनांक</th>
                <th width="15%" class="text-center">क्रिया</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $receipts = $fun->getAllJamaPavatiKadhane();
            if ($receipts && mysqli_num_rows($receipts) > 0) {
                $counter = 1;
                while ($receipt = mysqli_fetch_assoc($receipts)) {
                    echo '<tr>
                        <td class="text-center">'.$counter.'</td>
                        <td class="text-center">'.$receipt['book_number'].'</td>
                        <td class="text-center">'.$receipt['receipt_number'].'</td>
                        <td>'.$receipt['owner_name'].'</td>
                        <td class="text-end">₹ '.number_format($receipt['collected_amount'], 2).'</td>
                        <td class="text-center">'.date('d/m/Y', strtotime($receipt['collection_date'])).'</td>
                        <td class="text-center">
    <div class="btn-group btn-group-sm" role="group">
        <button class="btn btn-info btn-view" data-id="'.$receipt['id'].'" title="पहा">
            <i class="fas fa-eye"></i>
        </button>
        <button class="btn btn-warning btn-edit" data-id="'.$receipt['id'].'" title="सुधारा">
            <i class="fas fa-edit"></i>
        </button>
        <button class="btn btn-danger btn-delete" data-id="'.$receipt['id'].'" title="हटवा">
            <i class="fas fa-trash"></i>
        </button>
        <button class="btn btn-success btn-print" data-id="'.$receipt['id'].'" title="प्रिंट">
            <i class="fas fa-print"></i>
        </button>
    </div>
</td>
                    </tr>';
                    $counter++;
                }
            } else {
                echo '<tr>
                    <td colspan="7" class="text-center">कोणतीही पावती सापडली नाही</td>
                </tr>';
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-end">एकूण:</th>
                <th class="text-end">₹ <?php 
                    $total = $fun->getJamaPavatiKadhaneTotal($_SESSION['panchayat_code']);
                    echo number_format($total, 2);
                ?></th>
                <th colspan="2"></th>
            </tr>
        </tfoot>
    </table>
</div>

<div class="modal fade" id="viewReceiptModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">पावती तपशील</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="receiptDetails">
                <!-- Details will be loaded via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">बंद करा</button>
                <button type="button" class="btn btn-primary" id="printReceiptBtn">प्रिंट करा</button>
            </div>
        </div>
    </div>
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
<script>
$(document).ready(function() {
    // Initialize DataTable with Marathi language
    $('#receiptTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Marathi.json'
        },
        dom: '<"top"Bf>rt<"bottom"lip><"clear">',
        buttons: [
            {
                extend: 'excel',
                text: 'एक्सेल निर्यात',
                className: 'btn btn-success btn-sm',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                }
            },
            {
                extend: 'pdf',
                text: 'PDF निर्यात',
                className: 'btn btn-danger btn-sm',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                }
            },
            {
                extend: 'print',
                text: 'प्रिंट',
                className: 'btn btn-info btn-sm',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                }
            }
        ],
        columnDefs: [
            { orderable: false, targets: [6] }
        ],
        order: [[5, 'desc']]
    });

    // View receipt details
    $(document).on('click', '.btn-view', function() {
        const receiptId = $(this).data('id');
        $.ajax({
            url: 'api/get_receipt_details.php',
            type: 'GET',
            data: { id: receiptId },
            success: function(response) {
                $('#receiptDetails').html(response);
                $('#viewReceiptModal').modal('show');
            },
            error: function(xhr) {
                alert('Error loading receipt details');
            }
        });
    });

    // Edit button handler
    $(document).on('click', '.btn-edit', function() {
        const receiptId = $(this).data('id');
        // Redirect to edit page or load data into form
        window.location.href = 'edit_receipt.php?id=' + receiptId;
    });

    // Delete button handler
    $(document).on('click', '.btn-delete', function() {
        if(confirm('तुम्हाला ही पावती खरोखर हटवायची आहे?')) {
            const receiptId = $(this).data('id');
            $.ajax({
                url: 'api/delete_receipt.php',
                type: 'POST',
                data: { id: receiptId },
                success: function(response) {
                    if(response.success) {
                        location.reload();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr) {
                    alert('Delete request failed');
                }
            });
        }
    });

    // Print button handler
    $(document).on('click', '.btn-print', function() {
        const receiptId = $(this).data('id');
        window.open('print_receipt.php?id=' + receiptId, '_blank');
    });
});
</script>
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
    <script>
document.addEventListener("DOMContentLoaded", function() {
    // Set today's date as default for collection and check dates
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('collection_date').value = today;
    document.getElementById('check_date').value = today;
    
    // Amount validation - allow only numbers
    document.getElementById('amount').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');
    });
    
    // Fetch book numbers from server (example)
    fetchBookNumbers();
});

function fetchBookNumbers() {
    // AJAX call to get book numbers
    fetch('api/get_books.php')
        .then(response => response.json())
        .then(data => {
            const bookSelect = document.getElementById('book_number');
            bookSelect.innerHTML = '<option value="">--निवडा--</option>';
            
            data.forEach(book => {
                const option = document.createElement('option');
                option.value = book.id;
                option.textContent = book.book_number;
                bookSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error:', error));
}

// Function to fetch receipt numbers based on selected book
document.getElementById('book_number').addEventListener('change', function() {
    const bookId = this.value;
    if (bookId) {
        fetch(`api/get_receipts.php?book_id=${bookId}`)
            .then(response => response.json())
            .then(data => {
                const receiptSelect = document.getElementById('receipt_number');
                receiptSelect.innerHTML = '<option value="">--निवडा--</option>';
                
                data.forEach(receipt => {
                    const option = document.createElement('option');
                    option.value = receipt.id;
                    option.textContent = receipt.receipt_number;
                    receiptSelect.appendChild(option);
                });
            });
    }
});

// Function to fetch bank names
function fetchBankNames() {
    fetch('api/get_banks.php')
        .then(response => response.json())
        .then(data => {
            const bankSelect = document.getElementById('bank_name');
            bankSelect.innerHTML = '<option value="">--निवडा--</option>';
            
            data.forEach(bank => {
                const option = document.createElement('option');
                option.value = bank.id;
                option.textContent = bank.bank_name;
                bankSelect.appendChild(option);
            });
        });
}
</script>
</body>

</html>