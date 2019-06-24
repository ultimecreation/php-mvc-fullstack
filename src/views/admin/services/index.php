<?php require_once('../src/views/base_header.php');
?>
<section id="services">
    <header>
        <h1>Liste des Prestations</h1>
        <a href="<?php echo linkUrl('/admin/nouvelle-prestation'); ?>" class="btn_primary btn_block">Nouvelle Prestation</a>
    </header>

    <?php foreach ($data['services'] as $service) : ?>

        <article>
            <div class="divider">
                <hr>
                <span>&gt</span>
                <hr>
            </div>
            <header>
                <h1><?php echo $service->name; ?></h1>
            </header>
            <div class="services-admin">
                <div class="d_flex_evenly">
                    <form action="<?php echo linkUrl("/admin/modification-prestation"); ?>" method="GET">
                        <input type="hidden" name="idToEdit" value="<?php echo $service->id; ?>">
                        <input type="submit" value="Modifier" class="btn_success vw_20 btn_fake_a">
                    </form>

                    <form action="<?php echo linkUrl("/admin/suppression-prestation"); ?>" method="POST">
                        <input type="hidden" name="idToDelete" value="<?php echo $service->id; ?>">
                        <input type="submit" value="Supprimer" class="btn_danger vw_20 btn_fake_a">
                    </form>
                </div>
            </div>
            <div class="services-card">
                <img src="<?php echo assetsUrl("uploads/prestations/{$service->image}"); ?>" alt="<?php echo $service->name; ?>">
                <details>
                    <p><?php echo $service->description; ?></p>
                </details>
            </div>

        </article>
    <?php endforeach; ?>
</section>


<?php require_once('../src/views/base_footer.php'); ?>