<?php
session_start();
if (!isset($_SESSION['staff_logged_in'])) {
    header("Location: staff_login.php");
    exit();}
$staff_name = $_SESSION['staff_name'];
$conn = new mysqli("localhost", "root", "", "globetrek_db", 3308);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pName'])) {
    $name = $_POST['pName'];
    $price = $_POST['pPrice'];
    $members = $_POST['pMembers'];
    $duration = $_POST['pDuration'];
    $discount = $_POST['pDiscount'];
    $video = $_POST['pVideo'];
    $activities = $_POST['pActivities'];
    $image = str_replace('.mp4', '.jpg', $video); 

    $sql = "INSERT INTO packages 
    (destination_name, price, max_members, duration, discount, video_link, activities, image)
    VALUES 
    ('$name', '$price', '$members', '$duration', '$discount', '$video', '$activities', '$image')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
            alert('Package Published Successfully!');
            window.location.href='Staff.php';
        </script>";
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
/*  Delete button*/
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM packages WHERE id=$id");
    header("Location: Staff.php"); 
}

$pkg_count = $conn->query("SELECT id FROM packages")->num_rows;
$inquiries = $conn->query("SELECT * FROM inquiries ORDER BY id DESC");
$bookings  = $conn->query("SELECT * FROM bookings ORDER BY id DESC");
$packages = $conn->query("SELECT * FROM packages ORDER BY id DESC");
?>
!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard Pro | GlobeTrek</title>
    <style>
        :root {
            --primary: #008c9e; 
            --accent: #48f3ed;
            --bg-overlay: rgba(240, 244, 248, 0.85);
            --sidebar-bg: rgba(10, 45, 50, 0.95);
            --text-dark: #1e293b;
            --text-light: #64748b;
            --danger: #ef4444;
            --warning: #f59e0b;
        }

        body {
           
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.6)), 
                        url('https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: var(--text-dark);
            font-family: 'Inter', 'Segoe UI', sans-serif;
            margin: 0;
            display: flex;
        }

        
        .sidebar {
            width: 260px;
            height: 100vh;
            background: var(--sidebar-bg);
            backdrop-filter: blur(20px);
            position: fixed;
            padding: 40px 0;
            z-index: 1000;
        }

        .sidebar h2 { 
            color: white; 
            font-size: 20px; 
            padding: 0 30px;
            margin-bottom: 50px; 
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .sidebar nav a {
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            padding: 15px 30px;
            transition: 0.3s;
            font-size: 15px;
        }

        .sidebar nav a:hover, .sidebar nav a.active {
            background: rgba(72, 243, 237, 0.1);
            color: var(--accent);
            border-left: 4px solid var(--accent);
        }

      
        .main-content {
            margin-left: 260px;
            padding: 40px;
            width: calc(100% - 260px);
            min-height: 100vh;
        }

        h2 { font-weight: 700; color: white; margin-bottom: 25px; }

      
        .stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: var(--bg-overlay);
            padding: 25px;
            border-radius: 20px;
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border: 1px solid rgba(255,255,255,0.5);
            transition: 0.3s;
        }

        .stat-card:hover { 
            transform: translateY(-5px);
         }

        .stat-card p {
             color: var(--text-light); 
             margin: 0; 
             font-size: 14px;
              font-weight: 600; 
            }
        .stat-card h3 {
             color: var(--primary);
              font-size: 32px; 
              margin: 10px 0 0 0;
             }

      
        .admin-section {
            background: rgba(255, 255, 255, 0.95);
            padding: 35px;
            border-radius: 25px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            margin-bottom: 40px;
        }

        #form-title { color: var(--text-dark); margin-bottom: 25px; font-size: 22px; }

        .input-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        label { font-size: 13px; font-weight: 700; color: var(--text-light); margin-bottom: 8px; text-transform: uppercase; }

        input, textarea, select {
            width: 100%;
            padding: 14px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: var(--text-dark);
            border-radius: 12px;
            transition: 0.3s;
            font-size: 14px;
        }

        input:focus { border-color: var(--primary); outline: none; background: white; box-shadow: 0 0 0 4px rgba(0, 140, 158, 0.1); }

        .btn-row { display: flex; gap: 15px; margin-top: 25px; }
        
        .btn-main { 
            flex: 2; 
            padding: 15px; 
            background: linear-gradient(135deg, #008c9e, #005f6b);
            color: white; 
            border: none; 
            border-radius: 12px; 
            cursor: pointer; 
            font-weight: 700; 
            letter-spacing: 0.5px;
            transition: 0.3s;
        }

        .btn-main:hover { filter: brightness(1.1); transform: scale(1.01); }

        .btn-cancel { 
            flex: 1; 
            background: #e2e8f0; 
            color: var(--text-dark); 
            border: none; 
            border-radius: 12px; 
            cursor: pointer; 
            font-weight: 600;
        }

     
        .inventory-header {
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 20px;
        }

        .inventory-container {
            background: white;
            border-radius: 25px;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        table { width: 100%; border-collapse: separate; border-spacing: 0; }
        
        th { 
            background: #f1f5f9; 
            color: var(--text-light); 
            padding: 18px; 
            font-size: 12px; 
            text-transform: uppercase; 
            letter-spacing: 1px;
            text-align: left;
        }

        th:first-child { border-radius: 15px 0 0 15px; }
        th:last-child { border-radius: 0 15px 15px 0; }

        td { padding: 20px 18px; border-bottom: 1px solid #f1f5f9; font-size: 14px; }
        
        tr:hover td { background: #f8fafc; }

        .search-bar {
            padding: 12px 20px;
            width: 350px;
            border-radius: 50px;
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
        }
        .search-bar::placeholder { color: rgba(255,255,255,0.7); }

      
        .action-btns button { 
            padding: 8px 15px; 
            border-radius: 8px; 
            font-size: 12px; 
            font-weight: 600;
            border: none;
            cursor: pointer;
            margin-right: 5px;
        }
        .edit-btn { background: #dcfce7; color: #166534; }
        .del-btn { background: #fee2e2; color: #991b1b; }


       
/* --- Customer Section CSS --- */

#section-customers .admin-section {
    background: rgba(255, 255, 255, 0.98); 
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    margin-top: 20px;
    align-items: center;
}

#section-customers h2 {
    color: #1e293b;
    font-size: 24px;
    margin-bottom: 10px;
    border-left: 5px solid #00cec8; 
    padding-left: 15px;
}

#section-customers p {
    color: #64748b;
    margin-bottom: 25px;
    font-size: 14px;
}

/* Table*/
.data-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 12px;
    overflow: hidden; 
}

.data-table therapeutic {
    background-color: #f1f5f9;
}

.data-table th {
    text-align: left;
    padding: 18px 15px;
    background-color: #f8fafc;
    color: #475569;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #e2e8f0;
}

.data-table td {
    padding: 18px 15px;
    color: #1e293b;
    font-size: 14px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}


.data-table tbody tr:hover {
    background-color: #f0f9ff;
    transition: 0.2s;
}

/* Reply Button */
.reply-btn {
    background: linear-gradient(135deg, #00cec8, #008c9e);
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 10px rgba(0, 206, 200, 0.2);
}

.reply-btn:hover {
    background: linear-gradient(135deg, #008c9e, #00cec8);
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(0, 206, 200, 0.3);
}

.reply-btn:active {
    transform: translateY(0);
}

/* Message Column  */
.data-table td:nth-child(4) {
    color: #475569;
    font-style: italic;
    max-width: 300px; 
}

/* Email Column */
.data-table td:nth-child(2) {
    color: #008c9e;
    font-weight: 500;
}
        

/* --- Bookings Section  --- */
#section-bookings .status-confirmed {
    color: #10b981;
    background: rgba(16, 185, 129, 0.1);
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}


.main-content {
    padding: 20px;
    width: 100%;
}

.admin-section {
    background: rgba(255, 255, 255, 0.98);
    color: #1e293b;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    margin-bottom: 20px;
}

.admin-section h2 {
    border-left: 5px solid #008c9e;
    padding-left: 15px;
    margin-bottom: 10px;
    color: #0f172a;
}

.admin-section p {
    color: #64748b;
    margin-bottom: 25px;
    font-size: 14px;
}

/* --- Bookings Table  --- */
.data-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 10px;
    overflow: hidden;
}

.data-table th {
    background: #f8fafc;
    padding: 15px;
    text-align: left;
    color: #475569;
    border-bottom: 2px solid #e2e8f0;
    font-size: 13px;
    text-transform: uppercase;
}

.data-table td {
    padding: 15px;
    border-bottom: 1px solid #f1f5f9;
    font-size: 14px;
    color: #334155;
}

/* Status Dropdown  */
.status-select {
    padding: 6px 10px;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    background: #f8fafc;
    font-size: 13px;
    font-weight: 600;
    color: #475569;
    cursor: pointer;
    outline: none;
}

.status-select:focus {
    border-color: #00cec8;
}

/* --- Settings g --- */
.settings-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr); 
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    font-weight: 600;
    margin-bottom: 8px;
    font-size: 14px;
    color: #1e293b;
}

