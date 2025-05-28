<?php 
    require_once './include/auth_middleware.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php 
$title = "नमूना क्र १० पावती";
?>
<?php include('include/header.php'); ?>
<?php
    $newName = $fun->getNewName();
    $periods = $fun->getPeriodDetails($_SESSION['district_code']);
    $malmatta_details = $fun->getMalmattNumbers();
?>
 <style>
       
        .section-title {
            font-weight: bold;
            margin-top: 20px;
            color: blue;
        }
        .table td, .table th {
            vertical-align: middle;
            text-align: center;
        }
        .highlight {
            background-color: #66ff66;
        }
    </style>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php 
        $page = 'namuna10';
        $subpage = 'yearlyWork';
        include('include/sidebar.php');
       ?>
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <?php include('include/topbar.php'); ?>
                <!-- Topbar -->

                <!-- Container Fluid-->
                <div class="container-fluid mt-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5>नमूना क्र १० पावती</h5>
      <nav><a href="#">Home</a> / नमूना क्र १० पावती</nav>
    </div>

    <!-- Info -->
    <div class="alert alert-primary" role="alert">
      टीप: महाराष्ट्र ग्रामपंचायत कर फी (शुल्क) नियम १९९५ व नियम २० (२) अनुसार सूट सुविधा लागू करण्यात आली आहे. महाराष्ट्र ग्रामपंचायत कर फी (शुल्क) नियम २०(३) अनुसार दंड आकारण्यात आला आहे.
    </div>
      <div class="alert alert-danger" role="alert" id="not_available" >
        वसूल करण्यासाठी रक्कम उपलब्ध नाही !
      </div>
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
    <!-- Form -->
     <form action="api/karvasuli_save.php" method="post">

       <div class="form-section card px-4 py-5 my-5">
         <div class="row g-3">
           <div class="col-md-3 my-2">
             <label class="form-label" for="malamatta_kramanak">मालमत्ता क्रमांक: <span class="text-danger">*</span></label>
             <select class="form-control" name="malamatta_kramanak" id="malamatta_kramanak">
               <option>--निवडा--</option>
               <?php foreach ($malmatta_details as $malmatta) { ?>
                 <option value="<?php echo $malmatta['id']; ?>">
                   <?php echo $malmatta['malmatta_no']; ?>
                 </option>
                 <?php } ?>
           </select>
           </div>
           <div class="col-md-3 my-2 d-none">
             <label class="form-label">शोधा</label><br>
             <button class="btn btn-primary">शोधा</button>
           </div>
           <div class="col-md-3 my-2">
             <label class="form-label" for="ward_kramanak">वॉर्ड क्रं:</label>
             <input type="text" class="form-control" name="ward_kramanak" id="ward_kramanak" placeholder="वॉर्ड क्रं">
           </div>
           <div class="col-md-3 my-2">
             <label class="form-label" for="kar_denaryache_nav" >कर देणाऱ्याचे नाव:</label>
             <select class="form-control" name="kar_denaryache_nav" id="kar_denaryache_nav">
               <option value=""> --निवडा-- </option>
             </select>
           </div>
           <div class="col-md-3 my-2">
             <label class="form-label" for="vasul_dinank" >वसूल दिनांक: <span class="text-danger">*</span></label>
             <input type="date" class="form-control" name="vasul_dinank" id="vasul_dinank" >
           </div>
           <div class="col-md-3 my-2">
       <label class="form-label" for="pustak_kramanak">पुस्तक क्रमांक: <span class="text-danger">*</span></label>
       <select class="form-control" name="pustak_kramanak" id="pustak_kramanak" required>
           <option value="">--निवडा--</option>
           <!-- Will be populated by JavaScript -->
       </select>
   </div>
   <div class="col-md-3 my-2">
       <label class="form-label" for="pavati_kramanak">पावती क्रमांक:</label>
       <select class="form-control" name="pavati_kramanak" id="pavati_kramanak" required>
           <option value="">--प्रथम पुस्तक निवडा--</option>
       </select>
   </div>
         </div>
           <div class="row my-5 justify-content-center " >
             <div class="custom-control custom-radio mt-3 col-md-3">
               <input class="custom-control-input" type="radio" name="full" id="fullItem">
               <label class="custom-control-label" for="fullItem">संपूर्ण वस्तू</label>
             </div>
             <div class="custom-control custom-radio col-md-3">
               <input class="custom-control-input" type="radio" name="full" id="fullDemand">
               <label class="custom-control-label" for="fullDemand">संपूर्ण मागणी कर</label>
             </div>
             <div class="custom-control custom-radio col-md-3">
               <input class="custom-control-input" type="radio" name="full" id="fullCurrent">
               <label class="custom-control-label" for="fullCurrent">संपूर्ण चालू कर</label>
             </div>
           </div>
       </div>
   
       <!-- Tax Breakdown -->
        <div class="card px-4 py-5" >
          <div class="row  py-2 ">
            <div class="col-md-2">
              <ul class="list-group">
                <li class="list-group-item active text-center">कराचे तपशील</li>
                <li class="list-group-item">इमारत कर</li>
                <li class="list-group-item">आरोग्य कर</li>
                <li class="list-group-item">दिवाबत्ती कर</li>
                <li class="list-group-item">पाणियोजना कर</li>
                <li class="list-group-item">फडसर/खुळी व इतर कर</li>
                <li class="list-group-item">दंड/नोटीस फी</li>
                <li class="list-group-item">सूट</li>
                <li class="list-group-item">एकूण</li>
              </ul>
            </div>
      
            <!-- Input columns -->
            <div class="col-md-5">
              <div class="row g-2">
                <div class="col">
                  <label>मागील मागणी कर</label>
                  <input type="text" name="previous_mangani_building_tax" id="previous_mangani_building_tax" class="form-control my-2"  value="000">
                  <input type="text" class="form-control my-2" name="previous_mangani_health_tax" id="previous_mangani_health_tax"  value="0.00">
                  <input type="text" class="form-control my-2" name="previous_mangani_divabatti_tax" id="previous_mangani_divabatti_tax"  value="0.00">
                  <input type="text" class="form-control my-2" name="previous_mangani_panniyojana_tax" id="previous_mangani_panniyojana_tax"  value="0.00">
                  <input type="text" class="form-control my-2" name="previous_mangani_padsar_tax" id="previous_mangani_padsar_tax"  value="0.00">
                  <input type="text" class="form-control my-2" name="previous_mangani_dand_tax" id="previous_mangani_dand_tax"  value="0.00">
                  <input type="text" class="form-control my-2 highlight-green" name="previous_mangani_sut_tax" id="previous_mangani_sut_tax"  value="0.00">
                  <input type="text" class="form-control my-2" name="previous_mangani_total_tax" id="previous_mangani_total_tax" readonly  value="0.00">
                </div>
                <div class="col">
                  <label>चालू मागणी कर</label>
                  <input type="text" class="form-control my-2" name="current_mangani_building_tax" id="current_mangani_building_tax" readonly value="0.00">
                  <input type="text" class="form-control my-2" name="current_mangani_health_tax" id="current_mangani_health_tax" readonly value="0.00">
                  <input type="text" class="form-control my-2" name="current_mangani_divabatti_tax" id="current_mangani_divabatti_tax" readonly value="0.00">
                  <input type="text" class="form-control my-2" name="current_mangani_panniyojana_tax" id="current_mangani_panniyojana_tax" readonly value="0.00">
                  <input type="text" class="form-control my-2" name="current_mangani_padsar_tax" id="current_mangani_padsar_tax" readonly value="0.00">
                  <input type="text" class="form-control my-2" name="current_mangani_dand_tax" id="current_mangani_dand_tax"  value="0.00">
                  <input type="text" class="form-control my-2 highlight-green" name="current_mangani_sut_tax" id="current_mangani_sut_tax"  value="0.00">
                  <input type="text" class="form-control my-2" name="current_mangani_total_tax" id="current_mangani_total_tax" readonly value="0.00">
                </div>
                <div class="col">
                  <label>एकूण मागणी कर</label>
                  <input type="text" class="form-control my-2" name="total_mangani_building_tax" id="total_mangani_building_tax" readonly value="0.00">
                  <input type="text" class="form-control my-2" name="total_mangani_health_tax" id="total_mangani_health_tax" readonly value="0.00">
                  <input type="text" class="form-control my-2" name="total_mangani_divabatti_tax" id="total_mangani_divabatti_tax" readonly value="0.00">
                  <input type="text" class="form-control my-2" name="total_mangani_panniyojana_tax" id="total_mangani_panniyojana_tax" readonly value="0.00">
                  <input type="text" class="form-control my-2" name="total_mangani_padsar_tax" id="total_mangani_padsar_tax" readonly value="0.00">
                  <input type="text" class="form-control my-2" name="total_mangani_dand_tax" id="total_mangani_dand_tax" readonly value="0.00">
                  <input type="text" class="form-control my-2 highlight-green" name="total_mangani_sut_tax" id="total_mangani_sut_tax" readonly value="0.00">
                  <input type="text" class="form-control my-2" name="total_mangani_total_tax" id="total_mangani_total_tax" readonly value="0.00">
                </div>
              </div>
            </div>
            <div class="col-md-5">
              <div class="row g-2">
                <div class="col">
                  <label>मागील वसूल कर</label>
                  <input type="text" class="form-control my-2"  name="previous_vasul_building_tax" id="previous_vasul_building_tax" value="000">
                  <input type="text" class="form-control my-2"  name="previous_vasul_health_tax" id="previous_vasul_health_tax" value="0.00">
                  <input type="text" class="form-control my-2"  name="previous_vasul_divabatti_tax" id="previous_vasul_divabatti_tax" value="0.00">
                  <input type="text" class="form-control my-2"  name="previous_vasul_panniyojana_tax" id="previous_vasul_panniyojana_tax" value="0.00">
                  <input type="text" class="form-control my-2"  name="previous_vasul_padsar_tax" id="previous_vasul_padsar_tax" value="0.00">
                  <input type="text" class="form-control my-2"  name="previous_vasul_dand_tax" id="previous_mangani_dand_tax" value="0.00">
                  <input type="text" class="form-control my-2 highlight-green"  name="previous_vasul_sut_tax" id="previous_vasul_sut_tax" value="0.00">
                  <input type="text" class="form-control my-2"  name="previous_vasul_total_tax" readonly id="previous_vasul_total_tax" value="0.00">
                </div>
                <div class="col">
                  <label>चालू वसूल कर</label>
                  <input type="text" class="form-control my-2"  name="current_vasul_building_tax" id="current_vasul_building_tax" value="0.00">
                  <input type="text" class="form-control my-2"  name="current_vasul_health_tax" id="current_vasul_health_tax" value="0.00">
                  <input type="text" class="form-control my-2"  name="current_vasul_divabatti_tax" id="current_vasul_divabatti_tax" value="0.00">
                  <input type="text" class="form-control my-2"  name="current_vasul_panniyojana_tax" id="current_vasul_panniyojana_tax" value="0.00">
                  <input type="text" class="form-control my-2"  name="current_vasul_padsar_tax" id="current_vasul_padsar_tax" value="0.00">
                  <input type="text" class="form-control my-2"  name="current_vasul_dand_tax" id="current_vasul_dand_tax" value="0.00">
                  <input type="text" class="form-control my-2 highlight-green"  name="current_vasul_sut_tax" id="current_vasul_sut_tax" value="0.00">
                  <input type="text" class="form-control my-2"  name="current_vasul_total_tax" readonly id="current_vasul_total_tax" value="0.00">
                </div>
                <div class="col">
                  <label>एकूण वसूल कर</label>
                  <input type="text" class="form-control my-2" readonly name="total_vasul_building_tax" id="total_vasul_building_tax" value="0.00">
                  <input type="text" class="form-control my-2" readonly name="total_vasul_health_tax" id="total_vasul_health_tax" value="0.00">
                  <input type="text" class="form-control my-2" readonly name="total_vasul_divabatti_tax" id="total_vasul_divabatti_tax" value="0.00">
                  <input type="text" class="form-control my-2" readonly name="total_vasul_panniyojana_tax" id="total_vasul_panniyojana_tax" value="0.00">
                  <input type="text" class="form-control my-2" readonly name="total_vasul_padsar_tax" id="total_vasul_padsar_tax" value="0.00">
                  <input type="text" class="form-control my-2" readonly name="total_vasul_dand_tax" id="total_vasul_dand_tax" value="0.00">
                  <input type="text" class="form-control my-2 highlight-green" readonly name="total_vasul_sut_tax" id="total_vasul_sut_tax" value="0.00">
                  <input type="text" class="form-control my-2" readonly name="total_vasul_total_tax" id="total_vasul_total_tax" value="0.00">
                </div>
              </div>
            </div>
          </div>
        </div>
     </div>
   <div class="row mt-4 ml-3 card px-5">
     <div class="row mt-4 col-12">
           <div class="col-12 d-flex flex-column  mb-5 mt-3">
               <label class="bg-gradient-primary text-white py-3 px-5 w-25 rounded-pill fw-bold">वसूल प्रकार</label><br>
               <div class="d-flex justify-content-around align-items-center col-12 " >
                 <div class="custom-control custom-checkbox">
                     <input class="custom-control-input" type="radio" name="paymentType" value="cash" id="cash" checked>
                     <label class="custom-control-label text-primary" for="cash">रोख</label>
                 </div>
                 <div class="custom-control custom-checkbox">
                     <input class="custom-control-input" type="radio" name="paymentType" value="cheque" id="cheque">
                     <label class="custom-control-label text-primary" for="cheque">चेक असलेस</label>
                 </div>
                 <div class="custom-control custom-checkbox">
                     <input class="custom-control-input" type="radio" name="paymentType" value="neft" id="neft">
                     <label class="custom-control-label text-primary" for="neft">NEFT</label>
                 </div>
                 <div class="custom-control custom-checkbox">
                     <input class="custom-control-input" type="radio" name="paymentType" value="rtgs" id="rtgs">
                     <label class="custom-control-label text-primary" for="rtgs">RTGS</label>
                 </div>
                 <div class="custom-control custom-checkbox">
                     <input class="custom-control-input" type="radio" name="paymentType" value="card" id="card">
                     <label class="custom-control-label text-primary" for="card">परस्पर जमा (कार्ड पेमेंट)</label>
                 </div>
               </div>
           </div>
       </div>
   
       <div class="section-title bg-gradient-primary text-white py-3 px-5 w-25 rounded-pill fw-bold mt-5">बँकेची माहिती</div>
       <div class="row mb-3 mt-5">
           <div class="col-md-4">
               <label for="bank_name" class="form-label" >चेक जमा बँकेचे नाव</label>
               <select class="form-control" name="bank_name" id="bank_name"> >
                 <option>--निवडा--</option>
                 <?php
                   $banks = $fun->getBanks();
                   if($banks["success"]){
                     
                     foreach ($banks["data"] as $bank) {
                         echo '<option value="'.$bank['id'].'">'.$bank['bank_name'].'</option>';
                     }
                   }else{
                     echo '<option value="">बँकांची माहिती उपलब्ध नाही</option>';
                   }
                 ?>
             </select>
           </div>
           <div class="col-md-4">
               <label for="account_holder_name" class="form-label" >खातेदार बँकेचे नाव</label>
               <input type="text" class="form-control" name="account_holder_name" id="account_holder_name" placeholder="खातेदार बँकेचे नाव">
           </div>
           <div class="col-md-4">
               <label for="cheque_number" class="form-label" >चेक नंबर</label>
               <input type="text" class="form-control" name="cheque_number" id="cheque_number" placeholder="चेक नंबर">
           </div>
       </div>
       <div class="row mb-3">
           <div class="col-md-4">
               <label for="check_date" class="form-label" >दिनांक</label>
               <input type="date" name="check_date" id="check_date" class="form-control">
           </div>
           <div class="col-md-4">
               <label for="neft_rtgs_ref_1" class="form-label" >NEFT/RTGS REF 1</label>
               <input type="text" class="form-control" name="neft_rtgs_ref_1" id="neft_rtgs_ref_1" placeholder="NEFT/RTGS REF 1">
           </div>
           <div class="col-md-4">
               <label for="neft_rtgs_ref_2" class="form-label" >NEFT/RTGS REF 2</label>
               <input type="text" class="form-control" name="neft_rtgs_ref_2" id="neft_rtgs_ref_2" placeholder="NEFT/RTGS REF 2">
           </div>
       </div>
   
       <div class="row mb-3">
       <div class="col-md-12 text-center">
           <button type="submit" class="btn btn-primary">साठवणे</button>
           <button type="reset" class="btn btn-secondary">रद्द करणे</button>
           <button type="button" class="btn btn-info">पावती</button>
           <button type="button" class="btn btn-outline-primary">अहवाल</button>
       </div>
       </div>
       </div>
     </form>

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
    // When malmatta_kramanak is changed
    $("#not_available").hide();
    $('#malamatta_kramanak').change(function() {
        var malmattaId = $(this).val();
        $('#current_mangani_building_tax').val('0.00');
                          $('#current_mangani_health_tax').val('0.00');
                          $('#current_mangani_divabatti_tax').val('0.00');
                          $('#current_mangani_panniyojana_tax').val('0.00');
                          $('#current_mangani_padsar_tax').val('0.00');
                          $('#current_mangani_dand_tax').val('0.00');
                          $('#current_mangani_sut_tax').val('0.00');
                          $('#current_mangani_total_tax').val('0.00');
        if (malmattaId) {
            // Make AJAX call to get property details
            $.ajax({
                url: 'api/getPropertyDetails.php', // Create this file
                type: 'POST',
                data: { malmatta_id: malmattaId },
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        // Update ward number
                        console.log(data);
                        const malmatta_info = data.data.malmatta_info;
                        $('#ward_kramanak').val(data.data.ward_no);
                        $('#ward_kramanak').attr('readonly', true);
                        // Update owner name dropdown
                        $('#kar_denaryache_nav').empty();
                        $('#kar_denaryache_nav').attr('readonly', true);
                        if (data.data.owner_name) {
                            $('#kar_denaryache_nav').append('<option value="' + data.data.owner_name + '">' + data.data.owner_name + '</option>');
                        } else {
                            $('#kar_denaryache_nav').append('<option value="">--निवडा--</option>');
                        }
                        if(malmatta_info.malmatta_id){
                          $('#current_mangani_building_tax').val(malmatta_info.building_tax || '0.00');
                          $('#current_mangani_health_tax').val(malmatta_info.health_tax || '0.00');
                          $('#current_mangani_divabatti_tax').val(malmatta_info.light_tax || '0.00');
                          $('#current_mangani_panniyojana_tax').val(malmatta_info.water_tax || '0.00');
                          $('#current_mangani_padsar_tax').val(malmatta_info.padsar_tax || '0.00');
                          $('#current_mangani_dand_tax').val(malmatta_info.dand_tax || '0.00');
                          $('#current_mangani_sut_tax').val(malmatta_info.sut_tax || '0.00');
                          $('#current_mangani_total_tax').val(malmatta_info.total_tax || '0.00');
                          calculateTaxTotals();
                        }else {
                          $('#not_available').show();
                          setTimeout(function() {
                              $('#not_available').hide();
                          }, 5000);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: " + status + " - " + error);
                }
            });
        } else {
            // Reset fields if no property selected
            $('#ward_kramanak').val('');
            $('#kar_denaryache_nav').empty().append('<option value="">--निवडा--</option>');
        }
    });
});
// Add this function to calculate totals
function calculateTaxTotals() {
    // Calculate for Mangani (Demand) section
    const prevBuilding = parseFloat($('#previous_mangani_building_tax').val()) || 0;
    const currBuilding = parseFloat($('#current_mangani_building_tax').val()) || 0;
    $('#total_mangani_building_tax').val((prevBuilding + currBuilding).toFixed(2));

    const prevHealth = parseFloat($('#previous_mangani_health_tax').val()) || 0;
    const currHealth = parseFloat($('#current_mangani_health_tax').val()) || 0;
    $('#total_mangani_health_tax').val((prevHealth + currHealth).toFixed(2));

    const prevLight = parseFloat($('#previous_mangani_divabatti_tax').val()) || 0;
    const currLight = parseFloat($('#current_mangani_divabatti_tax').val()) || 0;
    $('#total_mangani_divabatti_tax').val((prevLight + currLight).toFixed(2));

    const prevWater = parseFloat($('#previous_mangani_panniyojana_tax').val()) || 0;
    const currWater = parseFloat($('#current_mangani_panniyojana_tax').val()) || 0;
    $('#total_mangani_panniyojana_tax').val((prevWater + currWater).toFixed(2));

    const prevPadsar = parseFloat($('#previous_mangani_padsar_tax').val()) || 0;
    const currPadsar = parseFloat($('#current_mangani_padsar_tax').val()) || 0;
    $('#total_mangani_padsar_tax').val((prevPadsar + currPadsar).toFixed(2));

    const prevDand = parseFloat($('#previous_mangani_dand_tax').val()) || 0;
    const currDand = parseFloat($('#current_mangani_dand_tax').val()) || 0;
    $('#total_mangani_dand_tax').val((prevDand + currDand).toFixed(2));

    const prevSut = parseFloat($('#previous_mangani_sut_tax').val()) || 0;
    const currSut = parseFloat($('#current_mangani_sut_tax').val()) || 0;
    $('#total_mangani_sut_tax').val((prevSut + currSut).toFixed(2));

    // Calculate grand total for Mangani
    const manganiTotal = (prevBuilding + currBuilding + prevHealth + currHealth + 
                         prevLight + currLight + prevWater + currWater + 
                         prevPadsar + currPadsar + prevDand + currDand + 
                         prevSut + currSut).toFixed(2);
    $('#total_mangani_total_tax').val(manganiTotal);

    // Calculate for Vasul (Collection) section
    const prevVasulBuilding = parseFloat($('#previous_vasul_building_tax').val()) || 0;
    const currVasulBuilding = parseFloat($('#current_vasul_building_tax').val()) || 0;
    $('#total_vasul_building_tax').val((prevVasulBuilding + currVasulBuilding).toFixed(2));

    const prevVasulHealth = parseFloat($('#previous_vasul_health_tax').val()) || 0;
    const currVasulHealth = parseFloat($('#current_vasul_health_tax').val()) || 0;
    $('#total_vasul_health_tax').val((prevVasulHealth + currVasulHealth).toFixed(2));

    const prevVasulLight = parseFloat($('#previous_vasul_divabatti_tax').val()) || 0;
    const currVasulLight = parseFloat($('#current_vasul_divabatti_tax').val()) || 0;
    $('#total_vasul_divabatti_tax').val((prevVasulLight + currVasulLight).toFixed(2));

    const prevVasulWater = parseFloat($('#previous_vasul_panniyojana_tax').val()) || 0;
    const currVasulWater = parseFloat($('#current_vasul_panniyojana_tax').val()) || 0;
    $('#total_vasul_panniyojana_tax').val((prevVasulWater + currVasulWater).toFixed(2));

    const prevVasulPadsar = parseFloat($('#previous_vasul_padsar_tax').val()) || 0;
    const currVasulPadsar = parseFloat($('#current_vasul_padsar_tax').val()) || 0;
    $('#total_vasul_padsar_tax').val((prevVasulPadsar + currVasulPadsar).toFixed(2));

    const prevVasulDand = parseFloat($('#previous_vasul_dand_tax').val()) || 0;
    const currVasulDand = parseFloat($('#current_vasul_dand_tax').val()) || 0;
    $('#total_vasul_dand_tax').val((prevVasulDand + currVasulDand).toFixed(2));

    const prevVasulSut = parseFloat($('#previous_vasul_sut_tax').val()) || 0;
    const currVasulSut = parseFloat($('#current_vasul_sut_tax').val()) || 0;
    $('#total_vasul_sut_tax').val((prevVasulSut + currVasulSut).toFixed(2));

    // Calculate grand total for Vasul
    const vasulTotal = (prevVasulBuilding + currVasulBuilding + prevVasulHealth + currVasulHealth + 
                       prevVasulLight + currVasulLight + prevVasulWater + currVasulWater + 
                       prevVasulPadsar + currVasulPadsar + prevVasulDand + currVasulDand + 
                       prevVasulSut + currVasulSut).toFixed(2);
    $('#total_vasul_total_tax').val(vasulTotal);
}

