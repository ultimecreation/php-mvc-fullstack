<?php require_once('../src/views/base_header.php'); ?>
<a href="<?php echo linkUrl('/admin/prestations'); ?>" class="go-back">&lt &lt Retour</a>
<div class="form-card">
    <h1>Modification Prestation</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?php echo setCsrfToken('http://localhost/php-mvc-fullstack/admin/modification-prestation'); ?>">
        <input type="hidden" name="referer" value="<?php echo linkUrl('/admin/modification-prestation') ?>">
        <input type="hidden" name="idToUpdate" value="<?php echo $data['idToUpdate'] ?>">
        <input type="hidden" name="image_old" value="<?php echo $data['image_old'] ?>">
        <div>
            <label for="name">Nom</label>
            <input type="text" name="name" value="<?php echo $data['name']; ?>">
            <?php if (!empty($data['name_error'])) echo "<p>{$data['name_error']}</p>"; ?>
        </div>

        <div>
            <label for="description">Description</label>
            <textarea name="description" id="admin-editor" cols="30" rows="10"><?php echo $data['description']; ?></textarea>
            <?php if (!empty($data['description_error'])) echo "<p>{$data['description_error']}</p>"; ?>
        </div>

        <div>
            <input type="file" name="image">
            <?php if (!empty($data['file_error'])) echo "<p>{$data['file_error']}</p>"; ?>
        </div>
        <div>
            <input type="submit" value="Soumettre">
        </div>
    </form>
    </fieldset>
</div>
<?php require_once('../src/views/base_footer.php'); ?>