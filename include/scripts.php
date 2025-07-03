<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="js/ruang-admin.min.js"></script>
<script src="vendor/chart.js/Chart.min.js"></script>
<script src="js/demo/chart-area-demo.js"></script>
<!-- Add these to your header -->
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.11.3/b-2.1.1/b-html5-2.1.1/b-print-2.1.1/datatables.min.js"></script>
<script src="vendor/select2/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('#dataTable').DataTable(); // ID From dataTable 
        $('#dataTableHover').DataTable(); // ID From dataTable with Hover
    });
</script>
<script>
$(document).ready(function() {
    $('.select2-single').select2();

    // Select2 Single  with Placeholder
    $('.select2-single-placeholder').select2({
        placeholder: "Select a Province",
        allowClear: true
    });

    // Select2 Multiple
    $('.select2-multiple').select2();

});

function showFullImage(imgElement) {
    const fullImgUrl = imgElement.getAttribute('data-fullimg');

    // Create modal overlay
    const overlay = document.createElement('div');
    overlay.style.position = 'fixed';
    overlay.style.top = '0';
    overlay.style.left = '0';
    overlay.style.width = '100%';
    overlay.style.height = '100%';
    overlay.style.backgroundColor = 'rgba(0,0,0,0.8)';
    overlay.style.zIndex = '1000';
    overlay.style.display = 'flex';
    overlay.style.justifyContent = 'center';
    overlay.style.alignItems = 'center';
    overlay.style.cursor = 'pointer';
    overlay.onclick = function() {
        document.body.removeChild(overlay);
    };

    // Create image element
    const fullImg = document.createElement('img');
    fullImg.src = fullImgUrl;
    fullImg.style.maxWidth = '90%';
    fullImg.style.maxHeight = '90%';
    fullImg.style.objectFit = 'contain';

    // Prevent clicks on image from closing the modal
    fullImg.onclick = function(e) {
        e.stopPropagation();
    };

    // Add close button
    const closeBtn = document.createElement('span');
    closeBtn.innerHTML = '&times;';
    closeBtn.style.position = 'absolute';
    closeBtn.style.top = '20px';
    closeBtn.style.right = '30px';
    closeBtn.style.color = 'white';
    closeBtn.style.fontSize = '40px';
    closeBtn.style.fontWeight = 'bold';
    closeBtn.style.cursor = 'pointer';
    closeBtn.onclick = function() {
        document.body.removeChild(overlay);
    };

    overlay.appendChild(fullImg);
    overlay.appendChild(closeBtn);
    document.body.appendChild(overlay);
}
</script>