.form-group input {
    padding: 12px;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    background: #f8fafc;
    font-size: 14px;
    transition: all 0.3s ease;
}

.form-group input:focus {
    border-color: #00cec8;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(0, 206, 200, 0.1);
    outline: none;
}

/* Button */
.btn-action {
    background: linear-gradient(135deg, #00cec8, #008c9e);
    color: white;
    border: none;
    padding: 12px 25px;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
}

.btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 206, 200, 0.3);
}
.logout-link {
    color: #ff4d4d !important; 
    font-weight: bold;
    margin-top: 20px;
    display: block;
    padding: 10px 20px;
    text-decoration: none;
}

.logout-link:hover {
    background-color: rgba(255, 77, 77, 0.1);
    border-radius: 5px;
}
    </style>
</head>
<body>

  <div class="sidebar">
        <h2>GlobeTrek Staff</h2>
     <nav>
    <a onclick="switchTab('section-packages')" id="link-packages" class="active">📦 Packages</a>
    <a onclick="switchTab('section-customers')" id="link-customers">👥 Customers</a>
    <a onclick="switchTab('section-bookings')" id="link-bookings">📅 Bookings</a>
    <a onclick="switchTab('section-settings')" id="link-settings">⚙️ Settings</a>
   <a href="logout.php" class="logout-link" onclick="return confirm('Are you sure you want to logout?')">🚪 Logout</a>
