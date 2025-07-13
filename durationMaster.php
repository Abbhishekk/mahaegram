<?php 
    require_once './include/auth_middleware.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php 
$title = "कालावधी माहिती";
?>
<?php include('include/header.php'); ?>
<?php
    $durationReason = $fun->getDurationReason();
    $durationReasons = $fun->getDurationReason();
    $periods = $fun->getPeriodDetails($_SESSION['district_code']);
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
                        <h1 class="h3 mb-0 text-gray-800">कालावधी माहिती</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">पंचायत पोर्टल </a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 8</li>
                            <li class="breadcrumb-item active" aria-current="page">मास्टर्स</li>
                            <li class="breadcrumb-item active" aria-current="page">कालावधी माहिती</li>
                        </ol>
                    </div>

                   <div class="row mb-3">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-primary">
                <h6 class="m-0 font-weight-bold text-white">कालावधी व्यवस्थापन</h6>
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
                <form method="post" action="api/duration.php">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="form-floating">
                                <select class="form-select border-primary" name="reason" id="reason" required>
                                    <option value=""> -- निवडा -- </option>
                                    <?php
                                    if(mysqli_num_rows($durationReason) > 0){
                                        while($duration = mysqli_fetch_assoc($durationReason)){
                                            echo "<option value='".$duration['id']."'>".$duration['reason']."</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <label for="reason">कालावधी प्रकार निवडा <span class="text-danger">*</span></label>
                                <input type="number" value="" class="form-control d-none" name="update" id="update">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-floating">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    <input type="date" class="form-control border-primary" name="durationStart" 
                                           value="" id="durationStart" required>
                                    <label for="durationStart">कालावधी पासून <span class="text-danger">*</span></label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-floating">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    <input type="date" class="form-control border-primary" name="durationEnd" 
                                           value="01/06/2020" id="durationEnd" readonly>
                                    <label for="durationEnd">कालावधी पर्यंत <span class="text-danger">*</span></label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-floating">
                                <input type="text" class="form-control border-primary" name="duration" 
                                       id="duration" placeholder="कालावधी" readonly>
                                <label for="duration">एकूण कालावधी <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mt-4">
                        <button type="submit" name="add" id="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save me-2"></i>साठवणे
                        </button>
                        <button type="reset" class="btn btn-outline-danger px-4">
                            <i class="fas fa-times me-2"></i>रद्द करणे
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card shadow">
            <div class="card-header py-3 bg-primary">
                <h6 class="m-0 font-weight-bold text-white">कालावधी यादी</h6>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                        <tr>
                            <th>अ.क्र.</th>
                            <th>कालावधी पासून</th>
                            <th>कालावधी पर्यंत</th>
                            <th>एकूण कालावधी</th>
                            <th>कालावधी प्रकार</th>
                            <th>बदल</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(mysqli_num_rows($periods) > 0){
                            $i = 1;
                            while($period = mysqli_fetch_assoc($periods)){
                        ?>
                        <tr>
                            <td><a href="#"><?php echo $i; ?></a></td>
                            <td><?php echo $period['period_start']; ?></td>
                            <td><?php echo $period['period_end']; ?></td>
                            <td><?php echo $period['total_period']; ?></td>
                            <td><?php echo $period['period_reason']; ?></td>
                            <td>
                                <a href="#" class="text-primary" 
                                   onclick="filldata('<?php echo $period['id']; ?>', '<?php echo $period['period_start']; ?>', '<?php echo $period['period_end']; ?>', '<?php echo $period['total_period']; ?>', '<?php echo $period['period_reason']; ?>')">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <?php
                        $i++;
                            }
                        }else{
                            echo "<tr><td colspan='6' class='text-center'>No data found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer"></div>
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
    function filldata(id, period_start, period_end, total_period, period_reason) {
        document.getElementById('update').value = id;

        const reasonSelect = document.getElementById('reason');
        for (let option of reasonSelect.options) {
            if (option.text === period_reason) {
                reasonSelect.value = option.value;
                break;
            }
        }

        document.getElementById('durationStart').disabled = false;
        document.getElementById('durationEnd').disabled = false;

        document.getElementById('durationStart').value = period_start;
        document.getElementById('durationEnd').value = period_end;
        document.getElementById('duration').value = total_period;

        document.getElementById('submit').disabled = false;
    }


    document.addEventListener("DOMContentLoaded", function() {
        const reasonSelect = document.getElementById("reason");
        const durationStart = document.getElementById("durationStart");
        const durationEnd = document.getElementById("durationEnd");
        const duration = document.getElementById("duration");
        const submitButton = document.getElementById("submit");
        const reasonYears = {
            <?php
                if (mysqli_num_rows($durationReasons) > 0) {
                    while ($durationReason = mysqli_fetch_assoc($durationReasons)) {
                        echo $durationReason['id'].":"."'" . $durationReason['duration'] . "',";
                    }
                }
            ?>
        };

        console.log(reasonYears);


        // Disable fields initially
        durationStart.disabled = true;
        durationEnd.disabled = true;
        submitButton.disabled = true;

        // Function to update duration field
        function updateDuration() {
            const startDate = new Date(durationStart.value);
            const reasonId = reasonSelect.value;
            const yearsToAdd = parseInt(reasonYears[reasonId]);

            if (!isNaN(startDate) && !isNaN(yearsToAdd)) {
                const endDate = new Date(startDate);
                endDate.setFullYear(endDate.getFullYear() + yearsToAdd);
                endDate.setDate(endDate.getDate() - 1); // Subtract 1 day

                durationEnd.value = endDate.toISOString().split("T")[0];
                duration.value = `${startDate.getFullYear()}-${endDate.getFullYear()}`;
                checkSubmitCondition();
            }
        }



        // Enable date inputs when a reason is selected
        reasonSelect.addEventListener("change", function() {
            if (this.value) {
                const today = new Date();
                const fourYearsFromToday = new Date(today);
                fourYearsFromToday.setFullYear(fourYearsFromToday.getFullYear() + Number(
                    reasonYears[this.value]));
                fourYearsFromToday.setDate(fourYearsFromToday.getDate() - 1); // Subtract 1 day

                durationStart.disabled = false;
                durationEnd.disabled = false;
                durationStart.value = today.toISOString().split("T")[0];
                durationEnd.value = fourYearsFromToday.toISOString().split("T")[0];

                updateDuration();
            } else {
                durationStart.disabled = true;
                durationEnd.disabled = true;
                submitButton.disabled = true;
                duration.value = "";
            }
        });


        // Update duration on date change
        durationStart.addEventListener("change", updateDuration);
        durationEnd.addEventListener("change", updateDuration);

        // Check if all fields are filled before enabling submit button
        function checkSubmitCondition() {
            if (reasonSelect.value && durationStart.value && durationEnd.value && duration.value) {
                submitButton.disabled = false;
            } else {
                submitButton.disabled = true;
            }
        }
    });
    </script>
</body>

</html>