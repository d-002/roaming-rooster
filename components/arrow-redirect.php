<?php function insert_arrow_redirect($user_call, $title, $page): void
{ ?>
    <div class="arrow-redirect">
        <div class="arrow-container">
            <p> <?= $user_call ?> </p>
            <p class="arrow arrow-large"> &rarr; </p>
        </div>
        <a <?= "href=" . $page ?>><p class="pointed"><?= $title ?></p></a>
    </div>
<?php } ?>
