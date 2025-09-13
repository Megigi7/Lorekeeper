

<?php $__env->startSection('content'); ?>

<div class="character-closet">
    <h1><?php echo e($character->name); ?>'s Closet</h1>
    <form action="<?php echo e(url('/characters/'. $character->id .'/closet/store')); ?>" method="post" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="character_id" value="<?php echo e($character->id); ?>">
        <input type="file" name="image" accept="image/*" required>
        <button type="submit">Add Image</button>
    </form>

    <div class="closet-items">
        <?php $__currentLoopData = $closetItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="closet-item">
                <img src="<?php echo e(asset('storage/' . $item->image)); ?>" alt="Closet Image" width="200">
                <form action="<?php echo e(route('closet.destroy', ['id' => $item->id])); ?>" method="POST" class="delete-form">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>


    <p><a href="<?php echo e(url('characters/' . $character->id)); ?>">Back to Character Sheet</a></p>

</div>



    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\María\Desktop\proyectitos\meggify\resources\views/character_closet.blade.php ENDPATH**/ ?>