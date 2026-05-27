<?php
session_start();

$conn = new mysqli("localhost", "root", "", "globetrek_db", 3308);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_POST['confirm_booking'])) {

    // Login c
    if (!isset($_SESSION['user_name'])) {
        echo "<script>
                alert('Please login first!');
                window.location.href='login.php';
              </script>";
        exit();
    }

    // Form data
    $u_name   = $_SESSION['user_name'];
    $pkg_name = $_POST['package_name'];
    $b_date   = $_POST['arrival_date'];
    $members  = $_POST['members'];
    $phone    = $_POST['phone'];
    $email    = $_POST['email'] ?? '';
    $status   = "Confirmed";

    // data conneto to  database
 $stmt = $conn->prepare("INSERT INTO bookings 
(user_name, package_name, booking_date, members, status) 
VALUES (?, ?, ?, ?, ?)");

$stmt->bind_param(
    "sssis",
    $u_name,
    $pkg_name,
    $b_date,
    $members,
    $status
);

if ($stmt->execute()) {

    echo "<script>
        alert('Booking Successful and Saved to Database!');
        window.location.href='userdashboard.php';
    </script>";

    exit();

} else {

    echo "<script>
        alert('Database Error!');
    </script>";
}

$stmt->close();
}
// Get packge details
$pkg_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$pkg_name_url = isset($_GET['name']) ? $_GET['name'] : '';

$package = null;

// Database package
if ($pkg_id > 0) {

    $stmt = $conn->prepare("SELECT * FROM packages WHERE id = ?");
    $stmt->bind_param("i", $pkg_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $package = $result->fetch_assoc();
}
if (!$package) {

    if ($pkg_name_url === 'mirissa') {

        $p_name = "Mirissa Whale Watching";
        $p_price = 42000;
        $p_video = "mirissa1.mp4";
        $p_duration = "1 Day Tour";
        $p_activities = "Whale & Dolphin Watching, Coconut Tree Hill visit, Mirissa Beach leisure";
    }
    else if ($pkg_name_url === 'negombo') {

        $p_name = "Negombo Lagoon & Culture";
        $p_price = 25000;
        $p_video = "negambo.mp4";
        $p_duration = "1 Day Tour";
        $p_activities = "Boat ride in the lagoon, Fish Market visit, Dutch Fort exploration";

    }

    else if ($pkg_name_url === 'kandy') {

        $p_name = "Kandy Heritage Tour";
        $p_price = 38000;
        $p_video = "kandy.mp4";
        $p_duration = "1 Day Tour";
        $p_activities = "Temple of the Sacred Tooth Relic, Peradeniya Botanical Garden, Kandy Lake view";

    }

    else if ($pkg_name_url === 'sigiriya') {

        $p_name = "Ancient Sigiriya Rock";
        $p_price = 40000;
        $p_video = "sigiriya.mp4";
        $p_duration = "1 Day Tour";
        $p_activities = "Climb the Lion Rock, View Ancient Frescoes, Sigiriya Museum visit";
 }

    else if ($pkg_name_url === 'nuwaraeliya') {

        $p_name = "Little England";
        $p_price = 58500;
        $p_video = "nuwaraeliya.mp4";
        $p_duration = "2 Days / 1 Night";
        $p_activities = "Visit Tea Estates & Factories, Boat ride at Gregory Lake, Victoria Park walk";
 }

    else if ($pkg_name_url === 'galle') {

        $p_name = "Galle Dutch Fort";
        $p_price = 22000;
        $p_video = "galle.mp4";
        $p_duration = "1 Day Tour";
        $p_activities = "Walk on the Galle Fort Ramparts, Visit the Lighthouse, Maritime Museum tour";

    }

    else if ($pkg_name_url === 'yala') {

        $p_name = "Yala Wildlife Safari";
        $p_price = 45000;
        $p_video = "yala.mp4";
        $p_duration = "2 Days / 1 Night";
        $p_activities = "Jeep Safari to spot Leopards, Elephant sightings, Wilderness camping experience";

    }

    else if ($pkg_name_url === 'anuradhapura') {

        $p_name = "Anuradhapura City";
        $p_price = 38000;
        $p_video = "anuradhapura.mp4";
        $p_duration = "1 Day Tour";
        $p_activities = "Visit Sri Maha Bodhi, Explore Ruwanwelisaya, Abhayagiri Dagaba visit";

    }

    else if ($pkg_name_url === 'polonnaruwa') {

        $p_name = "Medieval Capital Explorer";
        $p_price = 46500;
        $p_video = "polonnaruwa.mp4";
        $p_duration = "1 Day Tour";
        $p_activities = "Gal Vihara Rock carvings, Explore the Royal Palace ruins, Parakrama Samudra view";

    }

    else if ($pkg_name_url === 'jaffna') {

        $p_name = "Northern Heritage";
        $p_price = 38000;
        $p_video = "jaffna.mp4";
        $p_duration = "3 Days / 2 Nights";
        $p_activities = "Nallur Kandaswamy Kovil, Casuarina Beach, Jaffna Fort exploration";

    }

    else if ($pkg_name_url === 'trincomalee' || $pkg_name_url === 'trinco') {

        $p_name = "Trinco Coastal Gem";
        $p_price = 42000;
        $p_video = "trinco.mp4";
        $p_duration = "2 Days / 1 Night";
        $p_activities = "Snorkeling at Pigeon Island, Koneswaram Temple, Nilaveli Beach relaxation";

    }

    else if ($pkg_name_url === 'hikkaduwa') {

        $p_name = "Hikkaduwa Coral Reef";
        $p_price = 38000;
        $p_video = "hikka.mp4";
        $p_duration = "1 Day Tour";
        $p_activities = "Glass bottom boat ride, Turtle Hatchery visit, Coral reef snorkeling";

    }

    else {

        $p_name = "Ella Mist Adventure";
        $p_price = 46000;
        $p_video = "ella.mp4";
        $p_duration = "2 Days / 1 Night";
        $p_activities = "Hiking to Little Adam's Peak, Visiting Nine Arch Bridge, Ella Rock climbing";

    }

} else {


    $p_name = $package['destination_name'];
    $p_price = $package['price'];
    $p_video = $package['video_link'];
    $p_duration = $package['duration'];
    $p_activities = $package['activities'];

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Package Details | GlobeTrek</title>
    <style>
       
       body {
 
    background: linear-gradient(rgba(41, 45, 46, 0.8), rgba(0, 12, 12, 0.85)), 
                url('https://images.unsplash.com/photo-1506461883276-594a12b11cf3?auto=format&fit=crop&w=1600&q=80');
    
    background-size: cover;
    background-position: center;
    background-attachment: fixed; 
    color: white;
    font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
    margin: 0;
    padding: 40px;
}

.activity-btn {
    position: absolute; 
    left: 1500px;       
    top: 25px;         
    background: rgba(255, 255, 255, 0.2);
    color: white;
    padding: 8px 15px;
    border: 1px solid rgba(255, 255, 255, 0.5);
    border-radius: 50px;
    cursor: pointer;
    font-size: 14px;
    backdrop-filter: blur(5px);
    z-index: 100;      
}
.activity-btn:hover {
    background: #f1c40f;
    color: #1e272e;
    transform: scale(1.05);
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
               background: linear-gradient(to right,#5ddfff, #090f0f, #086974);
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
            font-family: serif;
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

.navbar {
    display: flex;
    justify-content: space-between; 
    align-items: center;
    padding: 0px 60px;
    height: 90px;
    
}


.nav-links {
    display: flex;
    align-items: center;
    gap: 20px;            
    margin-left: 1200px;    
    margin-right: auto;   
    padding-right: 150px; 
}

.nav-action-btn {
    text-decoration: none !important; 
    background: rgba(255, 255, 255, 0.15); 
    color: white;
    padding: 8px 10px;
    border: 1px solid rgba(255, 255, 255, 0.3) !important; 
    border-radius: 30px; 
    cursor: pointer;
    font-size: 14px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: 0.3s ease;
    backdrop-filter: blur(5px);
}

.nav-action-btn:hover {
    background: #f0f348;
    color: #090f0f;
    border-color: #f0f348 !important;
    transform: translateY(-2px);
}

.edit-profile-btn {
    border: 1px solid #d4af37 !important; 
    color: #ffffff !important;
}


.profile-container {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none; 
    position: absolute;
    right: 0;
    top: 50px;
    background: rgba(15, 15, 15, 0.95);
    min-width: 150px;
    border-radius: 10px;
    border: 1px solid #d4af37;
    z-index: 10002;
    overflow: hidden;
}


.dropdown-content.show {
    display: block;
}

.dropdown-content a {
    color: white;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    font-size: 14px;
}

.dropdown-content a:hover {
    background: rgba(212, 175, 55, 0.2);
    color: #f1c40f;
}


#navProfilePic {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    border: 2px solid #d4af37 !important;
    box-shadow: 0 0 10px rgba(72, 243, 237, 0.5);
    object-fit: cover;
}
.dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    top: 50px;
    background: rgba(15, 15, 15, 0.95);
    min-width: 160px;
    border-radius: 12px;
    border: 1px solid #d4af37;
    z-index: 10002;
    overflow: hidden;
}

.dropdown-content a {
    display: block;
    color: white;
    padding: 12px;
    text-decoration: none;
    font-size: 14px;
}

.dropdown-content a:hover {
    background: rgba(72, 243, 237, 0.1);
}


#plannerForm {
    display: flex;
    flex-direction: column; 
    gap: 15px; 
    padding: 20px;
    width: 100%;
    box-sizing: border-box;
}


.form-group {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    width: 100%;
}


#plannerForm label {
    color: #48f3ed;
    font-size: 14px;
    margin-bottom: 5px;
    font-weight: bold;
}


#plannerForm input, 
#plannerForm textarea {
    width: 100%;
    padding: 12px;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(72, 243, 237, 0.3);
    border-radius: 8px;
    color: white;
    font-size: 14px;
    box-sizing: border-box; 
}


