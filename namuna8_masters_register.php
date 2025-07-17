<?php
require_once './include/auth_middleware.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php
$title = "रजिस्टर";
?>
<?php include('include/header.php'); ?>
<?php
$wards = $fun->getWard($_SESSION['district_code']);
$khasaraWardList = $fun->getRegisterMalmattaMappings();
    $malmatta_propertyVerifications = $fun->getPropertyVerificationsAccordingToPanchayat();

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
                        <h1 class="h3 mb-0 text-gray-800">रजिस्टर माहिती</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">पंचायत पोर्टल</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 8</li>
                            <li class="breadcrumb-item active" aria-current="page">मास्टर्स</li>
                            <li class="breadcrumb-item active" aria-current="page">रजिस्टर माहिती</li>
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
                                    <form id="khasaraWardForm">
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="register_no" class="form-label">रजिस्टर क्रमांक</label>
                                                <input type="text" id="register_no" name="register_no"
                                                    class="form-control" />
                                            </div>
                                               <div class="col-md-3 my-2 d-none" id="malmatta_no_div">
                                    <label class="form-label fw-bold" for="malmatta_no">मिळकत नंबर</label>
                                    <select class="form-control form-select border-primary select2-multiple" multiple name="malmatta_no[]"
                                        id="malmatta_no">
                                        <option value="">--निवडा--</option>
                                        <?php if(count($malmatta_propertyVerifications) > 0) {
                                            foreach($malmatta_propertyVerifications as $property) {
                                                // print_r($property);
                                            ?>
                                        <option value="<?php echo $property['malmatta_id']; ?>">
                                            <?php echo $property['malmatta_no']; ?>
                                        </option>
                                        <?php }
                                        } ?>
                                    </select>
                                </div>
                                            
                                        </div>
                                        <button type="button" id="saveBtn" class="btn btn-primary">साठवणे</button>
                                         <button type="button"class="btn btn-secondary px-4 ms-2" onclick="window.location.href='Form_Malmatta_N8.php'">
                            <i class="fas fa-redo me-2"></i>रद्द करा

                        </button>
                                    </form>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
    <div class="card mt-3">
        <div class="card-header">
            <h5 class="mb-0"></h5>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered mb-0 table-flush" id="dataTable">
                <thead class="thead-light">
                    <tr>
                        <th>अ.क्र.</th>
                        <th>रजिस्टर क्रमांक</th>
                        <!-- <th>मिळकत क्रमांक</th>
                        <th>मालकाचे नाव</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($khasaraWardList && mysqli_num_rows($khasaraWardList) > 0) {
                        $i = 1;
                        $currentKhasara = '';
                        $rowspanMap = [];

                        // Step 1: Group ward entries by register_no
                        while ($row = mysqli_fetch_assoc($khasaraWardList)) {
                            $rowspanMap[$row['register_no']][] = $row;
                        }

                        // Step 2: Display grouped data
                        foreach ($rowspanMap as $register_no => $wards) {
                            $first = true;
                            foreach ($wards as $ward) {
                                // print_r($ward);
                                echo "<tr>";
                                if ($first) {
                                    echo "<td rowspan='" . count($wards) . "'>$i</td>";
                                    echo "<td rowspan='" . count($wards) . "'>$register_no</td>";
                                    $first = false;
                                    $i++;
                                }
                                // echo "<td>{$ward['malmatta_no']}</td><td>{$ward['owner']}</td></tr>";
                            }
                        }
                    } else {
                        echo "<tr><td colspan='4' class='text-center'>कोणतीही नोंद उपलब्ध नाही.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
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
        function filldata(ward_no, ward_name) {
            document.getElementById('ward_no').value = ward_no;
            document.getElementById('ward_name').value = ward_name;
        }
    </script>
    <script>
 const registerInput = document.getElementById('register_no');
const malmattaSelect = $('#malmatta_no');

registerInput.addEventListener('blur', () => {
    const regNo = registerInput.value.trim();
    if (!regNo) return;
    $.post('api/register_malmatta.php', { action: 'fetch', register_no: regNo }, resp => {
        if (resp.success) {
            malmattaSelect.val(resp.malmatta_ids).trigger('change');
        } else {
            malmattaSelect.val([]).trigger('change');
        }
    }, 'json');
});

document.getElementById('saveBtn').addEventListener('click', () => {
    const regNo = registerInput.value.trim();
    const mids = malmattaSelect.val() || [];
    if (!regNo) return alert('रजिस्टर क्रमांक आवश्यक आहे');

    $.post('api/register_malmatta.php', {
        action: 'save',
        register_no: regNo,
        malmatta_no: mids
    }, resp => {
        alert(resp.msg);
        window.location.reload();
    }, 'json');
});

</script>

</body>

</html>