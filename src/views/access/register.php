<?php require_once('../src/views/base_header.php'); ?>
<div class="form-card">
    <h1>Inscription</h1>
    <form action="" method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo setCsrfToken('http://localhost/php-mvc-fullstack/inscription'); ?>">
        <input type="hidden" name="referer" value="<?php echo linkUrl('/inscription') ?>">
        <div>
            <label for="name">Nom</label>
            <input type="text" name="name" value="<?php echo $data['name']; ?>">
            <?php if (!empty($data['name_error'])) echo "<p>{$data['name_error']}</p>"; ?>
        </div>

        <div>
            <label for="email">Email</label>
            <input type="text" name="email" value="<?php echo $data['email']; ?>">
            <?php if (!empty($data['email_error'])) echo "<p>{$data['email_error']}</p>"; ?>
        </div>

        <div>
            <label for=" password">Mot de passe</label>
            <input type="password" name="password">
            <?php if (!empty($data['password_error'])) echo "<p>{$data['password_error']}</p>"; ?>
        </div>

        <div>
            <label for="confirm_password">Confirmer le Mot de Passe</label>
            <input type="password" name="confirm_password">
            <?php if (!empty($data['confirm_password_error'])) echo "<p>{$data['confirm_password_error']}</p>"; ?>
        </div>

        <div>
            <input type="submit" value="Soumettre">
        </div>
    </form>
    </fieldset>
</div>
<?php require_once('../src/views/base_footer.php'); ?>