.confirm-btn {
    background: #48f3ed;
    color: #090f0f;
    border: none;
    padding: 15px;
    border-radius: 10px;
    font-weight: bold;
    cursor: pointer;
    margin-top: 10px;
    transition: 0.3s;
}

.confirm-btn:hover {
    background: #36c7c2;
    transform: translateY(-2px);
}



#profileForm {
    display: none; 
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(20, 20, 20, 0.8); 
    backdrop-filter: blur(25px);
    padding: 40px;
    border-radius: 40px;
    border: 1px solid rgba(212, 175, 55, 0.2);
    z-index: 12000; 
    width: 380px;
    text-align: center;
    color: white;
}


#profilePreview {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    border: 2px solid #d4af37;
    object-fit: cover;
    margin-bottom: 20px;
}


.form-group {
    margin-bottom: 25px;
    text-align: left;
}

.form-group label {
    color: rgba(255, 255, 255, 0.6); 
    font-size: 13px;
    margin-bottom: 5px;
}

.form-group input {
    width: 100%;
    padding: 10px 0; 
    background: transparent; 
    border: none;
    border-bottom: 1px solid rgba(212, 175, 55, 0.5); 
    border-radius: 0;
    color: white;
    font-size: 15px;
    outline: none;
    transition: 0.3s;
}


