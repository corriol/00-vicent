<?php

use App\Entity\Movie;

?>
<div class="container flex-fill">
    <div class="row">
        <div class="col-lg-3 col-md-6 my-4">
            <?= generar_imagen_local("/".Movie::POSTER_PATH, $movie->getPoster(),
                $movie->getTitle() , "rounded w-100") ?>
        </div>
        <div class="col-lg-9 col-md-6 my-5">
            <h1><?= $movie->getTitle() ?></h1>
            <p class="text-muted"><?= $movie->getReleaseDate()->format("d-M-Y") ?> · Action</p>
            <h2><em><?= $movie->getTagline() ?>.</em></h2>
            <h5 class="text-muted">Overview</h5>
            <p><?= $movie->getOverview() ?></p>
            <p class="text-muted">★ ★ ★ ★ ☆</p>
        </div>
    </div> <!-- /.row -->
</div> <!-- /.container -->
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" novalidate>
    <input type="hidden" name="id" value="<?= $movie->getId() ?>">
    <div class="form-group text-left">
        <h4>¿Estas seguro que quieres borrar la pelicula " <?= $movie->getTitle() ?> "?</h4>
        <button type="submit" name="yes" id="yes" class="btn btn-warning btn-lg">Yes</button>
        <a class="btn btn-lg btn-primary" href="../../movies">
            No
        </a>

    </div>
</form>
<br><br>


