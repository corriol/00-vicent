<!DOCTYPE html>
<?php $start = microtime(true)?>
<html lang="en">
<head>
    <?php use App\Entity\Movie;
    use App\Entity\Partner;

    require __DIR__ . '/../_partials/head.partial.php' ?>
    <title><?=$title ?? "Movie FX"?> - Movie FX</title>
</head>
<body class="d-flex flex-column min-vh-100">
<header>
    <?php require __DIR__ . '/../_partials/header.partial.php' ?>
</header>
<main class="mt-2 flex-fill">
    <div class="container">
        <?php require __DIR__ . '/../_partials/alert.partial.php' ?>
    </div>
<?=$content?>
</main>
<?php require __DIR__ . '/../_partials/footer.partial.php' ?>
</body>
</html>