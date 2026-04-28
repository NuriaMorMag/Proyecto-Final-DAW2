<h1>Shooting Mood</h1>

<h2>Gallery</h2>
<!-- Category menu -->
<div class="category-menu">
  <button class="category-btn active" data-category="all">All</button>
  <button class="category-btn" data-category="day">Daylife</button>
  <button class="category-btn" data-category="night">Nightlife</button>
  <button class="category-btn" data-category="home">Home</button>
</div>

<!-- GALLERY -->
<div class="image-container">
  <!-- Loop instead of writing all the <img> -->
  <?php foreach ($images as $img): ?>

    <?php
    // Original image path stored in the database
    $originalPath = $img->path;

    // File name only
    $filename = basename($originalPath);

    // File name without extension
    $basename = pathinfo($filename, PATHINFO_FILENAME);

    // Derived paths for different image versions
    $thumbPath = "web/img/thumbs/" . $filename;                     // Thumbnail JPG
    $thumbWebpPath = "web/img/webp/thumbs/" . $basename . ".webp";  // Thumbnail WebP
    $originalWebp = "web/img/webp/" . $basename . ".webp";          // Original WebP
    ?>

    <div class="photo">

      <!-- When you click: open the big WebP image in a lightbox -->
      <a href="<?= $originalWebp ?>"
        data-lightbox="gallery"
        data-title="<?= htmlspecialchars($img->title) ?>">

        <picture>
          <!-- Thumbnail WebP (used if the browser supports WebP) -->
          <source srcset="<?= $thumbWebpPath ?>" type="image/webp">

          <!-- Thumbnail JPG (fallback if WebP is not supported) -->
          <img src="<?= $thumbPath ?>"
            alt="<?= htmlspecialchars($img->alt) ?>"
            class="gallery-item <?= htmlspecialchars($img->category) ?>"
            loading="lazy">
        </picture>

      </a>

      <!-- Edit/Delete buttons just for some users -->
      <?php if (userCanManageImages()): ?>
        <div class="photo-actions">
          <a href="index.php?order=editImage&id=<?= $img->id ?>">Edit</a>
          <a href="index.php?order=deleteImage&id=<?= $img->id ?>">Delete</a>
        </div>
      <?php endif; ?>

    </div>

  <?php endforeach; ?>

  <!-- Add images options just for some users -->
  <div class="photo-actions">
    <?php if (userCanManageImages()): ?>
      <a href="index.php?order=addImage">Add image</a>
    <?php endif; ?>
  </div>
</div>

<script src="web/js/gallery.js?v=2"></script>