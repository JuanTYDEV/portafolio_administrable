<!-- scripts.php -->
<!-- ==================== SCRIPTS ADICIONALES ==================== -->
<?php if (!empty($scripts_adicionales) && is_array($scripts_adicionales)): ?>
    <?php foreach ($scripts_adicionales as $script): ?>
        <?php
        // Si es externo (CDN), se queda igual. Si es local, el Helper hace la magia.
        $src = (strpos($script, 'http') === 0) ? $script : \App\Helpers\UrlHelper::asset_url($script);
        ?>
        <script src="<?php echo $src; ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>