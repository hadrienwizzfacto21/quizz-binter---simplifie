<section id="networks">
    <?php foreach (TEMPLATES["networks"] as $key => $value) if (!empty($value[0])) echo "<a href='$value[0]' target='_blank'> <img src='$value[1]' alt='$key'></a>"; ?>
</section>