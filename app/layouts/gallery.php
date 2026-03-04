<h1>Shooting Mood</h1>

<h2>Gallery</h2>
<!-- category menu -->
<div class="category-menu">
  <button class="category-btn active" data-category="all">All</button>
  <button class="category-btn" data-category="day">Daylife</button>
  <button class="category-btn" data-category="night">Nightlife</button>
  <button class="category-btn" data-category="home">Home</button>
</div>

<!-- gallery -->
<div class="image-container">
  <!-- bucle en vez de escribir todos los <img> -->
  <?php foreach ($images as $img): ?>
    <div class="photo">
      <img src="<?= htmlspecialchars($img->path) ?>"
        alt="<?= htmlspecialchars($img->alt) ?>"
        class="gallery-item <?= htmlspecialchars($img->category) ?>">

      <?php if (userCanManageImages()): ?>
        <div class="photo-actions">
          <a href="index.php?order=editImage&id=<?= $img->id ?>">Edit </a>
          <a href="index.php?order=deleteImage&id=<?= $img->id ?>">Delete</a>
        </div>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>

  <!-- Opción de añadir imágenes (solo para algunos usuarios) -->
  <div class="photo-actions">
  <?php if (userCanManageImages()): ?>
    <a href="index.php?order=addImage">Add image</a>
  <?php endif; ?>
  </div> 
</div>

<script src="web/js/gallery.js?v=2"></script>