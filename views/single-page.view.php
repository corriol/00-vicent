<div class="container">
    <div class="row">
        <?php
            if (empty($errors)) : ?>
            <div class="col-lg-3 col-md-6 my-4">
                <?= generar_imagen_local('/' . $config["posters_path"], $movie->getPoster(),
                    $movie->getTitle(), "rounded w-100") ?>
            </div>
            <div class="col-lg-9 col-md-6 my-5">
                <h1><?= $movie->getTitle() ?></h1>
                <p class="text-muted"><?= $movie->getReleaseDateObj()->format("d-M-Y") ?> · Action</p>
                <h2><em><?= $movie->getTagline() ?>.</em></h2>
                <h5 class="text-muted">Overview</h5>
                <p><?= $movie->getOverview() ?></p>
                <p class="text-muted">★ ★ ★ ★ ☆</p>
            </div>
        <?php else :?>
            <?php foreach ($errors as $error) : ?>
                <h3><?= $error ?></h3>
            <?php endforeach; ?>
        <?php endif ?>
    </div> <!-- /.row -->
</div> <!-- /.container -->
