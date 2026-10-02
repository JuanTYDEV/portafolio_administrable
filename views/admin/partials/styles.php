<!--styles.php -->
<!-- ==================== ESTILOS ADICIONALES ==================== -->
<?php if (!empty($estilos_adicionales) && is_array($estilos_adicionales)): ?>
    <?php foreach ($estilos_adicionales as $estilo): ?>
        <?php
        $href = (strpos($estilo, 'http') === 0) ? $estilo : \App\Helpers\UrlHelper::asset_url($estilo);
        ?>
        <link rel="stylesheet" href="<?php echo $href; ?>">
    <?php endforeach; ?>
<?php endif; ?>