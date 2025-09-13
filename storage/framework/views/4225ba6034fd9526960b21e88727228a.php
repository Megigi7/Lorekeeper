

<?php $__env->startSection('content'); ?>

<script async type="text/javascript" src="https://assets.pinterest.com/js/pinit.js"></script>

<div class="character-sheet">
    <h2>Character sheet</h2>

    <!-- ENLACES DEL PERSONAJE -->
    <div class="character-navigation-links">
        <p> <a href="<?php echo e(url('characters/'. $character->id .'/gallery')); ?>">Gallery</a></p>
        <p> <a href="<?php echo e(url('characters/'. $character->id .'/closet')); ?>">Closet</a></p>
        <p> <a href="<?php echo e(url('characters/'. $character->id .'/house')); ?>">House</a></p>
        <p> <a href="<?php echo e(url('characters/'. $character->id .'/inspo')); ?>">Inspo</a></p>
        <p> <a href="<?php echo e(url('character/' . $character->id . '/relationships')); ?>">Relationships</a></p>
    </div>

    <!-- IMAGEN DE PERFIL -->
    <div class="character-image">
        <?php if($character->image): ?>
            <img src="<?php echo e(asset('storage/' . $character->image)); ?>" width="250">
        <?php endif; ?>
    </div>

    <!-- INFORMACION  -->
    <div class="character-details">
        <p><strong>Name:</strong> <?php echo e($character->name); ?></p>
        <p><strong>Age:</strong> <?php echo e($character->age); ?></p>
        <p><strong>Birthday:</strong> <?php echo e($character->birthday); ?> </p>
        <p><strong>Height:</strong> <?php echo e($character->height); ?> cm </p> 
        <p><strong>Species:</strong> <?php echo e($character->species); ?></p>
        <p><strong>Occupation:</strong> <?php echo e($character->occupation); ?></p>
        <p><strong>Sexual Orientation:</strong> <?php echo e($character->sexual_orientation); ?></p>
        <p><strong>Personality:</strong> <?php echo e($character->personality); ?></p>
    </div>

    <!-- PINTEREST -->
    <div class="character-pinterest">
        <?php if($character->pinterest_board): ?>
            <a data-pin-do="embedBoard" 
            href="<?php echo e($character->pinterest_board); ?>" 
            data-pin-scale-width="150" data-pin-scale-height="300" data-pin-board-width="600" ></a>
        <?php endif; ?>
    </div>

    <!-- SPOTIFY -->
    <div class="character-spotify">
        <?php if($character->spotify_playlist): ?>
            <iframe data-testid="embed-iframe" style="border-radius:12px" src="https://open.spotify.com/embed/playlist/<?php echo e($character->spotify_playlist); ?>?utm_source=generator&theme=0" 
            width="100%" height="352" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>
        <?php endif; ?>
    </div>


    <!-- BOTONES  -->
    <div class="character-actions">
        <a href="<?php echo e(url('characters/' . $character->id . '/edit')); ?>">Editar Personaje</a>
        
        <form action="<?php echo e(url('characters/' . $character->id . '/delete')); ?>" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este personaje?');">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button type="submit">Eliminar Personaje</button>
        </form>
    </div>

</div>
    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\María\Desktop\proyectitos\meggify\resources\views/character_sheet.blade.php ENDPATH**/ ?>