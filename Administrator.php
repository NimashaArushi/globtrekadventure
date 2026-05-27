<?php
session_start();
if (!isset($_SESSION['admin_access']) || $_SESSION['admin_access'] !== true) {
    header("Location: admin_login.php");
    exit();
}
?>
<h1>Welcome, <?php echo $_SESSION['admin_name']; ?>!</h1>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | GlobeTrek Adventures</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-teal: #007991;
            --secondary-cyan: #00CEC8;
            --accent-gold: #D69E2E;
            --glass-bg: rgba(255, 255, 255, 0.85);
            --sidebar-gradient: linear-gradient(180deg, #007991 0%, #004d4d 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(rgba(29, 31, 32, 0.8), rgba(9, 10, 10, 0.8)), 
                        url('travel3.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            min-height: 100vh;
            color: #333;
        }


        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, rgba(0, 121, 145, 0.95) 0%, rgba(0, 77, 77, 0.95) 100%);
            backdrop-filter: blur(10px); 
            color: white;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            box-shadow: 4px 0 15px rgba(0,0,0,0.1);
            z-index: 1000;
        }

        .admin-logo {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 50px;
            text-align: center;
            letter-spacing: 1px;
            border-bottom: 1px solid rgba(255,255,255,0.2);
            padding-bottom: 15px;
        }

        .nav-menu {
            list-style: none;
            flex-grow: 1;
        }

        .nav-item {
            padding: 15px 20px;
            margin-bottom: 10px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 14px;
            border-left: 4px solid transparent;
        }

        .nav-item:hover, .nav-item.active {
            background: rgba(255, 253, 253, 0.2);
            backdrop-filter: blur(5px);
            transform: translateX(5px);
            border-left: 4px solid var(--secondary-cyan);
        }

        .logout-btn {
            color: #ff6b6b;
            text-decoration: none;
            font-weight: 600;
            padding: 15px 20px;
            border-radius: 12px;
            transition: 0.3s;
        }

        .logout-btn:hover {
            background: rgba(255, 107, 107, 0.1);
        }

      
        .main-content {
            margin-left: 260px;
            flex-grow: 1;
            padding: 40px;
            width: calc(100% - 260px);
        }

       
        .section {
            display: none;
            animation: fadeIn 0.4s ease-in-out;
        }

        .section.active {
            display: block;
        }

.section h1 {
    color: #ffffff !important; 
    text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.5); 
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 10px;
}


.section p {
    color: #ffffff !important; 
    font-size: 14px;
    text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.5);
}

      .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        .header h1 {
            color: var(--primary-teal);
            font-size: 28px;
        }

        .backup-btn {
            background: var(--secondary-cyan);
            color: #004d4d;
            border: none;
            padding: 12px 25px;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 206, 200, 0.3);
            transition: 0.3s;
        }

        /* --- Stats Grid --- */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: var(--glass-bg);
            padding: 25px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 8px 32px rgba(0, 121, 145, 0.1);
            backdrop-filter: blur(10px);
            transition: 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card .value {
            font-size: 32px;
            font-weight: 700;
            color: var(--primary-teal);
        }

      
        .table-container {
    background: var(--glass-bg);
    border-radius: 20px;
    padding: 30px 60px; 
    border: 1px solid rgba(255, 255, 255, 0.5);
    box-shadow: 0 8px 32px rgba(0, 121, 145, 0.1);
}

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 15px;
            border-bottom: 2px solid #eee;
            color: var(--primary-teal);
            font-weight: 600;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
        }

        .badge {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: 700;
        }

      
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
.sub-text {
     color: #ffffff !important;
     font-size: 14px; 
     text-shadow: 1px 1px 5px rgba(0,0,0,0.5);
     }
