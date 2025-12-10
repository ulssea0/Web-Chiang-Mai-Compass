<?php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = isset($_GET['id']) ? $_GET['id'] : '';

$details = [
    'food-1' => [
        'title' => 'Riverfront Restaurant Chiang Mai',
        'address' => '367 ถนน เจริญราษฎร์ ตำบลวัดเกต เมือง เชียงใหม่ 50000',
        'phone' => '092 641 6983',
        'hours' => 'เปิดเวลา 17:00',
        'image' => '355101441_10161504729094237_5318895870746153819_n.jpg',
        'description' => 'ร้านอาหารริมแม่น้ำปิง บรรยากาศดี วิวสวย อาหารอร่อย'
    ],
    'food-2' => [
        'title' => 'เขยเชียงใหม่',
        'address' => '14 ซอย สันติธรรม ตำบลช้างเผือก อำเภอเมืองเชียงใหม่ เชียงใหม่ 50300',
        'phone' => '093 138 5553',
        'hours' => 'เปิดอยู่ ⋅ ปิดเวลา 22:00',
        'image' => 'images.jpg',
        'description' => 'ร้านอาหารไทยต้นตำรับ รสชาติดี บริการเป็นกันเอง'
    ],
    'travel-1' => [
        'title' => 'อ่างแก้ว มช.',
        'address' => 'RX42+JPM ซอย สุโขทัย 5 ตำบลสุเทพ อำเภอเมืองเชียงใหม่ เชียงใหม่ 50200',
        'phone' => '-',
        'hours' => 'เปิดอยู่ ⋅ ปิดเวลา 22:00',
        'image' => '483361588_1203476391343987_1958632709949115213_n.jpg',
        'description' => 'สถานที่ท่องเที่ยวในมหาวิทยาลัยเชียงใหม่ ธรรมชาติสวยงาม'
    ],
    'travel-2' => [
        'title' => 'Title',
        'address' => '-',
        'phone' => '-',
        'hours' => '-',
        'image' => '',
        'description' => 'Body text for whatever you\'d like to say.'
    ]
];

$detail = isset($details[$id]) ? $details[$id] : null;

if (!$detail) {
    header("Location: home.php");
    exit();
}

$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($detail['title']); ?></title>
    <link rel="stylesheet" href="home.css">
    <style>
        .detail-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        .back-btn {
            padding: 10px 20px;
            background-color: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin-bottom: 30px;
            transition: all 0.3s;
        }
        .back-btn:hover {
            background-color: #5568d3;
            transform: translateY(-2px);
        }
        .detail-content {
            background: white;
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .detail-image {
            width: 100%;
            max-height: 500px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        .detail-title {
            font-size: 32px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }
        .detail-info {
            margin-bottom: 15px;
            font-size: 16px;
            color: #666;
            line-height: 1.8;
        }
        .detail-info strong {
            color: #333;
            margin-right: 10px;
        }
        .detail-description {
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid #e0e0e0;
            font-size: 16px;
            color: #666;
            line-height: 1.8;
        }
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
                <button class="profile-btn" onclick="window.location.href='profile.php'">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                    <?php echo htmlspecialchars($username); ?>
                </button>
            </div>
        </header>

        <div class="detail-container">
            <button class="back-btn" onclick="window.location.href='home.php'">← กลับหน้าหลัก</button>
            
            <div class="detail-content">
                <?php if ($detail['image']): ?>
                    <img src="<?php echo htmlspecialchars($detail['image']); ?>" alt="<?php echo htmlspecialchars($detail['title']); ?>" class="detail-image">
                <?php endif; ?>
                
                <h1 class="detail-title"><?php echo htmlspecialchars($detail['title']); ?></h1>
                
                <div class="detail-info">
                    <strong>ที่อยู่:</strong> <?php echo htmlspecialchars($detail['address']); ?>
                </div>
                
                <div class="detail-info">
                    <strong>โทรศัพท์:</strong> <?php echo htmlspecialchars($detail['phone']); ?>
                </div>
                
                <div class="detail-info">
                    <strong>เวลาทำการ:</strong> <?php echo htmlspecialchars($detail['hours']); ?>
                </div>
                
                <div class="detail-description">
                    <strong>รายละเอียด:</strong><br>
                    <?php echo nl2br(htmlspecialchars($detail['description'])); ?>
                </div>
            </div>
        </div>

        <footer class="footer">
            <button class="footer-btn" onclick="window.location.href='logout.php'">ออกจากระบบ</button>
        </footer>
    </div>
</body>
</html>