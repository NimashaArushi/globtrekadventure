<?php
session_start();

$conn = new mysqli("localhost", "root", "", "globetrek_db", 3308);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

$name = $_SESSION['user_name'];

$sql = "SELECT * FROM bookings WHERE user_name = '$name' ORDER BY booking_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard | GlobeTrek</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background: linear-gradient(rgba(4, 77, 110, 0.6), rgba(0, 0, 0, 0.7)), 
              url('https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?auto=format&fit=crop&w=1920&q=80');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
}

.dashboard-container {
    width: 950px;
    max-width: 100%;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 30px;
    padding: 40px;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
    color: white;
}

header {
    text-align: center;
    margin-bottom: 30px;
}

header h1 { font-size: 2.2rem; }
.user-name { color: #48f3ed; text-shadow: 0 0 10px rgba(72, 243, 237, 0.5); }
.sub-text { font-weight: 300; opacity: 0.8; }

.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 30px;
}

.stat-box {
    background: rgba(255, 255, 255, 0.1);
    padding: 20px;
    border-radius: 20px;
    border: 1px solid rgba(72, 243, 237, 0.3);
    text-align: center;
    transition: 0.3s;
}

.stat-box h2 { font-size: 2rem; color: #48f3ed; }


.message-container {
    margin-bottom: 30px;
    text-align: left;
}

.message-container h3 {
    margin-bottom: 15px;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    gap: 10px;
}

.msg-card {
    background: rgba(72, 243, 237, 0.15);
    border-left: 5px solid #48f3ed;
    padding: 15px 20px;
    border-radius: 12px;
    animation: fadeIn 0.5s ease-in;
}

.msg-time {
    display: block;
    font-size: 0.75rem;
    opacity: 0.6;
    margin-top: 8px;
    text-align: right;
}


.table-wrapper {
    background: rgba(0, 0, 0, 0.2);
    border-radius: 20px;
    padding: 20px;
    margin-bottom: 30px;
    overflow-x: auto;
}

table { width: 100%; border-collapse: collapse; }
th { text-align: left; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.2); font-size: 0.8rem; opacity: 0.7; }
td { padding: 12px; font-size: 0.9rem; border-bottom: 1px solid rgba(255,255,255,0.05); }

.status-badge {
    background: #48f3ed;
    color: #003049;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: bold;
}


.actions {
    display: flex;
    justify-content: center;
    gap: 20px;
}

.btn {
    padding: 12px 28px;
    border: none;
    border-radius: 15px;
    cursor: pointer;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
    transition: 0.3s;
}

.btn-plan {  
      background: linear-gradient(135deg, #ecf001, #008a86);
}
.btn-logout { 
    background:red;
     color: #ffffff;  
    }
.btn:hover { transform: scale(1.05); }

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
    </style>
</head>
<body>
<div class="dashboard-container">
    <header>
        <h1>Welcome Travelers, <span class="user-name"><?php echo htmlspecialchars($name); ?></span> 🥰!</h1>
        <p class="sub-text">Your Personalized Travel Explorer</p>
    </header>

    <div class="stats-grid">
        <div class="stat-box"><h2>02</h2><p>Trips Booked</p></div>
        <div class="stat-box"><h2>01</h2><p>Active Plans</p></div>
       <div class="stat-box"><h2>36k</h2><p>Last Spent</p>
</div>
    </div>

<div class="message-container">
    <h3><i class="fas fa-envelope-open-text"></i>  📩 Messages from Staff</h3>
    <div class="msg-card">
        <div class="msg-header">
            <span class="staff-tag">Official Support</span>
            <span class="msg-time">Just now</span>
        </div>
        <div class="msg-body">
            <p>Hi <b><?php echo htmlspecialchars($name); ?></b>, Your personalized travel plan for Ella is ready! Let us know if you need any changes.</p>
        </div>
    </div>
</div>

    <h3>📍 My Booking History</h3>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Package Name</th>
                    <th>Date</th>
                    <th>Members</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
              <?php
            if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td><b>" . htmlspecialchars($row['package_name']) . "</b></td>";
                    echo "<td>" . htmlspecialchars($row['booking_date']) . "</td>";
                    echo "<td>" . sprintf("%02d", $row['members']) . "</td>";
        
                    $status = htmlspecialchars($row['status']);
                    echo "<td><span class='status-badge'>" . $status . "</span></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4' style='text-align:center; color:#fff;'>No booking history found.</td></tr>";
            }
            ?> </tbody> </table></div>
<div class="actions">
        <button class="btn btn-plan" id="planBtn">
            <span>✈️</span> Explore More Packages
        </button>
        <button class="btn btn-logout" id="logoutBtn">
            <span>✖️</span> Logout
        </button>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
    const planBtn = document.getElementById('planBtn');
    const logoutBtn = document.getElementById('logoutBtn');

   
    if (planBtn) {
        planBtn.addEventListener('click', () => {
            window.location.href = 'second.php';
        });
    }
if (logoutBtn) {
    logoutBtn.addEventListener('click', () => {
        const confirmLogout = confirm("Are you sure you want to logout?");
        if (confirmLogout) {
            window.location.href = 'logout.php';
        }
    });}});
</script>
</body>
</html>