.form-group input:focus {
    border-bottom: 1px solid #d4af37;
}


.save-btn {
    background: white;
    color: black;
    border: none;
    padding: 15px;
    width: 100%;
    border-radius: 50px;
    font-weight: bold;
    font-size: 14px;
    letter-spacing: 1.5px; 
    cursor: pointer;
    margin-top: 20px;
    text-transform: uppercase;
    transition: 0.3s;
}

.save-btn:hover {
    background: #d4af37; 
    color: white;
    transform: scale(1.02);
}

.upload-label {
    color: #d4af37;
    font-size: 12px;
    cursor: pointer;
    display: block;
    margin-bottom: 20px;
}
.side-drawer {
    position: fixed;
    top: 0;
    right: -500px;
    width: 400px;
    height: 100%;
    background: rgba(10, 25, 30, 0.98);
    backdrop-filter: blur(20px);
    z-index: 11000;
    padding: 40px;
    transition: 0.5s;
    border-left: 1px solid rgba(72, 243, 237, 0.3);
}

.side-drawer.open {
    right: 0;
}

.drawer-title {
    color: #48f3ed;
    margin-bottom: 30px;
}
.search-section {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 110px; 
    margin-bottom: 30px;
    padding: 0 20px;
}


.search-box {
    display: flex;
    width: 100%;
    max-width: 600px;
    background: rgba(255, 255, 255, 0.05); 
    backdrop-filter: blur(10px);
    border: 1px solid rgba(72, 243, 237, 0.4);
    border-radius: 50px;
    padding: 5px;
    transition: all 0.3s ease;
}

.search-box:focus-within {
    box-shadow: 0 0 20px rgba(72, 243, 237, 0.3);
    border-color: #48f3ed;
}


#packagesearch {
    flex: 1;
    background: transparent;
    border: none;
    outline: none;
    padding: 12px 25px;
    color: white;
    font-size: 16px;
    font-family: inherit;
}

#packagesearch::placeholder {
    color: rgba(255, 255, 255, 0.5);
}

.search-btn{
    background: linear-gradient(135deg, #48f3ed, #008a86);
    color: white;
       border: none;
    padding: 10px 30px;
    font-weight: bold;
  cursor: pointer;
  border-radius: 50px;
    transition: 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.search-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 5px 15px rgb(0, 206, 199);
  
}



/*main card*/
.details-card {
    display: flex;
    background: rgba(255, 255, 255, 0.05); 
    backdrop-filter: blur(15px); 
    -webkit-backdrop-filter: blur(15px);
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 25px;
    overflow: hidden;
    width: 850px;
    margin: 70px auto 50px auto;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.6);
}

.details-card video{
width: 450px;
height: auto;
object-fit: cover;
}

.info {
    padding: 25px 35px; 
    display: flex;
    flex-direction: column;
    justify-content: center; 
}

.info h1 {
    display: inline-block;
    position: relative;
}

.info h1::after {
    content: '';
    position: absolute;
    width: 0; 
    height: 3px;
    bottom: -5px;
    left: 0;
    background-color: #48f3ed;
    transition: width 0.4s ease;
}

.info h1:hover::after {
    width: 100%; 
}

.price-tag{
    font-size: 28px;
    font-weight: bold;
    color: #ffcc00;
  
}


.price-note{
    font-size: 18px;
    font-style: bold;
    color: rgb(255, 0, 0);
}
ul {
    padding-left: 20px;
}

ul li {
    margin-bottom: 8px;
    color: #cbd5e1;
}

.book-btn {
    background: linear-gradient(135deg, #ecf001, #008a86);
    color: black;
    border: none;
    padding: 15px 40px;
    border-radius: 12px;
    font-weight: bold;
    font-size: 16px;
    cursor: pointer;
    margin-top: 20px;
    transition: 0.3s;
}

.book-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 0 20px rgba(0, 206, 200, 0.4);
}
hr {
    border: 0;
    height: 1px;
    background: linear-gradient(to right, transparent, rgba(255,255,255,0.2), transparent);
    margin: 40px 0;
}
h2 {
    text-align: center;
    margin-bottom: 30px;
    letter-spacing: 2px;
    text-transform: uppercase;
}

.mini-card-container {
    display: grid;
    grid-template-columns: repeat(4, 1fr); 
    gap: 20px;
    max-width: 1200px;
    margin: 0 auto 80px auto;
}
.mini-card {
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 15px;
    padding: 10px;
    text-align: center;
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}




.mini-card:hover {
    background: rgba(255, 255, 255, 0.1);
    transform: translateY(-15px);
    border-color: #cbce00;
}

.mini-card img {
    width: 100%;
    height: 120px;
    object-fit: cover;
    border-radius: 10px;
    margin-bottom: 12px;
}

.mini-card h4 {
    margin: 0;
    font-size: 14px;
    color: #e2e8f0;
    font-weight: 500;
}

#paymentMethod {
    background: rgba(255, 255, 255, 0.07) !important;
    color: #48f3ed !important;
    border: 1px solid rgba(72, 243, 237, 0.3) !important;
    padding: 12px;
    border-radius: 12px;
    cursor: pointer;
    font-weight: bold;
    appearance: none; 
}


#paymentMethod:hover {
    border-color: #00CEC8 !important;
}

#paymentMethod option {
    background-color: #0a191e; 
    color: white; 
    padding: 10px;
}


#paymentMethod:focus {
    outline: none;
    border-color: #48f3ed !important;
    box-shadow: 0 0 10px rgba(72, 243, 237, 0.3);
}

