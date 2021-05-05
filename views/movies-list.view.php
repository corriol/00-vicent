<div class="container">
    <div class="row">
        <?php require __DIR__ . '/./_partials/alert.partial.php'?>
    <div class="col-12">
        <h1><?= $title ?></h1>
    </div>
    <?php if (empty($movies)) : ?>
        <h3>No s'ha trobar cap pel·lícula</h3>
    <?php else: ?>
            <?php foreach ($movies as $movie) : ?>
            <div class="col-lg-2 col-md-6 my-2">
                <?= generar_imagen_local('/'. $config["posters_path"], $movie->getPoster(),
                    $movie->getTitle(), "rounded w-100") ?>
            </div>
            <div class="col-lg-10 col-md-6 my-2">
                <h1><?= $movie->getTitle() ?></h1>
                <p class="text-muted"><?= $movie->getReleaseDateObj()->format("d-M-Y") ?> · Action</p>
                <h5 class="text-muted">Overview</h5>
                <p><?= $movie->getOverview() ?></p>
                <p class="text-muted">★ ★ ★ ★ ☆</p>
            </div>
                <?php
            endforeach;
            ?>
        </table>
    <?php endif; ?>
    </div>
    <!-- /.row -->
</div>