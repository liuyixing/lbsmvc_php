<!DOCTYPE html> 
<html>
<head>
    <meta charset="UTF-8">
    <title>新闻列表</title>
</head>
<body>
<table>
<tr><th>新闻ID</th><th>新闻标题</th><th>新闻内容</th><th>创建时间</th></tr>
<?php foreach ($news as $new): ?>
    <tr><td><?= $new['id'] ?></td><td><?= $new['title'] ?></td><?= $new['content'] ?><td><?= $new['id'] ?></td></tr>
<?php endforeach; ?>
</table>
</body
</html>
