<?php if (!empty($_SESSION['messages'])) : ?>
    <?php if (!empty($_SESSION['messages']['danger'])) : ?>
        <div class="alert-danger">
            <?php foreach ($_SESSION['messages']['danger'] as $key => $value) : ?>
                <?php echo $value . '<br>'; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?php if (!empty($_SESSION['messages'])) : ?>
    <?php if (!empty($_SESSION['messages']['success'])) : ?>
        <div class="alert-success">
            <?php foreach ($_SESSION['messages']['success'] as $key => $value) : ?>
                <?php echo $value . '<br>'; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>
<?php unset($_SESSION['messages']); ?>