/*form css*/




.side-drawer {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) scale(0.8); 
    width: 500px;
    max-height: 85vh;
    overflow-y: auto;
    visibility: hidden;
    opacity: 0;
    
background: linear-gradient(rgba(14, 29, 34, 0.8), rgba(10, 25, 30, 0.9));
    background-size: cover;
    background-position: center;
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    
    box-shadow: 0 20px 50px rgba(0,0,0,0.6);
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1); 
    z-index: 11000; 
    padding: 40px;
    border-radius: 25px;
    color: white;
    border: 1px solid rgba(72, 243, 237, 0.3);
}

.side-drawer.open {
    visibility: visible;
    opacity: 1;
    transform: translate(-50%, -50%) scale(1);
}


.drawer-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(8px);
    z-index: 10500;
    display: none;
}


#drawerPackageTitle {
    color: #48f3ed;
    font-size: 24px;
    font-weight: 700;
    text-align: center;
    text-transform: capitalize;
    text-shadow: 0 0 15px rgba(72, 243, 237, 0.4);
    margin-bottom: 25px;
}

#bookingform input, #bookingform select {
    width: 100%;
    padding: 12px;
    margin-top: 8px;
    border-radius: 12px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    background: rgba(255, 255, 255, 0.07);
    color: white;
    transition: 0.3s;
}

#bookingform input:focus {
    border-color: #48f3ed;
    outline: none;
    box-shadow: 0 0 10px rgba(72, 243, 237, 0.3);
}


.total-box {
    background: rgba(72, 243, 237, 0.1);
    padding: 20px;
    border-radius: 20px;
    text-align: center;
    margin: 25px 0;
    border: 1px solid rgba(72, 243, 237, 0.2);
}

.total-box h2 {
    color: #48f3ed;
    margin-top: 5px;
    font-size: 30px;
    font-weight: 800;
}

.close-btn {
    position: absolute;
    top: 20px;
    right: 25px;
    font-size: 30px;
    color: rgba(255, 255, 255, 0.5);
    cursor: pointer;
    transition: 0.3s;
}

.close-btn:hover {
    color: #ff4d4d;
    transform: rotate(90deg);
}


.confirm-btn {
    width: 100%;
    padding: 16px;
    background: linear-gradient(135deg, #00CEC8, #007991);
    color: #040c0e; 
    border: none;
    border-radius: 15px;
    font-weight: 800;
    font-size: 16px;
    cursor: pointer;
    transition: 0.4s;
    text-transform: uppercase;
}



.otp-overlay {
    display: none; 
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.85); 
    backdrop-filter: blur(8px); 
    z-index: 15000;
    justify-content: center;
    align-items: center;
}


.otp-box {
    background: #0a191e;
    padding: 40px;
    border-radius: 25px;
    border: 1px solid #48f3ed;
    text-align: center;
    width: 320px;
    box-shadow: 0 0 30px rgba(72, 243, 237, 0.2);
}

.otp-box h3 {
    color: #48f3ed;
    margin-bottom: 10px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.otp-box p {
    color: rgba(255, 255, 255, 0.8);
    font-size: 14px;
    margin-bottom: 20px;
}

#otpInput {
    width: 140px;
    text-align: center;
    font-size: 24px;
    letter-spacing: 8px;
    margin: 20px 0;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(72, 243, 237, 0.4);
    color: #48f3ed;
    border-radius: 10px;
    padding: 10px;
    outline: none;
    transition: 0.3s;
}

#otpInput:focus {
    border-color: #48f3ed;
    box-shadow: 0 0 15px rgba(72, 243, 237, 0.3);
}


.otp-verify-btn {
    background: #48f3ed;
    color: #0a191e;
    border: none;
    padding: 12px 30px;
    border-radius: 12px;
    font-weight: bold;
    font-size: 16px;
    cursor: pointer;
    transition: 0.3s;
    width: 100%;
    text-transform: uppercase;
}

