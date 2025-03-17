<?php function insertHeader($name, $css)
{ ?>
    <head>
        <title>
            <?php echo $name; ?>
        </title>
        <link rel="stylesheet" href="/assets/css/main_style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
              crossorigin="anonymous">
        <?php
        foreach ($css as $link) {
            ?>
            <link rel="stylesheet" href="/assets/css/<?php echo $link; ?>.css">
            <?php
        }
        ?>
    </head>
<?php }

function insertSimpleHeader($name)
{
    insertHeader($name, array());
}

?>
