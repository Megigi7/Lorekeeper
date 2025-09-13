<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link  rel="stylesheet" type="text/css" href="<?php echo e(asset('css/layout.css')); ?>">
    <title>Lorekeeper</title>
</head>
<body>
    <div class="header">
        <h1>Lorekeeper</h1>
        <div class="menu">
            <a href="<?php echo e(url('/')); ?>"> ▸ Home</a>
            <a href="<?php echo e(url('characters')); ?>"> ▸ Characters</a>
            <a href="<?php echo e(url('relationships')); ?>"> ▸ Relationships</a>
        </div>
    </div>

    <div class="container">
        <?php echo $__env->yieldContent('content'); ?>
    </div>
</body>
</html><?php /**PATH C:\Users\María\Desktop\proyectitos\meggify\resources\views/layout/layout.blade.php ENDPATH**/ ?>