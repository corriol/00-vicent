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
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <form method="post" action="<? $_SERVER["PHP_SELF"] ?>"
                          class="form-inline  justify-content-center my-4">
                        <input name="text" class="form-control w-75 mr-sm-4"
                               value="<?= ($_POST["text"]) ?? "" ?>"
                               type="text" placeholder="Search" aria-label="Search">
                        <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
                    </form>
                </div>
                <p><?=$error??""?></p>
            </div>

            <? if (empty($partners)) : ?>
                <h3>No s'ha trobat cap element</h3>
            <? else: ?>
                <table class="table">
                    <tr>
                        <th>Company</th>
                        <th>Logo</th>
                    </tr>
                    <?php foreach ($partners as $partner) {
                        ?>
                        <tr>
                            <td><?= $partner["name"] ?></td>
                            <td><img src="<?= PARTNER_PATH . "/" . $partner["logo"] ?>"</td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            <? endif; ?>

        </div>
    </div>
    <!-- /.row -->
</div>
<?php require 'partials/footer.partial.php'?>
</body>
</html>