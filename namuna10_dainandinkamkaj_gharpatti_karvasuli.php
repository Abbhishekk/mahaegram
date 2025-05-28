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
    <!-- Form -->
     
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
          <label class="form-label" for="pustak_kramanak" >पुस्तक क्रमांक: <span class="text-danger">*</span></label>
          <select class="form-control" name="pustak_kramanak" id="pustak_kramanak" ><option>--निवडा--</option></select>
        </div>
        <div class="col-md-3 my-2">
          <label class="form-label" id="pavati_kramanak">पावती क्रमांक:</label>
          <select class="form-control" name="pavati_kramanak" id="pavati_kramanak"></select>
        </div>
      </div>
        <div class="row my-5 justify-content-center " >
          <div class="custom-control custom-checkbox mt-3 col-md-3">
            <input class="custom-control-input" type="checkbox" id="fullItem">
            <label class="custom-control-label" for="fullItem">संपूर्ण वस्तू</label>
          </div>
          <div class="custom-control custom-checkbox col-md-3">
            <input class="custom-control-input" type="checkbox" id="fullDemand">
            <label class="custom-control-label" for="fullDemand">संपूर्ण मागणी कर</label>
          </div>
          <div class="custom-control custom-checkbox col-md-3">
            <input class="custom-control-input" type="checkbox" id="fullCurrent">
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
               <input type="text" name="previous_building_tax" id="previous_building_tax" class="form-control my-2" readonly value="000">
               <input type="text" class="form-control my-2" name="previous_health_tax" id="previous_health_tax" readonly value="0.00">
               <input type="text" class="form-control my-2" name="previous_divabatti_tax" id="previous_divabatti_tax" readonly value="0.00">
               <input type="text" class="form-control my-2" name="previous_panniyojana_tax" id="previous_panniyojana_tax" readonly value="0.00">
               <input type="text" class="form-control my-2" name="previous_padsar_tax" id="previous_padsar_tax" readonly value="0.00">
               <input type="text" class="form-control my-2" name="previous_dand_tax" id="previous_dand_tax" readonly value="0.00">
               <input type="text" class="form-control my-2 highlight-green" name="previous_sut_tax" id="previous_sut_tax" readonly value="0.00">
               <input type="text" class="form-control my-2" name="previous_total_tax" id="previous_total_tax" readonly value="0.00">
             </div>
             <div class="col">
               <label>चालू मागणी कर</label>
               <input type="text" class="form-control my-2" name="current_building_tax" id="current_building_tax" readonly value="0.00">
               <input type="text" class="form-control my-2" name="current_health_tax" id="current_health_tax" readonly value="0.00">
               <input type="text" class="form-control my-2" name="current_divabatti_tax" id="current_divabatti_tax" readonly value="0.00">
               <input type="text" class="form-control my-2" name="current_panniyojana_tax" id="current_panniyojana_tax" readonly value="0.00">
               <input type="text" class="form-control my-2" name="current_padsar_tax" id="current_padsar_tax" readonly value="0.00">
               <input type="text" class="form-control my-2" name="current_dand_tax" id="current_dand_tax" readonly value="0.00">
               <input type="text" class="form-control my-2 highlight-green" name="current_sut_tax" id="current_sut_tax" readonly value="0.00">
               <input type="text" class="form-control my-2" name="current_total_tax" id="current_total_tax" readonly value="0.00">
             </div>
             <div class="col">
               <label>एकूण मागणी कर</label>
               <input type="text" class="form-control my-2" name="total_building_tax" id="total_building_tax" readonly value="0.00">
               <input type="text" class="form-control my-2" name="total_health_tax" id="total_health_tax" readonly value="0.00">
               <input type="text" class="form-control my-2" name="total_divabatti_tax" id="total_divabatti_tax" readonly value="0.00">
               <input type="text" class="form-control my-2" name="total_panniyojana_tax" id="total_panniyojana_tax" readonly value="0.00">
               <input type="text" class="form-control my-2" name="total_padsar_tax" id="total_padsar_tax" readonly value="0.00">
               <input type="text" class="form-control my-2" name="total_dand_tax" id="total_dand_tax" readonly value="0.00">
               <input type="text" class="form-control my-2 highlight-green" name="total_sut_tax" id="total_sut_tax" readonly value="0.00">
               <input type="text" class="form-control my-2" name="total_total_tax" id="total_total_tax" readonly value="0.00">
             </div>
           </div>
         </div>
         <div class="col-md-5">
           <div class="row g-2">
             <div class="col">
               <label>मागील वसूल कर</label>
               <input type="text" class="form-control my-2" readonly name="previous_mangani_building_tax" id="previous_mangani_building_tax" value="000">
               <input type="text" class="form-control my-2" readonly name="previous_mangani_health_tax" id="previous_mangani_health_tax" value="0.00">
               <input type="text" class="form-control my-2" readonly name="previous_mangani_divabatti_tax" id="previous_mangani_divabatti_tax" value="0.00">
               <input type="text" class="form-control my-2" readonly name="previous_mangani_panniyojana_tax" id="previous_mangani_panniyojana_tax" value="0.00">
               <input type="text" class="form-control my-2" readonly name="previous_mangani_padsar_tax" id="previous_mangani_padsar_tax" value="0.00">
               <input type="text" class="form-control my-2" readonly name="previous_mangani_dand_tax" id="previous_mangani_dand_tax" value="0.00">
               <input type="text" class="form-control my-2 highlight-green" readonly name="previous_mangani_sut_tax" id="previous_mangani_sut_tax" value="0.00">
               <input type="text" class="form-control my-2" readonly name="previous_mangani_total_tax" id="previous_mangani_total_tax" value="0.00">
             </div>
             <div class="col">
               <label>चालू वसूल कर</label>
               <input type="text" class="form-control my-2" readonly name="current_mangani_building_tax" id="current_mangani_building_tax" value="0.00">
               <input type="text" class="form-control my-2" readonly name="current_mangani_health_tax" id="current_mangani_health_tax" value="0.00">
               <input type="text" class="form-control my-2" readonly name="current_mangani_divabatti_tax" id="current_mangani_divabatti_tax" value="0.00">
               <input type="text" class="form-control my-2" readonly name="current_mangani_panniyojana_tax" id="current_mangani_panniyojana_tax" value="0.00">
               <input type="text" class="form-control my-2" readonly name="current_mangani_padsar_tax" id="current_mangani_padsar_tax" value="0.00">
               <input type="text" class="form-control my-2" readonly name="current_mangani_dand_tax" id="current_mangani_dand_tax" value="0.00">
               <input type="text" class="form-control my-2 highlight-green" readonly name="current_mangani_sut_tax" id="current_mangani_sut_tax" value="0.00">
               <input type="text" class="form-control my-2" readonly name="current_mangani_total_tax" id="current_mangani_total_tax" value="0.00">
             </div>
             <div class="col">
               <label>एकूण वसूल कर</label>
               <input type="text" class="form-control my-2" readonly name="total_mangani_building_tax" id="total_mangani_building_tax" value="0.00">
               <input type="text" class="form-control my-2" readonly name="total_mangani_health_tax" id="total_mangani_health_tax" value="0.00">
               <input type="text" class="form-control my-2" readonly name="total_mangani_divabatti_tax" id="total_mangani_divabatti_tax" value="0.00">
               <input type="text" class="form-control my-2" readonly name="total_mangani_panniyojana_tax" id="total_mangani_panniyojana_tax" value="0.00">
               <input type="text" class="form-control my-2" readonly name="total_mangani_padsar_tax" id="total_mangani_padsar_tax" value="0.00">
               <input type="text" class="form-control my-2" readonly name="total_mangani_dand_tax" id="total_mangani_dand_tax" value="0.00">
               <input type="text" class="form-control my-2 highlight-green" readonly name="total_mangani_sut_tax" id="total_mangani_sut_tax" value="0.00">
               <input type="text" class="form-control my-2" readonly name="total_mangani_total_tax" id="total_mangani_total_tax" value="0.00">
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
                  <input class="custom-control-input" type="radio" name="paymentType" id="cash" checked>
                  <label class="custom-control-label text-primary" for="cash">रोख</label>
              </div>
              <div class="custom-control custom-checkbox">
                  <input class="custom-control-input" type="radio" name="paymentType" id="cheque">
                  <label class="custom-control-label text-primary" for="cheque">चेक असलेस</label>
              </div>
              <div class="custom-control custom-checkbox">
                  <input class="custom-control-input" type="radio" name="paymentType" id="neft">
                  <label class="custom-control-label text-primary" for="neft">NEFT</label>
              </div>
              <div class="custom-control custom-checkbox">
                  <input class="custom-control-input" type="radio" name="paymentType" id="rtgs">
                  <label class="custom-control-label text-primary" for="rtgs">RTGS</label>
              </div>
              <div class="custom-control custom-checkbox">
                  <input class="custom-control-input" type="radio" name="paymentType" id="card">
                  <label class="custom-control-label text-primary" for="card">परस्पर जमा (कार्ड पेमेंट)</label>
              </div>
            </div>
        </div>
    </div>

    <div class="section-title">बँकेची माहिती</div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label>चेक जमा बँकेचे नाव</label>
            <select class="form-control"><option>--निवडा--</option></select>
        </div>
        <div class="col-md-4">
            <label>खातेदार बँकेचे नाव</label>
            <input type="text" class="form-control" placeholder="खातेदार बँकेचे नाव">
        </div>
        <div class="col-md-4">
            <label>चेक नंबर</label>
            <input type="text" class="form-control" placeholder="चेक नंबर">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label>दिनांक</label>
            <input type="date" class="form-control">
        </div>
        <div class="col-md-4">
            <label>NEFT/RTGS REF 1</label>
            <input type="text" class="form-control" placeholder="NEFT/RTGS REF 1">
        </div>
        <div class="col-md-4">
            <label>NEFT/RTGS REF 2</label>
            <input type="text" class="form-control" placeholder="NEFT/RTGS REF 2">
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
        $('#current_building_tax').val('0.00');
                          $('#current_health_tax').val('0.00');
                          $('#current_divabatti_tax').val('0.00');
                          $('#current_panniyojana_tax').val('0.00');
                          $('#current_padsar_tax').val('0.00');
                          $('#current_dand_tax').val('0.00');
                          $('#current_sut_tax').val('0.00');
                          $('#current_total_tax').val('0.00');
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
                          $('#current_building_tax').val(malmatta_info.building_tax || '0.00');
                          $('#current_health_tax').val(malmatta_info.health_tax || '0.00');
                          $('#current_divabatti_tax').val(malmatta_info.light_tax || '0.00');
                          $('#current_panniyojana_tax').val(malmatta_info.water_tax || '0.00');
                          $('#current_padsar_tax').val(malmatta_info.padsar_tax || '0.00');
                          $('#current_dand_tax').val(malmatta_info.dand_tax || '0.00');
                          $('#current_sut_tax').val(malmatta_info.sut_tax || '0.00');
                          $('#current_total_tax').val(malmatta_info.total_tax || '0.00');
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
    </script>
</body>

</html>