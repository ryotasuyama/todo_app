<?php
require 'db.php';

// 編集対象の質問を取得
$id = $_GET['id'];
$stmt = $pdo->prepare('SELECT * FROM interview_questions WHERE id = ?');
$stmt->execute([$id]);
$question = $stmt->fetch();

// タグを取得
$tag_stmt = $pdo->query('SELECT DISTINCT tag FROM interview_questions ORDER BY tag ASC');
$tags = $tag_stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tag = $_POST['tag'] ?: $_POST['new_tag'];
    $question_text = $_POST['question'];
    $answer = $_POST['answer'];

    $stmt = $pdo->prepare('UPDATE interview_questions SET tag = ?, question = ?, answer = ? WHERE id = ?');
    $stmt->execute([$tag, $question_text, $answer, $id]);

    header('Location: interview_templete.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>質問編集</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1 class="mt-5">質問編集</h1>
        <form action="edit_interview.php?id=<?php echo $id; ?>" method="POST">
            <div class="form-group">
                <label for="tag">タグ</label>
                <select name="tag" class="form-control">
                    <?php foreach ($tags as $tag): ?>
                        <option value="<?php echo htmlspecialchars($tag['tag'], ENT_QUOTES, 'UTF-8'); ?>" <?php echo ($tag['tag'] == $question['tag']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($tag['tag'], ENT_QUOTES, 'UTF-8'); ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="text" name="new_tag" class="form-control mt-2" placeholder="新しいタグを入力">
            </div>
            <div class="form-group">
                <label for="question">予想質問</label>
                <input type="text" name="question" class="form-control" value="<?php echo htmlspecialchars($question['question'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            <div class="form-group">
                <label for="answer">回答例</label>
                <textarea name="answer" class="form-control" rows="4" required><?php echo htmlspecialchars($question['answer'], ENT_QUOTES, 'UTF-8'); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">保存</button>
        </form>
        <div class="text-center mt-4">
            <a href="interview_templete.php" class="btn btn-secondary">戻る</a>
        </div>
    </div>
</body>

</html>
