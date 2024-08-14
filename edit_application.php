<?php
require 'db.php';

$id = $_GET['id'];
$stmt = $pdo->prepare('SELECT * FROM applications WHERE id = ?');
$stmt->execute([$id]);
$application = $stmt->fetch();

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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>応募情報の編集</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">応募情報の編集</h1>
        <form action="add_application.php?id=<?php echo $id; ?>" method="POST" class="mb-4">
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
                    <option value="横暴予定" <?php if ($application['status'] === '応募予定') echo 'selected'; ?>>応募予定</option>
                    <option value="ES通過" <?php if ($application['status'] === 'ES通過') echo 'selected'; ?>>ES通過</option>
                    <option value="webテスト通過" <?php if ($application['status'] === 'webテスト通過') echo 'selected'; ?>>webテスト通過</option>
                    <option value="一次面接通過" <?php if ($application['status'] === '一次面接通過') echo 'selected'; ?>>一次面接通過</option>
                    <option value="二次面接通過" <?php if ($application['status'] === '二次面接通過') echo 'selected'; ?>>二次面接通過</option>
                    <option value="最終面接通過" <?php if ($application['status'] === '最終面接通過') echo 'selected'; ?>>最終面接通過</option>
                    <option value="内定" <?php if ($application['status'] === '内定') echo 'selected'; ?>>内定</option>
                </select>
            </div>
            <div class="form-group">
                <label for="apply_date">応募日</label>
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
                <textarea name="notes" class="form-control"><?php echo htmlspecialchars($application['notes'], ENT_QUOTES, 'UTF-8'); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">更新する</button>
        </form>
        <div class="text-center">
            <a href="recruit.php" class="btn btn-secondary">戻る</a>
        </div>
    </div>
</body>
</html>
