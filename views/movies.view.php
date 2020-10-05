<!DOCTYPE html>
<html lang="en">
<head>
    <?php require 'views/partials/head.partial.php' ?>
</head>
<body>
<header>
    <?php require 'views/partials/header.partial.php' ?>
</header>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <form method="post" action="<?php $_SERVER["PHP_SELF"] ?>"
                          class="form-inline  justify-content-center my-4">
                        <input name="text" class="form-control w-75 mr-sm-4"
                               value="<?= ($_POST["text"]) ?? "" ?>"
                               type="text" placeholder="Search" aria-label="Search">
                        <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
                    </form>
                </div>
                <p><?=$error??""?></p>
            </div>
            <?php if (empty($films)) : ?>
                <h3>No s'ha trobar cap element</h3>
            <?php else: ?>
                <table class="table">
                    <tr>
                        <th>Poster</th>
                        <th>Title <i class="fa fa-arrow-down"></i><i class="fa fa-arrow-up"></i></th>
                        <th>Tagline</th>
                        <th>Release date <i class="fa fa-arrow-down"></i><i class="fa fa-arrow-up"></i></th>
                    </tr>
                    <?php foreach ($films as $film) { ?>
                        <tr>
                            <td> <?= generarImagenLocal(MOVIES_PATH, $film["poster"],
                                    $film["title"], 200, 100) ?> </td>
                            <td><?= $film["title"] ?></td>

                            <td><?= $film["tagline"] ?></td>
                            <td><?= date("d-M-Y", $film["release_date"]) ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            <?php endif; ?>
        </div>
    </div>
    <!-- /.row -->
</div>
<?php require 'views/partials/footer.partial.php' ?>
</body>
</html>