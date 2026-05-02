<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM tbl_users WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile | Paws for Keeps</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        html { overflow-y: scroll; }
        /* 🛠️ Standardized gap to 100px para pantay ang navbar sa lahat ng pages */
        body { font-family: 'Poppins', sans-serif; background-color: #f4f4f4; margin: 0; padding-top: 100px; }

        .profile-container { max-width: 900px; margin: 0 auto 60px; padding: 0 20px; }
        .profile-card { 
            background: #fff; 
            border-radius: 15px; 
            box-shadow: 0 1px 4px rgba(0,0,0,0.08); 
            padding: 30px; 
            margin-bottom: 20px;
        }

        .section-title { 
            font-size: 18px; 
            font-weight: 700; 
            color: #4D2412; 
            border-left: 5px solid #FFBE3E; 
            padding-left: 15px; 
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-group { display: flex; flex-direction: column; gap: 8px; }
        label { font-size: 13px; font-weight: 600; color: #888; }
        
        .view-text { font-size: 15px; color: #333; font-weight: 500; padding: 10px 0; border-bottom: 1px solid #eee; min-height: 24px; }
        .edit-input { 
            display: none; 
            padding: 10px; 
            border: 1px solid #ddd; 
            border-radius: 8px; 
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            width: 100%;
            box-sizing: border-box;
        }

        /* Edit/Done Toggle Button */
        .btn-edit { 
            background-color: #4D2412; 
            color: #fff; 
            padding: 8px 20px; 
            border-radius: 50px; 
            cursor: pointer; 
            font-size: 12px; 
            font-weight: 600;
            border: none;
            transition: background 0.3s;
        }
        .btn-edit.done { background-color: #2e7d32; }

        /* General Action Buttons */
        .btn-outline { background: none; border: 1px solid #4D2412; color: #4D2412; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-size: 14px; font-weight: 600; transition: 0.3s; width: 100%; text-align: center; }
        .btn-outline:hover { background: #4D2412; color: #fff; }

        .btn-danger { color: #D32F2F; border: 1px solid #D32F2F; background: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 600; transition: 0.3s; width: 100%; text-align: center; }
        .btn-danger:hover { background: #D32F2F; color: #fff; }

        .verified-badge { background: #e8f5e9; color: #2e7d32; font-size: 10px; padding: 2px 8px; border-radius: 20px; margin-left: 10px; }
        
        /* ── Settings List Style ── */
        .settings-list { display: flex; flex-direction: column; }
        .settings-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 0;
            border-bottom: 1px solid #f5f5f5;
            cursor: pointer;
            transition: 0.2s;
        }
        .settings-item:last-child { border-bottom: none; }
        .settings-item:hover { transform: translateX(5px); }
        .item-left { display: flex; align-items: center; gap: 15px; }
        .icon-box {
            width: 40px;
            height: 40px;
            background: #FFF8ED;
            color: #FFBE3E;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 18px;
        }
        .item-info { display: flex; flex-direction: column; }
        .item-label { font-size: 15px; font-weight: 600; color: #4D2412; }
        .item-subtext { font-size: 12px; color: #888; }
        .chevron { font-size: 24px; color: #ccc; font-weight: 300; }
        .settings-item.danger:hover .item-label { font-weight: 700; }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="profile-container">
        <form id="profileForm">
            <div class="profile-card">
                <div class="section-title">
                    PERSONAL INFORMATION
                    <button type="button" id="toggleBtn" class="btn-edit" onclick="handleToggle()">Edit Profile</button>
                </div>
                <div class="info-grid">
                    <div class="form-group">
                        <label>First Name</label>
                        <div class="view-text"><?php echo $user['first_name']; ?></div>
                        <input type="text" name="first_name" class="edit-input" value="<?php echo $user['first_name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <div class="view-text"><?php echo $user['last_name']; ?></div>
                        <input type="text" name="last_name" class="edit-input" value="<?php echo $user['last_name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Email Address <span class="verified-badge">Verified</span></label>
                        <div class="view-text"><?php echo $user['email']; ?></div>
                        <input type="email" name="email" class="edit-input" value="<?php echo $user['email']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <div class="view-text"><?php echo $user['phone'] ?: 'Not set'; ?></div>
                        <input type="text" name="phone" class="edit-input" value="<?php echo $user['phone']; ?>" placeholder="09xxxxxxxxx">
                    </div>
                </div>
            </div>

            <div class="profile-card">
                <div class="section-title">SHIPPING ADDRESS</div>
                <div class="info-grid">
                    <div class="form-group" style="grid-column: span 2;">
                        <label>Street Address</label>
                        <div class="view-text"><?php echo $user['street_address'] ?: 'Not set'; ?></div>
                        <input type="text" name="street_address" class="edit-input" value="<?php echo $user['street_address']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Barangay</label>
                        <div class="view-text"><?php echo $user['barangay'] ?: 'Not set'; ?></div>
                        <input type="text" name="barangay" class="edit-input" value="<?php echo $user['barangay']; ?>">
                    </div>
                    <div class="form-group">
                        <label>City</label>
                        <div class="view-text"><?php echo $user['city'] ?: 'Not set'; ?></div>
                        <input type="text" name="city" class="edit-input" value="<?php echo $user['city']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Province</label>
                        <div class="view-text"><?php echo $user['province'] ?: 'Not set'; ?></div>
                        <input type="text" name="province" class="edit-input" value="<?php echo $user['province']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Postal Code</label>
                        <div class="view-text"><?php echo $user['postal_code'] ?: 'Not set'; ?></div>
                        <input type="text" name="postal_code" class="edit-input" value="<?php echo $user['postal_code']; ?>">
                    </div>
                </div>
            </div>
        </form>

        <div class="profile-card">
            <div class="section-title">ACCOUNT SETTINGS & SECURITY</div>
            <div class="settings-list">
                <div class="settings-item" onclick="window.location.href='login.php'">
                    <div class="item-left">
                        <div class="icon-box"><i class="fa-solid fa-user-plus"></i></div>
                        <div class="item-info">
                            <span class="item-label">Add Another Account</span>
                            <span class="item-subtext">Switch between multiple pet profiles</span>
                        </div>
                    </div>
                    <span class="chevron">›</span>
                </div>

                <div class="settings-item" onclick="changePassword()">
                    <div class="item-left">
                        <div class="icon-box"><i class="fa-solid fa-lock"></i></div>
                        <div class="item-info">
                            <span class="item-label">Update Password</span>
                            <span class="item-subtext">Keep your account safe and secure</span>
                        </div>
                    </div>
                    <span class="chevron">›</span>
                </div>

                <div class="settings-item" onclick="window.location.href='logout.php'">
                    <div class="item-left">
                        <div class="icon-box" style="background: #f5f5f5; color: #4D2412;"><i class="fa-solid fa-right-from-bracket"></i></div>
                        <div class="item-info">
                            <span class="item-label">Logout</span>
                            <span class="item-subtext">Sign out from this session</span>
                        </div>
                    </div>
                    <span class="chevron">›</span>
                </div>

                <div class="settings-item danger" onclick="deleteAccount()">
                    <div class="item-left">
                        <div class="icon-box" style="background: #ffebee; color: #D32F2F;"><i class="fa-solid fa-trash-can"></i></div>
                        <div class="item-info">
                            <span class="item-label" style="color: #D32F2F;">Delete Account</span>
                            <span class="item-subtext">Permanently remove your data</span>
                        </div>
                    </div>
                    <span class="chevron" style="color: #D32F2F;">›</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        let isEditing = false;

        function handleToggle() {
            const btn = document.getElementById('toggleBtn');
            const viewTexts = document.querySelectorAll('.view-text');
            const editInputs = document.querySelectorAll('.edit-input');

            if (!isEditing) {
                viewTexts.forEach(el => el.style.display = 'none');
                editInputs.forEach(el => el.style.display = 'block');
                btn.innerText = 'Done';
                btn.classList.add('done');
                isEditing = true;
            } else {
                saveProfile();
            }
        }

        function saveProfile() {
            const form = document.getElementById('profileForm');
            const formData = new FormData(form);

            fetch('update_profile_logic.php', {
                method: 'POST',
                body: formData
            })
            .then(r => r.json())
            .then(data => {
                if(data.status === 'success') {
                    Swal.fire({ title: 'Updated! 🐾', text: 'Profile changes saved.', icon: 'success', timer: 1500, showConfirmButton: false })
                    .then(() => location.reload());
                }
            });
        }

        function deleteAccount() {
            Swal.fire({
                title: 'Delete Account? 😿',
                text: "This action is permanent.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#D32F2F',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) { window.location.href = 'delete_account_logic.php'; }
            });
        }

        function changePassword() {
            Swal.fire({
                title: 'Update Password 🐾',
                html: `
                    <div style="text-align: left; padding: 10px;">
                        <div class="swal-form-group" style="margin-bottom: 15px;">
                            <label style="font-size: 13px; font-weight: 600; color: #888; display: block; margin-bottom: 5px;">Current Password</label>
                            <input type="password" id="current_pw" class="swal2-input" style="width: 100%; margin: 0; border-radius: 10px;" placeholder="Enter current password">
                        </div>
                        <div class="swal-form-group" style="margin-bottom: 15px;">
                            <label style="font-size: 13px; font-weight: 600; color: #888; display: block; margin-bottom: 5px;">New Password</label>
                            <input type="password" id="new_pw" class="swal2-input" style="width: 100%; margin: 0; border-radius: 10px;" placeholder="Enter new password">
                        </div>
                        <div class="swal-form-group">
                            <label style="font-size: 13px; font-weight: 600; color: #888; display: block; margin-bottom: 5px;">Confirm New Password</label>
                            <input type="password" id="confirm_pw" class="swal2-input" style="width: 100%; margin: 0; border-radius: 10px;" placeholder="Confirm new password">
                        </div>
                    </div>
                `,
                icon: 'security',
                showCancelButton: true,
                confirmButtonText: 'Update Password',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#4D2412',
                cancelButtonColor: '#aaa',
                reverseButtons: true,
                preConfirm: () => {
                    const current = document.getElementById('current_pw').value;
                    const newPw = document.getElementById('new_pw').value;
                    const confirm = document.getElementById('confirm_pw').value;

                    if (!current || !newPw || !confirm) {
                        Swal.showValidationMessage('Please fill in all fields');
                        return false;
                    }
                    if (newPw !== confirm) {
                        Swal.showValidationMessage('New passwords do not match');
                        return false;
                    }
                    if (newPw.length < 6) {
                        Swal.showValidationMessage('Password must be at least 6 characters');
                        return false;
                    }
                    return { current: current, newPw: newPw };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData();
                    formData.append('current_pw', result.value.current);
                    formData.append('new_pw', result.value.newPw);

                    fetch('update_password_logic.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(r => r.json())
                    .then(data => {
                        if(data.status === 'success') {
                            Swal.fire({ title: 'Success!', text: 'Password updated safely.', icon: 'success', confirmButtonColor: '#4D2412' });
                        } else {
                            Swal.fire({ title: 'Error', text: data.message, icon: 'error', confirmButtonColor: '#4D2412' });
                        }
                    })
                    .catch(err => {
                        Swal.fire('Error', 'Could not connect to the server.', 'error');
                    });
                }
            });
        }
    </script>
</body>
</html>