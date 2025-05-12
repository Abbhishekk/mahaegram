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
        include('include/sidebar.php');
       ?>
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <?php include('include/topbar.php'); ?>
                <!-- Topbar -->

                <!-- Container Fluid-->
                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">कालावधी माहिती</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">माहईग्राम</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 8</li>
                            <li class="breadcrumb-item active" aria-current="page">मास्टर्स</li>
                            <li class="breadcrumb-item active" aria-current="page">कालावधी माहिती</li>
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
                                <div class="card-body">
                                    <span class="text-danger">नमुना नंबर 8 कालावधी हा ४ वर्षाकरिता नोंद करावा.</span>
                                    <form method="post" action="api/duration.php">
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <label for="reason">कालावधी प्रकार निवडा <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <select class="form-control mb-3" name="reason" id="reason">
                                                    <option value=""> -- निवडा -- </option>
                                                    <?php
                                                        if(mysqli_num_rows($durationReason) > 0){
                                                            while($duration = mysqli_fetch_assoc($durationReason)){
                                                                echo "<option value='".$duration['id']."'>".$duration['reason']."</option>";
                                                            }
                                                        }
                                                    ?>
                                                </select>

                                                <input type="number" value="" class="form-control d-none" name="update"
                                                    id="update" aria-describedby="emailHelp">

                                            </div>

                                            <div class="form-group col-md-3" id="simple-date1">
                                                <label for="durationStart">कालावधी पासून <span
                                                        class="text-danger">*</span> </label>
                                                <div class="input-group date">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="fas fa-calendar"></i></span>
                                                    </div>
                                                    <input type="date" class="form-control" name="durationStart"
                                                        value="" id="durationStart">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3" id="simple-date1">
                                                <label for="durationEnd">कालावधी पर्यंत <span
                                                        class="text-danger">*</span> </label>
                                                <div class="input-group date">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="fas fa-calendar"></i></span>
                                                    </div>
                                                    <input type="date" class="form-control" name="durationEnd"
                                                        value="01/06/2020" id="durationEnd" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3" id="simple-date1">
                                                <label for="duration">एकूण कालावधी <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" value="" class="form-control" name="duration"
                                                    id="duration" aria-describedby="emailHelp" placeholder="कालावधी"
                                                    readonly>

                                            </div>

                                        </div>

                                        <button type="submit" name="add" id="submit"
                                            class="btn btn-primary">साठवणे</button>
                                        <button type="reset" class="btn btn-secondary">रद्द करणे</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">

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
                                                    <a href="#"
                                                        onclick="filldata('<?php echo $period['id']; ?>', '<?php echo $period['period_start']; ?>', '<?php echo $period['period_end']; ?>', '<?php echo $period['total_period']; ?>', '<?php echo $period['period_reason']; ?>')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            fill="currentColor" class="bi bi-pencil-square"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                            <path fill-rule="evenodd"
                                                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                                        </svg>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php
                                            $i++;
                                                    }
                                                }else{
                                                    echo "<tr><td colspan='4'>No data found</td></tr>";
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