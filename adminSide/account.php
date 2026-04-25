<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include '../db_connect.php';
$admin_id = $_SESSION['admin_id'];
$query = "SELECT * FROM tbl_admin WHERE admin_id = '$admin_id'";
$result = mysqli_query($conn, $query);
$admin = mysqli_fetch_assoc($result);
$full_name = $admin['full_name'] ?? 'Admin User';
$name_parts = explode(' ', $full_name, 2);
$first_name = $name_parts[0];
$last_name = $name_parts[1] ?? '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/logo1.png" type="image/png">
    <title>Accounts | Paws for Keeps</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Nunito:wght@400;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="account.css">
</head>

<body>
    <div class="container">
        <div class="main">
            <nav class="sidebar">
                <div class="logo-container">
                    <img src="images/logo.png" alt="Paws for Keeps Logo"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                    <h2 class="logo-fallback" style="display:none;">PAWS FOR KEEPS</h2>
                </div>

                <div class="divider"></div>

                <ul class="menu">
                    <li><a href="overview.php"><i class="fa-solid fa-table-cells-large"></i> Overview</a></li>
                    <li class="has-submenu">
                        <a href="Inventory.php"><i class="fa-solid fa-box-archive"></i> Inventory</a>
                        <ul class="submenu">
                            <li><a href="expiry.php"><i class="fa-solid fa-calendar"></i> Product Expiration</a></li>
                            <li><a href="archive.php"><i class="fa-solid fa-trash-arrow-up"></i> Archive History</a></li>
                        </ul>
                    </li>
                    <li><a href="sales.php"><i class="fa-solid fa-chart-simple"></i> Sales</a></li>
                    <li class="active"><a href="account.php"><i class="fa-solid fa-user"></i> Account</a></li>
                </ul>

                <div class="spacer"></div>
                <div class="divider"></div>

                <div class="logout-section">
                    <a href="login.php" class="logout-btn"><i class="fas fa-arrow-right-from-bracket"></i> Log Out</a>
                </div>
            </nav>

            <div class="content-wrapper">
                <div class="overview-card">
                    <div class="header-left">
                        <div class="overview-icon-box" style="background: #F9A825;"><i class="fa-solid fa-user"
                        style="color: white;"></i></div>
                        <div class="overview-text">
                            <h1>Account</h1>
                            <p>Manage Your Account Settings</p>
                        </div>
                    </div>
                    <div class="clock">
                        <div class="clock-time"><span id="time"></span><span id="ampm" class="clock-ampm"></span></div>
                        <div id="date" class="clock-date"></div>
                    </div>
                </div>

                <div class="section-header">
                    <h2 class="section-title">Personal Information</h2>
                    <span class="section-subtitle">Update your account profile and email address</span>
                </div>
                <div class="settings-card">
                    <form id="personal-form">
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-input" value="<?php echo $first_name; ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-input" value="<?php echo $last_name; ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-input" value="<?php echo $admin['username']; ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Email Address</label>
                                <input type="email" class="form-input" value="<?php echo $admin['email'] ?? 'admin@pawsforkeeps.com'; ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Phone Number</label>
                                <input type="text" class="form-input" value="+63 912 345 6789">
                            </div>
                        </div>
                        <div class="action-row">
                            <button type="button" class="btn-cancel" onclick="location.reload()">Cancel</button>
                            <button type="button" class="btn-save" onclick="alert('Profile Information Saved!')">Save Changes</button>
                        </div>
                    </form>
                </div>

                <div class="section-header">
                    <h2 class="section-title">Security</h2>
                    <span class="section-subtitle">Manage your password and account security</span>
                </div>
                <div class="settings-card">
                    <h3 style="margin-top:0; color:#3e2723;">Change Password</h3>
                    <form id="password-form" style="display:flex; flex-direction:column; gap:20px;">
                        <div class="form-group">
                            <label class="form-label">Current Password</label>
                            <input type="password" class="form-input" placeholder="Enter current password">
                        </div>
                        <div class="form-group">
                            <label class="form-label">New Password</label>
                            <input type="password" class="form-input" placeholder="Enter new password">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" class="form-input" placeholder="Confirm new password">
                        </div>
                        <div class="action-row">
                            <button type="button" class="btn-cancel"
                                onclick="document.getElementById('password-form').reset()">Cancel</button>
                            <button type="button" class="btn-save"
                                onclick="alert('Password Changed Successfully!')">Save Changes</button>
                        </div>
                    </form>
                </div>

                <div class="section-header">
                    <h2 class="section-title">Active Sessions</h2>
                </div>
                <div class="settings-card">
                    <div class="session-list">
                        <div class="session-item" style="border: 1px solid #E1F5FE;">
                            <div class="session-left">
                                <div class="session-icon"><i class="fa-solid fa-desktop"></i></div>
                                <div class="session-info">
                                    <span class="session-title">Windows - Chrome</span>
                                    <span class="session-meta">Current session • Last active now</span>
                                </div>
                            </div>
                            <div class="session-right"><span class="badge-current">Current</span></div>
                        </div>
                    </div>
                </div>

                <div class="section-header">
                    <h2 class="section-title danger">Danger Zone</h2>
                </div>
                <div class="settings-card danger-card">
                    <div class="danger-content-wrapper">
                        <div class="danger-text-group">
                            <h3>Delete Account</h3>
                            <p>Once you delete your account, there is no going back. All your data will be removed.</p>
                        </div>
                        <button class="btn-delete" onclick="openDeleteModal()">
                            <i class="fas fa-trash-alt"></i> Delete Account
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="deleteModal">
        <div class="modal-box">
            <div class="modal-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h2 class="modal-title">Are you sure?</h2>
            <p class="modal-desc">
                Do you really want to delete your account? <br>
                This process cannot be undone and all data will be lost.
            </p>
            <div class="modal-actions">
                <button class="btn-cancel" onclick="closeDeleteModal()">Cancel</button>
                <button class="btn-delete" onclick="window.location.href='login.php'">Confirm & Delete</button>
            </div>
        </div>
    </div>

    <script>
        function updateClock() {
            const now = new Date();
            let hours = now.getHours();
            let minutes = now.getMinutes().toString().padStart(2, "0");
            let ampm = hours >= 12 ? "PM" : "AM";
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            hours = hours % 12 || 12;
            document.getElementById("time").textContent = `${hours}:${minutes}`;
            document.getElementById("ampm").textContent = ampm;
            document.getElementById("date").textContent = now.toLocaleDateString('en-US', options);
        }
        setInterval(updateClock, 1000);
        updateClock();

        const modal = document.getElementById('deleteModal');
        function openDeleteModal() { modal.style.display = 'flex'; }
        function closeDeleteModal() { modal.style.display = 'none'; }
        window.onclick = function (event) { if (event.target == modal) { modal.style.display = "none"; } }
    </script>
</body>
</html>