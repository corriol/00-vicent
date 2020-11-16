<h3>Name:</h3>
<h6> <?= $partners->getName() ?></h6>
<h3>Logo:</h3>
<?= generar_imagen_local(Partner::PARTNER_PATH . '/', $partners->getLogo()) ?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" novalidate>
    <input type="hidden" name="id" value="<?= $partners->getId() ?>">
    <div class="form-group text-left">
        <h4>¿Estas seguro que quieres borrar <?= $partners->getName() ?>?</h4>
        <button type="submit" name="yes" id="yes" class="btn btn-success btn-lg">Yes</button>
    </div>
</form>
    <a href="../../partners.php" ><button type="submit" name="no" id="no" class="btn btn-danger btn-lg">No</button></a>
    <br><br>


