<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="/">Movie FX</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?=$router->getUrl("partners_index")?>">Partners</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?=$router->getUrl("movies_index")?>">Movies</a>
                </li>
            </ul>

            <ul class="nav navbar-nav ml-auto">
            <?php if (empty($user)): ?>

                <li class="nav-item ">
                    <a class="nav-item nav-link mr-md-2" id="bd-versions" aria-haspopup="false"
                       aria-expanded="false" href="/login">
                        Log in
                    </a>

                </li>
                <li class="nav-item">
                    <a class="nav-item nav-link" aria-haspopup="false" aria-expanded="false"
                       href="">
                        Register
                    </a>
                </li>
                <?php else :?>
                <li class="nav-item">
                    <a class="nav-item nav-link mr-md-2" id="bd-versions" aria-haspopup="false"
                       aria-expanded="false" href="/logout">
                        Log out
                    </a>

                </li>
                <?php endif; ?>
            </ul>
            <form class="form-inline ml-2 my-2 my-lg-0" action="<?= $router->getUrl("movies_search") ?>">
                <input class="form-control mr-sm-2" name="q" type="text" placeholder="Search" aria-label="Search" value="<?=getQueryText()?>">
                <button class="btn btn-secondary my-2 my-sm-0" type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
    </div>
</nav>