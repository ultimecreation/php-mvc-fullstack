<?php include_once('../src/views/base_header.php'); ?>
<div class="form-card">
    <h1>Connexion</h1>
    <form action="<?php echo linkUrl('/connexion') ?>" method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo setCsrfToken('http://localhost/php-mvc-fullstack/connexion'); ?>">
        <input type="hidden" name="referer" value="<?php echo linkUrl('/connexion') ?>">
        <div>
            <label for="email">Email</label>
            <input type="email" name="email">
            <?php if (!empty($data['email_error'])) echo "<p>{$data['email_error']}</p>" ?>
        </div>

        <div>
            <label for="password">Mot de passe</label>
            <input type="password" name="password">
            <?php if (!empty($data['password_error'])) echo "<p>{$data['password_error']}</p>"; ?>
        </div>

        <div>
            <input type="submit" value="Soumettre">
            <a href="<?php echo linkUrl('/inscription'); ?>" class="a-inscription">Pas encore de compte? je m'inscris</a>
        </div>
    </form>
    </fieldset>
</div>
<?php include_once('../src/views/base_footer.php'); ?>