

<?php $__env->startSection('content'); ?>

<div class="character-inspo">
    <h1><?php echo e($character->name); ?>'s Inspo</h1>
    <form action="<?php echo e(url('/characters/'. $character->id .'/inspo/store')); ?>" method="post" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="character_id" value="<?php echo e($character->id); ?>">
        <input type="file" name="image" accept="image/*" required>
        <p>Character name: 
            <input type="text" name="character_name" required>
        </p>
        <p>Media:
            <input type="text" name="media" required>
        </p>
        <button type="submit">Add character inspo</button>
    </form>

    <div class="inspo-items">
        <?php $__currentLoopData = $inspos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inspo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="inspo-item">
                <img src="<?php echo e(asset('storage/' . $inspo->image)); ?>" alt="Inspo Image" width="200">
                <p> Character: <?php echo e($inspo->character_name); ?> </p>
                <p> Media: <?php echo e($inspo->media); ?> </p>
                <form action="<?php echo e(route('inspo.destroy', ['id' => $inspo->id])); ?>" method="POST" class="delete-form">
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
<?php echo $__env->make('layout.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\María\Desktop\proyectitos\meggify\resources\views/character_inspo.blade.php ENDPATH**/ ?>