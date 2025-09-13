

<?php $__env->startSection('content'); ?>

    <h2>Character form</h2>

    <form <?php if($type=='new'): ?>
            action="<?php echo e(url('/characters/store')); ?>"
          <?php else: ?> 
            action="<?php echo e(url('/characters/' . $character->id . '/update')); ?>"
        <?php endif; ?> method="post" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>


        <p><b>Name</b> |
        <input type="text" name="name" 
                    <?php if($type=='new'): ?>
                        value= "<?php echo e(old('name')); ?>"
                    <?php else: ?> 
                        value= "<?php echo e($character->name); ?>"
                    <?php endif; ?>></p>

        <!-- Select -->
        <p><b>Gender</b> |
        <select name="gender">
            <option value="Female" 
            <?php if(($type=='new' && old('gender')=='Female') || ($type!='new' && $character->gender=='Female')): ?> selected <?php endif; ?>>
            Female
            </option>
            <option value="Male" 
            <?php if(($type=='new' && old('gender')=='Male') || ($type!='new' && $character->gender=='Male')): ?> selected <?php endif; ?>>
            Male
            </option>
            <option value="Non-binary" 
            <?php if(($type=='new' && old('gender')=='Non-binary') || ($type!='new' && $character->gender=='Non-binary')): ?> selected <?php endif; ?>>
            Non-binary
            </option>            
            <option value="Other" 
            <?php if(($type=='new' && old('gender')=='Other') || ($type!='new' && $character->gender=='Other')): ?> selected <?php endif; ?>>
            Other
            </option>
        </select>
        </p>

              
        <!-- Number -->
        <p><b>Age</b> |
        <input type="number" name="age" id="age"
                <?php if($type=='new'): ?>
                value= "<?php echo e(old('age')); ?>"
                <?php else: ?> 
                value= "<?php echo e($character->age); ?>"
                <?php endif; ?>></p>
        
        
        <!-- Calendario (sin año) -->
        <p><b>Birthday</b> |
        <input type="date" name="birthday" id="birthday"
                <?php if($type=='new'): ?>
                value="<?php echo e(old('birthday')); ?>"
                <?php else: ?> 
                value= "<?php echo e($character->birthday); ?>"
                <?php endif; ?> onchange="calculateAge()"></p>


        <!-- Number (decimal) -->
        <p><b>Height</b> <i>(cm)</i> |
        <input type="number" name="height" 
                    <?php if($type=='new'): ?>
                        value="<?php echo e(old('height')); ?>"
                    <?php else: ?> 
                        value= "<?php echo e($character->height); ?>"
                    <?php endif; ?>></p>

        <!-- Select -->
        <p><b>Species</b> |
        <select name="species">
            <?php $__currentLoopData = $species; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $specie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($specie); ?>" 
                <?php if(($type=='new' && old('species')==$specie) || ($type!='new' && $character->species==$specie)): ?> selected <?php endif; ?>>
                <?php echo e($specie); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        </p>



        <p><b>Occupation</b> |
        <input type="text" name="occupation" 
                    <?php if($type=='new'): ?>
                        value="<?php echo e(old('occupation')); ?>"
                    <?php else: ?> 
                        value= "<?php echo e($character->occupation); ?>"
                    <?php endif; ?>></p>
                

        <p><b>Image</b> |
        <input type="file" name="image" 
                    <?php if($type=='new'): ?>
                        value="<?php echo e(old('image')); ?>"
                    <?php else: ?> 
                        value= "<?php echo e($character->image); ?>"
                    <?php endif; ?> ></p>
            

        <!-- Select -->
        <p><b>Sexual Orientation</b> |
        <select name="sexual_orientation">
            <?php $__currentLoopData = $sexualities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sexuality): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($sexuality); ?>" 
                <?php if(($type=='new' && old('sexual_orientation')==$sexuality) || ($type!='new' && $character->sexual_orientation==$sexuality)): ?> selected <?php endif; ?>>
                <?php echo e($sexuality); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        </p>

                        
        <!-- Select (MBTI) y añadir enneagrama? -->
        <p><b>Personality</b> |
        <select name="personality">
            <?php $__currentLoopData = $personalities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mbti): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($mbti); ?>" 
                <?php if(($type=='new' && old('personality')==$mbti) || ($type!='new' && $character->personality==$mbti)): ?> selected <?php endif; ?>>
                <?php echo e($mbti); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        </p>

        <p><b>Pinterest board</b> <i>(url)</i> |
        <input type="text" name="pinterest_board" 
                    <?php if($type=='new'): ?>
                        value="<?php echo e(old('pinterest_board')); ?>"
                    <?php else: ?> 
                        value= "<?php echo e($character->pinterest_board); ?>"
                    <?php endif; ?>>
        </p>

        <p><b>Spotify playlist</b> <i>(url)</i> |
        <input type="text" name="spotify_playlist" 
                    <?php if($type=='new'): ?>
                        value="<?php echo e(old('spotify_playlist')); ?>"
                    <?php else: ?> 
                        value= "<?php echo e($character->spotify_playlist); ?>"
                    <?php endif; ?>>
        </p>
        


        <input type="submit" value="Guardar">
    </form>


<script>
    function calculateAge() {
        const birthday = document.getElementById('birthday').value;
        if (!birthday) return;
        const birthDate = new Date(birthday);
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        document.getElementById('age').value = age;
        }
</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\María\Desktop\proyectitos\meggify\resources\views/character_form.blade.php ENDPATH**/ ?>