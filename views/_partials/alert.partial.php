<?php
$message = $flashMessage->get("message");
if (!empty($message)) : ?>
    <div class="container alert alert-info alert-dismissible fade show" role="alert">
        <?= $message ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>
