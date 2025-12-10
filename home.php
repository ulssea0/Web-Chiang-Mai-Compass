<?php
require_once 'config.php';

// ตรวจสอบการล็อกอิน
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - ChiangMai Compass</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero-slider {
            height: 600px;
            background-size: cover;
            background-position: center;
            position: relative;
        }
        .hero-overlay {
            background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.5));
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="text-2xl font-bold">LOGO</div>
                </div>

                <!-- Search Bar -->
                <div class="hidden md:flex items-center space-x-2 flex-1 max-w-md mx-8">
                    <select class="border border-gray-300 rounded-l-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option>Title</option>
                        <option>ร้านอาหาร</option>
                        <option>สถานที่</option>
                        <option>ที่พัก</option>
                    </select>
                    <input type="text" placeholder="Value" class="flex-1 border-t border-b border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button class="bg-gray-100 border border-gray-300 px-3 py-2 hover:bg-gray-200">
                        <i class="fas fa-times text-gray-500"></i>
                    </button>
                    <button class="bg-white border border-l-0 border-gray-300 rounded-r-lg px-4 py-2 hover:bg-gray-50">
                        <i class="fas fa-search text-gray-600"></i>
                    </button>
                </div>

                <!-- User Menu -->
                <div class="flex items-center space-x-4">
                    <button class="p-2 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-user text-gray-600"></i>
                        <span class="ml-2 font-medium text-gray-700"><?php echo htmlspecialchars($username); ?></span>
                    </button>
                    <a href="logout.php" class="text-red-600 hover:text-red-700 font-medium">
                        <i class="fas fa-sign-out-alt mr-1"></i>ออกจากระบบ
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section / Slider -->
    <div class="relative hero-slider" style="background-image: url('https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=1200');">
        <div class="absolute inset-0 hero-overlay flex items-center justify-center">
            <div class="text-center text-white px-4">
                <!-- Badge ปากหมุด -->
                <div class="inline-block bg-yellow-400 text-gray-800 px-6 py-2 rounded-full text-lg font-semibold mb-4">
                    ปากหมุด
                </div>
                
                <!-- หัวข้อหลัก -->
                <h1 class="text-5xl md:text-7xl font-bold mb-4">8 ร้านอาหาร</h1>
                <p class="text-2xl md:text-4xl font-semibold mb-2">บรรยากาศดี เชียงใหม่</p>
                <p class="text-3xl md:text-5xl font-script italic opacity-90">Chiangmai</p>
            </div>
        </div>

        <!-- Dots Navigation -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex space-x-3">
            <button class="w-3 h-3 rounded-full bg-white"></button>
            <button class="w-3 h-3 rounded-full bg-white opacity-50"></button>
            <button class="w-3 h-3 rounded-full bg-white opacity-50"></button>
            <button class="w-3 h-3 rounded-full bg-white opacity-50"></button>
            <button class="w-3 h-3 rounded-full bg-white opacity-50"></button>
        </div>
    </div>

    <!-- Content Section -->
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Card 1 -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition">
                <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=400" alt="Restaurant" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">ร้านอาหารบรรยากาศดี</h3>
                    <p class="text-gray-600 mb-4">ร้านอาหารบรรยากาศดีในเชียงใหม่ เหมาะสำหรับทุกโอกาส</p>
                    <a href="#" class="text-blue-600 hover:text-blue-700 font-medium">อ่านเพิ่มเติม →</a>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition">
                <img src="https://images.unsplash.com/photo-1559339352-11d035aa65de?w=400" alt="Cafe" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">คาเฟ่เชียงใหม่</h3>
                    <p class="text-gray-600 mb-4">คาเฟ่สุดชิลล์ ถ่ายรูปสวย บรรยากาศดี</p>
                    <a href="#" class="text-blue-600 hover:text-blue-700 font-medium">อ่านเพิ่มเติม →</a>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition">
                <img src="https://images.unsplash.com/photo-1528543606781-2f6e6857f318?w=400" alt="Travel" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">สถานที่ท่องเที่ยว</h3>
                    <p class="text-gray-600 mb-4">สถานที่ท่องเที่ยวสุดฮิตในเชียงใหม่</p>
                    <a href="#" class="text-blue-600 hover:text-blue-700 font-medium">อ่านเพิ่มเติม →</a>
                </div>
            </div>
        </div>

        <!-- Categories Section -->
        <div class="mt-16">
            <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">หมวดหมู่ยอดนิยม</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition text-center cursor-pointer">
                    <div class="text-4xl mb-2">🍜</div>
                    <p class="font-semibold text-gray-700">ร้านอาหาร</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition text-center cursor-pointer">
                    <div class="text-4xl mb-2">☕</div>
                    <p class="font-semibold text-gray-700">คาเฟ่</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition text-center cursor-pointer">
                    <div class="text-4xl mb-2">🏨</div>
                    <p class="font-semibold text-gray-700">ที่พัก</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition text-center cursor-pointer">
                    <div class="text-4xl mb-2">📍</div>
                    <p class="font-semibold text-gray-700">สถานที่</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition text-center cursor-pointer">
                    <div class="text-4xl mb-2">🎭</div>
                    <p class="font-semibold text-gray-700">กิจกรรม</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition text-center cursor-pointer">
                    <div class="text-4xl mb-2">🛍️</div>
                    <p class="font-semibold text-gray-700">ช้อปปิ้ง</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 mt-16">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">ChiangMai Compass</h3>
                    <p class="text-gray-400">คู่มือท่องเที่ยวและไลฟ์สไตล์เชียงใหม่</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">เมนูหลัก</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white">ร้านอาหาร</a></li>
                        <li><a href="#" class="hover:text-white">คาเฟ่</a></li>
                        <li><a href="#" class="hover:text-white">ที่พัก</a></li>
                        <li><a href="#" class="hover:text-white">สถานที่ท่องเที่ยว</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">เกี่ยวกับเรา</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white">เกี่ยวกับ</a></li>
                        <li><a href="#" class="hover:text-white">ติดต่อเรา</a></li>
                        <li><a href="#" class="hover:text-white">เงื่อนไขการใช้งาน</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">ติดตามเรา</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white text-2xl"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white text-2xl"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white text-2xl"><i class="fab fa-line"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>© 2024 ChiangMai Compass. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>