</nav>
    </div>

    <div class="main-content" id="section-packages">
        <div class="stats-row">
            <div class="stat-card">
                <p>TOTAL PACKAGES</p>
                <h3 id="stat-pkg">0</h3>
            </div>
            <div class="stat-card">
                <p>TOTAL MEMBERS</p>
                <h3 id="stat-mem">0</h3>
            </div>
            <div class="stat-card">
                <p>ACTIVE DISCOUNTS</p>
                <h3 id="stat-disc">0</h3>
            </div>
        </div>

        <section class="admin-section">
    <h2 id="form-title">Add New Package</h2>
    <form id="packageForm" method="POST" action="Staff.php"> 
        <input type="hidden" id="editIndex" value="-1">
        <div class="input-grid">
            <div class="input-group">
                <label>Destination Name</label>
                <input type="text" id="pName" name="pName" placeholder="e.g. Ella" required>
            </div>
            <div class="input-group">
                <label>Price (LKR)</label>
                <input type="number" id="pPrice" name="pPrice" placeholder="36000" required>
            </div>
            <div class="input-group">
                <label>Max Members</label>
                <input type="number" id="pMembers" name="pMembers" placeholder="6" required>
            </div>
            <div class="input-group">
                <label>Duration</label>
                <input type="text" id="pDuration" name="pDuration" placeholder="2 Days / 1 Night" required>
            </div>
            <div class="input-group">
                <label>Discount (%)</label>
                <input type="number" id="pDiscount" name="pDiscount" placeholder="0">
            </div>
            <div class="input-group">
    <label>Video File Name (e.g., travel.mp4)</label>
    <input type="text" id="pVideo" name="pVideo" placeholder="travel.mp4">
</div>
        </div>
        <div class="input-group" style="margin-top: 15px;">
            <label>Activities (Split with commas)</label>
            <textarea id="pActivities" name="pActivities" rows="2" placeholder="Hiking, Photography, Climbing"></textarea>
        </div>
        <div class="btn-row">
            <button type="submit" class="btn-main" id="submitBtn">PUBLISH PACKAGE</button>
            <button type="button" class="btn-cancel" onclick="resetForm()">CANCEL</button>
        </div>
    </form>
