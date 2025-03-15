<?php function insertArrowRedirect($user_call, $title, $page)
{ ?>
    <div>
        <div>
            <p> <?php echo $user_call; ?> </p>
        </div>
        <p> <a <?php echo "href=".$page ?>><?php echo $title; ?></a> </p>
    </div>
<?php } ?>
