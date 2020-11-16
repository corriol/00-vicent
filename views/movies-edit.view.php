<!DOCTYPE html>
<html lang="en">
<head>
    <?php require 'views/_partials/head.partial.php' ?>
</head>
<body>
<header>
    <?php require 'views/_partials/header.partial.php' ?>
</header>
<div class="container">
    <div class="row">
        <div class="col-8">
            <h1>Edit movies</h1>
            <?php if (!empty($errors) || ($isGetMethod)) : ?>
                <?php if (!empty($errors)) : ?>
                    <ul>
                        <?php foreach ($errors as $error) : ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <?php require 'views/movies/form-edit.view.php' ?>
            <?php else: ?>
                <h2>The movies has been updated successfully!</h2>
            <?php endif; ?>
        </div>
    </div>
    <!-- /.row -->
</div>
<?php require 'views/_partials/footer.partial.php' ?>
</body>
</html>
