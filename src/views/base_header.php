<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo assetsUrl('css/style.css'); ?>">
    <title>Base_template</title>
</head>

<body class="body">
    <nav onclick="toggleMenu()">

        <ul>
            <li><a href=" <?php echo linkUrl('/'); ?>" class="nav-link">Accueil</a></li>
            <li><a href="<?php echo linkUrl('/prestations'); ?>" class="nav-link">Prestations</a></li>
            <li><a href="<?php echo linkUrl('/contact'); ?>" class="nav-link">Contact</a></li>
            <?php if (isUserLogged()) : ?>
                <li><a href="<?php echo linkUrl('/deconnexion'); ?>" class="nav-link">Déconnexion</a></li>
                <?php if (getUserData('role') === 'ADMIN') : ?>
                    <li class="dropdown"><a>Administration</a>
                        <ul class="dropdown-content">
                            <li><a href="<?php echo linkUrl('/admin/contacts'); ?>" class="nav-link">Contacts</a></li>
                            <li><a href="<?php echo linkUrl('/admin/prestations'); ?>" class="nav-link">Prestations</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            <?php else : ?>
                <li><a href="<?php echo linkUrl('/connexion'); ?>" class="nav-link">Connexion / Inscription</a></li>

            <?php endif; ?>

        </ul>
        <div id="menu-icon">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </nav>
    <?php if (isHomeUrl() === true) : ?>
        <section id="hero">
            <div class="overlay">
                <div>
                    <h1><span>Acme</span>Fleurs</h1>
                    <p>Livraison rapide sous 2H</p>
                    <a href="<?php echo linkUrl('/contact'); ?>">Contact</a>
                </div>

            </div>
        </section>
    <?php endif; ?>
    <div class="container">
        <?php include('../src/views/inc/flash_message.php'); ?>