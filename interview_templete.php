<?php
require 'db.php';

// タグで絞り込みがされているか確認
$filter_tag = isset($_GET['tag']) ? $_GET['tag'] : '';

// タグを取得
$tag_stmt = $pdo->query('SELECT DISTINCT tag FROM interview_questions ORDER BY tag ASC');
$tags = $tag_stmt->fetchAll(PDO::FETCH_ASSOC);

// 絞り込みによって表示するデータを決定
if ($filter_tag) {
    $stmt = $pdo->prepare('SELECT * FROM interview_questions WHERE tag = ? ORDER BY created_at ASC');
    $stmt->execute([$filter_tag]);
} else {
    $stmt = $pdo->query('SELECT * FROM interview_questions ORDER BY created_at ASC');
}

$questions = $stmt->fetchAll();

// 新しいタグを追加する場合の処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tag = $_POST['tag'] ?: $_POST['new_tag'];
    $question = $_POST['question'];
    $answer = $_POST['answer'];

    $stmt = $pdo->prepare('INSERT INTO interview_questions (tag, question, answer) VALUES (?, ?, ?)');
    $stmt->execute([$tag, $question, $answer]);

    header('Location: interview_templete.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>面接質問管理</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1 class="mt-5">面接質問管理</h1>
        <form action="interview_templete.php" method="POST" class="mb-4">
            <div class="form-group">
                <label for="tag">タグ</label>
                <select name="tag" class="form-control">
                    <option value="">タグを選択</option>
                    <?php foreach ($tags as $tag): ?>
                        <option value="<?php echo htmlspecialchars($tag['tag'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($tag['tag'], ENT_QUOTES, 'UTF-8'); ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="text" name="new_tag" class="form-control mt-2" placeholder="新しいタグを入力">
            </div>
            <div class="form-group">
                <label for="question">予想質問</label>
                <input type="text" name="question" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="answer">回答例</label>
                <textarea name="answer" class="form-control" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">質問を追加</button>
        </form>

        <div class="mb-3">
            <span>タグで絞り込み:</span>
            <a href="interview_templete.php" class="btn btn-outline-primary btn-sm">全て</a>
            <?php foreach ($tags as $tag): ?>
                <a href="interview_templete.php?tag=<?php echo urlencode($tag['tag']); ?>" class="btn btn-outline-primary btn-sm"><?php echo htmlspecialchars($tag['tag'], ENT_QUOTES, 'UTF-8'); ?></a>
            <?php endforeach; ?>
        </div>

        <ul class="list-group">
            <?php foreach ($questions as $question): ?>
                <li class="list-group-item">
                    <h5><?php echo htmlspecialchars($question['question'], ENT_QUOTES, 'UTF-8'); ?> <span class="badge badge-secondary"><?php echo htmlspecialchars($question['tag'], ENT_QUOTES, 'UTF-8'); ?></span></h5>
                    <p><?php echo nl2br(htmlspecialchars($question['answer'], ENT_QUOTES, 'UTF-8')); ?></p>
                    <a href="edit_interview.php?id=<?php echo $question['id']; ?>" class="btn btn-warning btn-sm">編集</a>
                </li>

                </li>
            <?php endforeach; ?>
        </ul>

        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-secondary">戻る</a>
        </div>
    </div>
</body>

</html>