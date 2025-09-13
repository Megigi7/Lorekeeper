

<?php $__env->startSection('content'); ?>

<div class="relationship-gallery">
    <h1><?php echo e($relationship->character1->name); ?> & <?php echo e($relationship->character2->name); ?>'s Gallery</h1>
    <form action="<?php echo e(url('/relationships/'. $relationship->id .'/gallery/store')); ?>" method="post" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="relationship_id" value="<?php echo e($relationship->id); ?>">
        <input type="file" name="image" accept="image/*" required>
        <select name="type" required>
            <?php $__currentLoopData = $galleryItemsType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($type[0]); ?>"><?php echo e($type[1]); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <button type="submit">Add Image</button>
    </form>


    <div class="gallery-tabs">
        <!-- Pestañas -->
        <ul class="tab-list">
            <li><a href="#all" class="tab-link active" onclick="showTab(event, 'all')">All</a></li>
            <?php $__currentLoopData = $galleryItemsType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><a href="#<?php echo e($type[0]); ?>" class="tab-link active" onclick="showTab(event, '<?php echo e($type[0]); ?>')"><?php echo e($type[1]); ?></a></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <!-- Contenido de las pestañas -->
    <!-- CSS SECCION CON OVERFLOW Y -->
        <div id="all" class="tab-content" style="display:block;">
            <div class="gallery-items">
                <?php $__currentLoopData = $galleryItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="gallery-item">
                        <img src="<?php echo e(asset('storage/' . $item->image)); ?>" alt="Gallery Image" width="200">
                        <form action="<?php echo e(route('relationship_gallery.destroy', ['id' => $item->id])); ?>" method="POST" class="delete-form">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <?php $__currentLoopData = $galleryItemsType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div id="<?php echo e($type[0]); ?>" class="tab-content" style="display:block;">
            <div class="gallery-items">
                <?php $__currentLoopData = $galleryItems->where('type', $type[0]); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="gallery-item">
                        <img src="<?php echo e(asset('storage/' . $item->image)); ?>" alt="Gallery Image" width="200">
                        <form action="<?php echo e(route('relationship_gallery.destroy', ['id' => $item->id])); ?>" method="POST" class="delete-form">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>


    <p><a href="<?php echo e(url('relationships/' . $relationship->id)); ?>">Back to relationship Sheet</a></p>

</div>



<script>
    function showTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tab-content");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tab-link");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].classList.remove("active");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.classList.add("active");
    }
    showTab(event, 'all'); // Mostrar la pestaña "All" por defecto

</script>
<style>
    /* .gallery-tabs { margin-top: 20px; }
    .tab-list { list-style: none; padding: 0; display: flex; gap: 10px; }
    .tab-link { padding: 8px 16px; background: #eee; border-radius: 5px; text-decoration: none; color: #333; cursor: pointer; }
    .tab-link.active { background: #ccc; }
    .tab-content { margin-top: 15px; }
    .gallery-item { display: inline-block; margin: 10px; vertical-align: top; } */
</style>


    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\María\Desktop\proyectitos\meggify\resources\views/relationship_gallery.blade.php ENDPATH**/ ?>