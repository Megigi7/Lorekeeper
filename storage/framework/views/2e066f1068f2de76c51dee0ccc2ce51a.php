

<?php $__env->startSection('content'); ?>

<div class="character-sheet">
    <h2><?php echo e($relationship->character1->name); ?> & <?php echo e($relationship->character2->name); ?>'s relationship</h2>

    <a href="<?php echo e(url('relationships/' . $relationship->id . '/gallery')); ?>">Gallery</a>

    <a href="<?php echo e(url('characters/' . $relationship->character_1 )); ?>"> 
        <?php if($relationship->character1->image): ?>
            <img src="<?php echo e(asset('storage/' . $relationship->character1->image )); ?>" width="250">
        <?php endif; ?>
            <p> <?php echo e($relationship->character1->name); ?> </p>
    </a>

    <a href="<?php echo e(url('characters/' . $relationship->character_2 )); ?>"> 
        <?php if($relationship->character2->image): ?>
            <img src="<?php echo e(asset('storage/' . $relationship->character2->image )); ?>" width="250"> 
        <?php endif; ?>
        <p> <?php echo e($relationship->character2->name); ?> </p>
    </a>

    <p><strong>Relationship type:</strong> <?php echo e($relationship->relationship_type); ?></p>

    <!-- Spotify -->
    <?php if($relationship->spotify_playlist): ?>
        <iframe data-testid="embed-iframe" style="border-radius:12px" src="https://open.spotify.com/embed/playlist/<?php echo e($relationship->spotify_playlist); ?>?utm_source=generator&theme=0" 
        width="100%" height="352" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>
    <?php endif; ?>


    <!-- BOTONES  -->
    <a href="<?php echo e(url('relationships/' . $relationship->id . '/edit')); ?>">Edit relationship</a>
    
    <!-- Añadir confirmación -->
    <form action="<?php echo e(url('relationships/' . $relationship->id . '/delete')); ?>" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this relationship?');">
        <?php echo csrf_field(); ?>
        <?php echo method_field('DELETE'); ?>
        <button type="submit">Delete relationship</button>
    </form>


</div>
    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\María\Desktop\proyectitos\meggify\resources\views/relationship_sheet.blade.php ENDPATH**/ ?>