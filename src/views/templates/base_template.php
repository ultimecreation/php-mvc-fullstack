<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo assetsUrl('css/style.css'); ?>">
    <title>Base_template</title>
</head>

<body>
    <?php include("../src/views/inc/navbar.php"); ?>

    <div class="container">

        <?php include($content); ?>

    </div>

    <script src="<?php echo assetsUrl('js/main.js'); ?>"></script>
</body>

</html>