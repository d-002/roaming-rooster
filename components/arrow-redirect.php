<?php function insert_arrow_redirect($user_call, $title, $page): void
{ ?>
    <div class="arrow-redirect">
        <div class="arrow-container">
            <p> <?= $user_call ?> </p>
            <img src="/assets/images/symbols/arrow.svg" class="arrow arrow-large" alt="An arrow to the right">
        </div>
        <a <?= "href=" . $page ?>><p class="pointed"><?= $title ?></p></a>
    </div>
<?php } ?>
