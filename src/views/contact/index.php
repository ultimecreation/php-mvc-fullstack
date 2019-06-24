<?php require_once('../src/views/base_header.php'); ?>
<div class="form-card">
    <h1>Contact</h1>
    <form action="" method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo setCsrfToken('http://localhost/php-mvc-fullstack/contact'); ?>">
        <input type="hidden" name="referer" value="<?php echo linkUrl('/contact') ?>">
        <div>
            <label for="name">Nom</label>
            <input type="text" name="name" value="<?php echo $data['name']; ?>">
            <?php if (!empty($data['name_error'])) echo "<p>{$data['name_error']}</p>"; ?>
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" name="email" value="<?php echo $data['email']; ?>">
            <?php if (!empty($data['email_error'])) echo "<p>{$data['email_error']}</p>"; ?>
        </div>

        <div>
            <label for="contact_subject">Sujet</label>
            <input type="text" name="contact_subject" value="<?php echo $data['contact_subject']; ?>">
            <?php if (!empty($data['contact_subject_error'])) echo "<p>{$data['contact_subject_error']}</p>"; ?>
        </div>

        <div>
            <label for="contact_message">Message</label>
            <textarea name="contact_message" id="" cols="30" rows="10"></textarea>
            <?php if (!empty($data['contact_message_error'])) echo "<p>{$data['contact_message_error']}</p>"; ?>
        </div>



        <div>
            <input type="submit" value="Soumettre">
        </div>
    </form>
    </fieldset>
</div>
<?php require_once('../src/views/base_footer.php'); ?>