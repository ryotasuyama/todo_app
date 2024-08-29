<?php
require 'db.php';

$filter_tag = isset($_GET['tag']) ? $_GET['tag'] : '';

if ($filter_tag) {
    $stmt = $pdo->prepare('SELECT * FROM tasks WHERE tag = ? ORDER BY due_date ASC, created_at ASC');
    $stmt->execute([$filter_tag]);
} else {
    $stmt = $pdo->query('SELECT * FROM tasks ORDER BY due_date ASC, created_at ASC');
}

$tasks = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>就活管理アプリ</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <h1 class="mt-5">就活管理アプリ</h1>
        <form action="add_task.php" method="POST">
            <div class="form-group">
                <label for="tag">タグ</label>
                <select name="tag" class="form-control">
                    <option value="大学">大学</option>
                    <option value="就活">就活</option>
                    <option value="バイト">バイト</option>
                    <option value="その他">その他</option>
                </select>
            </div>
            <div class="form-group">
                <label for="due_date">期日</label>
                <input type="date" name="due_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="title">タスク</label>
                <input type="text" name="title" class="form-control" placeholder="Task Title" required>
            </div>
            <button type="submit" class="btn btn-primary">タスクを追加</button>
        </form>
        <button onclick="location.href='calendar.php'" class="btn btn-secondary mb-3">カレンダー表示</button>
        <button onclick="location.href='application.php'" class="btn btn-secondary mb-3">応募管理</button>
        <button onclick="location.href='ES_templete.php'" class="btn btn-secondary mb-3">エントリーシート管理</button>
        <button onclick="location.href='interview_templete.php'" class="btn btn-secondary mb-3">面接質問管理</button>


        <div class="mb-3">
            <span>タグで絞り込み:</span>
            <a href="index.php" class="btn btn-outline-primary btn-sm">全て</a>
            <a href="index.php?tag=大学" class="btn btn-outline-primary btn-sm">大学</a>
            <a href="index.php?tag=就活" class="btn btn-outline-primary btn-sm">就活</a>
            <a href="index.php?tag=バイト" class="btn btn-outline-primary btn-sm">バイト</a>
            <a href="index.php?tag=その他" class="btn btn-outline-primary btn-sm">その他</a>
        </div>

        <ul class="list-group">
            <?php foreach ($tasks as $task): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <span><?php echo htmlspecialchars($task['title'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
                        <span class="badge badge-primary badge-pill"><?php echo htmlspecialchars($task['due_date'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
                        <span class="badge badge-secondary"><?php echo htmlspecialchars($task['tag'], ENT_QUOTES, 'UTF-8'); ?></span>
                    </div>
                    <div>
                        <a href="delete_task.php?id=<?php echo $task['id']; ?>" class="btn btn-danger btn-sm">削除</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>

</html>