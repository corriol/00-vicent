<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Ava - Movie FX</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- =================================================
        START HEAD Section
    ================================================== -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/global.css" rel="stylesheet">
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- =================================================
            END HEAD Section
        ================================================== -->

</head>
<body>
<header>
    <?php require 'views/_partials/header.partial.php' ?>
</header>
<div class="container">
</div>
<div class="container">
    <div class="row">
        <?php if (empty($errors)) : ?>
            <div class="col-lg-3 col-md-6 my-4">
                <?= generar_imagen_local(Movie::POSTER_PATH . '/', $movie->getPoster(),
                    $movie->getTitle(), "rounded w-100") ?>
            </div>
            <div class="col-lg-9 col-md-6 my-5">
                <h1><?= $movie->getTitle() ?></h1>
                <p class="text-muted"><?= $movie->getReleaseDate()->format("d-M-Y") ?> · Action</p>
                <h2><em><?= $movie->getTagline() ?>.</em></h2>
                <h5 class="text-muted">Overview</h5>
                <p><?= $movie->getOverview() ?></p>
                <p class="text-muted">★ ★ ★ ★ ☆</p>
            </div>
        <?php else :?>
            <? foreach ($errors as $error) : ?>
                <h3><?= $error ?></h3>
            <?php endforeach; ?>
        <?php endif ?>
    </div> <!-- /.row -->
</div> <!-- /.container -->
<?php require 'views/_partials/footer.partial.php' ?>
</body>
</html>