// Add event listeners to all input fields that should trigger calculations
function setupCalculationListeners() {
    // Mangani (Demand) inputs
    $('#previous_mangani_building_tax, #current_mangani_building_tax').on('input', calculateTaxTotals);
    $('#previous_mangani_health_tax, #current_mangani_health_tax').on('input', calculateTaxTotals);
    $('#previous_mangani_divabatti_tax, #current_mangani_divabatti_tax').on('input', calculateTaxTotals);
    $('#previous_mangani_panniyojana_tax, #current_mangani_panniyojana_tax').on('input', calculateTaxTotals);
    $('#previous_mangani_padsar_tax, #current_mangani_padsar_tax').on('input', calculateTaxTotals);
    $('#previous_mangani_dand_tax, #current_mangani_dand_tax').on('input', calculateTaxTotals);
    $('#previous_mangani_sut_tax, #current_mangani_sut_tax').on('input', calculateTaxTotals);

    // Vasul (Collection) inputs
    $('#previous_vasul_building_tax, #current_vasul_building_tax').on('input', calculateTaxTotals);
    $('#previous_vasul_health_tax, #current_vasul_health_tax').on('input', calculateTaxTotals);
    $('#previous_vasul_divabatti_tax, #current_vasul_divabatti_tax').on('input', calculateTaxTotals);
    $('#previous_vasul_panniyojana_tax, #current_vasul_panniyojana_tax').on('input', calculateTaxTotals);
    $('#previous_vasul_padsar_tax, #current_vasul_padsar_tax').on('input', calculateTaxTotals);
    $('#previous_vasul_dand_tax, #current_vasul_dand_tax').on('input', calculateTaxTotals);
    $('#previous_vasul_sut_tax, #current_vasul_sut_tax').on('input', calculateTaxTotals);
}

