<?php
require 'db.php';

// データベースから応募情報を取得
$stmt = $pdo->query('SELECT * FROM applications');
$applications = $stmt->fetchAll();

function generateDateOptions() {
    $options = '<option value="未定">未定</option>';
    for ($i = 0; $i < 365; $i++) {
        $date = date('Y-m-d', strtotime("+$i days"));
        $options .= "<option value=\"$date\">$date</option>";
    }
    return $options;
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>応募管理</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">応募管理</h1>
        <form action="add_application.php" method="POST" class="mb-4">
            <div class="form-group">
                <label for="company_name">会社名</label>
                <input type="text" name="company_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="job_title">職種</label>
                <input type="text" name="job_title" class="form-control">
            </div>
            <div class="form-group">
                <label for="status">ステータス</label>
                <select name="status" class="form-control">
                    <option value="ES通過">ES通過</option>
                    <option value="webテスト通過">webテスト通過</option>
                    <option value="一次面接通過">一次面接通過</option>
                    <option value="二次面接通過">二次面接通過</option>
                    <option value="最終面接通過">最終面接通過</option>
                    <option value="内定">内定</option>
                </select>
            </div>
            <div class="form-group">
                <label for="apply_date">応募締め切り</label>
                <select name="apply_date" class="form-control">
                    <?php echo generateDateOptions(); ?>
                </select>
            </div>
            <div class="form-group">
                <label for="interview_date">面接予定日</label>
                <select name="interview_date" class="form-control">
                    <?php echo generateDateOptions(); ?>
                </select>
            </div>
            <div class="form-group">
                <label for="notes">メモ</label>
                <textarea name="notes" class="form-control" placeholder="特になし">特になし</textarea>
            </div>
            <button type="submit" class="btn btn-primary">応募情報を追加</button>
        </form>
        <ul class="list-group">
            <?php foreach ($applications as $application): ?>
                <li class="list-group-item">
                    <h5><?php echo htmlspecialchars($application['company_name'], ENT_QUOTES, 'UTF-8'); ?> - <?php echo htmlspecialchars($application['job_title'], ENT_QUOTES, 'UTF-8'); ?></h5>
                    <p>ステータス: <?php echo htmlspecialchars($application['status'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p>応募締め切り: <?php echo htmlspecialchars($application['apply_date'] ?? '未定',ENT_QUOTES, 'UTF-8'); ?></p>
                    <p>面接予定日: <?php echo htmlspecialchars($application['interview_date'] ?? '未定', ENT_QUOTES, 'UTF-8'); ?></p>
                    <p>メモ: <?php echo nl2br(htmlspecialchars($application['notes'] ?? '特になし', ENT_QUOTES, 'UTF-8')); ?></p>
                    <a href="edit_application.php?id=<?php echo $application['id']; ?>" class="btn btn-warning btn-sm">編集</a>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-secondary">戻る</a>
        </div>
    </div>
</body>
</html>
