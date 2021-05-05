<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Users</h1>
            <form method="post" action="<?= $router->getUrl("users_filter") ?>"
                  class="form-inline  justify-content-center my-4">
                <input name="text" class="form-control w-75 mr-sm-4"
                       value="<?= ($_POST["text"]) ?? "" ?>"
                       type="text" placeholder="Search" aria-label="Search">
                <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
            </form>
            <div class="text-right mb-3"><a class="btn btn-primary" href="<?= $router->getUrl("users_create") ?>"
                                            title="create a new partner"><i class="fa fa-plus-circle"></i> New
                    User</a></div>
        </div>
        <p><?= $error ?? "" ?></p>

        <? if (empty($users)) : ?>
            <h3>No s'ha trobat cap element</h3>
        <? else: ?>
            <table class="table">
                <tr>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><?= $user->getUsername() ?></td>
                        <td><?= $user->getRole() ?></td>
                        <td>
                            <a class="btn btn-primary"
                               href="<?= $router->getUrl("users_edit", ["id" => $user->getId()]) ?>">
                                <i class="fa fa-edit"></i> Edita</a>
                            <a class="btn btn-warning"
                               href="<?= $router->getUrl("users_delete", ["id" => $user->getId()]) ?>">
                                <i class="fa fa-remove"></i> Delete</a>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </table>
        <? endif; ?>

    </div>
    <!-- /.row -->
</div>
