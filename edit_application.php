<?php
require 'db.php';

$id = $_GET['id'];

$stmt = $pdo->prepare('SELECT * FROM applications WHERE id = ?');
$stmt->execute([$id]);
$application = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $company_name = $_POST['company_name'];
    $job_title = $_POST['job_title'];
    $status = $_POST['status'];
    $apply_date = $_POST['apply_date'] !== '未定' ? $_POST['apply_date'] : NULL;
    $interview_date = $_POST['interview_date'] !== '未定' ? $_POST['interview_date'] : NULL;
    $notes = $_POST['notes'];

    $stmt = $pdo->prepare('UPDATE applications SET company_name = ?, job_title = ?, status = ?, apply_date = ?, interview_date = ?, notes = ? WHERE id = ?');
    $stmt->execute([$company_name, $job_title, $status, $apply_date, $interview_date, $notes, $id]);

    header('Location: application.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>応募情報編集</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">応募情報編集</h1>
        <form action="edit_application.php?id=<?php echo $id; ?>" method="POST">
            <div class="form-group">
                <label for="company_name">会社名</label>
                <input type="text" name="company_name" class="form-control" value="<?php echo htmlspecialchars($application['company_name'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            <div class="form-group">
                <label for="job_title">職種</label>
                <input type="text" name="job_title" class="form-control" value="<?php echo htmlspecialchars($application['job_title'], ENT_QUOTES, 'UTF-8'); ?>">
            </div>
            <div class="form-group">
                <label for="status">ステータス</label>
                <select name="status" class="form-control">
                    <option value="ES通過" <?php echo ($application['status'] == 'ES通過') ? 'selected' : ''; ?>>ES通過</option>
                    <option value="webテスト通過" <?php echo ($application['status'] == 'webテスト通過') ? 'selected' : ''; ?>>webテスト通過</option>
                    <option value="一次面接通過" <?php echo ($application['status'] == '一次面接通過') ? 'selected' : ''; ?>>一次面接通過</option>
                    <option value="二次面接通過" <?php echo ($application['status'] == '二次面接通過') ? 'selected' : ''; ?>>二次面接通過</option>
                    <option value="最終面接通過" <?php echo ($application['status'] == '最終面接通過') ? 'selected' : ''; ?>>最終面接通過</option>
                    <option value="内定" <?php echo ($application['status'] == '内定') ? 'selected' : ''; ?>>内定</option>
                </select>
            </div>
            <div class="form-group">
                <label for="apply_date">応募締め切り</label>
                <input type="text" name="apply_date" class="form-control" value="<?php echo htmlspecialchars($application['apply_date'] ?? '未定', ENT_QUOTES, 'UTF-8'); ?>">
            </div>
            <div class="form-group">
                <label for="interview_date">面接予定日</label>
                <input type="text" name="interview_date" class="form-control" value="<?php echo htmlspecialchars($application['interview_date'] ?? '未定', ENT_QUOTES, 'UTF-8'); ?>">
            </div>
            <div class="form-group">
                <label for="notes">メモ</label>
                <textarea name="notes" class="form-control" rows="4"><?php echo htmlspecialchars($application['notes'], ENT_QUOTES, 'UTF-8'); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">更新</button>
        </form>
        <div class="text-center mt-4">
            <a href="application.php" class="btn btn-secondary">戻る</a>
        </div>
    </div>
</body>
</html>
