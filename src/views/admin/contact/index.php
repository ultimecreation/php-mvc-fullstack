<?php require_once('../src/views/base_header.php');
?>
<section id="services">
    <header>
        <h1>Liste des Contact</h1>
    </header>

    <?php foreach ($data['contacts'] as $contact) : ?>
        <div class="contact-card">
            <div class="divider">
                <hr>
                <span>&gt</span>
                <hr>
            </div>
            <div class="card-header d_flex_evenly">
                <h2>Message de <?php echo $contact->name; ?></h2>
                <small><?php echo $contact->created_at; ?></small>
            </div>
            <div class="card-body">
                <h3>Sujet: <?php echo $contact->contact_subject; ?></h3>
                <p>Email: <?php echo $contact->email; ?></p>
                <details>
                    <p> <?php echo $contact->contact_message; ?></p>
                </details>
            </div>
            <div class="card-footer">
                <form action="<?php echo linkUrl("/admin/suppression-contact"); ?>" method="POST">
                    <input type="hidden" name="idToDelete" value="<?php echo $contact->id; ?>">
                    <input type="submit" value="Supprimer" class="btn_danger btn_block">
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</section>


<?php require_once('../src/views/base_footer.php'); ?>