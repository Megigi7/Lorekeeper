

<?php $__env->startSection('content'); ?>

    <h2>Relationship form</h2>

    <?php if($type=='mod'): ?>
        <h3><?php echo e($relationship->character1->name); ?> & <?php echo e($relationship->character2->name); ?></h3>
    <?php endif; ?>

    <form <?php if($type=='new'): ?>
            action="<?php echo e(url('/relationships/store')); ?>"
          <?php else: ?> 
            action="<?php echo e(url('/relationships/' . $relationship->id . '/update')); ?>"
        <?php endif; ?> method="post" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        <?php if($type=='new'): ?>
            <select name="character_1">
                <?php $__currentLoopData = $characters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $character): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($character->id); ?>" 
                    <?php if(($type=='new' && old('character_1')==$character->id) || ($type!='new' && $relationship->character_1_id==$character->id)): ?> selected <?php endif; ?>>
                    <?php echo e($character->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            <select name="character_2">
                <?php $__currentLoopData = $characters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $character): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($character->id); ?>" 
                    <?php if(($type=='new' && old('character_2')==$character->id) || ($type!='new' && $relationship->character_2_id==$character->id)): ?> selected <?php endif; ?>>
                    <?php echo e($character->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        <?php endif; ?>

        <!-- Select -->
        <p><b>Relationship type</b> |
        <select name="relationship_type">
            <?php $__currentLoopData = $relationship_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type_option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($type_option); ?>" 
                <?php if(($type=='new' && old('relationship_type')==$type_option) || ($type!='new' && $relationship->relationship_type==$type_option)): ?> selected <?php endif; ?>>
                <?php echo e($type_option); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        </p>


        <p><b>Spotify playlist</b> <i>(url)</i> |
        <input type="text" name="spotify_playlist" 
                    <?php if($type=='new'): ?>
                        value="<?php echo e(old('spotify_playlist')); ?>"
                    <?php else: ?> 
                        value= "<?php echo e($relationship->spotify_playlist); ?>"
                    <?php endif; ?>>
        </p>


        <?php if(isset($error)): ?>
            <p style="color:red"><?php echo e($error); ?></p>
        <?php endif; ?>


        <input type="submit" value="Guardar">



    </form>




<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\María\Desktop\proyectitos\meggify\resources\views/relationship_form.blade.php ENDPATH**/ ?>