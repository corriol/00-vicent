<div class="container">
    <div class="row">
        <div class="col-8">
            <h1>Delete movie</h1>
            <?php if (!empty($errors) || ($isGetMethod)) : ?>
                <?php if (!empty($errors)) : ?>
                    <ul>
                        <?php foreach ($errors as $error) : ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <?php require __DIR__ . '/movies/form-delete.view.php' ?>
            <?php else: ?>
                <h2>The movie <?=$movie->getTitle()?> has been deleted successfully!</h2>
            <?php endif; ?>
        </div>
    </div>
    <!-- /.row -->
</div>