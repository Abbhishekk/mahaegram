<!DOCTYPE html>
<html lang="mr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>आमच्याबद्दल - पंचायत पोर्टल</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Noto+Sans+Devanagari:wght@400;500&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: 'Arial Unicode MS', 'Arial', 'Nirmala UI', sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        
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
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
      .navbar-main .nav-link {
        padding: 0.5rem 1rem;
        border-right: none;
        border-bottom: 1px solid rgba(255,255,255,0.1);
      }
    }
        
        
        .container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 5px;
        }
        
        .section {
            margin-bottom: 30px;
        }
        
        .section h2 {
            color: #0d4e96;
            border-bottom: 2px solid #0d4e96;
            padding-bottom: 5px;
            margin-top: 0;
        }
        
        .logo {
            text-align: center;
            margin: 20px 0;
        }
        
        .logo img {
            height: 80px;
        }
        
        .features {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        
        .feature-box {
            width: 30%;
            background-color: #f0f7ff;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            border-left: 4px solid #0d4e96;
        }
        
        .feature-box h3 {
            color: #0d4e96;
            margin-top: 0;
        }
        
        .footer {
            background-color: #0d4e96;
            color: white;
            text-align: center;
            padding: 15px 0;
            margin-top: 30px;
        }
        
        @media (max-width: 768px) {
            .feature-box {
                width: 100%;
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
          <li class="nav-item active"><a class="nav-link dev-font" href="index.php">मुख्य पृष्ठ</a></li>
          <li class="nav-item"><a class="nav-link dev-font" href="aboutus.php">आमच्याबद्दल</a></li>
          <li class="nav-item"><a class="nav-link dev-font" href="#">संपर्क</a></li>
          <li class="nav-item ms-lg-3 p-1"><a href="register.php" class="btn btn-govt btn-md">Register</a></li>
          <li class="nav-item ms-lg-2 p-1"><a href="login.php" class="btn btn-govt btn-md">Login</a></li>
        </ul>
      </div>
    </div>
  </nav>
</body>
</html>
    
    
    <div class="container">
        <div class="logo">
            <img src="img/portal_logo.png" alt="भारत सरकारचे प्रतीक चिन्ह">
        </div>
        
        <div class="section">
            <h2>आमच्याबद्दल</h2>
            <p>पंचायत पोर्टल हे एक डिजिटल प्लॅटफॉर्म आहे जे पंचायत राज संस्थांच्या निर्णय प्रक्रिया, सेवा वितरण आणि प्रशासकीय कार्यांना समर्थन आणि वर्धित करण्यासाठी डिझाइन केलेले आहे. हे अनुप्रयोग पारदर्शकता, कार्यक्षमता, जबाबदारी आणि शासन प्रक्रियेत नागरिकांचा सहभाग वाढविण्याचा प्रयत्न करतात.</p>
        </div>
        
        <!--<div class="section">-->
        <!--    <h2>आमचे उद्दिष्ट</h2>-->
        <!--    <p>ग्रामीण भागातील नागरिकांना सुविधाजनक सेवा पुरविणे, स्थानिक स्वराज्य संस्थांच्या कार्यक्षमतेत वाढ करणे आणि सर्व पातळ्यांवर पारदर्शकता आणणे हे आमचे प्रमुख उद्दिष्ट आहे. डिजिटल तंत्रज्ञानाच्या मदतीने आम्ही ग्रामपंचायतींचे कार्य अधिक प्रभावी आणि जनतेसाठी सुलभ करण्याचा प्रयत्न करत आहोत.</p>-->
        <!--</div>-->
        
        <div class="section">
            <h2>आमची वैशिष्ट्ये</h2>
            <div class="features">
                <div class="feature-box">
                    <h3>पारदर्शकता</h3>
                    <p>सर्व पंचायत कार्यक्रम, योजना आणि अर्थव्यवस्था ऑनलाइन उपलब्ध करून देणे.</p>
                </div>
                
                <div class="feature-box">
                    <h3>कार्यक्षमता</h3>
                    <p>माहिती तंत्रज्ञानाचा वापर करून प्रशासकीय प्रक्रिया सुलभ आणि वेगवान बनविणे.</p>
                </div>
                
                <div class="feature-box">
                    <h3>जबाबदारी</h3>
                    <p>प्रत्येक कामाची माहिती ऑनलाइन उपलब्ध करून जबाबदारी सुनिश्चित करणे.</p>
                </div>
                
                <div class="feature-box">
                    <h3>नागरिक सहभाग</h3>
                    <p>ग्रामस्थांना पंचायत कार्यात थेट सहभागी होण्याची संधी देणे.</p>
                </div>
                
                <div class="feature-box">
                    <h3>एकत्रित माहिती</h3>
                    <p>सर्व पंचायत संबंधित माहिती एकाच ठिकाणी उपलब्ध करून देणे.</p>
                </div>
                
               
            </div>
        </div>
        
        <!--<div class="section">-->
        <!--    <h2>आमची सेवा</h2>-->
        <!--    <p>या पोर्टलद्वारे आम्ही खालील सेवा पुरवित आहोत:</p>-->
        <!--    <ul>-->
        <!--        <li>पंचायत योजनांची माहिती</li>-->
        <!--        <li>अर्थसंकल्प आणि खर्चाची तपशीलवार माहिती</li>-->
        <!--        <li>सभासदांची माहिती</li>-->
        <!--        <li>नोकरी आणि भरती संबंधित माहिती</li>-->
        <!--        <li>प्रमाणपत्रे आणि दस्तऐवजांची ऑनलाइन मागणी</li>-->
        <!--        <li>तक्रार नोंदणी आणि मदत प्रणाली</li>-->
        <!--        <li>ग्रामसभा आणि इतर बैठकींची मिनिटे</li>-->
        <!--    </ul>-->
        <!--</div>-->
        
        <!--<div class="section">-->
        <!--    <h2>संपर्क</h2>-->
        <!--    <p><strong>पंचायत राज विभाग</strong><br>-->
        <!--    ग्रामविकास मंत्रालय, भारत सरकार<br>-->
        <!--    ईमेल: panchayatportal@gov.in<br>-->
        <!--    फोन: 1800-123-4567</p>-->
        <!--</div>-->
    </div>
    
    <div class="footer">
        <p>© 2023 पंचायत पोर्टार. सर्व हक्क राखीव.</p>
    </div>
</body>
</html>