.status-msg { color: #27ae60; font-size: 12px; margin-top: 5px; }
.card-desc { color: #ffffff; font-size: 12px; }
.active-badge { background: #e8f5e9; color: #2e7d32; }


.card-cyan-top { border-top: 4px solid var(--secondary-cyan); }
.card-gold-top { border-top: 4px solid var(--accent-gold); }
.card-earnings { border-left: 5px solid #2ecc71; }
.card-pending { border-left: 5px solid #e74c3c; }
.card-promo { border-left: 5px solid #3498db; }


.stat-card p.trend-up { 
    color: #1b5e20 !important; /
    font-size: 14px !important; 
    font-weight: 700 !important; 
    opacity: 1 !important;
    display: block !important;
}

.stat-card p.trend-warn { 
    color: #b71c1c !important; 
    font-size: 14px !important; 
    font-weight: 700 !important;
    opacity: 1 !important;
    display: block !important;
}

.stat-card p.trend-info { 
    color: #0d47a1 !important; 
    font-size: 14px !important; 
    font-weight: 700 !important;
    opacity: 1 !important;
    display: block !important;
}

.chart-container {
    background: var(--glass-bg);
    backdrop-filter: blur(12px);
    border-radius: 20px;
    padding: 40px;
    margin-top: 30px;
    text-align: center;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.bar-chart {
    height: 180px;
    background: rgba(0, 0, 0, 0.05);
    border-radius: 15px;
    display: flex;
    align-items: flex-end;
    justify-content: space-around;
    padding: 20px;
    margin-top: 20px;
}

.bar {
    width: 35px;
    border-radius: 5px 5px 0 0;
    transition: 0.3s ease;
}

.bar-1 { height: 90%; background: var(--secondary-cyan); }
.bar-2 { height: 70%; background: var(--primary-teal); }
.bar-3 { height: 55%; background: var(--accent-gold); }
.bar-4 { height: 70%; background: var(--secondary-cyan); }
.bar-5 { height: 5%; background: var(--primary-teal); }


.chart-container .chart-footer {
    margin-top: 15px;
    color: #000000 !important; 
    font-size: 13px !important;
    font-weight: 700 !important; 
    display: block !important;
    opacity: 1 !important;
}
    </style>
</head>
<body>

  <!-- Sidebar Section -->
<div class="sidebar">
    <div class="admin-logo">🌍 GLOBETREK ADMIN</div>
    <ul class="nav-menu">
        <li class="nav-item active" onclick="showSection('section-overview', this)">📊 System Overview</li>
        <li class="nav-item" onclick="showSection('section-staff', this)">👥 Staff Management</li>
        <li class="nav-item" onclick="showSection('section-revenue', this)">💰 Revenue Analytics</li>
        <li class="nav-item" onclick="showSection('section-security', this)">🛡️ Security Logs</li>
        <li class="nav-item" onclick="showSection('section-settings', this)">⚙️ Global Settings</li>
    </ul>
 <a href="logout_admin.php" class="logout-btn">X LOGOUT ADMIN</a>
</div>

<div class="main-content">
    <!-- 1. System Overview -->
    <div id="section-overview" class="section active">
        <div class="header">
            <div>
                <h1>Operations Control Center</h1>
                <p class="sub-text">System Monitoring & Data Integrity</p>
            </div>
            <button class="backup-btn" onclick="alert('Full System Backup Generated!')">⚡ GENERATE FULL BACKUP</button>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>System Status</h3>
                <div class="value status-online">ONLINE</div>
                <p class="status-msg">● All Services Running</p>
            </div>
            <div class="stat-card card-cyan-top">
                <h3>Total Packages</h3>
                <div class="value">12</div>
                <p class="card-desc">Active in Database</p>
            </div>
            <div class="stat-card card-gold-top">
                <h3>Security Alerts</h3>
                <div class="value">0</div>
                <p class="card-desc">No Unauthorized Access</p>
            </div>
        </div>

        <div class="table-container">
            <h2>Active Operations Log</h2>
            <table>
                <thead>
                    <tr>
                        <th>Process ID</th>
                        <th>Module</th>
                        <th>Status</th>
                        <th>Integrity</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#GT-9921</td>
                        <td>Package Manager</td>
                        <td><span class="badge active-badge">ACTIVE</span></td>
                        <td>100% Secure</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 2. Staff Management -->
    <div id="section-staff" class="section">
        <div class="header">
            <h1>Staff Management</h1>
            <p class="sub-text">Manage Staff Details & Performance</p>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Staff ID</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Status</th>
                    </tr>
                </thead>
               <tbody>
  <tbody>
    <?php 
   
    if (!isset($conn)) {
        $conn = new mysqli("localhost", "root", "", "globetrek_db", 3308);
    }

$result = $conn->query("SELECT * FROM staff");

    if ($result) {
        while($row = $result->fetch_assoc()) {
    
            $statusValue = isset($row['status']) ? $row['status'] : 'INACTIVE';
            $badgeClass = ($statusValue == 'ACTIVE') ? 'active-badge' : 'inactive-badge';
            ?>
            <tr>
                <td>ST-00<?php echo $row['id']; ?></td>
                <td><?php echo isset($row['full_name']) ? htmlspecialchars($row['full_name']) : (isset($row['name']) ? htmlspecialchars($row['name']) : 'No Name'); ?></td>
                <td>Travel Consultant</td>
                <td>
                    <span class="badge <?php echo $badgeClass; ?>">
                        <?php echo $statusValue; ?>
                    </span>
                </td>
            </tr>
            <?php 
        }
    } else {
        echo "<tr><td colspan='4'>Error: " . $conn->error . "</td></tr>";
    }
    ?></tbody>
            </table>
        </div>
    </div>

    <!-- 3. Revenue Analytics  -->
    <div id="section-revenue" class="section">
        <div class="header">
            <h1>Revenue Analytics</h1>
            <p class="sub-text">Real-time financial tracking for GlobeTrek</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card card-earnings">
                <h3>Total Earnings</h3>
                <div class="value">LKR 850,000</div>
                <p class="trend-up">↑ 12% increase</p>
            </div>
            <div class="stat-card card-pending">
                <h3>Pending Payments</h3>
                <div class="value">LKR 45,000</div>
                <p class="trend-warn">From 3 Bookings</p>
            </div>
            <div class="stat-card card-promo">
                <h3>Active Promotions</h3>
                <div class="value">03</div>
                <p class="trend-info">April Seasonal Offers</p>
            </div>
        </div>

        <div class="chart-container">
            <h2>Monthly Revenue Graph</h2>
            <div class="bar-chart">
                <div class="bar bar-1">90%</div>
                <div class="bar bar-2">70%</div>
                <div class="bar bar-3">55%</div>
                <div class="bar bar-4">70%</div>
                <div class="bar bar-5">5%</div>
            </div>
            <p class="chart-footer">Data based on last 5 months travel bookings.</p>
             <p class="chart-footer">[December 01 - April 01].</p>
        </div>
    </div>

    <!-- Other  -->
    <div id="section-security" class="section">
        <h1>Security Logs</h1>
        <p class="sub-text">Login history and access attempts.</p>
    </div>
    <div id="section-settings" class="section">
        <h1>Global Settings</h1>
        <p class="sub-text">System-wide configurations.</p>
    </div>
</div>
<script>
function showSection(sectionId, clickedItem) {
   const sections = document.querySelectorAll('.section');
    sections.forEach(section => {
        section.classList.remove('active');
    });

    const targetSection = document.getElementById(sectionId);
    if (targetSection) {
        targetSection.classList.add('active');
    }

    
    const navItems = document.querySelectorAll('.nav-item');
    navItems.forEach(item => {
        item.classList.remove('active');
    });


    clickedItem.classList.add('active');
}

function logoutAdmin() {
    window.location.href = "logout_admin.php"; 
}

</script>


</body>

</html>