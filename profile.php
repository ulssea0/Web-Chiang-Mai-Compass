<?php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

$sql = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>โปรไฟล์</title>
    <link rel="stylesheet" href="home.css">
    <style>
        .profile-container { max-width: 800px; margin: 0 auto; padding: 40px 20px; }
        .profile-card {
            background: white;
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .profile-header { text-align: center; margin-bottom: 40px; }
        .profile-avatar {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        .profile-avatar svg { width: 60px; height: 60px; fill: white; }
        .profile-name { font-size: 28px; font-weight: 600; color: #333; margin-bottom: 10px; }
        .profile-info { display: grid; gap: 20px; margin-top: 30px; }
        .info-row { display: flex; padding: 15px; background: #f9f9f9; border-radius: 8px; }
        .info-label { font-weight: 600; color: #666; min-width: 150px; }
        .info-value { color: #333; }
        .profile-actions { display: flex; gap: 15px; margin-top: 30px; }
        .btn {
            flex: 1;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4); }
        .btn-secondary { background: white; color: #667eea; border: 2px solid #667eea; }
        .btn-secondary:hover { background: #f0f0f0; }
    </style>
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="header-left">
                <span class="logo">LOGO</span>
            </div>
            <div class="header-center">
                <select class="dropdown">
                    <option>Title</option>
                </select>
                <input type="text" class="search-input" placeholder="Value">
                <button class="close-btn">×</button>
            </div>
            <div class="header-right">
                <button class="search-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.35-4.35"></path>
                    </svg>
                </button>
                <button class="profile-btn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                    <?php echo htmlspecialchars($username); ?>
                </button>
            </div>
        </header>

        <div class="profile-container">
            <div class="profile-card">
                <div class="profile-header">
                    <div class="profile-avatar">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    </div>
                    <div class="profile-name"><?php echo htmlspecialchars($user['username']); ?></div>
                </div>
                
                <div class="profile-info">
                    <div class="info-row">
                        <div class="info-label">ชื่อผู้ใช้:</div>
                        <div class="info-value"><?php echo htmlspecialchars($user['username']); ?></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">วันที่สมัคร:</div>
                        <div class="info-value"><?php echo date('d/m/Y H:i', strtotime($user['created_at'])); ?></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">สถานะ:</div>
                        <div class="info-value">ใช้งานอยู่</div>
                    </div>
                </div>
                
                <div class="profile-actions">
                    <button class="btn btn-secondary" onclick="window.location.href='home.php'">กลับหน้าหลัก</button>
                    <button class="btn btn-primary" onclick="window.location.href='logout.php'">ออกจากระบบ</button>
                </div>
            </div>
        </div>

        <footer class="footer">
            <button class="footer-btn" onclick="window.location.href='logout.php'">ออกจากระบบ</button>
        </footer>
    </div>
</body>
</html>