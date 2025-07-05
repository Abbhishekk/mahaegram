<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Panchayat Portal</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Noto+Sans+Devanagari:wght@400;500&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    :root {
      --govt-blue: #002244;
      --govt-green: #006400;
      --govt-gold: #D4AF37;
      --govt-light: #f5f9ff;
    }
    
    body {
      font-family: 'Poppins', sans-serif;
      background-color: var(--govt-light);
      color: #333;
    }
    
    .dev-font {
      font-family: 'Noto Sans Devanagari', sans-serif;
    }
    
    .object-fit-cover {
      object-fit: cover;
    }
    
    /* Header Styles */
    .header-container {
      background: linear-gradient(135deg, var(--govt-blue) 0%, var(--govt-green) 100%);
      color: white;
      border-bottom: 3px solid var(--govt-gold);
    }
    
    .header-title {
      font-weight: 600;
      letter-spacing: 1px;
      text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
    }
    
    /* Navbar Styles */
    .navbar-main {
      background: linear-gradient(to right, var(--govt-blue), #003366);
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .navbar-main .nav-link {
      color: white !important;
      font-weight: 500;
      padding: 0.5rem 1.5rem;
      transition: all 0.3s ease;
      border-right: 1px solid rgba(255,255,255,0.1);
    }
    
    .navbar-main .nav-link:hover {
      background-color: rgba(255,255,255,0.1);
      transform: translateY(-2px);
    }
    
    .navbar-main .nav-item:last-child .nav-link {
      border-right: none;
    }
    
    .btn-govt {
      background-color: var(--govt-gold);
      color: var(--govt-blue);
      font-weight: 600;
      border: none;
      transition: all 0.3s ease;
    }
    
    .btn-govt:hover {
      background-color: #c9a227;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    /* Carousel Styles */
    .main-carousel {
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      border: 2px solid var(--govt-blue);
    }
    
    .carousel-control-prev, .carousel-control-next {
      width: 5%;
      background-color: rgba(0,0,0,0.2);
    }
    
    /* Form Styles */
    .search-form {
      background: white;
      border-radius: 8px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      border-top: 4px solid var(--govt-blue);
    }
    
    .form-label {
      font-weight: 500;
      color: var(--govt-blue);
    }
    
    .form-control, .form-select {
      border: 1px solid #ced4da;
      transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
      border-color: var(--govt-blue);
      box-shadow: 0 0 0 0.25rem rgba(0, 34, 68, 0.25);
    }
    
    /* News Ticker */
    .news-container {
      background: linear-gradient(to right, var(--govt-blue), #003366);
      color: white;
      border-radius: 8px;
      overflow: hidden;
    }
    
    .news-label {
      background: var(--govt-gold);
      color: var(--govt-blue);
      font-weight: 600;
    }
    
    .news-content {
      background: rgba(255,255,255,0.9);
    }
    
    /* Process Cards */
    .process-card {
      transition: all 0.3s ease;
      border-top: 4px solid;
      height: 100%;
    }
    
    .process-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .step-a { border-color: #0d6efd; }
    .step-b { border-color: #198754; }
    .step-c { border-color: #ffc107; }
    .step-d { border-color: #dc3545; }
    
    /* Footer */
    .footer {
      background: linear-gradient(to right, var(--govt-blue), #003366);
      color: white;
      padding: 2rem 0;
      margin-top: 3rem;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
      .navbar-main .nav-link {
        padding: 0.5rem 1rem;
        border-right: none;
        border-bottom: 1px solid rgba(255,255,255,0.1);
      }
    }
  </style>
</head>
<body>
  <!-- Header -->
  <header class="header-container">
    <div class="container-fluid py-3">
      <div class="container-xxl">
        <div class="d-flex justify-content-between align-items-center">
            
          <div class="d-flex justify-content-center align-items-center gap-3">
            <div class="text-start">
              <p class="mb-0 dev-font">पंचायत पोर्टल <br>
                <span class="h4 header-title"><strong>Panchayat Portal</strong></span>
              </p>
            </div>
          </div>
          <div class="d-none d-sm-block">
            <!-- Placeholder for government emblem/logo -->
            <div style="width: 80px; height: 80px; background-color: rgba(255,255,255,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
              <!--<i class="fas fa-landmark fa-2x" style="color: var(--govt-gold);"></i>-->
              <img src="img/portal_logo.png" width="80px" height="80px">
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-main sticky-top">
    <div class="container-xxl">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarExample01">
        <span class="navbar-toggler-icon text-white"><i class="fas fa-bars"></i></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarExample01">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item active"><a class="nav-link dev-font" href="#">मुख्य पृष्ठ</a></li>
          <li class="nav-item"><a class="nav-link dev-font" href="#">आमच्याबद्दल</a></li>
          <li class="nav-item"><a class="nav-link dev-font" href="#">संपर्क</a></li>
          <li class="nav-item ms-lg-3"><a href="register.php" class="btn btn-govt btn-md">Register</a></li>
          <li class="nav-item ms-lg-2"><a href="login.php" class="btn btn-govt btn-md">Login</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="container-xxl py-4">
    <!-- Carousel + Form in same row -->
    <section class="py-4">
      <div class="row g-4">
        <!-- Carousel -->
        <div class="col-lg-7 mb-4 mb-lg-0">
          <div id="carouselExampleCaptions" class="carousel slide main-carousel" data-bs-ride="carousel" style="height: 65vh;">
            <div class="carousel-inner h-100">
              <div class="carousel-item active h-100">
                <img src="img/im5.png" class="d-block w-100 h-100 object-fit-cover" alt="Village Development">
                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded">
                  <h5>गाव विकास</h5>
                  <p>डिजिटल प्रशासनाच्या माध्यमातून ग्रामीण भारतात परिवर्तन</p>
                </div>
              </div>
              <div class="carousel-item h-100">
                <img src="img/im2.webp" class="d-block w-100 h-100 object-fit-cover" alt="Community Meeting">
                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded">
                <h5>समुदाय सहभाग</h5>
                <p>शासन निर्णयांमध्ये ग्रामस्थांचा सक्रिय सहभाग</p>
                </div>
              </div>
              <div class="carousel-item h-100">
                <img src="img/im1.jpg" class="d-block w-100 h-100 object-fit-cover" alt="Rural Infrastructure">
                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded">
                  <h5>ग्रामीण पायाभूत सुविधा</h5>
                    <p>आपल्या गावांसाठी अधिक चांगल्या सुविधा उभारणे</p>
                </div>
              </div>
              <div class="carousel-item h-100">
                <img src="img/im3.jpg" class="d-block w-100 h-100 object-fit-cover" alt="Agricultural Development">
                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded">
                 <h5>कृषी सहाय्यता</h5>
                <p>पंचायत उपक्रमांद्वारे शेतकऱ्यांना सक्षम बनविणे</p>
                </div>
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
        <div class="col-lg-5 d-flex align-items-center">
          <div class="search-form w-100 p-4">
            <h4 class="text-center mb-4" style="color: var(--govt-blue);">ग्रामपंचायत शोधा</h4>
            <form>
              <div class="mb-3">
                <label for="district" class="form-label dev-font">जिल्ह्याचे नाव</label>
                <select class="form-select" id="district" required>
                  <option value="" selected disabled>-- जिल्हा निवडा --</option>
                  <option value="पुणे">पुणे</option>
                  <option value="सातारा">सातारा</option>
                  <option value="कोल्हापूर">कोल्हापूर</option>
                  <option value="सांगली">सांगली</option>
                  <option value="सोलापूर">सोलापूर</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="taluka" class="form-label dev-font">तालुक्याचे नाव</label>
                <input type="text" class="form-control" id="taluka" placeholder="तालुक्याचे नाव प्रविष्ट करा" required>
              </div>
              <div class="mb-3">
                <label for="grampanchayat" class="form-label dev-font">ग्रामपंचायतीचे नाव</label>
                <input type="text" class="form-control" id="grampanchayat" placeholder="ग्रामपंचायतीचे नाव प्रविष्ट करा" required>
              </div>
              <div class="mb-3">
                <label for="search" class="form-label">Grampanchayat Name</label>
                <div class="input-group">
                  <input type="search" class="form-control" id="search" placeholder="Search Grampanchayat Name">
                  <button class="btn btn-outline-primary" type="button" id="searchBtn">
                    <i class="fa fa-search"></i> Search
                  </button>
                </div>
              </div>
              <button type="submit" class="btn btn-govt w-100 py-2">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </section>

    <!-- News Ticker -->
    <section id="latest-news-section" class="my-4">
      <div class="news-container rounded">
        <div class="row g-0">
          <div class="col-12 col-sm-2 text-center d-flex align-items-center justify-content-center py-3 news-label">
            <p class="h6 m-0 dev-font"><strong>ताजी बातमी</strong></p>
          </div>
          <div class="col-12 col-sm-10 py-3 news-content">
            <div id="liSlider" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item border-0 p-1 small text-center text-dark">📰 महाराष्ट्रात आजपासून जोरदार पावसास सुरुवात, शेतकरी आनंदित.</li>
                  </ul>
                </div>
                <div class="carousel-item">
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item border-0 p-1 small text-center text-dark">🌧️ हवामान विभागाने पुढील ५ दिवस मुसळधार पावसाचा इशारा दिला आहे.</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    <!-- Tax Process Section -->
    <section class="py-5 bg-white rounded shadow-sm">
      <div class="container-xxl">
        <h2 class="text-center mb-4 fw-bold" style="color: var(--govt-blue);">ग्रामपंचायत कर वसुली प्रक्रिया</h2>
        <div class="row g-4 text-center">
          <!-- Step A -->
          <div class="col-md-3">
            <div class="card process-card step-a h-100">
              <div class="card-body">
                <div class="mb-3">
                  <span class="badge bg-primary rounded-circle p-3">A</span>
                </div>
                <h5 class="card-title text-primary">कर बिल</h5>
                <p class="card-text small">
                  <strong>Date:</strong> दिनांक: १ एप्रिल <br>
                  ग्रामपंचायत कर मागणी निर्माण करते आणि कर बिल जारी करते.<br>
                  <strong>देय:</strong>१५ दिवस..
                </p>
              </div>
            </div>
          </div>

          <!-- Step B -->
          <div class="col-md-3">
              <div class="card process-card step-b h-100">
                <div class="card-body">
                  <div class="mb-3">
                    <span class="badge bg-success rounded-circle p-3">B</span>
                  </div>
                  <h5 class="card-title text-success">सूचना (Notice)</h5>
                  <p class="card-text small">
                    <strong>देय तारखेनंतर:</strong> २% शुल्कासह नोटीस जारी केली जाते.<br>
                    <strong>देय कालावधी:</strong> बिल जारी केल्यापासून ३० दिवस.
                  </p>
                </div>
              </div>
           </div>

          <!-- Step C -->
          <div class="col-md-3">
              <div class="card process-card step-c h-100">
                <div class="card-body">
                  <div class="mb-3">
                    <span class="badge bg-warning rounded-circle p-3">C</span>
                  </div>
                  <h5 class="card-title text-warning">अंतिम नोटीस (Final Notice)</h5>
                  <p class="card-text small">
                    पंचायत समितीच्या मंजुरीनुसार अंतिम नोटीस ग्रामपंचायतीने जारी केली जाते.<br>
                    <strong>देय कालावधी:</strong> आधीच्या नोटीसनंतर ७ दिवस.
                  </p>
                </div>
              </div>
           </div>


          <!-- Step D -->
          <div class="col-md-3">
              <div class="card process-card step-d h-100">
                <div class="card-body">
                  <div class="mb-3">
                    <span class="badge bg-danger rounded-circle p-3">D</span>
                  </div>
                  <h5 class="card-title text-danger">जप्ती (Confiscation)</h5>
                  <p class="card-text small">
                    अंतिम नोटीसनंतर कायदेशीर कारवाईसाठी जप्तीची नोटीस जारी केली जाते.<br>
                    <strong>६% शुल्क</strong>. <strong>देय कालावधी:</strong> ३० दिवस.
                  </p>
                </div>
              </div>
        </div>


        <!-- Highlight Info Section -->
        <div class="row mt-5">
          <div class="col-md-6">
            <div class="alert alert-success shadow-sm d-flex align-items-center">
              <div class="flex-shrink-0 me-3 fs-4">🏠</div>
              <div>
               <h6 class="alert-heading">५% सवलत</h6>
                <p class="mb-0 small">
                  <strong>१ एप्रिल ते ३० सप्टेंबर</strong> दरम्यान कर भरल्यास नागरिकांना ५% घर कर सवलत लागू होते.
                </p>
                </p>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="alert alert-danger shadow-sm d-flex align-items-center">
              <div class="flex-shrink-0 me-3 fs-4">⚠️</div>
              <div>
                <h6 class="alert-heading">५% दंड</h6>
                <p class="mb-0 small">
                  <strong>३१ मार्च</strong> नंतर घरकराच्या एकूण थकबाकी रकमेवर ५% दंड लावण्यात येतो.
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Marathi Activities -->
       <div class="card mt-4 shadow-sm border-0" style="background-color: rgba(0, 34, 68, 0.05);">
  <div class="row g-0">
    <!-- Left side - Content -->
    <div class="col-md-7 p-4">
      <div class="card-body">
        <h5 class="card-title fw-bold text-center mb-3 dev-font">ग्रामपंचायत कर संकलन प्रक्रिया</h5>
        <ul class="list-group list-group-flush small">
          <li class="list-group-item bg-transparent dev-font d-flex align-items-center">
            <span class="badge bg-primary rounded-circle me-3">1</span>
            नविन करनिर्धारण नोंद.
          </li>
          <li class="list-group-item bg-transparent dev-font d-flex align-items-center">
            <span class="badge bg-primary rounded-circle me-3">2</span>
            करपट न उचलणे.
          </li>
          <li class="list-group-item bg-transparent dev-font d-flex align-items-center">
            <span class="badge bg-primary rounded-circle me-3">3</span>
            वसूली अधिकाऱ्यांमार्फत नोटीस पाठविणे.
          </li>
          <li class="list-group-item bg-transparent dev-font d-flex align-items-center">
            <span class="badge bg-primary rounded-circle me-3">4</span>
            ग्रामपंचायत सदस्यांमार्फत वसूली मोहीम.
          </li>
          <li class="list-group-item bg-transparent dev-font d-flex align-items-center">
            <span class="badge bg-primary rounded-circle me-3">5</span>
            इतर कायदेशीर कारवाईची नोटीस.
          </li>
        </ul>
      </div>
    </div>
    
    <!-- Right side - Image -->
    <div class="col-md-5 d-flex align-items-center justify-content-center p-3">
      <img src="img/im4.jpeg" alt="Tax Collection Process" class="img-fluid rounded" style="max-height: 300px; object-fit: cover;">
      <!-- If you don't have an image, you can use this placeholder instead: -->
      <!-- <div class="bg-light d-flex align-items-center justify-content-center h-100 w-100 rounded" style="background-color: #f8f9fa;">
        <div class="text-center p-3">
          <i class="fas fa-file-invoice-dollar fa-4x mb-3" style="color: var(--govt-blue);"></i>
          <p class="mb-0">Tax Collection Process</p>
        </div>
      </div> -->
    </div>
  </div>
</div>

        <!-- Legal Note -->
        <div class="text-muted small mt-4 border-top pt-3 text-center">
         <em>टीप: सर्व प्रक्रिया ग्रामपंचायत अधिनियमानुसार असून पंचायत समितीच्या मार्गदर्शक सूचनांनुसार राबविल्या जातात.</em>
        </div>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <footer class="footer mt-5">
    <div class="container-xxl">
      <div class="row">
        <div class="col-md-4 mb-4 mb-md-0">
          <h5 class="mb-3">पंचायत पोर्टल</h5>
          <p class="small">Digital platform for transparent and efficient rural governance.</p>
        </div>
        <div class="col-md-4 mb-4 mb-md-0">
          <h5 class="mb-3">Quick Links</h5>
          <ul class="list-unstyled small">
            <li><a href="#" class="text-white">Home</a></li>
            <li><a href="#" class="text-white">About Us</a></li>
            <li><a href="#" class="text-white">Contact</a></li>
          </ul>
        </div>
        <div class="col-md-4">
          <h5 class="mb-3">Contact</h5>
          <ul class="list-unstyled small">
            <li><i class="fas fa-phone-alt me-2"></i> +91 1234567890</li>
            <li><i class="fas fa-envelope me-2"></i> info@panchayatportal.gov.in</li>
            <li><i class="fas fa-map-marker-alt me-2"></i> Maharashtra, India</li>
          </ul>
        </div>
      </div>
      <div class="border-top mt-4 pt-3 text-center small">
        <p class="mb-0">© 2023 Panchayat Portal. All Rights Reserved.</p>
      </div>
    </div>
  </footer>
</body>
</html>