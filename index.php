<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Panchayat Portal</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!--<link rel="stylesheet" href="styles.css" />-->
  <style>
    .object-fit-cover {
      object-fit: cover;
    }
    .bg-sky{
    background-color: #002244;
    color: white;
}

.navbar-brand {
    letter-spacing: 3px;
    color: black;
}


.navbar-brand:hover {
    color: white;
    transition: all 0.5s;
}


.navbar-scroll .nav-link,
.navbar-scroll .fa-bars {
    color: white;
}

.navbar-scrolled .nav-link,
.navbar-scrolled .fa-bars {
    color: white;
}

.navbar-scrolled {
    background-color: #ffede7;
}

.navbar-nav li a {
    font-weight: bold;
}

/* .navbar-nav li {
    border-left: 1px solid black;
} */

.navbar-nav li:first-child {
    border-left: none;
}

.navbar-toggler{
    border: 2px solid white;
}



/* card css */

#liSlider .carousel-item {
    background-color: transparent;
    width: 100%; /* Full width for individual carousel items */
}
    #liSlider .carousel-inner {
        background-color: transparent;
    }

    #liSlider .carousel-item {
        background-color: transparent;
    }

    #liSlider .list-group-item {
        background-color: transparent;
        border: none; /* Optional: Remove list item borders for a cleaner look */
        color: black; /* Set text color to ensure visibility */
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        filter: invert(1); /* Turns control icons white for better visibility */
    }
    .bg-glass{
       
        background: rgba(255, 255, 255, 0.1); /* Transparent white */
        border-radius: 20px;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1); 
        backdrop-filter: blur(1px); /* Core Glassmorphism effect */
        -webkit-backdrop-filter: blur(5px); /* For Safari support */
        border: 1px solid rgba(255, 255, 255, 0.3);
        display: flex;
        justify-content: center;
        align-items: center;
        color: #fff;
        
        font-size: 24px;
        text-align: center;
    }




    .glass-effect {
        width: 400px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1); /* Transparent white */
        border-radius: 20px;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1); 
        backdrop-filter: blur(15px); /* Core Glassmorphism effect */
        -webkit-backdrop-filter: blur(15px); /* For Safari support */
        border: 1px solid rgba(255, 255, 255, 0.3);
        display: flex;
        justify-content: center;
        align-items: center;
        color: #fff;
        font-size: 24px;
        text-align: center;
    }




   .form-image {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .form-container {
      min-height: 100vh;
    }
  </style>
</head>
<body style="background-color: rgba(232, 255, 255, 0.488);">
  <!-- Header -->
  <header>
    <div class="container-fluid border-top border-bottom border-secondary ">
      <div class="container-xxl my-3 ">
        <div class="d-flex justify-content-between ">
          <div class="d-flex justify-content-center align-items-center gap-3">
            <!-- <img src="img/emblem.svg" alt="" height="88px"> -->
            <div class="text-start mt-2">
              <p>पंचायत पोर्टल <br>
                <span class="h4"><strong>Panchayat Portal</strong></span>
              </p>
            </div>
          </div>
          <div class="d-flex justify-content-center align-items-center gap-3 d-none d-sm-inline-flex">
            <!-- <img src="img/2023012956.png" alt="" height="88px"> -->
            <!-- <img src="img/2023021046-e1676007895778.png" alt="" height="88px"> -->
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- Navbar -->
  <section>
    <nav class="navbar navbar-expand-lg navbar-scroll shadow-0 bg-sky">
      <div class="container-xxl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarExample01">
          <span><i class="fa fa-bars"></i></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarExample01">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item active"><a class="nav-link px-4" href="#">मुख्य पृष्ठ</a></li>
            
            
            <li class="nav-item"><a class="nav-link px-4" href="#">आमच्याबद्दल</a></li>
           
           
            <li class="nav-item"><a class="nav-link px-4" href="#">संपर्क</a></li>
           
           
            <li class="nav-item"><a href="register.php" class="btn btn-primary btn-md mb-3 mb-lg-0 ms-lg-5">Register</a></li>
            <li class="nav-item"><a href="login.php" class="btn btn-primary btn-md mb-3 mb-lg-0 ms-lg-5">Login</a></li>
          </ul>
        </div>
      </div>
    </nav>
  </section>

  <!-- Carousel + Form in same row -->
  <section class="py-4">
    <div class="container-xxl">
      <div class="row">
        <!-- Carousel -->
        <div class="col-lg-7 mb-4 mb-lg-0">
          <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" style="height: 65vh;">
            <div class="carousel-inner h-100">
              <div class="carousel-item active h-100">
                <img src="img/im5.png" class="d-block w-100 h-100 object-fit-cover" alt="...">
              </div>
              <div class="carousel-item h-100">
                <img src="img/im2.webp" class="d-block w-100 h-100 object-fit-cover" alt="...">
              </div>
              <div class="carousel-item h-100">
                <img src="img/im1.jpg" class="d-block w-100 h-100 object-fit-cover" alt="...">
              </div>
              <div class="carousel-item h-100">
                <img src="img/im3.jpg" class="d-block w-100 h-100 object-fit-cover" alt="...">
              </div>
               <div class="carousel-item h-100">
                <img src="img/im3.jpg" class="d-block w-100 h-100 object-fit-cover" alt="...">
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
              <span class="carousel-control-prev-icon"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
              <span class="carousel-control-next-icon"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>

        <!-- Form -->
        <div class="col-lg-5 " style="place-content: center;">
          <div class=" bg-white shadow-sm p-4 rounded">
            <form>
              <div class="mb-3">
                <label for="district" class="form-label">जिल्ह्याचे नाव</label>
                <select class="form-select" id="district" required>
                  <option value="पुणे">पुणे</option>
                  <option value="सातारा">सातारा</option>
                  <option value="कोल्हापूर">कोल्हापूर</option>
                  <option value="सांगली">सांगली</option>
                  <option value="सोलापूर">सोलापूर</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="taluka" class="form-label">तालुक्याचे नाव</label>
                <input type="text" class="form-control" id="taluka" placeholder="तालुक्याचे नाव" required>
              </div>
              <div class="mb-3">
                <label for="grampanchayat" class="form-label">ग्रामपंचायतीचे नाव</label>
                <input type="text" class="form-control" id="grampanchayat" placeholder="ग्रामपंचायतीचे नाव" required>
              </div>
              <div class="mb-3">
                <label for="search" class="form-label">Grampanchayat Name</label>
                <div class="input-group">
                  <input type="search" class="form-control" id="search" placeholder="Search Grampanchayat Name">
                  <button class="btn btn-outline-secondary" type="button" id="searchBtn">
                    <i class="fa fa-search"></i> Search
                  </button>
                </div>
              </div>
              <button type="submit" class="btn btn-primary w-100">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="latest-news-section" class="">
            <div class="container-fluid">
                <div class="row">
                    <div
    class="col-12 col-sm-2 border text-center bg-sky border-secondary rounded-1 d-flex align-items-center justify-content-center py-4 news-label">
    <p class="h6 m-0 text-decoration-underline"><strong>ताजी बातमी</strong></p>
</div>


                    <div class="col-12 col-sm-10 border border-secondary rounded-1 py-3 news-content  ">
                        <div id="liSlider" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                 <div class="carousel-item active">
                                    <ul class="list-group">
                                        <li class="list-group-item p-1 small text-center ">📰 महाराष्ट्रात आजपासून जोरदार पावसास सुरुवात, शेतकरी आनंदित.</li>
                                    </ul>
                                </div>
                                <div class="carousel-item">
                                    <ul class="list-group">
                                        <li class="list-group-item p-1 small text-center">🌧️ हवामान विभागाने पुढील ५ दिवस मुसळधार पावसाचा इशारा दिला आहे.
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

</body>
</html>