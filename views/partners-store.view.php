<div class="container">
    <div class="row">
        <div class="col-12">
            <?php if (!empty($errors)): ?>
                <ul>
                    <?php foreach ($errors as $error) : ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php require __DIR__ . '/partners/form-create.view.php'; ?>
            <?php else: ?>
                <h2>The partner has been inserted successfully!</h2>
            <?php endif ?>
        </div>
    </div>
    <!-- /.row -->
</div>