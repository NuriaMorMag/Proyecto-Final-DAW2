<h2>Edit image</h2>
<div class="form-container">

<form action="index.php" method="post">
    <input type="hidden" name="order" value="updateImage">
    <input type="hidden" name="id" value="<?= $image->id ?>">

    <!-- PATH -->
    <p>
        <strong>Current path:</strong>
        <?= htmlspecialchars($image->path) ?>
    </p>

    <p>
        <img
            src="img/<?= htmlspecialchars($image->path) ?>"
            alt="<?= htmlspecialchars($image->alt) ?>">
    </p>
    <br>

    <!-- TITLE -->
    <label for="title">Title:</label><br>
    <input
        type="text"
        name="title"
        id="title"
        value="<?= htmlspecialchars($image->title) ?>">
    <br><br>

    <!-- ALT -->
    <label for="alt">Alt text:</label><br>
    <input
        type="text"
        name="alt"
        id="alt"
        value="<?= htmlspecialchars($image->alt) ?>"
        required>
    <br><br>

    <!-- CATEGORY -->
    <label for="category">Category:</label><br>
    <select name="category" id="category" required>
        <option value="day" <?= $image->category === 'day' ? 'selected' : '' ?>>Day</option>
        <option value="night" <?= $image->category === 'night' ? 'selected' : '' ?>>Night</option>
        <option value="home" <?= $image->category === 'home' ? 'selected' : '' ?>>Home</option>
    </select>
    <br><br>

    <!-- DATE -->
    <label for="date">Date:</label><br>
    <textarea name="date" id="date" rows="1" cols="40" placeholder="January 25, 2026"><?= htmlspecialchars($image->date) ?></textarea>
    <br><br>

    <!-- COMMENTARY -->
    <label for="commentary">Commentary:</label><br>
    <textarea
        name="commentary"
        id="commentary"
        rows="4"
        cols="40"><?= htmlspecialchars($image->commentary) ?></textarea>
    <br><br>

    <!-- BLOG -->
     <label for="is_blog">Show in blog?</label><br> 
     <input type="checkbox" name="is_blog" id="is_blog" value="1" <?= $image->is_blog ? 'checked' : '' ?> > 
     <br><br>

    <button type="submit">Update image</button>
</form>

<br>

<a href="index.php?page=gallery">Go back to gallery</a>
</div>