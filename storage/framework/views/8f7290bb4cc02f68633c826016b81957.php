

<?php $__env->startSection('content'); ?>
<div class="relationship-list">
    <h2><?php echo e($character->name); ?>'s Relationships</h2>
    
    <ul>
        <?php $__currentLoopData = $relationships; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relationship): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <a href="<?php echo e(url('relationships/' . $relationship->id)); ?>">
                    <?php if($relationship->character_1 == $character->id): ?>
                        <?php echo e($relationship->character2->name); ?>

                    <?php else: ?>
                        <?php echo e($relationship->character1->name); ?>

                    <?php endif; ?>
                </a>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>

    <p><a href="<?php echo e(url('relationships/create')); ?>">New Relationship</a></p>

</div>
    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\María\Desktop\proyectitos\meggify\resources\views/relationship_list.blade.php ENDPATH**/ ?>