</section>

        <div class="inventory-header">
            <h2>Inventory Management</h2>
            <input type="text" id="searchPkg" class="search-bar" placeholder="Search destination..." onkeyup="filterTable()">
        </div>

        <div class="inventory-container">
            <div class="table-container">
                <table id="pkgTable">
    <thead>
        <tr>
            <th>Destination</th>
            <th>Price (LKR)</th>
            <th>Members</th>
            <th>Duration</th>
            <th>Discount</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
    <tbody>
    <?php if ($packages && $packages->num_rows > 0): ?>
        <?php while($row = $packages->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['destination_name']); ?></td>
                <td><?php echo htmlspecialchars($row['price']); ?></td>
                <td><?php echo htmlspecialchars($row['max_members']); ?></td>
                <td><?php echo htmlspecialchars($row['duration']); ?></td>
                <td><?php echo htmlspecialchars($row['discount']); ?>%</td>
              <td class="action-btns">
    <button class="edit-btn" onclick="editPackage(
        '<?php echo $row['id']; ?>', 
        '<?php echo addslashes($row['destination_name']); ?>', 
        '<?php echo $row['price']; ?>', 
        '<?php echo $row['max_members']; ?>', 
        '<?php echo $row['duration']; ?>', 
        '<?php echo $row['discount']; ?>', 
        '<?php echo $row['video_link']; ?>', 
        '<?php echo addslashes($row['activities']); ?>'
    )">Edit</button>

    <a href="Staff.php?delete=<?php echo $row['id']; ?>" 
       class="del-btn" 
       style="text-decoration: none; display: inline-block;"
       onclick="return confirm('Are you sure you want to delete this?')">Delete</a>
</td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="6" style="text-align:center;">No packages found in Database.</td>
        </tr>
    <?php endif; ?>
</tbody>

</table>
            </div>
        </div>
    </div>