.otp-verify-btn:hover {
    background: #00CEC8;
    transform: scale(1.03);
}

   .contact-section{
    padding: 80px 5%;
    text-align: center;

   
              

   }
   
   .contact-section h2 {
    font-size: 25px;
    font-weight: 800;
    text-transform: uppercase;
    margin-bottom: 50px;
    position: relative;
    display: inline-block; 
    

    background: white;
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
   width:100px;
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

    </style>
</head>
<body>
<nav class="navbar">
    <div class="logo"><img src="logo.png" alt="Logo" class="logo-img"></div> 
    <span class="welcome-msg">Welcome to <b>GlobeTrek Adventures</b></span>
    
    <div class="nav-links">
       <a href="index.php" class="nav-action-btn">Home 🏠 </a>
       
       <button class="nav-action-btn" onclick="window.location.href='userdashboard.php'">
    Your Activities 📈
</button>
        
        <div class="profile-container">
            <button class="nav-action-btn edit-profile-btn" onclick="toggleDropdown(event)">Edit Profile ✒️</button>
            <div id="profileDropdown" class="dropdown-content">
                <a href="#" onclick="showProfileForm()">Settings ⚙️</a>
                <a href="logout.php">Logout ❌</a>
            </div>
        </div>
    </div>
</nav>
<div id="drawerOverlay" class="drawer-overlay" onclick="closeAll()"></div>


    <!-- Profile Picture Section -->
<form id="profileForm">
    <div class="profile-pic-upload">
        <img src="profile-icon.png" id="profilePreview" alt="Profile" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 2px solid #2ecc71;">
        <label for="fileInput" class="upload-label">Change Photo</label>
        <input type="file" id="fileInput" accept="image/*" onchange="previewImage(event)" style="display: none;">
    </div>

    <div class="form-group">
        <label>Full Name</label>
        <input type="text" id="p_fullName" name="fullName" placeholder="Your Name" required> 
    </div>

    <div class="form-group">
        <label>Email Address (Cannot change)</label>
        <input type="email" id="p_email" name="email" value="example@gmail.com" readonly style="background: rgba(255,255,255,0.1); color: #888;">
    </div>

    <div class="form-group">
        <label>Phone Number</label>
        <input type="tel" id="p_phone" name="phone" placeholder="077-xxxxxxx">
    </div>

    <div class="form-group">
        <label>City / Address</label>
        <input type="text" id="p_address" name="address" placeholder="e.g. Colombo, Galle">
    </div>

    <button type="submit" class="save-btn">SAVE CHANGES</button>
</form>

 <div class="search-section">
    <div class="search-box">
        <input type="text" id="packagesearch" placeholder="Eg :-Ella">
        <button onclick="searchpackage()" class="search-btn">🔍 search</button></div></div>

<div class="details-card">
    <video id="main-video" width="450" autoplay muted loop>
        <source src="<?php echo $p_video; ?>" type="video/mp4" id="video-source">
        Your browser does not support the video tag.
    </video>

 <div class="info">
    <h1 id="main-title"><?php echo $p_name; ?></h1>
    
    <p class="price-tag" id="main-price">Rs <?php echo number_format($p_price); ?></p>
    
    <p><strong>Duration:</strong> <span id="main-duration"><?php echo $p_duration; ?></span></p>
    <p class="price-note">⚠️This price is valid for groups of 06 members only.</p>

        <h3>What's Included:</h3>
        <ul id="main-included">
            <li>Luxury Accommodation</li>
            <li>Breakfast & Dinner</li>
            <li>Private Transport</li>
        </ul>

        <h3>Activities:</h3>
        <ul id="main-activities">
            <?php 
            
            $act_list = explode(',', $p_activities);
            foreach($act_list as $act) {
                echo "<li>" . trim($act) . "</li>";
            }
            ?>
        </ul>

        <button class="book-btn" onclick="opendrawer()">BOOK NOW</button>
    </div>
</div>

    <hr>
    <h2>Explore Other Packages</h2>
     <hr>
     
<div class="mini-card-container">
    <div class="mini-card" onclick="openDetails('mirissa')">
        <img src="Mirissa-Beach.jpeg" alt="Mirissa">
        <h4>Mirissa Whale Watching</h4>
    </div>
    <div class="mini-card" onclick="openDetails('negombo')">
        <img src="negambo.jpg" alt="Negombo">
        <h4>Negombo Lagoon & Culture</h4>
    </div>
    <div class="mini-card" onclick="openDetails('kandy')">
        <img src="kandypro.jpg" alt="Kandy">
        <h4>Kandy Heritage Tour</h4>
    </div>
    <div class="mini-card" onclick="openDetails('sigiriya')">
        <img src="sigiriyapro.jpg" alt="Sigiriya">
        <h4>Ancient Sigiriya Rock</h4>
    </div>

    <div class="mini-card" onclick="openDetails('nuwaraeliya')">
        <img src="nuwaraeliyapro.jpg" alt="Nuwara Eliya">
        <h4>Little England</h4>
    </div>
    <div class="mini-card" onclick="openDetails('galle')">
        <img src="gallepro.jpg" alt="Galle">
        <h4>Galle Dutch Fort</h4>
    </div>
    <div class="mini-card" onclick="openDetails('yala')">
        <img src="yala.jpg" alt="Yala">
        <h4>Yala Wildlife Safari</h4>
    </div>
    <div class="mini-card" onclick="openDetails('anuradhapura')">
        <img src="anuradapurapro.jpg" alt="Anuradhapura">
        <h4>Anuradhapura City</h4>
    </div>

    <div class="mini-card" onclick="openDetails('jaffna')">
        <img src="jaffnapro.jpg" alt="Jaffna">
        <h4>Northern Heritage</h4>
    </div>
    <div class="mini-card" onclick="openDetails('polonnaruwa')">
        <img src="polonnaruwa.jpg" alt="polonnaruwa">
        <h4>Medieval Capital Explorer</h4>
    </div>
    <div class="mini-card" onclick="openDetails('trinco')">
        <img src="tincomaleepro.jpg" alt="Trinco">
        <h4>Trinco Coastal Gem</h4>
    </div>
    <div class="mini-card" onclick="openDetails('hikkaduwa')">
        <img src="hikkapro.jpg" alt="hikkaduwa">
        <h4>Hikkaduwa Coral Reef</h4>
    </div>
</div>

<div id="booking" class="side-drawer">
    <div class="drawer-header">
        <h3 id="drawerPackageTitle">Book Your Trip</h3>
        <span class="close-btn" onclick="closedrawer()">&times;</span>
    </div>

    <div class="drawer-content">
        <form  method="POST" id="bookingform">
          
    <input type="hidden" name="package_name" id="hidden_package_name" value="Ella Mist Adventure">

    <div class="input-group">
        <label>Full Name</label>
        <input type="text" name="full_name" placeholder="Enter Name" required>
    </div>

    <div class="input-group">
        <label>NIC Number</label>
        <input type="text" name="nic" placeholder="xxxxxxxxxx" required>
    </div>

    <div class="input-group">
    <label>Contact No</label>
    <input type="tel" name="phone" id="phone" placeholder="077XXXXXXX" required>
</div>

    <div class="input-row" style="display:flex; gap:10px;">
        <div class="input-group">
            <label>Arrival Date</label>
            <input type="date" name="arrival_date" required>
        </div>

        <div class="input-group">
            <label>Members</label>
            <input type="number" name="members" id="memberCount" min="1" oninput="calculateTotal()" required>
        </div>
    </div>

    <div class="input-group">
        <label>Payment Method</label>
        <select name="payment_method" id="paymentMethod" required>
            <option value="card">Credit/Debit Card</option>
            <option value="bank">Bank Transfer</option>
            <option value="cash">Pay at Destination</option>
        </select>
    </div>

<div id="otpOverlay" class="otp-overlay">
    <div class="otp-box">
        <h3>Bank Verification</h3>
        <p>Enter the 4-digit OTP sent to your phone</p>
        <input type="text" id="otpInput" maxlength="4" placeholder="0 0 0 0">
        <br>
        <button type="button" class="otp-verify-btn" onclick="verifyOTP()">VERIFY</button>
    </div>
</div>


    <div class="total-box">
        <span>Estimated Total</span>
        <h2 id="displaytotal">Rs 0</h2>
    </div>

<button type="submit" id="submitBtn" class="confirm-btn" name="confirm_booking">
    CONFIRM BOOKING
</button>
</form></div> 
</div>

<div id="drawerOverlay" class="drawer-overlay" onclick="closedrawer()"></div>
<section class="contact-section" id="contact">
    <hr>
    <h2>Connect With Us</h2>
    <hr>
    <div class="contact-grid">
        <a href="tel:+94740655034" class="contact-card">
            <img src="phone.jpg" alt="phone">
            <h3>Call Us</h3>
            <p>+94 74 065 5034</p>
        </a>

        <a href="https://wa.me/94740655034" target="_blank" class="contact-card">
            <img src="wp.jpg" alt="WhatsApp">
            <h3>WhatsApp</h3>
            <p>Message us directly</p>
        </a>

        <a href="mailto:info@globetrek.com" class="contact-card">
            <img src="email.jpg" alt="email">
            <h3>Email Us</h3>
            <p>info@globetrek.com</p>
        </a>

        <a href="https://instagram.com/globetrek" target="_blank" class="contact-card">
            <img src="inster.jpg" alt="instagram">
            <h3>Instagram</h3>
            <p>@GlobeTrekAdventures</p>
        </a>

        <a href="https://youtube.com/globetrek" target="_blank" class="contact-card">
            <img src="yrlogo.png" alt="youtube">
            <h3>YouTube</h3>
            <p>Watch Our Travel Vlogs</p>
        </a>
    </div>
</section>
<script>
function goToDashboard() {

    let isLoggedIn = localStorage.getItem('isLoggedIn');

    if (isLoggedIn === 'true') {
        window.location.href = "userdashboard.php"; 
    } else {
        alert("Please login to see your activities!");
        window.location.href = "login.php";
    }
}



function searchpackage() { 
    let inputField = document.getElementById('packagesearch');
    let input = inputField.value.toLowerCase().trim();

    if(input === ""){
        alert("Please enter a destination to search!");
        return;
    }

    const availablepackage = [
        'ella', 'mirissa', 'negombo', 'kandy', 'sigiriya', 
        'nuwaraeliya', 'galle', 'yala', 'anuradhapura', 
        'jaffna', 'polonnaruwa', 'trinco', 'hikkaduwa'
    ];

    if(availablepackage.includes(input)){
        openDetails(input);
        inputField.value = ""; 
    }
    else {
        alert("Sorry! Destination not found. Try 'Ella', 'Galle' or 'Sigiriya'.");
    }
}

function openDetails(type){
const title=document.getElementById('main-title');
const price=document.getElementById('main-price');
const video = document.getElementById('main-video');
const videoSource = document.getElementById('video-source');
const duration=document.getElementById('main-duration');
const included=document.getElementById('main-included');
const activities=document.getElementById('main-activities');
if (type === 'mirissa') {
        title.innerText = "Mirissa Whale Watching";
        price.innerText = "Rs 42,000";
        videoSource.src="mirissa1.mp4";
        duration.innerText = "1 Day Tour";
        activities.innerHTML = "<li>Whale & Dolphin Watching</li><li>Coconut Tree Hill visit</li><li>Mirissa Beach leisure</li>";
    }
else if (type === 'negombo') {
        title.innerText = "Negombo Lagoon & Culture";
        price.innerText = "Rs 25,000";
       videoSource.src ="negambo.mp4";
        duration.innerText = "1 Day Tour";
        activities.innerHTML = "<li>Boat ride in the lagoon</li><li>Fish Market visit</li><li>Dutch Fort exploration</li>";
    }
    else if (type === 'kandy') {
        title.innerText = "Kandy Heritage Tour";
        price.innerText = "Rs 38,000";
       videoSource.src = "kandy.mp4";
        duration.innerText = "1 Day Tour";
        activities.innerHTML = "<li>Temple of the Sacred Tooth Relic</li><li>Peradeniya Botanical Garden</li><li>Kandy Lake view</li>";
    }
    else if (type === 'sigiriya') {
        title.innerText = "Ancient Sigiriya Rock";
        price.innerText = "Rs 40,000";
        videoSource.src = "sigiriya.mp4";
        duration.innerText = "1 Day Tour";
        activities.innerHTML = "<li>Climb the Lion Rock</li><li>View Ancient Frescoes</li><li>Sigiriya Museum visit</li>";
    }
    else if (type === 'nuwaraeliya') {
        title.innerText = "Little England";
        price.innerText = "Rs 55,000";
        videoSource.src = "nuwaraeliya.mp4";
        duration.innerText = "2 Days / 1 Night";
        activities.innerHTML = "<li>Visit Tea Estates & Factories</li><li>Boat ride at Gregory Lake</li><li>Victoria Park walk</li>";
    }
    else if (type === 'galle') {
        title.innerText = "Galle Dutch Fort";
        price.innerText = "Rs 58,000";
       videoSource.src = "galle.mp4";
        duration.innerText = "1 Day Tour";
        activities.innerHTML = "<li>Walk on the Galle Fort Ramparts</li><li>Visit the Lighthouse</li><li>Maritime Museum tour</li>";
    }
    else if (type === 'yala') {
        title.innerText = "Yala Wildlife Safari";
        price.innerText = "Rs 45,000";
       videoSource.src = "yala.mp4";
        duration.innerText = "2 Days / 1 Night";
        activities.innerHTML = "<li>Jeep Safari to spot Leopards</li><li>Elephant sightings</li><li>Wilderness camping experience</li>";
    }
    else if (type === 'anuradhapura') {
        title.innerText = "Anuradhapura City";
        price.innerText = "Rs 38,000";
       videoSource.src = "anuradhapura.mp4";
        duration.innerText = "1 Day Tour";
        activities.innerHTML = "<li>Visit Sri Maha Bodhi</li><li>Explore Ruwanwelisaya</li><li>Abhayagiri Dagaba visit</li>";
    }
    else if (type === 'jaffna') {
        title.innerText = "Northern Heritage";
        price.innerText = "Rs 38,000";
       videoSource.src = "jaffna.mp4";
        duration.innerText = "3 Days / 2 Nights";
        activities.innerHTML = "<li>Nallur Kandaswamy Kovil</li><li>Casuarina Beach</li><li>Jaffna Fort exploration</li>";
    }
    else if (type === 'polonnaruwa') {
        title.innerText = "Medieval Capital Explorer";
        price.innerText = "Rs 46,000";
        videoSource.src = "polonnaruwa.mp4";
        duration.innerText = "1 Day Tour";
        activities.innerHTML = "<li>Gal Vihara Rock carvings</li><li>Explore the Royal Palace ruins</li><li>Parakrama Samudra view</li>";
    }
    else if (type === 'trinco') {
        title.innerText = "Trinco Coastal Gem";
        price.innerText = "Rs 42,000";
       videoSource.src = "trinco.mp4";
        duration.innerText = "2 Days / 1 Night";
        activities.innerHTML = "<li>Snorkeling at Pigeon Island</li><li>Koneswaram Temple</li><li>Nilaveli Beach relaxation</li>";
    }
    else if (type === 'hikkaduwa') {
        title.innerText = "Hikkaduwa Coral Reef";
        price.innerText = "Rs 38,000";
        videoSource.src = "hikka.mp4";
        duration.innerText = "1 Day Tour";
        activities.innerHTML = "<li>Glass bottom boat ride</li><li>Turtle Hatchery visit</li><li>Coral reef snorkeling</li>";
    }
    else if (type === 'ella') { 
        title.innerText = "Ella Mist Adventure";
        price.innerText = "Rs 46,000";
       videoSource.src = "ella.mp4";
        duration.innerText = "2 Days / 1 Night";
        activities.innerHTML = "<li>Hiking to Little Adam's Peak</li><li>Visiting Nine Arch Bridge</li><li>Ella Rock climbing</li>";
    }
video.load();
setTimeout(() => {
    video.play();
}, 100);
}

function opendrawer() {
    const currenttitle = document.getElementById('main-title').innerText;

    document.getElementById('drawerPackageTitle').innerText = "Booking : " + currenttitle;
     document.getElementById('hidden_package_name').value = currenttitle;
     document.getElementById('booking').classList.add('open');
    document.getElementById('drawerOverlay').style.display = 'block';
}

function closedrawer(){
    document.getElementById('booking').classList.remove('open');
    document.getElementById('drawerOverlay').style.display='none';

}
window.onload = function() {
    calculateTotal();
    console.log("Page loaded with Database content.");
};

// 2. Calculation Logic
function calculateTotal() {
    let priceElement = document.getElementById('main-price');
    if (!priceElement) return;

    let pricetext = priceElement.innerText;
    let baseprice = parseInt(pricetext.replace(/[^0-9]/g, ''));
    let memberInput = document.getElementById('memberCount');
    let member = parseInt(memberInput.value);
    let total = 0;

  
    if (isNaN(member) || member <= 0) {
        document.getElementById('displaytotal').innerText = "RS. 0";
        memberInput.style.borderColor = "red";
        return false;
    } else {
        memberInput.style.borderColor = "";
    }

    if (member == 1) { total = (baseprice / 6) * member + 550; }
    else if (member == 2) { total = (baseprice / 6) * member + 450; }
    else if (member == 3) { total = (baseprice / 6) * member + 350; }
    else if (member == 4) { total = (baseprice / 6) * member + 250; }
    else if (member == 5) { total = (baseprice / 6) * member + 100; }
    else if (member == 6) { total = (baseprice / 6) * member; }
    else { total = (baseprice / 6) * member - 3000; }

    document.getElementById('displaytotal').innerText = "RS. " + Math.round(total).toLocaleString();
    return true;
}

document.getElementById('bookingform').addEventListener('submit', function(event) {
    
    let phoneInput = document.getElementsByName('phone')[0];
    let nicInput = document.getElementsByName('nic')[0];
    let dateInput = document.getElementsByName('arrival_date')[0];
    let memberInput = document.getElementById('memberCount');
    
    let phoneValue = phoneInput.value.trim();
    let nicValue = nicInput.value.trim();
    let member = parseInt(memberInput.value);
    
  
    let selectedDate = new Date(dateInput.value);
    let today = new Date();
    today.setHours(0, 0, 0, 0);

    let method = document.getElementById('paymentMethod').value;
    let total = document.getElementById('displaytotal').innerText;
    
    let isValid = true;
    let errorMsg = "";

    // --- VALIDATION  ---

    const phonePattern = /^[0-9]{10}$/;
    if (!phonePattern.test(phoneValue)) {
        errorMsg += "• Phone number must be exactly 10 digits.\n";
        phoneInput.style.borderColor = "red";
        isValid = false;
    } else {
        phoneInput.style.borderColor = "";
    }

    // NIC Validation
    const nicPattern = /^([0-9]{9}[vVxX]|[0-9]{12})$/;
    if (!nicPattern.test(nicValue)) {
        errorMsg += "• Invalid NIC format (9 digits + V/X or 12 digits).\n";
        nicInput.style.borderColor = "red";
        isValid = false;
    } else {
        nicInput.style.borderColor = "";
    }

    // Date Validation
    if (!dateInput.value || selectedDate <= today) {
        errorMsg += "• Please select a future arrival date.\n";
        dateInput.style.borderColor = "red";
        isValid = false;
    } else {
        dateInput.style.borderColor = "";
    }

    // Member Validation
    if (isNaN(member) || member < 1) {
        errorMsg += "• Please enter at least 1 member.\n";
        memberInput.style.borderColor = "red";
        isValid = false;
    } else {
        memberInput.style.borderColor = "";
    }

    if (!isValid) {
        event.preventDefault(); 
        alert("Wait! Please fix these errors:\n\n" + errorMsg);
        return false;
    } 

  
   if (method === 'card' && !isOTPVerified) {
        event.preventDefault(); 
        document.getElementById('otpOverlay').style.display = 'flex';
    } else {
    
        if (method === 'bank') {
            alert("Booking Confirmed Successfully 🎫!\nYour " + total + " payment will be processed via bank transfer.");
        } else {
            alert("Booking Confirmed Successfully!\n" + total + " Pay at destination.");
        }
        
    }
});

function openPlanner() {
    document.getElementById('plannerDrawer').classList.add('open');
    document.getElementById('drawerOverlay').style.display = 'block';
}

function closePlanner() {
    document.getElementById('plannerDrawer').classList.remove('open');
    document.getElementById('drawerOverlay').style.display = 'none';
}

window.addEventListener('DOMContentLoaded', function () {
    const plannerForm = document.getElementById('plannerForm');

    plannerForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const destination = document.getElementById('plannerDestination').value;
        const duration = document.getElementById('plannerDuration').value;
        const activities = document.getElementById('plannerActivities').value;

        alert(
            "Quotation Request Sent!\n\n" +
            "Destination: " + destination +
            "\nDuration: " + duration + " day(s)" +
            "\nActivities: " + activities
        );

        plannerForm.reset();
        closePlanner();
    });
});
function goToDashboard() {
    console.log("Navigating to Dashboard...");
    window.location.href = "userdashboard.php";
}


