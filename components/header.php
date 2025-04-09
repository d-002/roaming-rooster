<?php function insert_head($name, $css = array(), $modules = array(), $scripts = array()): void
{ ?>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?=$name . " | The Roaming Rooster"?></title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
              crossorigin="anonymous">

        <!-- stylesheets -->
        <link rel="stylesheet" href="/assets/css/main-style.css">
        <?php foreach($css as $href) {?>
            <link rel="stylesheet" href="/assets/css/<?=$href?>.css">
        <?php }?>

        <!-- modules -->
        <?php foreach($modules as $src) {?>
            <script src="/assets/scripts/<?=$src?>.js" type="module"></script>
        <?php }?>

        <!-- scripts -->
        <?php foreach($scripts as $src) {?>
            <script src="/assets/scripts/<?=$src?>.js"></script>
        <?php }?>
    </head>
<?php } ?>
