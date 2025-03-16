<?php function insertArrowRedirect($user_call, $title, $page)
{ ?>
    <div class="arrow-redirect">
        <div class="arrow-container">
            <p> <?php echo $user_call; ?> </p>
            <p class="arrow"> &rarr; </p>
        </div>
        <a <?php echo "href=" . $page ?>><p class="pointed"><?php echo $title; ?></p></a>
    </div>
<?php } ?>
