<div class="container">
    <div class="row">
        <div class="col-lg-3 col-md-6 my-4">
            <?= generar_imagen_local(Movie::POSTER_PATH . '/', $movies->getPoster(),
                $movies->getTitle() , "rounded w-100") ?>
        </div>
        <div class="col-lg-9 col-md-6 my-5">
            <h1><?= $movies->getTitle() ?></h1>
            <p class="text-muted"><?= $movies->getReleaseDate()->format("d-M-Y") ?> · Action</p>
            <h2><em><?= $movies->getTagline() ?>.</em></h2>
            <h5 class="text-muted">Overview</h5>
            <p><?= $movies->getOverview() ?></p>
            <p class="text-muted">★ ★ ★ ★ ☆</p>
        </div>
    </div> <!-- /.row -->
</div> <!-- /.container -->
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" novalidate>
    <input type="hidden" name="id" value="<?= $movies->getId() ?>">
    <div class="form-group text-left">
        <h4>¿Estas seguro que quieres borrar la pelicula " <?= $movies->getTitle() ?> "?</h4>
        <button type="submit" name="yes" id="yes" class="btn btn-warning btn-lg">Yes</button>
        <a class="btn btn-lg btn-primary" href="../../movies.php">
            No
        </a>

    </div>
</form>
<br><br>


