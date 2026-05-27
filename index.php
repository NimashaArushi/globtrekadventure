
<?php session_start(); 

$redirect = "index.php";

if (isset($_GET['redirect']) && $_GET['redirect'] == "second") {
    $redirect = "second.php";
}?>


<?php
$conn = new mysqli("localhost", "root", "", "globetrek_db", 3308);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['send_message'])) {

    $name = trim($_POST['customer_name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    $stmt = $conn->prepare("INSERT INTO inquiries (customer_name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $subject, $message);

    if ($stmt->execute()) {
        echo "<script>
            alert('Message sent successfully!');
            window.location.href='index.php';
        </script>";
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GlobeTrek Adventures | Home</title>
    
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;

        }

    

        body {
            background-color: #f0f0f0;
        }


        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            height: 90px;
            position: fixed;
            top: 0;
            left: 0;
            padding: 0 50px;
            background: rgba(0, 121, 145, 0.7); 
            backdrop-filter: blur(15px); 
            -webkit-backdrop-filter: blur(15px);
            z-index: 10000;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

     
.logo {
    position: relative;
    z-index: 10001; 
    display: flex;
    align-items: center;
    transition: transform 0.3s ease; 
    size: 100px;
}

.logo-img {
    width: 150px; 
    height: auto;
    
 
    filter: drop-shadow(0px 10px 15px rgba(0, 0, 0, 0.5)); 
    transform: translateY(25px); 
    
    border-radius: 60%; 
    background: rgba(255, 255, 255, 0.1); 
    padding: 5px;
    backdrop-filter: blur(5px);
}


.logo:hover {
    transform: scale(1.1) translateY(20px);
    filter: drop-shadow(0px 15px 25px rgba(0, 0, 0, 0.7));
}

      
        .welcome-msg {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            color: white;
            font-size: 24px;
            font-weight: 400;
            white-space: nowrap;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
        }

        .welcome-msg b {
            color:#00CEC8;
            font-size: 28px;
            font-weight: 600;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 30px;
        }

        .nav-links li a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            transition: 0.3s;
        }

        .nav-links li a:hover {
            color: #D69E2E;
        }

        .hero {
            width: 100%;
            height: 100vh;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
           
        }

        .back-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
           
        }

        .content {
            text-align: center;
            color: #fff;
            z-index: 1;
        }

        .content h1 {
            font-size: 80px;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 4px 4px 15px rgba(0, 0, 0, 0.6);
            margin-bottom: 10px;
        }

        .content p {
            font-size: 20px;
            margin-bottom: 30px;
            background: rgba(0, 0, 0, 0.2);
            display: inline-block;
            padding: 5px 20px;
            border-radius: 5px;
        }

       /*Vision codes*/

        .vision-stats {
        padding: 60px 10%;
        text-align: center;
        background: linear-gradient(to right, #3b8d8d, #00ecf0,#ffffff);
    }
        .vision-container{
          padding: 80px 10%;
         background: linear-gradient(135deg, #ffffff 0%, #00CEC8 300%, #00a86b 200%);
          background-attachment: fixed;
          display: flex;
          justify-content: center;
          align-items: center;
}

        .vision-box{
         background: rgba(255,255,255,0.1);
         backdrop-filter: blur(15px);
        padding: 50px;
        border: 1px solid rgb(255, 255, 255, 0.2);
        border-radius: 30px;
        color: rgb(0, 0, 0);
        text-align: center;
        min-width: 900px;
        box-shadow: 0 25px 45px rgba(0, 0, 0, 0.2);

        }

        .vision-header{
           margin-bottom: 20px;

        }

       .vision-header span{
           font-size: 50px;
           font-weight: 800;
           opacity: 0.2;
           display: block;
           line-height: 1;

       }

       .vision-header h2{
       font-size: 35px;
       margin-top: -25px;
       color:#0a0a0a ;
       text-transform: uppercase;
       letter-spacing: 3px;
       border-bottom: 3px solid #00f2fe;
       display: inline-block;
       padding-bottom: 10px;
       margin-bottom: 25px;

       }

       .vision-box p{
       font-size: 19px;
       line-height: 1.8;
       color: #000000;

       }

       .vision-stats h2{
      font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
      text-align: center;
      padding: 10px;
      font-style: italic;
      font-weight: 600;
      font-size: 200%;



       }

    .stat-card h3 {
    margin: 15px 0 10px;
    color: #004d4d; 
    font-size: 20px;
}

     
    .stat p{
color: #000436;
font-weight: 500;

    }

     .stat-grid{
           display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: space-between;
     }

  .stat-card {
    background-color: #fff;
    border: 1px solid #eee;
    border-radius: 20px;
    padding: 30px;
    
    flex: 0 1 calc(33.333% - 40px); 
    min-width: 300px;
    transition: all 0.3s ease;
    text-align: left; 
    box-shadow: 0 10px 20px rgba(0,0,0,0.05);
}

    .stat-card:hover{
transform: translateY(-8px);
    box-shadow: 0 15px 30px rgba(0, 206, 200, 0.2);
    border-color: #00CEC8; 

    }


    
    .icon {
    font-size: 24px;
    display: block;
    margin-bottom: 10px;
}
        /* --- Package Grid  --- */
        .package-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
            justify-content: center;
            padding: 40px 20px;
            background: linear-gradient(to right, #3b8d8d, #00ecf0,#ffffff);
        }

        .package-card {
            background-color: white;
            width: 320px;
            border-radius: 20px;
            overflow: hidden;
            display: flex;
            flex-direction: column; 
            position: relative;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: 0.3s;
        }

        .package-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .package-info {
            padding: 20px;
            flex-grow: 1; 
            display: flex;
            flex-direction: column;
        }


      .buy-btn {
    width: 100%;
    padding: 12px;
    margin-top: auto;  
    border: 2px solid transparent; 
    color: #ffffff;
  background:rgb(26, 153, 147);
    border-radius: 25px;
    cursor: pointer;
    font-weight: 600;
    font-size: 15px;
    text-transform: uppercase; 
    letter-spacing: 1px;
    transition: all 0.4s ease; 
    box-shadow: 0 4px 15px rgba(255, 154, 158, 0.3); 
}

.buy-btn:hover { 
    background: #00b0b8; 
    transform: translateY(-3px); 
    box-shadow: 0 6px 20px rgba(3, 157, 165, 0.4);
    color: white;
}

h1, h2, h3 {
    font-family: 'Poppins', sans-serif;
    font-weight: 700; 
    color: #377e6e;
    letter-spacing: 0.5px;
}

p {
    font-family: 'Poppins', sans-serif;
    font-weight: 400; 
    line-height: 1.6; 
      color: #444;
}


.new-price {
    font-family: 'Poppins', sans-serif; 
    font-weight: 800;
    color: #f00202;
    font-size: 22px;
}



       .old-price{
    text-decoration: line-through;
    margin-right: 14px;
    color: #888;
    font-size: 16px;

}

.package-card {
    background-color: white;
    width: 320px;
    border-radius: 20px;
    overflow: hidden;
    display: flex;
    flex-direction: column; 
    position: relative;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    
    transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.4s ease;
}


.package-card:hover {
    transform: translateY(-15px); 
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2); 
    cursor: pointer;
}


.package-card:hover img {
    transform: scale(1.05);
    transition: transform 0.5s ease;
}

.package-card img {
    transition: transform 0.5s ease; 
}




      /* --- Updated Special April Offer  --- */
.selection-title {
    padding: 80px 20px 40px;
    text-align: center;
    background-color: #ffffff;
}

.selection-title h2 {
    font-size: 42px;
    font-weight: 800;
    color: #f8081c; 
    text-transform: uppercase;
    letter-spacing: 3px;
    margin-bottom: 10px;
    position: relative;
    display: inline-block;
}


.selection-title h2::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 25%;
    width: 50%;
    height: 4px;
    background: linear-gradient(to right, #00b0b8, #d4af37); 
    border-radius: 10px;
}


.selection-title p:first-of-type {
    color: #00b0b8; 
    font-weight: bold;
    font-size: 18px;
    margin-top: 15px;
}


.selection-title p:last-of-type {
    color: #666;
    font-size: 16px;
    margin-top: 5px;
}

        .badge {
            position: absolute; top: 15px; right: 15px;
            padding: 5px 12px; border-radius: 20px; color: #fff;
            font-size: 12px; font-weight: bold;
        }
       
       .hot { background-color: red; }

       .new{
        background: red;


       }

/*other travelas*/
 
.section-title {
    padding: 60px 20px 20px; 
    text-align: center;
    background: white;

}

.section-title h2 {
    font-size: 36px;
    font-weight: 700;
    color: #333; 
    text-transform: uppercase;
    letter-spacing: 2px;
    position: relative;
    display: inline-block;
    padding-bottom: 15px;
  
}


.section-title h2::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: linear-gradient(to right, #00b0b8, #d4af37); 
    border-radius: 2px;
}


.section-title h2 {
    text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
}


/*inquiry form*/


.inquiry-section {
    width: 100%;
    margin: 0;
    padding: 0;
    display: block;
}


.heading-area {
    background-color: #ffffff; 
    padding: 60px 20px 30px 20px;
    text-align: center;
}

.section-heading {
    color: #000000;
    font-size: 2.8rem;
    font-weight: bold;
    margin-bottom: 10px;
    text-transform: uppercase;
}

.section-subtext {
    color: #555;
    font-size: 1.1rem;
}


.form-area {
   background: linear-gradient(rgba(12, 12, 12, 0.6), rgba(0, 0, 0, 0.6)), 
                url('travel2.jpg');
                            background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    padding: 40px 20px 80px 20px;
    display: flex;
    justify-content: center;
}


.inquiry-card {
    max-width: 850px;
    width: 100%;
    background: rgba(255, 255, 255, 0.95);
    padding: 45px;
    border-radius: 20px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    backdrop-filter: blur(10px);
}

.input-row {
    display: flex;
    gap: 20px;
    margin-bottom: 10px;
}

input, textarea {
    width: 100%;
    padding: 15px;
    border: 1px solid #c8e6c9;
    border-radius: 12px;
    font-size: 1rem;
    margin-bottom: 20px;
    background: #ffffff;
    transition: 0.3s;
    outline: none;
}

input:focus, textarea:focus {
    border-color: #00CEC8;
    box-shadow: 0 0 10px rgba(0, 206, 200, 0.2);
}


.send-btn {
    background: linear-gradient(to right, #03a4b9, #046583, #017981);
    color:#ffffff;
    border: none;
    padding: 16px 50px;
    border-radius: 35px;
    font-weight: bold;
    font-size: 1rem;
    cursor: pointer;
    transition: 0.4s ease;
    width: auto;
    display: inline-block;
}

.send-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(22, 148, 144, 0.4);
    filter: brightness(1.1);
}

@media (max-width: 650px) {
    .input-row {
        flex-direction: column;
        gap: 0;
    }
    
    .section-heading {
        font-size: 2rem;
    }
}



            /*certificates*/
            .certificates-section{
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                width: 100%;
                padding: 40px 0;
                background-color: #ffffff;
   
            }

       .certificates-card img{
    
        max-width: 90%;
        height: auto;
        display: block;


       }






       /*Contact Us CSS*/
   .contact-section{
    padding: 80px 5%;
    text-align: center;
    background-color: #ffffff;
    background: linear-gradient(rgba(255, 255, 255, 0.6), rgba(0, 0, 0, 0.6)), 
                url('travel2.jpg');
                background-repeat: no-repeat;
    background-size: cover;
    background-position: center;

   }
   
   .contact-section h2 {
    font-size: 45px;
    font-weight: 800;
    text-transform: uppercase;
    margin-bottom: 50px;
    position: relative;
    display: inline-block; 
    

    background: linear-gradient(to right, #00828b, #00828b);
    -webkit-background-clip: text;
   -webkit-text-fill-color: transparent;
   text-shadow: 2px 4px 10px rgba(0, 0, 0, 0.3);
   
}


.contact-section h2::after {
    content: '';
    position: absolute;
    width: 60%;
    height: 4px;
   background-color: #f0f0f0;
    bottom: -15px;
    left: 20%;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0, 255, 255, 0.8);
}

   .contact-grid{
    display:flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
   }

   .contact-card{
 
    background: rgba(255, 255, 255, 0.05); 
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);

   border:1px solid #eee;
   border-radius: 20px;
   padding: 25px;
   width:220px;
   text-decoration:none;
   background: linear-gradient(to right, #ffffff, #14d6e4);
   transition: 0.3s;
   display: flex;
   flex-direction: column;
   align-items: center;

   }

   .contact-card:hover {
    transform: translateY(-15px) scale(1.05);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
    
    background: linear-gradient(135deg, #01a5e6 0%, #007991 50%, #00b0b8 100%);
}
   .contact-card img{
   width: 60px;
   height: 60px;
   object-fit: contain;
   margin-bottom: 15px;
   
   }
 
   .contact-card h3 {
    color: #333;
    font-size: 18px;
    margin-bottom: 8px;
}

.contact-card p {
    color: #777;
    font-size: 14px;
}
     

.main-footer {
    background: transparent; 
    padding: 30px 20px;
    text-align: center;
    width: 100%;
    margin-top: 50px;
}

.copyright {
    color: #00CEC8;
    font-size: 14px;
    margin-bottom: 20px;
    font-weight: 500;
    text-shadow: 1px 1px 5px rgba(0,0,0,0.5); 
}

.footer-links {
    display: flex;
    justify-content: center;
    gap: 20px;
}

.portal-link {
    color: #ffffff;
    text-decoration: none;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    padding: 10px 20px;
    border: 1px solid #00CEC8; 
    border-radius: 5px;
    background: rgba(0, 0, 0, 0.4); 
    transition: all 0.3s ease;
}

.portal-link:hover {
    background: #00CEC8;
    color: #000;
    box-shadow: 0 0 15px rgba(0, 206, 200, 0.6);
}
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="logo"><img src="logo.png" alt="Logo" class="logo-img"></div> 
        <span class="welcome-msg">Welcome to <b>GlobeTrek Adventures</b></span>
        <ul class="nav-links">
            <li><a href="#">Home</a></li>
            <li><a href="#about">About us</a></li>
         <li>
        <?php if(isset($_SESSION['user_name'])): ?>
            <a href="userdashboard.php" style="color: #ffffff;">Hi, <?php echo $_SESSION['user_name']; ?></a>
        <?php else: ?>
            <a href="login.php">Login / Register</a>
        <?php endif; ?>
    </li>
             <li><a href="#packages" >View Packages</a></li>
            <li><a href="#contact">Contact Us</a></li>
        </ul>
    </nav>

    <section class="hero">
        <video autoplay loop muted playsinline class="back-video"><source src="homepagevideo.mp4" type="video/mp4"></video>
        <div class="content">
           
          
           
        </div>
    </section>


<section class="vision-container">
    <div class="vision-box">
        <div class="vision-header">
            <span>01</span>
            <h2>OUR VISION</h2>
        </div>
        <p>To be the premier gateway for explorers in Sri Lanka, starting from the heart of Negombo. 
        We envision a world where every traveler experiences the true essence of the pearl of the Indian Ocean through 
        <b>safe, authentic, and unforgettable</b> journeys.</p>
    </div> </section>

<section>
    <div class="vision-stats">
        <h2>Why Choose GlobeTrek?</h2>
        <div class="stat-grid">
            <div class="stat-card">
                <i class="icon">🗺️⁀✈︎</i>
                <h3>Airport Proximity</h3>
                <p>Just 15 minutes away from BIA. No long transfers, just instant adventure</p>
            </div>

            <div class="stat-card">
                <i class="icon">🐚🔥</i>
                <h3>Certified Safety</h3>
                <p>Well-maintained fleet and professional drivers ensuring a secure journey.</p>
            </div>

            <div class="stat-card">
                <i class="icon">🌺🌊</i>
                <h3>Local Expertise & Hidden Gems</h3>
                <p>Explore Sri Lanka like a local, not just a tourist</p>
            </div>
            
            <div class="stat-card">
                <i class="icon">🧳</i>
                <h3>Tailor-Made Journeys</h3>
                <p>Travel your way, at your own pace.</p>
            </div>

            <div class="stat-card">
                <i class="icon">🛍️🧉📸</i>
                <h3>24/7 Island-wide Support</h3>
                <p>Seamless support from touchdown to takeoff.</p>
            </div>

            <div class="stat-card">
                <i class="icon">🎧🤝✨</i>
                <h3>Excellence in Service</h3>
                <p>Supported by our <b>dedicated team of 200+ professionals</b>, ensuring a seamless experience.</p>
            </div>
        </div> </div> </section>



   <div class="selection-title" id="packages">
    <h2>Special April Offer</h2>
    <p>Valid: April 01 - 30</p>
    <p>Book your April adventure with exclusive discounts!</p>
    
</div>

<div class="package-grid">
    
    <div class="package-card discount-border">
        <div class="badge hot">20% OFF</div>
        <img src="ella2.jpg" alt="Ella Mist Adventure">
        <div class="package-info">
            <h3>Ella Mist Adventure</h3><br>
            <p><b>Location:</b> Badulla District</p>
            <p>Enjoy the scenic beauty of Nine Arch Bridge and Ella Rock.</p><br>
            <div class="price-box">
                <span class="old-price">Rs 45,000</span>
                <span class="new-price">Rs 36,000</span>
            </div>
            <button class="buy-btn" onclick="checkLogin('ella')">View Details</button>
        </div>
    </div>

    <div class="package-card discount-border">
        <div class="badge new">HOT DEAL</div>
        <img src="mirissa-image.jpg" alt="Mirissa">
        <div class="package-info">
            <h3>Mirissa Whale Watching</h3><br>
            <p><b>Location:</b> Matara District</p>
            <p>Golden beaches and boat tours to see blue whales in their habitat.</p><br>
            <div class="price-box">
                <span class="old-price">Rs 48,000</span>
                <span class="new-price">Rs 42,000</span>
            </div>
           <button class="buy-btn" onclick="checkLogin('mirissa')">View Details</button>
        </div>

    </div> <div class="package-card discount-border">
        <img src="negembo.jpg" alt="Negombo Lagoon">
        <div class="package-info">
            <h3>Negombo Lagoon & Culture</h3><br>
            <p><b>Location:</b> Gampaha District</p>
            <p>Boat rides through mangroves and a visit to the historic St. Mary's Church.</p><br>
            <div class="price-box">
                <span class="old-price">Rs 32,000</span>
                <span class="new-price">Rs 25,000</span>
            </div>
          <button class="buy-btn" onclick="checkLogin('negombo')">View Details</button>
        </div>
    </div>
</div>

<div class="section-title">
    <h2>Other Travel Packages</h2>
</div>

<div class="package-grid">
    <?php
 
    $conn = new mysqli("localhost", "root", "", "globetrek_db", 3308);

    $res = $conn->query("SELECT * FROM packages ORDER BY id DESC");

    if ($res->num_rows > 0) {
        while($row = $res->fetch_assoc()) {
            $price = $row['price'];
            $disc = $row['discount'];
            $final_price = $price - ($price * ($disc / 100));
           
           $image_file = str_replace('.mp4', '.jpg', $row['video_link']); 
    ?>
           <div class="package-card">
<img src="<?php echo $row['image']; ?>"
     alt="<?php echo htmlspecialchars($row['destination_name']); ?>"
     onerror="this.src='images/default-package.jpg'">

     
<div class="package-info">
    <h3><?php echo htmlspecialchars($row['destination_name']); ?></h3><br>
    <p><b>Location:</b> <?php echo htmlspecialchars($row['destination_name']); ?></p>
    
    <div class="price-box">
        <?php if($disc > 0): ?>
            <span class="old-price">Rs <?php echo number_format($price); ?></span>
        <?php endif; ?>
        <span class="new-price">Rs <?php echo number_format($final_price); ?></span>
    </div>
  <button class="buy-btn"
onclick="window.location.href='second.php?id=<?php echo $row['id']; ?>'">
    View Details
</button>
</div>

            </div>
    <?php
        }
    }
    ?>

    <div class="package-card">
        <img src="beauty-of-srilanka-kandy.jpg" alt="Kandy">
        <div class="package-info">
            <h3>Kandy Heritage Tour</h3><br>
            <p><b>Location:</b> Central Province</p>
            <p>Visit the Temple of the Tooth and enjoy the Peradeniya gardens.</p><br>
            <div class="price-box">
                <span class="old-price">Rs 42,000</span>
                <span class="new-price">Rs 38,000</span>
            </div>
           <button class="buy-btn" onclick="checkLogin('kandy')">View Details</button>
        </div>
    </div>

    <div class="package-card">
        <img src="Lion-Rock2.jpg" alt="Sigiriya">
        <div class="package-info">
            <h3>Ancient Sigiriya Rock</h3><br>
            <p><b>Location:</b> Matale District</p>
            <p>Explore the 8th Wonder of the World and the beautiful water gardens.</p><br>
            <div class="price-box">
                <span class="old-price">Rs 42,000</span>
                <span class="new-price">Rs 40,000</span>
            </div>
           <button class="buy-btn" onclick="checkLogin('sigiriya')">View Details</button>
        </div>
    </div>

    <div class="package-card">
        <img src="nuwara-eliya-3.jpg" alt="Nuwara Eliya">
        <div class="package-info">
            <h3>Little England</h3><br>
            <p><b>Location:</b> Nuwara Eliya District</p>
            <p>Experience the misty mountains, tea plantations, and Gregory Lake.</p><br>
            <div class="price-box">
                <span class="old-price">Rs 65,000</span>
                <span class="new-price">Rs 58,500</span>
            </div>
        <button class="buy-btn" onclick="checkLogin('nuwaraeliya')">View Details</button>
        </div>
    </div>

    <div class="package-card">
        <img src="galle-fort.jpg" alt="Galle">
        <div class="package-info">
            <h3>Galle Dutch Fort</h3><br>
            <p><b>Location:</b> Galle District</p>
            <p>A walk through history with colonial architecture and scenic lighthouse views.</p><br>
            <div class="price-box">
                <span class="old-price">Rs 28,000</span>
                <span class="new-price">Rs 22,000</span>
            </div>
           <button class="buy-btn" onclick="checkLogin('galle')">View Details</button>
        </div>
    </div>

    <div class="package-card">
        <img src="yala.jpg" alt="Yala">
        <div class="package-info">
            <h3>Yala Wildlife Safari</h3><br>
            <p><b>Location:</b> Tissamaharama</p>
            <p>Thrilling Jeep safari to see leopards, elephants, and exotic birds.</p><br>
            <div class="price-box">
                <span class="old-price">Rs 48,000</span>
                <span class="new-price">Rs 45,000</span>
            </div>
           <button class="buy-btn" onclick="checkLogin('yala')">View Details</button>
        </div>
    </div>

    <div class="package-card">
        <img src="anuradhapura.jpg" alt="Anuradhapura">
        <div class="package-info">
            <h3>Anuradhapura City</h3><br>
            <p><b>Location:</b> North Central</p>
            <p>Visit ancient stupas and ruins of the first kingdom of Sri Lanka.</p><br>
            <div class="price-box">
                <span class="old-price">Rs 45,000</span>
                <span class="new-price">Rs 38,000</span>
            </div>
           <button class="buy-btn" onclick="checkLogin('anuradhapura')">View Details</button>
        </div>
    </div>

    <div class="package-card">
        <div class="badge hot">LIMITED</div>
        <img src="polonnaruwa.jpg" alt="Polonnaruwa">
        <div class="package-info">
            <h3>Medieval Capital Explorer</h3><br>
            <p><b>Location:</b> Polonnaruwa</p>
            <p>Cycling tours through ancient ruins and a visit to the Parakrama Samudra.</p><br>
            <div class="price-box">
                <span class="old-price">Rs 48,000</span>
                <span class="new-price">Rs 46,500</span>
            </div>
           <button class="buy-btn" onclick="checkLogin('polonnaruwa')">View Details</button>
        </div>
    </div>

    <div class="package-card">
        <img src="jaffna.jpg" alt="Jaffna">
        <div class="package-info">
            <h3>Northern Heritage</h3><br>
            <p><b>Location:</b> Jaffna District</p>
            <p>Visit Nallur Kovil, Jaffna Fort, and enjoy the unique northern culture.</p><br>
            <div class="price-box">
                
                <span class="new-price">Rs 38,000</span>
            </div>
            <button class="buy-btn" onclick="checkLogin('jaffna')">View Details</button>
        </div>
    </div>

    <div class="package-card">
        <img src="trincomalee.jpg" alt="Trincomalee">
        <div class="package-info">
            <h3>Trinco Coastal Gem</h3><br>
            <p><b>Location:</b> Trincomalee</p>
            <p>Visit Koneswaram Temple, Nilaveli Beach, and enjoy Pigeon Island.</p><br>
            <div class="price-box">
                <span class="old-price">Rs 45,500</span>
                <span class="new-price">Rs 42,000</span>
            </div>
            <button class="buy-btn" onclick="checkLogin('trincomalee')">View Details</button>
        </div>
    </div>

    <div class="package-card">
        <img src="hikkaduwa.jpg" alt="Hikkaduwa">
        <div class="package-info">
            <h3>Hikkaduwa Coral Reef</h3><br>
            <p><b>Location:</b> Galle District</p>
            <p>Glass bottom boat rides, snorkeling, and surfing in the turquoise waters.</p><br>
            <div class="price-box">
                <span class="old-price">Rs 41,000</span>
                <span class="new-price">Rs 38,000</span>
            </div>
         <button class="buy-btn" onclick="checkLogin('hikkaduwa')">View Details</button>
        </div>
    </div>
</div>


<section id="contact" class="inquiry-section">
 
    <div class="heading-area">
        <h2 class="section-heading">Get In Touch</h2>
        <p class="section-subtext">Have questions? Send us a message and our team will get back to you.</p>
    </div>
    
   
    <div class="form-area">
    <div class="inquiry-card">
        <form action="" method="POST">
            <div class="input-row">
                <input type="text" name="customer_name" placeholder="Your Name" required>
                <input type="email" name="email" placeholder="Email Address" required>
            </div>

            <input type="text" name="subject" placeholder="Subject" required>

            <textarea name="message" placeholder="Your Message..." rows="5" required></textarea>

            <button type="submit" name="send_message" class="send-btn">SEND MESSAGE</button>
        </form>
    </div>
</div>
</section>

<section class="certificates-section">
    <h2>Awarded & Recognised By</h2> <div class="certificates-card">
        
    <div class="certificates-card">
    <img src="certificates.png" alt="certificates"></div>
</section>
<section class="contact-section" id="contact">
    <h2>Connect With Us</h2>
    
    <div class="contact-grid">
        <a href="tel:+94749655034" class="contact-card">
            <img src="phone.jpg" alt="phone">
            <h3>Call Us</h3>
            <p>+94 74 965 5034</p>
        </a>

        <a href="https://wa.me/94749655034" target="_blank" class="contact-card">
            <img src="wp.jpg" alt="WhatsApp">
            <h3>WhatsApp</h3>
            <p>Message us directly</p>
        </a>

<a href="mailto:info@globetrek.com?subject=Inquiry about Travel Packages&body=Hi GlobeTrek Team, I would like to know more about..." 
   class="contact-card" id="emailCard">
    <img src="email.jpg" alt="email">
    <h3>Email Us</h3>
    <p>info@globetrek.com</p>
</a>

<div id="emailLoader" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); background:rgba(0,0,0,0.9); color:#2ecc71; padding:25px; border-radius:15px; z-index:1000; border: 1px solid #2ecc71; text-align:center;">
    <p style="margin-bottom:10px;">📧 Opening your Email App...</p>
    <small style="color:white;">Please wait a moment.</small>
</div>

     <a href="https://instagram.com/globetrek" target="_blank" class="contact-card">
            <img src="inster.jpg" alt="instagram">
            <h3>Instagram</h3>
            <p>@GlobeTrekAdventures</p>
        </a>
<a href="https://www.youtube.com/@GlobeTrekAdventures" target="_blank" class="contact-card" id="youtubeLink">
    <img src="yrlogo.png" alt="youtube">
    <h3>YouTube</h3>
    <p>Watch Our Travel Vlogs</p>
</a>
    </div>
<footer class="main-footer">
    <p class="copyright">&copy; 2026 GlobeTrek Adventures. All Rights Reserved.</p>
    <div class="footer-links">
        <a href="staff_login.php" class="portal-link">Staff Portal</a>
        <a href="admin_login.php" class="portal-link">ADMIN PANEL</a>
    </div>
</footer>


<script>
function checkLogin(packageName) {
     localStorage.setItem('selectedPackage', packageName);
     let isLoggedIn = <?php echo isset($_SESSION['user_name']) ? 'true' : 'false'; ?>;

    if (isLoggedIn) {
        window.location.href = "second.php?name=" + packageName;
    } else {
        window.location.href = "login.php?redirect=second&package=" + packageName;
    }
}
function enterStaffMode() {
    window.location.href = "staff_login.php"; 
}

</script>
</body>
</html>