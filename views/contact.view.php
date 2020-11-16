<!DOCTYPE html>
<html lang="en">
<head>
    <?php require '_partials/head.partial.php' ?>
</head>
<body>
<header>
    <?php require '_partials/header.partial.php' ?>
</header>
<div class="container">
    <h1>Formulari de contacte</h1>
    <? if ($_SERVER['REQUEST_METHOD']==='POST' && empty($errors)) :?>
    <h2>Missatge enviat</h2>
        <p>Nom: <?=$nom ?></p>
        <p>Email: <?=$email ?></p>
        <p>Data de naixement: <?=$data ?></p>
        <p>Assumpte: <?=$assumpte ?></p>
        <p>Missatge: <?=$missatge ?></p>
    <? else :?>

        <?if (!empty($errors)) :?>
        <h2>Hi ha errors en processar el formulari</h2>
        <ul>
            <? foreach ($errors as $error) :?>
                <li><?=$error?></li>
            <? endforeach; ?>
        </ul>
        <? endif ;?>
        <form action="<? $_SERVER['PHP_SELF'];?>" method="post">
            Nom i cognom: <input type="text" name="nom"><br><br>

            Data naixement: <input type="date" name="data"><br><br>

            Correu electronic: <input type="email" name="email"><br><br>

            Asunte: <input type="text" name="assumpte"><br><br>

            Missatge: <input type="text" name="missatge"><br><br>

            <p>
                <input type="submit" value="Validar">
            </p>
        </form>
    <? endif; ?>



</div>
<?php require '_partials/footer.partial.php' ?>
</body>
</html>