<!-- 2. Customer Section -->
<div id="section-customers" class="main-content" style="display: none;">
            <div class="admin-section">
                <h2>Customer Inquiries & Custom Plan Requests</h2>
                <p>Manage messages sent by users from the contact form.</p>
                
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Email Address</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php 
                
                if ($inquiries->num_rows > 0) {
                    while($row = $inquiries->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['customer_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['subject']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['message']) . "</td>";
                        echo "<td>" . $row['created_at'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' style='text-align:center;'>No messages found.</td></tr>";
                }
                ?>
            </tbody>
                   
                </table>
            </div>
        </div>
    </div>

<!-- 3. Bookings  -->
    <div id="section-bookings" class="main-content" style="display: none;">
        <div class="admin-section">
            <h2>Recent Bookings</h2>
            <p>View and manage all customer travel bookings.</p>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Customer</th>
                        <th>Destination</th>
                        <th>Booking Date</th>
                        <th>members</th>
                        <th>Status</th>
                    </tr>
                </thead>
               <tbody>
    <?php if ($bookings && $bookings->num_rows > 0): ?>
        <?php while($row = $bookings->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo isset($row['customer_name']) ? htmlspecialchars($row['customer_name']) : (isset($row['name']) ? htmlspecialchars($row['name']) : 'N/A'); ?></td>
                <td><?php echo htmlspecialchars($row['package_name']); ?></td>
                <td><?php echo $row['booking_date']; ?></td>
                <td><?php echo $row['members']; ?></td>
                <td>
                    <select class="status-select" onchange="updateBookingStatus(this)">
                        <option value="pending" <?php if($row['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                        <option value="confirmed" <?php if($row['status'] == 'confirmed') echo 'selected'; ?>>Confirmed</option>
                        <option value="cancelled" <?php if($row['status'] == 'cancelled') echo 'selected'; ?>>Cancelled</option>
                        <option value="completed" <?php if($row['status'] == 'completed') echo 'selected'; ?>>Completed</option>
                    </select>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="6" style="text-align:center;">No bookings found.</td></tr>
    <?php endif; ?>
</tbody>
        </table>
    </div>
</div>

    <!-- 4. Settings  -->
    <div id="section-settings" class="main-content" style="display: none;">
        <div class="admin-section">
            <h2>Account Settings</h2>
            <p>Manage your staff profile and system preferences.</p>
            <div class="settings-grid">
                <div class="form-group">
                    <label>Staff Name</label>
                    <input type="text" value="Staff Member 01">
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" value="staff@globetrek.com">
                </div>
                <div class="form-group">
                    <label>Change Password</label>
                    <input type="password" placeholder="New Password">
                </div>
            </div>
            <button class="btn-action" style="margin-top: 20px;">Save Changes</button>
        </div>
    </div>

</div>
<script>
        let packages = JSON.parse(localStorage.getItem('gt_packages')) || [
            { name: 'Ella', price: 36000, members: 6, duration: '2 Days / 1 Night', discount: 5, activities: 'Hiking, Nine Arch, Ella Rock', video: 'ella.mp4' },
            { name: 'Mirissa', price: 42000, members: 4, duration: '1 Day', discount: 0, activities: 'Whale Watching, Beach', video: 'mirissa.mp4' }
        ];

        const form = document.getElementById('packageForm');
        const tableBody = document.querySelector('#pkgTable tbody');

        function updateStats() {
            document.getElementById('stat-pkg').innerText = packages.length;
            let totalMembers = packages.reduce((sum, pkg) => sum + parseInt(pkg.members), 0);
            document.getElementById('stat-mem').innerText = totalMembers;
            let discounts = packages.filter(pkg => pkg.discount > 0).length;
            document.getElementById('stat-disc').innerText = discounts;
        }

        function renderTable() {
            tableBody.innerHTML = '';
            packages.forEach((pkg, index) => {
                const row = `<tr>
                    <td><strong>${pkg.name}</strong></td>
                    <td>${Number(pkg.price).toLocaleString()}</td>
                    <td>${pkg.members}</td>
                    <td>${pkg.duration}</td>
                    <td><span style="color: ${pkg.discount > 0 ? '#166534' : '#64748b'}; font-weight: bold;">${pkg.discount}%</span></td>
                    <td class="action-btns">
                        <button class="edit-btn" onclick="editPackage(${index})">Edit</button>
                        <button class="del-btn" onclick="deletePackage(${index})">Delete</button>
                    </td>
                </tr>`;
                tableBody.innerHTML += row;
            });
            updateStats();
            localStorage.setItem('gt_packages', JSON.stringify(packages));
        }

   
      function editPackage(id, name, price, members, duration, discount, video, activities) {

    document.getElementById('form-title').innerText = "Edit Package: " + name;
    document.getElementById('submitBtn').innerText = "SAVE CHANGES";
    document.getElementById('editIndex').value = id;
    document.getElementById('pName').value = name;
    document.getElementById('pPrice').value = price;
    document.getElementById('pMembers').value = members;
    document.getElementById('pDuration').value = duration;
    document.getElementById('pDiscount').value = discount;
    document.getElementById('pVideo').value = video;
    document.getElementById('pActivities').value = activities;
    
   window.scrollTo({ top: 0, behavior: 'smooth' });
}
        function deletePackage(index) {
            if(confirm("Are you sure?")) {
                packages.splice(index, 1);
                renderTable();
            }
        }
 function resetForm() {
            form.reset();
            document.getElementById('editIndex').value = "-1";
            document.getElementById('form-title').innerText = "Add New Package";
            document.getElementById('submitBtn').innerText = "PUBLISH PACKAGE";
        }

    function filterTable() {
            let input = document.getElementById("searchPkg").value.toLowerCase();
            let tr = tableBody.getElementsByTagName("tr");
            for (let i = 0; i < tr.length; i++) {
                let td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    let txtValue = td.textContent || td.innerText;
                    tr[i].style.display = txtValue.toLowerCase().indexOf(input) > -1 ? "" : "none";
                }
            }
        }

        renderTable();
function switchTab(id) {
            document.getElementById('section-packages').style.display = 'none';
            document.getElementById('section-customers').style.display = 'none';
            document.getElementById(id).style.display = 'block';
            document.getElementById('link-packages').classList.remove('active');
            document.getElementById('link-customers').classList.remove('active');

            if(id === 'section-packages') {
                document.getElementById('link-packages').classList.add('active');
            } else {
                document.getElementById('link-customers').classList.add('active');
            }
        }
function switchTab(tabId) {
    const sections = ['section-packages', 'section-customers', 'section-bookings', 'section-settings'];
    sections.forEach(id => {
        const element = document.getElementById(id);
        if (element) element.style.display = 'none';
    });
 const activeSection = document.getElementById(tabId);
    if (activeSection) {
        activeSection.style.display = 'block';
    }
    const navLinks = document.querySelectorAll('.sidebar nav a');
    navLinks.forEach(link => link.classList.remove('active'));
   const linkId = tabId.replace('section', 'link'); 
    const activeLink = document.getElementById(linkId);
    if (activeLink) activeLink.classList.add('active');
}
</script>
</body>
</html>