function toggleDropdown(event) {
    event.stopPropagation(); 
    document.getElementById("profileDropdown").classList.toggle("show");
}


function showProfileForm() {
    document.getElementById('profileForm').style.display = 'block';
    document.getElementById('drawerOverlay').style.display = 'block';
    document.getElementById('profileDropdown').classList.remove('show');
}

function closeAll() {
    document.getElementById('profileForm').style.display = 'none';
    document.getElementById('drawerOverlay').style.display = 'none';
   
}


window.addEventListener('click', function(event) {
   if (!event.target.closest('.profile-container')) {
        const dropdown = document.getElementById("profileDropdown");
        if (dropdown && dropdown.classList.contains('show')) {
            dropdown.classList.remove('show');
        }
    }
});

const profileForm = document.getElementById('profileForm');

if (profileForm) {
    profileForm.addEventListener('submit', function(event) {
        event.preventDefault();
       const name = document.getElementById('p_fullName').value;
        const phone = document.getElementById('p_phone').value;
        const address = document.getElementById('p_address').value;


        localStorage.setItem('userName', name);
        localStorage.setItem('userPhone', phone);
        localStorage.setItem('userAddress', address);

        alert("Profile Updated Successfully!");
        
       if(typeof closeAll === "function") closeAll(); 
        if(typeof closeAllDrawers === "function") closeAllDrawers();
    });
}
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const output = document.getElementById('profilePreview');
        output.src = reader.result;
    
        localStorage.setItem('userProfilePic', reader.result);
    };
    reader.readAsDataURL(event.target.files[0]);
}

window.onload = function() {
    if(localStorage.getItem('userName')) {
        document.getElementById('p_fullName').value = localStorage.getItem('userName');
    }
    if(localStorage.getItem('userPhone')) {
        document.getElementById('p_phone').value = localStorage.getItem('userPhone');
    }
    if(localStorage.getItem('userAddress')) {
        document.getElementById('p_address').value = localStorage.getItem('userAddress');
    }
};

let isOTPVerified = false;
function verifyOTP() {
    let otpVal = document.getElementById('otpInput').value;
    let total = document.getElementById('displaytotal').innerText;

    if (otpVal === "1234") { 
        isOTPVerified = true;
        document.getElementById('otpOverlay').style.display = 'none';
        alert("OTP Verified Successfully!\n" + total + " processed.");
        
       document.getElementById('submitBtn').click();
    } else {
        alert("Invalid OTP! Please try again .");
    }
}
</script>




</body>

</html>