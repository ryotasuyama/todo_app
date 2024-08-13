<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    // 文字数制限を外した状態でESテンプレートを保存
    $stmt = $pdo->prepare('INSERT INTO es_templates (title, content) VALUES (?, ?)');
    $stmt->execute([$title, $content]);
}

$stmt = $pdo->query('SELECT * FROM es_templates');
$es_templates = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ja">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ES管理</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script>
        // ES内容の文字数をリアルタイムで表示するスクリプト
        function countCharacters() {
            var content = document.getElementById('content').value;
            var charCount = content.length;
            document.getElementById('charCount').innerText = charCount + ' 文字';
        }
        window.onload = function() {
            countCharacters();
        }
    </script>
    </head>

    <body>
        <div class="container mt-5">
            <h1 class="text-center">ES管理</h1>
            <form action="ES_templete.php" method="POST" class="mb-4">
                <div class="form-group">
                    <label for="title">タイトル</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="content">ES内容</label>
                    <textarea name="content" id="content" class="form-control" rows="10" required oninput="countCharacters()"></textarea>
                    <small class="form-text text-muted">現在の文字数: <span id="charCount"> 文字</span></small>
                </div>
                <button type="submit" class="btn btn-primary">ESを保存</button>
            </form>
            <ul class="list-group">
                <?php foreach ($es_templates as $template): ?>
                    <li class="list-group-item">
                        <h5><?php echo htmlspecialchars($template['title'], ENT_QUOTES, 'UTF-8'); ?></h5>
                        <p><?php echo nl2br(htmlspecialchars($template['content'], ENT_QUOTES, 'UTF-8')); ?></p>
                        <small class="form-text text-muted">文字数: <?php echo mb_strlen($template['content']); ?> 文字</small>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="text-center mt-4">
                <a href="index.php" class="btn btn-secondary">戻る</a>
            </div>
        </div>
    </body>

</html>