function populateCurrentVasuli() {
   $('#current_vasul_building_tax').val(`${$('#current_mangani_building_tax').val()}`);
  
   
                $('#current_vasul_health_tax').val($('#current_mangani_health_tax').val());
                $('#current_vasul_divabatti_tax').val($('#current_mangani_divabatti_tax').val());
                $('#current_vasul_panniyojana_tax').val($('#current_mangani_panniyojana_tax').val());
                $('#current_vasul_padsar_tax').val($('#current_mangani_padsar_tax').val());
                $('#current_vasul_dand_tax').val($('#current_mangani_dand_tax').val());
                $('#current_vasul_sut_tax').val($('#current_mangani_sut_tax').val());
                $('#current_vasul_total_tax').val($('#current_mangani_total_tax').val());
}
function resetCurrentVasuli() {
    $('#current_vasul_building_tax').val('0.00');
    $('#current_vasul_health_tax').val('0.00');
    $('#current_vasul_divabatti_tax').val('0.00');
    $('#current_vasul_panniyojana_tax').val('0.00');
    $('#current_vasul_padsar_tax').val('0.00');
    $('#current_vasul_dand_tax').val('0.00');
    $('#current_vasul_sut_tax').val('0.00');
    $('#current_vasul_total_tax').val('0.00');
}

