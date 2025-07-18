<?php
require_once './include/auth_middleware.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php
$title = "पाणीपट्टी दर";
?>
<?php include('include/header.php'); ?>
<?php
$waterTariff = $fun->getWaterTariff($_SESSION['district_code']);
$durationReason = $fun->getDurationReason();
$drainageTypes = $fun->getDrainageTypes();
$property_verifications = $fun->getPropertyVerificationsAccordingToPanchayat();

$periodTotalPeriod = $fun->getPeriodTotalPeriodsWithPeriodReason("पाणीपट्टी कालावधी", $_SESSION['district_code']);
$periodsWithReasons = $fun->getPeriodTotalPeriodsWithPeriodReason("पाणीपट्टी कालावधी", $_SESSION['district_code']);
$yearArray = $fun->getYearArray($periodsWithReasons);
$waterTariffReading = $fun->getWaterTariffForPanniReading();
$periodCount = mysqli_num_rows($periodTotalPeriod);
if ($periodCount == 0) {
    $_SESSION['message'] = "⚠️ कृपया पाणीपट्टी कालावधी आधीच भरा!";
    $_SESSION['message_type'] = "danger";
}
?>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php
        $page = 'namuna8';
        $subpage = 'wardMaster';
        ?>
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <?php include('include/topbar.php');
                include('include/sidebar.php'); ?>
                <!-- Topbar -->

                <!-- Container Fluid-->
                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">पाणीपट्टी दर </h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">पंचायत पोर्टल</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 9</li>
                            <li class="breadcrumb-item active" aria-current="page">मास्टर्स</li>
                            <li class="breadcrumb-item active" aria-current="page">पाणीपट्टी दर माहिती</li>
                        </ol>
                    </div>

                    <div class="card shadow mb-4">
    <div class="card-header py-3 bg-primary">
        <h6 class="m-0 font-weight-bold text-white">पाणीपट्टी कर नोंद</h6>
    </div>
    <div class="card-body">
        <?php
        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            $message_type = $_SESSION['message_type'];
            echo "<div class='alert alert-$message_type'>$message</div>";
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
        }
        ?>
        
        <form id="waterTaxForm">
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-select border-primary" name="khasara_no" id="khasara_no">
                            <option value="">--निवडा--</option>
                            <?php
                            $khasaraNos = $fun->getKhasaraWard();
                            if (mysqli_num_rows($khasaraNos) > 0) {
                                while ($ward = mysqli_fetch_assoc($khasaraNos)) {
                                    echo '<option value="' . $ward['khasara_no'] . '">' . $ward['khasara_no'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                        <label for="khasara_no">खसारा क्रमांक</label>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-select border-primary select2-single-placeholder" name="malmatta_no" id="malmatta_no">
                            <option value="">--निवडा--</option>
                            <?php
                            foreach ($property_verifications as $property) {
                                if ($property['status'] != 0) continue;
                                echo "<option value='{$property['malmatta_id']}'>{$property['malmatta_no']}</option>";
                            }
                            ?>
                        </select>
                        <label for="malmatta_no">मालमत्ता क्रमांक</label>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-select border-primary" name="financial_year" required>
                            <option value="">--निवडा--</option>
                            <?php
                            foreach ($yearArray as $year) {
                                echo "<option value='$year'>$year</option>";
                            }
                            ?>
                        </select>
                        <label for="financial_year">आर्थिक वर्ष</label>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-select border-primary" id="entryType" onchange="generateTable()" required>
                            <option value="">--निवडा--</option>
                            <option value="monthly">मासिक</option>
                            <option value="yearly">वार्षिक</option>
                        </select>
                        <label for="entryType">टाईपी</label>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-select border-primary" id="pani_prakar" onchange="updateTaxRate()" name="pani_prakar" required>
                            <option value="">--निवडा--</option>
                            <?php
                            if (mysqli_num_rows($waterTariffReading) > 0) {
                                while ($water = mysqli_fetch_assoc($waterTariffReading)) {
                                    echo "<option value='{$water['id']}' data-rate='{$water['fixed_rate']}'>{$water['drainage_type']} - ₹{$water['fixed_rate']}/unit</option>";
                                }
                            } else {
                                echo "<option value=''>पाणीपट्टी प्रकार डेटा उपलब्ध नाही</option>";
                            }
                            ?>
                        </select>
                        <label for="pani_prakar">पाणीपट्टी प्रकार</label>
                    </div>
                </div>
            </div>

            <div id="readingsTableContainer" class="mb-4"></div>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <h6 class="text-primary fw-bold">संपूर्ण टॅक्स: ₹<span id="totalTax">0</span></h6>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control border-primary" id="ittar_aakar" name="ittar_aakar">
                        <label for="ittar_aakar">इतर आकार</label>
                    </div>
                </div>
            </div>

            <div class="mt-4 text-center">
                <button type="submit" class="btn btn-primary px-4 me-3">
                    <i class="fas fa-paper-plane me-2"></i>सबमिट करा
                </button>
                <button type="reset" class="btn btn-outline-secondary px-4">
                    <i class="fas fa-times me-2"></i>रद्द करा
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow mt-4">
    <div class="card-header py-3 bg-primary">
        <h6 class="m-0 font-weight-bold text-white">नवीन भरलेली पाणीपट्टी नोंद</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-primary">
                    <tr>
                        <th>मालमत्ता क्रमांक</th>
                        <th>आर्थिक वर्ष</th>
                        <th>खसारा क्रमांक</th>
                        <th>पाण्याचा प्रकार</th>
                        <th>संपूर्ण टॅक्स</th>
                        <th>इतर आकार</th>
                        <th>April</th>
                        <th>May</th>
                        <th>Jun</th>
                        <th>Jul</th>
                        <th>Aug</th>
                        <th>Sep</th>
                        <th>Oct</th>
                        <th>Nov</th>
                        <th>Dec</th>
                        <th>Jan</th>
                        <th>Feb</th>
                        <th>Mar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $submittedWaterTax = $fun->getWaterTaxEntries($_SESSION['district_code']);
                    if ($submittedWaterTax && mysqli_num_rows($submittedWaterTax) > 0) {
                        while ($tax = mysqli_fetch_assoc($submittedWaterTax)) {
                            echo "<tr>
                                <td>{$tax['malmatta_no_mde']}</td>
                                <td>{$tax['year']}</td>
                                <td>{$tax['khasara_no_wt']}</td>
                                <td>{$tax['drainage_type']}</td>
                                <td>₹{$tax['total_amount']}</td>
                                <td>{$tax['ittar_aakar']}</td>
                                <td>{$tax['april_reading']}</td>
                                <td>{$tax['may_reading']}</td>
                                <td>{$tax['jun_reading']}</td>
                                <td>{$tax['jul_reading']}</td>
                                <td>{$tax['aug_reading']}</td>
                                <td>{$tax['sep_reading']}</td>
                                <td>{$tax['oct_reading']}</td>
                                <td>{$tax['nov_reading']}</td>
                                <td>{$tax['dec_reading']}</td>
                                <td>{$tax['jan_reading']}</td>
                                <td>{$tax['feb_reading']}</td>
                                <td>{$tax['mar_reading']}</td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='18' class='text-center'>कोणतीही नोंद उपलब्ध नाही.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
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
        const months = ["April", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec", "Jan", "Feb", "Mar"];
        let currentTaxRate = 0;

        function updateTaxRate() {
            const prakar = document.getElementById("pani_prakar");
            const selectedOption = prakar.options[prakar.selectedIndex];
            currentTaxRate = parseInt(selectedOption.getAttribute("data-rate")) || 0;
            calculateTotal();
        }

        function generateTable() {
            const type = document.getElementById("entryType").value;
            const columns = (type === "monthly") ? months : ["Year"];
            const container = document.getElementById("readingsTableContainer");
            container.innerHTML = "";

            const table = document.createElement("table");
            table.className = "table table-bordered";

            const headerRow = document.createElement("tr");
            headerRow.innerHTML = `<th></th>` + columns.map(col => `<th>${col}</th>`).join('');
            table.appendChild(headerRow);

            const rows = ["Magil Reading", "Chalu Reading", "Wapar Kele"];
            rows.forEach((label, rowIndex) => {
                const row = document.createElement("tr");
                row.innerHTML = `<td><strong>${label}</strong></td>`;
                columns.forEach((col, colIndex) => {
                    const id = `${label.toLowerCase().replace(" ", "_")}_${colIndex}`;
                    const isReadonly = rowIndex === 2;
                    row.innerHTML += `
          <td>
            <input type="number" class="form-control ${label === "Wapar Kele" ? "readonly" : ""}" 
              id="${id}" ${isReadonly ? "readonly" : ""} 
              oninput="${rowIndex < 2 ? 'calculateWaparKele()' : ''}">
          </td>`;
                });
                table.appendChild(row);
            });

            container.appendChild(table);
            calculateTotal();
        }

        function calculateWaparKele() {
            const type = document.getElementById("entryType").value;
            const cols = (type === "monthly") ? months.length : 1;
            let totalUsage = 0;

            for (let i = 0; i < cols; i++) {
                const magil = parseFloat(document.getElementById(`magil_reading_${i}`).value) || 0;
                const chalu = parseFloat(document.getElementById(`chalu_reading_${i}`).value) || 0;
                const usage = Math.abs(chalu - magil);

                document.getElementById(`wapar_kele_${i}`).value = usage;
                totalUsage += usage;
            }

            document.getElementById("totalTax").innerText = totalUsage * currentTaxRate;
        }

        function calculateTotal() {
            calculateWaparKele(); // recalculate tax on rate change
        }

        document.getElementById("waterTaxForm").addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const type = document.getElementById("entryType").value;
            const cols = (type === "monthly") ? months.length : 1;
            const khasara_no = document.getElementById("khasara_no").value;

            for (let i = 0; i < cols; i++) {
                const monthKey = (type === "monthly") ? months[i].toLowerCase() + "_reading" : "april_reading";
                formData.append(monthKey, document.getElementById(`wapar_kele_${i}`).value);
            }

            formData.append("total_amount", document.getElementById("totalTax").innerText);
            formData.append("khasara_no", khasara_no);
            // Submit data to PHP
            fetch("api/save_water_tax.php", {
                method: "POST",
                body: formData
            }).then(res => res.text()).then(resp => {
                console.log(resp);

                alert("Saved successfully!");
                window.location.reload(); // Reload to see the new entry
                console.log(resp);
            }).catch(err => console.error(err));
        });

        let editingId = null;

        document.getElementById("malmatta_no").addEventListener("change", checkExistingEntry);
        document.querySelector("[name='financial_year']").addEventListener("change", checkExistingEntry);

        function checkExistingEntry() {
            const malmatta_no = document.getElementById("malmatta_no").value;
            const year = document.querySelector("[name='financial_year']").value;

            if (!malmatta_no || !year) return;

            const formData = new FormData();
            formData.append("malmatta_no", malmatta_no);
            formData.append("year", year);

            fetch("api/get_water_tax_entry.php", {
                method: "POST",
                body: formData
            }).then(res => res.json()).then(data => {
                if (data.success) {
                    editingId = data.data.id;
                    document.getElementById("entryType").value = "monthly"; // assuming monthly always
                    generateTable();

                    // Fill the fields
                    const readings = data.data;
                    months.forEach((month, i) => {
                        const key = month.toLowerCase() + "_reading";
                        const val = readings[key] || "0";

                        const magil = document.getElementById(`magil_reading_${i}`);
                        const chalu = document.getElementById(`chalu_reading_${i}`);

                        if (magil && chalu) {
                            magil.value = 0;
                            chalu.value = parseFloat(val);
                        }
                    });

                    calculateWaparKele();

                    // Set pani_prakar
                    document.getElementById("pani_prakar").value = readings.pani_prakar;
                    updateTaxRate();
                } else {
                    editingId = null;
                }
            }).catch(err => console.error(err));
        }

    </script>
</body>

</html>