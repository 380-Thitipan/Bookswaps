<?php
require_once 'db.php';

// ดึงข้อมูลหนังสือที่พร้อมแลกจากฐานข้อมูลมาแสดงผลบนหน้าเว็บ
$stmt = $conn->prepare("
    SELECT ub.user_book_id, b.title, b.author, b.category, b.book_value_points, ub.book_condition, u.username 
    FROM User_Books ub
    JOIN Books_Master b ON ub.book_id = b.book_id
    JOIN Users u ON ub.user_id = u.user_id
    WHERE ub.status = 'พร้อมแลก'
    ORDER BY ub.user_book_id DESC
");
$stmt->execute();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookSwap - แพลตฟอร์มแลกหนังสือด้วยแต้มมัดจำ</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f6f9; margin: 0; padding: 20px; color: #333; }
        .container { max-width: 1100px; margin: auto; }
        h1 { color: #2c3e50; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; margin-top: 20px; }
        .card { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e1e8ed; transition: transform 0.2s; }
        .card:hover { transform: translateY(-3px); }
        .btn-swap { background: #27ae60; color: white; border: none; padding: 10px 15px; border-radius: 6px; cursor: pointer; text-decoration: none; display: inline-block; margin-top: 15px; font-weight: bold; text-align: center; }
        .btn-swap:hover { background: #219653; }
        .badge { background: #3498db; color: white; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: bold; }
        .points-tag { font-size: 16px; color: #e67e22; font-weight: bold; margin: 10px 0; }
    </style>
</head>
<body>
<div class="container">
    <h1>📚 BookSwap Community</h1>
    <p>ยินดีต้อนรับสู่ระบบแลกเปลี่ยนหนังสือสำหรับชาวหอสมุด ปลอดภัยด้วยแต้มมัดจำผ่านระบบกลาง</p>
    <hr style="border: 0; height: 1px; background: #dcdde1;">
    
    <h2>📖 รายการหนังสือที่พร้อมแลกเปลี่ยนในระบบ</h2>
    
    <?php if (count($books) === 0): ?>
        <p style="color: #7f8c8d;">ขณะนี้ยังไม่มีหนังสือพร้อมแลกในระบบ ลองเปิดแท็บ SQL เพื่อเพิ่มข้อมูลตัวอย่าง</p>
    <?php else: ?>
        <div class="grid">
            <?php foreach ($books as $book): ?>
                <div class="card">
                    <h3 style="margin-top: 0; color: #2c3e50;"><?php echo htmlspecialchars($book['title']); ?></h3>
                    <p style="margin: 5px 0;"><strong>ผู้เขียน:</strong> <?php echo htmlspecialchars($book['author']); ?></p>
                    <p style="margin: 10px 0;"><strong>หมวดหมู่:</strong> <span class="badge"><?php echo htmlspecialchars($book['category']); ?></span></p>
                    <p style="margin: 5px 0;"><strong>สภาพหนังสือ:</strong> <?php echo htmlspecialchars($book['book_condition']); ?></p>
                    <div class="points-tag">มัดจำ: 💰 <?php echo $book['book_value_points']; ?> แต้ม</div>
                    <p style="font-size: 13px; color: #95a5a6; margin-bottom: 0;">ผู้โพสต์: @<?php echo htmlspecialchars($book['username']); ?></p>
                    
                    <a href="request_swap.php?id=<?php echo $book['user_book_id']; ?>" class="btn-swap" onclick="return confirm('คุณต้องการใช้แต้มมัดจำเพื่อขอแลกหนังสือเล่มนี้ใช่หรือไม่?')">ขอแลกเล่มนี้</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
