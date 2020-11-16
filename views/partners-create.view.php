<!DOCTYPE html>
<html lang="en">
<head>
    <?php require '_partials/head.partial.php' ?>
</head>
<body>
<header>
    <?php require '_partials/header.partial.php' ?>
</header>
<div class="container">
    <div class="row">
        <div clas="col-4"></div>
        <div class="col-8">
            <h1>New partner</h1>
            <?php if (!empty($errors) || ($isGetMethod)) : ?>
                <?php if (!empty($errors)): ?>
                    <ul>
                        <?php foreach ($errors as $error) : ?>
                            <li><?= $error ?></li>
                        <? endforeach; ?>
                    </ul>
                <?php endif; ?>
                <?php require 'views/partners/form-create.view.php'; ?>
            <?php else: ?>
                <h2>The partner has been inserted successfully!</h2>
            <? endif ?>
        </div>
    </div>
    <!-- /.row -->
</div>
<?php require '_partials/footer.partial.php' ?>
</body>
</html>