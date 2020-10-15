<!DOCTYPE html>
<html lang="en">
<head>
    <?php require 'partials/head.partial.php'?>
</head>
<body>
<header>
    <?php require 'partials/header.partial.php'?>
</header>
<div class="container">
</div>
<div class="container">
    <div class="row">

        <div class="col-lg-3">

            <h2 class="my-4">Genres</h2>
            <div class="list-group">
                <a href="#" class="list-group-item">Action</a>
                <a href="#" class="list-group-item">Adventure</a>
                <a href="#" class="list-group-item">Animation</a>
                <a href="#" class="list-group-item">Comedy</a>
                <a href="genre-page.html" class="list-group-item">Crime</a>
                <a href="genre-page.html" class="list-group-item">Documentary</a>
                <a href="genre-page.html" class="list-group-item">Drama</a>
                <a href="#" class="list-group-item">Family</a>
                <a href="#" class="list-group-item">Fantasy</a>
                <a href="#" class="list-group-item">Foreign</a>
                <a href="#" class="list-group-item">History</a>
                <a href="#" class="list-group-item">Horror</a>
                <a href="#" class="list-group-item">Music</a>
                <a href="#" class="list-group-item">Mystery</a>
                <a href="#" class="list-group-item">Romance</a>
                <a href="#" class="list-group-item">Science Fiction</a>
                <a href="#" class="list-group-item">Thriller</a>
                <a href="#" class="list-group-item">TV Movie</a>
                <a href="#" class="list-group-item">War</a>
                <a href="#" class="list-group-item">Western</a>
            </div>

        </div>
        <!-- /.col-lg-3 -->
        <div class="col-lg-9">

            <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class=""></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1" class=""></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2" class="active"></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                    <div class="carousel-item">
                        <img class="d-block  img-fluid" src="banners/banner01.jpg" alt="First slide" width="900"
                             height="350">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block  img-fluid" src="banners/banner02.jpg" alt="Second slide" width="900"
                             height="350">
                    </div>
                    <div class="carousel-item active">
                        <img class="d-block img-fluid" src="banners/banner03.jpg" alt="Third slide" width="900"
                             height="350">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block img-fluid" src="banners/banner04.jpg" alt="Fourth slide" width="900"
                             height="350">
                    </div>

                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>

            </div>

            <div class="row">
                <div class="col-12">
                    <form class="form-inline  justify-content-center my-4">
                        <input class="form-control w-75 mr-sm-4" type="text" placeholder="Search" aria-label="Search">
                        <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
                    </form>
                </div>
            </div>
            <h2>What's new!</h2>
            <div class="row">

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card h-100">
                        <a href="single-page.html"><img class="card-img-top"
                                                        src="posters/f33d8125166408a0e4baefddcba5b71d.jpg" alt=""></a>
                        <div class="card-body">
                            <h4 class="card-title">
                                <a href="#">Ava</a>
                            </h4>
                            <p class="card-text"><em>Kill. Or be killed.</em></p>
                            <p class="card-text text-muted">25-Sep-2020</p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">★ ★ ★ ★ ☆</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card h-100">
                        <a href="http://movie/movies/459493"><img class="card-img-top"
                                                                  src="posters/85747ee711361ce3836bb6cb879d3f2b.jpg"
                                                                  alt=""></a>
                        <div class="card-body">
                            <h4 class="card-title">
                                <a href="#">Bill &amp; Ted Face the Music</a>
                            </h4>
                            <p class="card-text"><em>The future awaits</em></p>
                            <p class="card-text text-muted">16-Sep-2020</p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">★ ★ ★ ★ ☆</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card h-100">
                        <a href="http://movie/movies/459494"><img class="card-img-top"
                                                                  src="posters/05c1df238b806d3d0efa6f55bdd3b7af.jpg"
                                                                  alt=""></a>
                        <div class="card-body">
                            <h4 class="card-title">
                                <a href="#">Hard Kill</a>
                            </h4>
                            <p class="card-text"><em>Take on a madman. Save the world.</em></p>
                            <p class="card-text text-muted">14-Sep-2020</p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">★ ★ ★ ★ ☆</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card h-100">
                        <a href="http://movie/movies/459492"><img class="card-img-top"
                                                                  src="posters/65fb72349a30fd32fdc5fb58cb110d44.jpg"
                                                                  alt=""></a>
                        <div class="card-body">
                            <h4 class="card-title">
                                <a href="#">The Owners</a>
                            </h4>
                            <p class="card-text"><em></em></p>
                            <p class="card-text text-muted">04-Sep-2020</p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">★ ★ ★ ★ ☆</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card h-100">
                        <a href="http://movie/movies/459495"><img class="card-img-top"
                                                                  src="posters/7799b35686db45a5d558f781518bfe6f.jpg"
                                                                  alt=""></a>
                        <div class="card-body">
                            <h4 class="card-title">
                                <a href="#">The New Mutants</a>
                            </h4>
                            <p class="card-text"><em>It's time to face your demons</em></p>
                            <p class="card-text text-muted">04-Sep-2020</p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">★ ★ ★ ★ ☆</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card h-100">
                        <a href="http://movie/movies/459491"><img class="card-img-top"
                                                                  src="posters/de4595bb153786acfbe8f19537f34d1f.jpg"
                                                                  alt=""></a>
                        <div class="card-body">
                            <h4 class="card-title">
                                <a href="#">Tenet</a>
                            </h4>
                            <p class="card-text"><em>Time runs out.</em></p>
                            <p class="card-text text-muted">28-Aug-2020</p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">★ ★ ★ ★ ☆</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card h-100">
                        <a href="http://movie/movies/426469"><img class="card-img-top" src="posters/growingup.jpg"
                                                                  alt=""></a>
                        <div class="card-body">
                            <h4 class="card-title">
                                <a href="#">Growing Up Smith</a>
                            </h4>
                            <p class="card-text"><em>It’s better to stand out than to fit in.</em></p>
                            <p class="card-text text-muted">09-Feb-2017</p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">★ ★ ★ ★ ☆</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card h-100">
                        <a href="http://movie/movies/325373"><img class="card-img-top" src="posters/325373.jpg" alt=""></a>
                        <div class="card-body">
                            <h4 class="card-title">
                                <a href="#">Two Lovers and a Bear</a>
                            </h4>
                            <p class="card-text"><em></em></p>
                            <p class="card-text text-muted">02-Oct-2016</p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">★ ★ ★ ★ ☆</small>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.row -->


        </div>
        <!-- /.col-lg-9 -->

    </div>

    <section id="partner">
        <div class="container">
            <div class="row pb-4">
                <div class="col-md-12">
                    <h2>Our Partners</h2>
                    <?php require 'inc/partners.php'; ?>
                    <div class="row">
                        <?php
                        shuffle($partners);
                        $partners = array_slice($partners, 0, 4);
                        foreach ($partners as $partner):  ?>
                            <div class="col-3 text-center"><img style="height: 50px; width: auto" src="<?= PARTNER_PATH . "/" . $partner["logo"] ?>"
                                                    alt="<?= $partner["name"] ?>"></div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- /.row -->
</div>

<?php require 'partials/footer.partial.php'?>
</body>
</html>