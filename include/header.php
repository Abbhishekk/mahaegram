<head>
    <?php 
    include "connect/db.php";
    include "connect/fun.php";
    if(!isset($title)) {
        $title = "";
    }
    
    $connect = new Connect();
    $db = $connect->dbConnect();
    $fun = new Fun($connect->dbConnect());
  ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="img/logo/logo.png" rel="icon">
    <title> <?php echo $title != ""? $title : "One Gov"; ?> </title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="vendor/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css">


    <!-- Bootstrap 5.3 CSS -->
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> 
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


<!-- Optional: Font Awesome (for icons) -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<!-- Bootstrap Bundle JS (includes Popper.js for dropdowns) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="../js/translate.js"></script>
    <style>
    /* Style for the modal overlay */
    /* .image-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.9);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1500;
        cursor: zoom-out;
    } */

    /* Style for the enlarged image */
    .enlarged-image {
        max-width: 90%;
        max-height: 90%;
        object-fit: contain;
    }

    /* Style for thumbnail images */
    .thumbnail-img {
        transition: transform 0.2s;
        border-radius: 4px;
        border: 1px solid #ddd;
    }

    .thumbnail-img:hover {
        transform: scale(1.05);
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    }

    /* Close button style */
    .close-btn {
        position: absolute;
        top: 20px;
        right: 30px;
        color: white;
        font-size: 40px;
        font-weight: bold;
        cursor: pointer;
    }

    .close-btn:hover {
        color: #ccc;
    }

/* Custom hover dropdown support */
.navbar-nav .dropdown:hover > .dropdown-menu {
  display: block;
  margin-top: 0;
}
.dropdown-submenu {
  position: relative;
}
.dropdown-submenu > .dropdown-menu {
  top: 0;
  left: 100%;
  margin-top: -1px;
  display: none;
}
.dropdown-submenu:hover > .dropdown-menu {
  display: block;
}
.dropdown-menu {
  border-radius: 0.25rem;
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
}


.navbar {
  font-size: 1rem;
  font-weight: 500;
}
.navbar .nav-link {
  color: white !important;
  transition: background-color 0.3s ease, color 0.3s ease;
  padding: 10px 16px;
  border-radius: 5px;
}
.navbar .nav-link:hover,
.navbar .nav-link:focus {
  background-color: rgba(255, 255, 255, 0.15);
  color: #fff;
}
.navbar-nav .dropdown-menu {
  background-color: #ffffff;
  border: 1px solid #ddd;
}
.dropdown-item:hover {
  background-color: #f0f0f0;
}
.dropdown-submenu {
  position: relative;
}
.dropdown-submenu > .dropdown-menu {
  top: 0;
  left: 100%;
  margin-top: -1px;
  display: none;
}
/* .dropdown-submenu:hover > .dropdown-menu {
  display: block;
} */
.dropdown-menu {
  border-radius: 0.25rem;
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
}




</style>





</head>