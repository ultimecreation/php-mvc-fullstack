<?php require_once('../src/views/base_header.php');
?>
<section id="services">

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