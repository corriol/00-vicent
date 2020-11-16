<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" novalidate>
    <input type="hidden" name="id" value="<?= $movies->getId() ?>">
    <div class="form-group">
        <label for="title">Title:</label>
        <input id="title" class="form-control" type="text" name="title" value="<?= $movies->getTitle() ?>" required>
    </div>
    <div class="form-group">
        <label for="tagline">Tagline:</label>
        <textarea id="tagline" name="tagline" class="form-control rounded-0" rows="2" ><?=$movies->getTagline()?></textarea>
    </div>

    <div class="form-group">
        <label for="overview">Overview:</label>
        <textarea id="overview" name="overview" class="form-control rounded-0" rows="5"><?=$movies->getOverview()?></textarea>
    </div>
    <div class="form-group">
        <label for="release_date">Release date:</label>
        <input id="release_date" class="form-control" type="date" name="release_date" value="<?=$movies->getReleaseDate()->format("Y-m-d")?>" required>
    </div>
    <div class="form-group">
        <label for="poster">Logo:</label>
        <input type="hidden" name="poster" value="<?= $movies->getPoster() ?>">
        <input id="poster" class="form-control" type="file" name="poster" value="<?= $movies->getPoster() ?>" required>
        <small><?= $movies->getPoster() ?></small>
    </div>
    <div class="form-group text-right">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>