function populatePreviousVasuli() {
    $('#previous_vasul_building_tax').val($('#previous_mangani_building_tax').val());

    $('#previous_vasul_health_tax').val($('#previous_mangani_health_tax').val());
    $('#previous_vasul_divabatti_tax').val($('#previous_mangani_divabatti_tax').val());
    $('#previous_vasul_panniyojana_tax').val($('#previous_mangani_panniyojana_tax').val());
    $('#previous_vasul_padsar_tax').val($('#previous_mangani_padsar_tax').val());
    $('#previous_vasul_dand_tax').val($('#previous_mangani_dand_tax').val());
    $('#previous_vasul_sut_tax').val($('#previous_mangani_sut_tax').val());
    $('#previous_vasul_total_tax').val($('#previous_mangani_total_tax').val());
}

function resetPreviousVasuli() {
    $('#previous_vasul_building_tax').val('000');
    $('#previous_vasul_health_tax').val('0.00');
    $('#previous_vasul_divabatti_tax').val('0.00');
    $('#previous_vasul_panniyojana_tax').val('0.00');
    $('#previous_vasul_padsar_tax').val('0.00');
    $('#previous_vasul_dand_tax').val('0.00');
    $('#previous_vasul_sut_tax').val('0.00');
    $('#previous_vasul_total_tax').val('0.00');
}
// Call this function in your document ready

