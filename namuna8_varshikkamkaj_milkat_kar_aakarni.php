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
    $periods = $fun->getPeriodDetails($_SESSION['district_code']);
    $lgdVillages = $fun->getVillagesWithDistrict($_SESSION['district_code']);
    $periodsWithReasons = $fun->getPeriodTotalPeriodsWithPeriodReason("नमुना नंबर 8 कालावधी", $_SESSION['district_code']);
    $malmattaEntry = $fun->getMalmattaDataEntryByLgdcodeApproved($_SESSION['district_code']);
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
                    <?php if(isset($_SESSION['message'])): ?>
                    <div class="alert alert-<?= $_SESSION['message_type'] ?>"><?= $_SESSION['message'] ?></div>
                    <?php 
                        unset($_SESSION['message']);
                        unset($_SESSION['message_type']);
                        ?>
                    <?php endif; ?>

                    <!-- Main Form -->
                    <form method="post" action="api/property_verification.php">
                        <input type="hidden" name="verification_id" id="verification_id" value="">

                        <!-- Radio Buttons -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="formula" id="formula1"
                                        value="सूत्र १" checked>
                                    <label class="form-check-label" for="formula1">सूत्र १</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="formula" id="formula2"
                                        value="सूत्र २">
                                    <label class="form-check-label" for="formula2">सूत्र २</label>
                                </div>
                            </div>
                        </div>

                        <!-- Search Section -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label fw-bold">गावाचे नाव</label>
                                <select class="form-control select2-single-placeholder" name="village_code"
                                    id="village_name" required>
                                    <option value="" selected>--निवडा--</option>
                                    <?php while($village = mysqli_fetch_assoc($lgdVillages)): ?>
                                    <option value="<?= $village['Village_Code'] ?>"><?= $village['Village_Name'] ?>
                                    </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">कालावधी</label>
                                <select name="period_id" id="period" class="form-control" required>
                                    <option value="" selected>--निवडा--</option>
                                    <?php while($period = mysqli_fetch_assoc($periodsWithReasons)): ?>
                                    <option value="<?= $period['id'] ?>"><?= $period['total_period'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">मालमत्ता क्रमांक <span
                                        class="text-danger">*</span></label>
                                <select name="malmatta_id" id="malmatta_no" class="form-control" required>
                                    <option value="" selected>--निवडा--</option>
                                    <?php while($malmatta = mysqli_fetch_assoc($malmattaEntry)): ?>
                                    <option value="<?= $malmatta['id'] ?>"><?= $malmatta['malmatta_no'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="button" class="btn btn-primary w-100" id="search-button">शोधा</button>
                            </div>
                        </div>

                        <!-- Property Details -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label fw-bold">वॉर्ड क्र</label>
                                <input type="text" class="form-control" name="ward_no" id="ward_no"
                                    placeholder="वॉर्ड क्र" readonly>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">मालमत्ता धारकाचे नाव</label>
                                <textarea class="form-control" name="owner_name" id="owner_name"
                                    placeholder="मालमत्ता धारकाचे नाव" readonly></textarea>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">रस्त्याचे नाव / गल्ली क्रमांक</label>
                                <input type="text" class="form-control" name="road_name" id="road_name"
                                    placeholder="रस्त्याचे नाव" readonly>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">गट / सर्वे नंबर</label>
                                <textarea class="form-control" id="group_no" name="group_no" placeholder="इतर माहिती"
                                    readonly></textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">भागवटा धारकाचे नाव</label>
                                <textarea class="form-control" name="occupant_name" id="occupant_name"
                                    placeholder="भागवटा धारकाचे नाव" readonly></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">मागील कर आकारणी नुसार कर</label>
                                <input type="text" class="form-control" name="previous_tax" id="previous_year_tax"
                                    placeholder="मागील कर" readonly>
                            </div>
                        </div>

                        <!-- Property Table -->
                        <div class="table-responsive mt-4">
                            <table id="propertyTable"
                                class="table table-bordered table-striped text-center align-middle">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>अ क्र</th>
                                        <th>मालमत्ता क्र.</th>
                                        <th>मालमत्ता प्रकार</th>
                                        <th>मजला</th>
                                        <th>लांबी</th>
                                        <th>रुंदी</th>
                                        <th>क्षेत्रफळ(Foot)</th>
                                        <th>क्षेत्रफळ(mt)</th>
                                        <th>बांधकाम वर्ष</th>
                                        <th>रेडीरेकनर दर</th>
                                        <th>बांधकाम दर</th>
                                        <th>घसारा दर</th>
                                        <th>भारांक</th>
                                        <th>भांडवली मुल्यांकन</th>
                                        <th>मिळकत कर दर</th>
                                        <th>इमारत कर</th>
                                        <th>फोटो</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <!-- Tax Calculation -->
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label class="form-label">इमारत कर</label>
                                <input type="text" class="form-control" name="building_tax" id="building_tax"
                                    value="0.00" readonly>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">दिवाबत्ती कर</label>
                                <input type="text" class="form-control" id="light_tax" name="light_tax" value="0.00"
                                    readonly>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">आरोग्य कर</label>
                                <input type="text" class="form-control" name="health_tax" id="health_tax" value="0.00"
                                    readonly>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">सामान्य पाणीपुरवठा</label>
                                <input type="text" class="form-control" id="water_tax" name="water_tax" value="0.00"
                                    readonly>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">पडसर/खुली कर</label>
                                <input type="text" class="form-control" name="padsar_tax" id="padsar_tax" value="0.00"
                                    readonly>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">भांडवली मूल्य</label>
                                <input type="text" class="form-control" name="capital_value" id="bhandavali_tax"
                                    value="0.00" readonly>
                            </div>
                        </div>

                        <!-- Final Calculation -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">कर आकारणी प्रमाणे एकूण</label>
                                <input type="text" class="form-control" name="total_tax" id="total_tax" value="0.00"
                                    readonly>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">% प्रमाणे कमी केलेली रक्कम(-)</label>
                                <input type="text" class="form-control" name="discount" id="discount" value="0.00">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">एकूण कर</label>
                                <input type="text" class="form-control" name="final_tax" id="total_tax_amount"
                                    value="0.00" readonly>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">प्रमाणिकरण दिनांक</label>
                                <input type="date" class="form-control" name="verification_date" id="verification_date"
                                    required>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-3 mt-4">
                            <button type="submit" name="save" class="btn btn-primary">साठवा</button>
                            <button type="reset" class="btn btn-secondary">रद्द करा</button>
                        </div>
                    </form>

                    <!-- Verification Records Table -->
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered table-striped text-center align-middle">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>अ क्रं</th>
                                    <th>वॉर्डचे नाव</th>
                                    <th>रस्त्याचे नाव</th>
                                    <!-- <th>गृ. नं.</th> -->
                                    <th>मालकाचे नाव</th>
                                    <th>भोगवटाधारकाचे नाव</th>
                                    <th>भांडवली मूल्य</th>
                                    <th>इमारत कर</th>
                                    <th>आरोग्य कर</th>
                                    <th>दिवाबत्ती कर</th>
                                    <th>पाणीपुरवठा कर</th>
                                    <th>पडसर / खुली जागा कर</th>
                                    <th>एकूण कर</th>
                                    <th class="d-none">बदल</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $verifications = $fun->getPropertyVerifications($_SESSION['district_code']);
                                if(mysqli_num_rows($verifications) > 0):
                                    $counter = 1;
                                    while($row = mysqli_fetch_assoc($verifications)):
                                ?>
                                <tr>
                                    <td><?= $counter++ ?></td>
                                    <td><?= $row['ward_no'] ?></td>
                                    <td><?= $row['road_name'] ?></td>
                                    <td class="d-none"><?= $row['group_no'] ?></td>
                                    <td><?= $row['owner_name'] ?></td>
                                    <td><?= $row['occupant_name'] ?></td>
                                    <td><?= number_format($row['capital_value'], 2) ?></td>
                                    <td><?= number_format($row['building_tax'], 2) ?></td>
                                    <td><?= number_format($row['health_tax'], 2) ?></td>
                                    <td><?= number_format($row['light_tax'], 2) ?></td>
                                    <td><?= number_format($row['water_tax'], 2) ?></td>
                                    <td><?= number_format($row['padsar_tax'], 2) ?></td>
                                    <td><?= number_format($row['final_tax'], 2) ?></td>
                                    <td class="d-none">
                                        <button class="btn btn-sm btn-primary" onclick="editVerification(
                                            '<?= $row['id'] ?>',
                                            '<?= $row['formula'] ?>',
                                            '<?= $row['village_code'] ?>',
                                            '<?= $row['period_id'] ?>',
                                            '<?= $row['malmatta_id'] ?>',
                                            '<?= $row['ward_no'] ?>',
                                            '<?= addslashes($row['owner_name']) ?>',
                                            '<?= addslashes($row['road_name']) ?>',
                                            '<?= addslashes($row['group_no']) ?>',
                                            '<?= addslashes($row['occupant_name']) ?>',
                                            '<?= $row['previous_tax'] ?>',
                                            '<?= $row['building_tax'] ?>',
                                            '<?= $row['light_tax'] ?>',
                                            '<?= $row['health_tax'] ?>',
                                            '<?= $row['water_tax'] ?>',
                                            '<?= $row['padsar_tax'] ?>',
                                            '<?= $row['capital_value'] ?>',
                                            '<?= $row['total_tax'] ?>',
                                            '<?= $row['discount'] ?>',
                                            '<?= $row['final_tax'] ?>',
                                            '<?= $row['verification_date'] ?>'
                                        )">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="14" class="text-center">प्रमाणिकरण माहिती सापडली नाही</td>
                                </tr>
                                <?php endif; ?>
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
    // Set current date as verification date
    document.addEventListener("DOMContentLoaded", function() {
        const verification_date = document.getElementById('verification_date');
        verification_date.value = new Date().toISOString().split('T')[0];
    });

    // Search property details
    document.getElementById('search-button').addEventListener('click', function() {
        const village = document.getElementById('village_name').value;
        const period = document.getElementById('period').value;
        const malmattaId = document.getElementById('malmatta_no').value;

        if (!village || !period || !malmattaId) {
            alert("कृपया सर्व फील्ड भरा");
            return;
        }

        const tbody = document.querySelector("#propertyTable tbody");
        tbody.innerHTML = ""; // Clear previous data

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

                    // Fill property details table
                    properties.forEach((prop, index) => {
                        console.log(prop);

                        const photoCell = prop.property_photo_path ?
                            `<td><img src="${prop.property_photo_path}" 
                 width="50" height="50" 
                 class="thumbnail-img"
                 style="cursor: pointer;"
                 data-fullimg="${prop.property_photo_path}"
                 onclick="showFullImage(this)"></td>` :
                            `<td>No photo</td>`;
                        const row = `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${info.malmatta_no}</td>
                                <td>${prop.property_use}</td>
                                <td>${prop.floor}</td>
                                <td>${prop.lenght || 0}</td>
                                <td>${prop.width || 0}</td>
                                <td>${prop.areaInFoot}</td>
                                <td>${prop.areaInMt}</td>
                                <td>${prop.construction_year}</td>
                                <td>${prop.yearly_tax}</td>
                                <td>${prop.construction_tax}</td>
                                <td>${prop.ghasara_tax}</td>
                                <td>${prop.bharank}</td>
                                <td>${prop.bhandavali}</td>
                                <td>${prop.milkat_fixed_tax}</td>
                                <td>${prop.building_value}</td>
                                ${photoCell}
                            </tr>
                        `;
                        tbody.insertAdjacentHTML("beforeend", row);
                    });

                    // Fill form fields
                    document.getElementById("previous_year_tax").value = info.previous_year_tax || 0;
                    document.getElementById("building_tax").value = info.building_total_value || 0;
                    document.getElementById("bhandavali_tax").value = info.total_bhandavali || 0;
                    document.getElementById('ward_no').value = info.ward_name || '';
                    document.getElementById('owner_name').value = info.owner_name || '';
                    document.getElementById('road_name').value = info.road_name || '';
                    document.getElementById('group_no').value = info.group_no || '';
                    document.getElementById('occupant_name').value = info.occupant_name || '';
                    document.getElementById('light_tax').value = taxRates.divabatti_prap_tharabaila_rate ||
                        0;
                    document.getElementById('health_tax').value = taxRates.arogya_prap_tharabaila_rate || 0;
                    document.getElementById('water_tax').value = waterTariff.fixed_rate || 0;
                    document.getElementById('padsar_tax').value = info.padsar_total_value || 0;

                    // Calculate totals
                    const buildingTax = parseFloat(info.building_total_value) || 0;
                    const lightTax = parseFloat(taxRates.divabatti_prap_tharabaila_rate) || 0;
                    const healthTax = parseFloat(taxRates.arogya_prap_tharabaila_rate) || 0;
                    const waterTax = parseFloat(waterTariff.fixed_rate) || 0;
                    const padsarTax = parseFloat(info.padsar_total_value) || 0;

                    const totalTax = buildingTax + lightTax + healthTax + waterTax + padsarTax;
                    document.getElementById('total_tax').value = totalTax.toFixed(2);

                    // Calculate final tax after discount
                    const discount = parseFloat(document.getElementById('discount').value) || 0;
                    const finalTax = totalTax - discount;
                    document.getElementById('total_tax_amount').value = finalTax.toFixed(2);
                } else {
                    alert("माहिती सापडली नाही.");
                }
            })
            .catch(err => {
                console.error(err);
                alert("त्रुटी आली.");
            });
    });

    // Calculate final tax when discount changes
    document.getElementById('discount').addEventListener('input', function() {
        const totalTax = parseFloat(document.getElementById('total_tax').value) || 0;
        const discount = parseFloat(this.value) || 0;
        const finalTax = totalTax - discount;
        document.getElementById('total_tax_amount').value = finalTax.toFixed(2);
    });

    // Edit verification record
    function editVerification(
        id, formula, villageCode, periodId, malmattaId, wardNo, ownerName,
        roadName, groupNo, occupantName, previousTax, buildingTax, lightTax,
        healthTax, waterTax, padsarTax, capitalValue, totalTax, discount,
        finalTax, verificationDate
    ) {
        // Set the verification ID
        document.getElementById('verification_id').value = id;

        // Set radio button
        document.querySelector(`input[name="formula"][value="${formula}"]`).checked = true;

        // Set dropdowns
        document.getElementById('village_name').value = villageCode;
        document.getElementById('period').value = periodId;
        document.getElementById('malmatta_no').value = malmattaId;

        // Set text fields
        document.getElementById('ward_no').value = wardNo;
        document.getElementById('owner_name').value = ownerName;
        document.getElementById('road_name').value = roadName;
        document.getElementById('group_no').value = groupNo;
        document.getElementById('occupant_name').value = occupantName;
        document.getElementById('previous_year_tax').value = previousTax;
        document.getElementById('building_tax').value = buildingTax;
        document.getElementById('light_tax').value = lightTax;
        document.getElementById('health_tax').value = healthTax;
        document.getElementById('water_tax').value = waterTax;
        document.getElementById('padsar_tax').value = padsarTax;
        document.getElementById('bhandavali_tax').value = capitalValue;
        document.getElementById('total_tax').value = totalTax;
        document.getElementById('discount').value = discount;
        document.getElementById('total_tax_amount').value = finalTax;
        document.getElementById('verification_date').value = verificationDate;

        // Change button text
        document.querySelector('button[name="save"]').textContent = 'अद्यतनित करा';

        // Scroll to form
        document.querySelector('form').scrollIntoView({
            behavior: 'smooth'
        });
    }

    // Reset form
    document.querySelector('button[type="reset"]').addEventListener('click', function() {
        document.getElementById('verification_id').value = '';
        document.querySelector('button[name="save"]').textContent = 'साठवा';
    });
    </script>
</body>

</html>