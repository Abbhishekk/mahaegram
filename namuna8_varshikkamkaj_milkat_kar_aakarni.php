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
$lgdVillages = $fun->getVillagesWithDistrict($_SESSION['district_code']);
$periodsWithReasons = $fun->getPeriodTotalPeriodsWithPeriodReason("नमुना नंबर 8 कालावधी", $_SESSION['district_code']);
$malmattaEntry = $fun->getMalmattaDataEntryByLgdcode($_SESSION['district_code']);
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
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <?php include('include/topbar.php'); ?>
                <!-- Topbar -->

                <!-- Container Fluid-->
                <div class="container-fluid bg-white p-4 border rounded">
                    <!-- Header and Breadcrumb -->
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <div><strong>मालमत्ता कर आकारणी</strong></div>
                        <div><a href="#"><i class="fa fa-home"></i> Home</a> / नमुना क्रमांक 8 / <strong>मालमत्ता कर
                                आकारणी</strong></div>
                    </div>

                    <!-- Alert Message -->
                    <div class="text-danger fw-bold mb-3">रेडीरेकनर दर भरलेले नाहीत...कृपया भरा</div>

                    <!-- Radio Buttons -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="सूत्र" id="सूत्र1" checked>
                                <label class="form-check-label" for="सूत्र1">सूत्र १</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="सूत्र" id="सूत्र2">
                                <label class="form-check-label" for="सूत्र2">सूत्र २</label>
                            </div>
                        </div>
                    </div>

                    <!-- First Row -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">गावाचे नाव</label>
                            <select class="form-control select2-single-placeholder mb-3" name="village_name"
                                id="village_name">
                                <option value="" selected>--निवडा.--</option>
                                <?php
                                                            if(mysqli_num_rows($lgdVillages) > 0){
                                                                while($village = mysqli_fetch_assoc($lgdVillages)){
                                                                    echo "<option value='".$village['Village_Code']."'>".$village['Village_Name']."</option>";
                                                                }
                                                            }
                                                        ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">कालावधी</label>
                            <select name="period" id="period" class="form-control">
                                <option value="" selected>--निवडा--</option>
                                <?php
                                                            if(mysqli_num_rows($periodsWithReasons) > 0){
                                                                while($periodsWithReason = mysqli_fetch_assoc($periodsWithReasons)){
                                                                    echo '<option value="'.$periodsWithReason['id'].'">'.$periodsWithReason['total_period'].'</option>';
                                                                }
                                                            }
                                                        ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">मालमत्ता क्रमांक <span
                                    class="text-danger">*</span></label>
                            <select name="malmatta_no" id="malmatta_no" class="form-control" required>
                                <option value="" selected>--निवडा--</option>
                                <?php
                                                            if(mysqli_num_rows($malmattaEntry) > 0){
                                                                while($malmattaEntr = mysqli_fetch_assoc($malmattaEntry)){
                                                                    echo '<option value="'.$malmattaEntr['id'].'">'.$malmattaEntr['malmatta_no'].'</option>';
                                                                }
                                                            }
                                                        ?>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button class="btn btn-primary w-100" id="search-button">शोधा</button>
                        </div>
                    </div>

                    <!-- Second Row -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">वॉर्ड क्र</label>
                            <input type="text" class="form-control" name="ward_no" id="ward_no" placeholder="वॉर्ड क्र">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">मालमत्ता धारकाचे नाव</label>
                            <textarea class="form-control" name="owner_name" id="owner_name"
                                placeholder="मालमत्ता धारकाचे नाव"></textarea>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">रस्त्याचे नाव / गल्ली क्रमांक</label>
                            <input type="text" class="form-control" name="road_name" id="road_name"
                                placeholder="रस्त्याचे नाव">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">गट / सर्वे नंबर</label>
                            <textarea class="form-control" id="group_no" name="group_no"
                                placeholder="इतर माहिती"></textarea>
                        </div>
                    </div>

                    <!-- Third Row -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">भागवटा धारकाचे नाव</label>
                            <textarea class="form-control" name="occupant_name" id="occupant_name"
                                placeholder="भागवटा धारकाचे नाव"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">मागील कर आकारणी नुसार कर</label>
                            <input type="text" class="form-control" placeholder="मागील कर">
                        </div>
                    </div>
                    <div class="table-responsive mt-4">
                        <table id="propertyTable" class="table table-bordered table-striped text-center align-middle"" >
                        <thead class=" bg-primary text-white">
                            <tr>
                                <th>अ क्र</th>
                                <th>मालमत्ता क्र.</th>
                                <th>मालमत्ता प्रकार</th>
                                <th>मजला</th>
                                <th>लांबी</th>
                                <th>रुंदी</th>
                                <th>क्षेत्रफळ</th>
                                <th>बांधकाम वर्ष</th>
                                <th>रेडीरेकनर दर</th>
                                <th>बांधकाम दर</th>
                                <th>घसारा दर</th>
                                <th>भारांक</th>
                                <th>इमारत मुल्यांकन</th>
                                <th>मिळकत कर दर</th>
                                <th>इमारत कर</th>
                                <th>Building_TaxNEW </th>
                                <th>OldTaxDiff </th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <!-- Tax Inputs -->
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label class="form-label">इमारत कर</label>
                            <input type="text" class="form-control" value="0.00">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label" for="light_tax">दिवाबत्ती कर</label>
                            <input type="text" class="form-control" id="light_tax" name="light_tax" value="0.00">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label" for="health_tax">आरोग्य कर</label>
                            <input type="text" class="form-control" name="health_tax" id="health_tax" value="0.00">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">सामान्य पाणीपुरवठा</label>
                            <input type="text" class="form-control" id="water_tax" name="water_tax" value="0.00">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">पडसर/खुली कर</label>
                            <input type="text" class="form-control" value="0.00">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">भांडवली मूल्य</label>
                            <input type="text" class="form-control" value="0.00">
                        </div>
                    </div>

                    <!-- Final Calculation Inputs -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="form-label">कर आकारणी प्रमाणे एकूण</label>
                            <input type="text" class="form-control" value="0.00">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">% प्रमाणे कमी केलेली रक्कम(-)</label>
                            <input type="text" class="form-control" value="0.00">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">एकूण कर</label>
                            <input type="text" class="form-control" value="0.00">
                        </div>
                    </div>

                    <!-- Buttons -->
                    <!-- Buttons -->
                    <div class="d-flex gap-3 mt-4">
                        <button class="btn btn-primary">साठवा</button>
                        <button class="btn btn-secondary">रद्द करा</button>
                    </div>

                    <!-- Data Table -->
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered table-striped text-center align-middle">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>अ क्रं</th>
                                    <th>वॉर्डचे नाव</th>
                                    <th>रस्त्याचे नाव</th>
                                    <th>गृ. नं.</th>
                                    <th>मालकाचे नाव</th>
                                    <th>भोगवटाधारकाचे नाव</th>
                                    <th>इमारत मुल्यांकन</th>
                                    <th>इमारत कर</th>
                                    <th>आरोग्य कर</th>
                                    <th>दिवाबत्ती कर</th>
                                    <th>पाणीपुरवठा कर</th>
                                    <th>पडसर / खुली जागा कर</th>
                                    <th>एकूण कर</th>
                                    <th>बदल</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>वॉर्ड (ब)</td>
                                    <td>ढाणू ते जव्हार रस्ता</td>
                                    <td>४५३</td>
                                    <td>दीपक अशोक कोब</td>
                                    <td>दीपक अशोक कोब</td>
                                    <td>507000</td>
                                    <td>491</td>
                                    <td>20</td>
                                    <td>20</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>531</td>
                                    <td><a href="#"><i class="fa fa-pencil-alt"></i></a></td>
                                </tr>
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
    document.getElementById('search-button').addEventListener('click', function() {
        const village = document.getElementById('village_name').value;
        const period = document.getElementById('period').value;
        const malmattaId = document.getElementById('malmatta_no').value;

        if (!village || !period || !malmattaId) {
            alert("कृपया सर्व फील्ड भरा");
            return;
        }

        fetch('api/fetch_malmatta_details.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    village,
                    period,
                    malmattaId
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const info = data.info[0];
                    const taxRates = data.tax_rates;
                    const waterTariff = data.water_tariff;
                    const tbody = document.querySelector("#propertyTable tbody");
                    const properties = info.properties;
                    properties.forEach((prop, index) => {
                        const length = parseFloat(prop.lenght || 0);
                        const width = parseFloat(prop.width || 0);
                        const area = prop.area || (length * width).toFixed(2);
                        const depreciation = prop.construction_year === "22" ? 0.9 : 1;

                        const row = `
      <tr>
        <td>${index + 1}</td>
        <td>${info.malmatta_no}</td>
        <td>${prop.property_use}</td>
        <td>${prop.floor}</td>
        <td>${length}</td>
        <td>${width}</td>
        <td>${area}</td>
        <td>${prop.construction_year}</td>
        <td>${depreciation}</td>
        <td>रहिवासी</td>
        <td>${prop.tax_exempt}</td>
        <td>${prop.property_tax_type}</td>
        <td>${prop.directions}</td>
        <td>${data.tax_rates.divabatti_kiman_rate}</td>
        <td>${data.tax_rates.arogya_kiman_rate}</td>
        <td>${data.water_tariff.fixed_rate}</td>
      </tr>
    `;
                        tbody.insertAdjacentHTML("beforeend", row);
                    });
                    console.log("info", info);
                    console.log(data.tax_rates);

                    document.getElementById('ward_no').value = info.ward_name;
                    console.log("info.ward_name", info.ward_name);

                    document.getElementById('ward_no').readOnly = true;

                    document.getElementById('owner_name').value = info.owner_name;
                    console.log("owner_name", info.owner_name);
                    document.getElementById('owner_name').readOnly = true;

                    document.getElementById('road_name').value = info.road_name ?? "";
                    console.log("info.road_name", info.road_name);
                    document.getElementById('road_name').readOnly = true;

                    document.getElementById('group_no').value = info.group_no ?? "";
                    console.log("info.group_no", info.group_no);
                    document.getElementById('group_no').readOnly = true;

                    document.getElementById('occupant_name').value = info.occupant_name;
                    console.log("info.occupant_name", info.occupant_name);
                    document.getElementById('occupant_name').readOnly = true;

                    // document.getElementById('building_tax').value = info.building_tax;
                    // document.getElementById('building_tax').readOnly = true;

                    document.getElementById('light_tax').value = taxRates.divabatti_prap_tharabaila_rate;
                    console.log("taxRates.divabatti_prap_tharabaila_rate", taxRates
                        .divabatti_prap_tharabaila_rate);
                    document.getElementById('light_tax').readOnly = true;

                    document.getElementById('health_tax').value = taxRates.arogya_prap_tharabaila_rate;
                    console.log("taxRates.arogya_prap_tharabaila_rate", taxRates
                        .arogya_prap_tharabaila_rate);
                    document.getElementById('health_tax').readOnly = true;

                    document.getElementById('water_tax').value = waterTariff.fixed_rate;
                    console.log("waterTariff.fixed_rate", waterTariff.fixed_rate);
                    document.getElementById('water_tax').readOnly = true;

                    document.getElementById('open_area_tax').value = info.open_area_tax;
                    document.getElementById('open_area_tax').readOnly = true;

                    const total = [
                        parseFloat(info.building_tax || 0),
                        parseFloat(info.light_tax || 0),
                        parseFloat(info.health_tax || 0),
                        parseFloat(info.water_tax || 0),
                        parseFloat(info.open_area_tax || 0)
                    ].reduce((a, b) => a + b, 0);

                    document.getElementById('total_tax').value = total.toFixed(2);
                } else {
                    alert("माहिती सापडली नाही.");
                }
            })
            .catch(err => {
                console.error(err);
                alert("त्रुटी आली.");
            });
    });
    </script>

</body>

</html>