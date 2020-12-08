
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <form method="post" action="<? use App\Entity\Partner;

                    $_SERVER["PHP_SELF"] ?>"
                          class="form-inline  justify-content-center my-4">
                        <input name="text" class="form-control w-75 mr-sm-4"
                               value="<?= ($_POST["text"]) ?? "" ?>"
                               type="text" placeholder="Search" aria-label="Search">
                        <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
                    </form>
                    <div class="text-right mb-3"><a class="btn btn-primary" href="/src/Controllers/partners-create.php"
                            title="create a new partner"?><i class="fa fa-plus-circle"></i> New Partner</a></div>
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
                        <th>Actions</th>
                    </tr>
                    <?php foreach ($partners as $partner) : ?>
                        <tr>
                            <td><?= $partner->getName() ?></td>
                            <td><img style="height: 40px" src="<?= Partner::PARTNER_PATH . "/" . $partner->getLogo() ?>"</td>
                            <td>
                                <a class="btn btn-primary" href="partners-edit.php?id=<?=$partner->getId()?>">
                                    <i class="fa fa-edit"></i> Edita</a>
                                <a class="btn btn-warning" href="partners-delete.php?id=<?=$partner->getId()?>">
                                    <i class="fa fa-remove"></i> Delete</a>
                            </td>

                        </tr>
                        <?php endforeach; ?>
                </table>
            <? endif; ?>

        </div>
    </div>
    <!-- /.row -->
</div>
