<div class="container" >
    <div class="row">
        <div class="col-sm-12">
            <h3>Login</h3>
            <?php require __DIR__ . '/../_partials/alert.partial.php'?>
            <form method="post" novalidate>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control"
                           name="username" id="username"
                           value="<?= null ?? "" ?>"
                           placeholder="Username:" required>
                </div>
                <div class="form-group">
                    <label for="password">Contrasenya</label>
                    <input type="password" class="form-control"
                           name="password" id="password"
                           value="<?= null ?? "" ?>"
                           placeholder="Password:" required>
                </div>
                <input type="submit" value="Login">
            </form>
        </div>

    </div>
</div>