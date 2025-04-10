<?php function insert_head($name, $css = array(), $osm = false): void
{ ?>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?=$name . " | The Roaming Rooster"?></title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
              crossorigin="anonymous">
<<<<<<< HEAD

        <!-- stylesheets -->
        <link rel="stylesheet" href="/assets/css/main-style.css">
        <?php foreach($css as $href) {?>
            <link rel="stylesheet" href="/assets/css/<?=$href?>.css">
        <?php }?>
=======
        <?php
        foreach ($css as $link) {
            ?>
            <link rel="stylesheet" href="/assets/css/<?= $link ?>.css">
            <?php
        }
        if ($osm) {
            ?>
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
                  integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
                  crossorigin=""/>
            <?php
        }
        ?>
>>>>>>> chat
    </head>
<?php } ?>