$(document).ready(function() {
    // When malmatta_kramanak is changed
    $("#not_available").hide();
     // Setup calculation listeners
    setupCalculationListeners();
    
    // Initial calculation
    calculateTaxTotals();

    // popuilate inputs according to the radio button selection
    $('input[name="full"]').on('change', ((elem) => {
          console.log(elem.target.id);
          
            if (event.target.id === "fullItem") {
                // Logic for full item
                populateCurrentVasuli();
                populatePreviousVasuli();
                
            } else if (event.target.id === "fullDemand") {
                // Logic for full demand
                resetCurrentVasuli();
                populatePreviousVasuli();
                
            } else if (event.target.id === "fullCurrent") {
                // Logic for full current
                resetPreviousVasuli();
                populateCurrentVasuli();
                
            }
            calculateTaxTotals();
      
    }));

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
                        $('#pustak_kramanak').append('<option value="' + book.x + '">' + book.x + '</option>');
                    });
                    
                    // When pustak_kramanak changes, populate pavati_kramanak (y values)
                    $('#pustak_kramanak').change(function() {
                        var selectedX = $(this).val();
                        $('#pavati_kramanak').empty();
                        $('#pavati_kramanak').append('<option value="">--निवडा--</option>');
                        
                        if (selectedX) {
                          console.log(selectedX);
                          
                            var selectedBook = data.books.find(book => book.x == selectedX);
                            console.log(selectedBook);
                            if (selectedBook) {
                                for (let y = 1; y <= selectedBook.max_y; y++) {
                                    $('#pavati_kramanak').append('<option value="' + y + '">' + y + '</option>');
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
    
    // Rest of your existing code...
    $('#malamatta_kramanak').change(function() {
        // Your existing malmatta change handler
    });
});
    </script>
    
</body>

</html>