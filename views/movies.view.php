<div class="container">
    <div class="row">
        <div class="col-12">
            <form method="post" action="<?= $router->getUrl("movies_filter") ?>"
                  class="form-inline  justify-content-center my-4">
                <div class="form-group">
                    <input name="text" class="form-control w-auto mr-sm-4"
                           value="<?= ($_POST["text"]) ?? "" ?>"
                           type="text"
                           size="50" placeholder="Search" aria-label="Search">
                </div>
                <div class="form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="optradio" id="title" value="title">&nbsp;title                        &nbsp;
                    </label>
                </div>
                <div class="form-check-inline">
                    <label class="form-check-inline">
                        <input class="form-check-input" type="radio" name="optradio" id="tagline" value="tagline">&nbsp;tagline                        &nbsp;
                    </label></div>
                <div class="form-check-inline">
                    <label class="form-check-inline">
                        <input class="form-check-input" type="radio" name="optradio" id="both" value="both" checked>&nbsp;both                        &nbsp;
                    </label>
                </div>
                <div class="form-group">
                    <button class="form-control btn btn-secondary my-2 my-sm-0" type="submit" name="botonFiltrar">Search</button>
                </div>
            </form>
            <div class="text-right mb-3"><a class="btn btn-primary" href="<?= $router->getUrl("movies_create") ?>"
                                            title="create a new partner"> <i class="fa fa-plus-circle">
                    </i> New Movie</a>
            </div>
        </div>
        <p><?= $error ?? "" ?></p>
    </div>
    <?php if (empty($movies)) : ?>
        <h3>No s'ha trobar cap element</h3>
    <?php else: ?>
        <table class="table table-condensed">
            <tr>
                <th>Poster</th>
                <th>Title <a href="<?= $router->getUrl("movies_index", ["order"=>"title", "tipo"=>"DESC"]) ?>"<i
                            class="fa fa-arrow-down"></i></a>
                    <a href="<?= $router->getUrl("movies_index", ["order"=>"title", "tipo"=>"ASC"]) ?>"><i
                                class="fa fa-arrow-up"></i></a></th>
                <th>Tagline</th>
                <th>Genre</th>
                <th>Release date <a href="<?= $router->getUrl("movies_index", ["order"=>"release_date", "tipo"=>"DESC"]) ?>"><i
                                class="fa fa-arrow-down"></i></a>
                    <a href="<?= $router->getUrl("movies_index", ["order"=>"release_date", "tipo"=>"ASC"]) ?>"><i
                                class="fa fa-arrow-up"></i></a></th>
                </th>
                <th>Actions</th>
            </tr>
            <?php foreach ($movies as $movie) { ?>
                <tr>
                    <td> <?= generar_imagen_local("/". $config["posters_path"], $movie->getPoster(),
                            $movie->getTitle(), 200, 100) ?> </td>
                    <td><?= $movie->getTitle() ?></td>
                    <td><?= $movie->getTagline() ?></td>
                    <td><?php $genre = $movieModel->getGenre($movie->getGenreId());
                                echo $genre->getName() ?></td>
                    <td><?= $movie->getReleaseDateObj()->format("d-M-Y") ?></td>
                    <td style="width: 140px"><a href="<?=$router->getUrl("movies_edit", ["id"=>$movie->getId()]) ?>">
                            <button type="button" class="btn btn-primary"><i class="fa fa-edit"></i></button>
                        </a>
                        <a href="<?=$router->getUrl("movies_delete", ["id"=>$movie->getId()]) ?>">
                            <button type="button" class="btn btn-warning"><i class="fa fa-trash"></i></button>
                        </a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
    <?php endif; ?>

    <!-- /.row -->
</div>