

<?php $__env->startSection('content'); ?>
<div class="character-list">
    <h2>Characters</h2>
    
    <ul>
        <?php $__currentLoopData = $characters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $character): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <a href="<?php echo e(url('characters/' . $character->id)); ?>"><?php echo e($character->name); ?></a>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>

    <p><a href="<?php echo e(url('characters/create')); ?>">New character</a></p>

</div>
    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\María\Desktop\proyectitos\meggify\resources\views/character_list.blade.php ENDPATH**/ ?>