</div>
<footer>
    <h1>Informations</h1>
    <?php if (isHomeUrl()) : ?>
        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d25040.990809100123!2d2.357112186841406!3d48.85148521579128!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sfr!2sfr!4v1561367516979!5m2!1sfr!2sfr" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
    <?php endif; ?>
    <div class="d_flex_evenly">
        <p>Email: AcmeFleurs@gmail.com</p>
        <p>Tél: 01 02 03 04 05</p>
        <p>Adresse: 12 Avenue de la Liberté </p>
    </div>
</footer>
<script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>
<script src="<?php echo assetsUrl('js/main.js'); ?>"></script>
<?php
?>
</body>

</html>