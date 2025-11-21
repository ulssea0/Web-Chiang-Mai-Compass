<?php
// dashboard.php - หน้าหลักหลังจากล็อกอิน พร้อมแสดงข้อมูลผู้ใช้
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'];

// ดึงข้อมูลผู้ใช้ทั้งหมดจากฐานข้อมูล
$sql = "SELECT id, username, email, created_at FROM users ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
        }
        
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .navbar h1 {
            font-size: 24px;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .logout-btn {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 8px 20px;
            border: 2px solid white;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .logout-btn:hover {
            background: white;
            color: #667eea;
        }
        
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .welcome-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .welcome-card h2 {
            color: #333;
            margin-bottom: 10px;
        }
        
        .welcome-card p {
            color: #666;
            font-size: 16px;
        }
        
        .users-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .users-card h3 {
            color: #333;
            margin-bottom: 20px;
            font-size: 22px;
        }
        
        .table-container {
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }
        
        td {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        tbody tr:hover {
            background: #f8f9fa;
        }
        
        .badge {
            background: #667eea;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #999;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .stat-number {
            font-size: 36px;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>ระบบจัดการ</h1>
        <div class="user-info">
            <span>สวัสดี, <?php echo htmlspecialchars($username); ?></span>
            <a href="logout.php" class="logout-btn">ออกจากระบบ</a>
        </div>
    </div>
    
    <div class="container">
        <div class="welcome-card">
            <h2>ยินดีต้อนรับสู่ Dashboard</h2>
            <p>คุณเข้าสู่ระบบสำเร็จแล้ว! ด้านล่างคือข้อมูลผู้ใช้ทั้งหมดในระบบ</p>
        </div>
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?php echo $result->num_rows; ?></div>
                <div class="stat-label">ผู้ใช้ทั้งหมด</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">1</div>
                <div class="stat-label">ผู้ใช้ออนไลน์</div>
            </div>
        </div>
        
        <div class="users-card">
            <h3>📋 รายชื่อผู้ใช้ทั้งหมด</h3>
            
            <?php if ($result->num_rows > 0): ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>ชื่อผู้ใช้</th>
                                <th>อีเมล</th>
                                <th>วันที่สมัคร</th>
                                <th>สถานะ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($row['username']); ?></strong>
                                        <?php if ($row['username'] == $username): ?>
                                            <span class="badge">คุณ</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($row['created_at'])); ?></td>
                                    <td>
                                        <span style="color: #22c55e;">● ใช้งานอยู่</span>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="no-data">
                    <p>ไม่มีข้อมูลผู้ใช้ในระบบ</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>