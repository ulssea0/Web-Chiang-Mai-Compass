<?php
require_once 'config.php';

if (isset($_SESSION['user_id'])) {
    header("Location: home.php");
    exit();
}

$error = '';
$success = isset($_GET['registered']) ? 'สมัครสมาชิกสำเร็จ! กรุณาเข้าสู่ระบบ' : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = clean_input($_POST['username']);
    $password = $_POST['password'];
    
    if (empty($username) || empty($password)) {
        $error = 'กรุณากรอกข้อมูลให้ครบถ้วน';
    } else {
        $sql = "SELECT id, username, email, password FROM users WHERE username = ? OR email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                
                // อัพเดทเวลาล็อกอินล่าสุด
                $update_sql = "UPDATE users SET last_login = NOW() WHERE id = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("i", $user['id']);
                $update_stmt->execute();
                
                header("Location: home.html");
                exit();
            } else {
                $error = 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง';
            }
        } else {
            $error = 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง';
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ - ChiangMai Compass</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-xl">CM</span>
                    </div>
                    <span class="text-xl font-bold text-gray-800">ChiangMai Compass</span>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="p-2 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-search text-gray-600"></i>
                    </button>
                    <button class="p-2 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-user text-gray-600"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Login Form -->
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">เข้าสู่ระบบ</h2>
                
                <?php if ($error): ?>
                <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                    <p class="text-red-700 text-sm"><?php echo $error; ?></p>
                </div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded">
                    <p class="text-green-700 text-sm"><?php echo $success; ?></p>
                </div>
                <?php endif; ?>

                <form method="POST" action="" class="space-y-6">
                    <div>
                        <input type="text" name="username" placeholder="ชื่อผู้ใช้ หรือ อีเมล" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                               required>
                    </div>
                    
                    <div>
                        <input type="password" name="password" placeholder="รหัสผ่าน"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                               required>
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <a href="#" class="text-blue-600 hover:text-blue-700">ลืมรหัสผ่าน?</a>
                        <a href="signup.php" class="text-blue-600 hover:text-blue-700">สมัครสมาชิก</a>
                    </div>

                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white py-3 rounded-lg font-semibold hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                        ล็อกอิน
                    </button>

                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-white text-gray-500">หรือเข้าสู่ระบบด้วย</span>
                        </div>
                    </div>

                    <button type="button" 
                            class="w-full flex items-center justify-center space-x-2 bg-white border border-gray-300 text-gray-700 py-3 rounded-lg font-medium hover:bg-gray-50 transition">
                        <i class="fab fa-google text-red-500"></i>
                        <span>เข้าสู่ระบบด้วย Google</span>
                    </button>

                    <button type="button" 
                            class="w-full flex items-center justify-center space-x-2 bg-blue-600 text-white py-3 rounded-lg font-medium hover:bg-blue-700 transition">
                        <i class="fab fa-facebook-f"></i>
                        <span>เข้าสู่ระบบด้วย Facebook</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-black text-white py-8">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-gray-400">© 2024 ChiangMai Compass. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>