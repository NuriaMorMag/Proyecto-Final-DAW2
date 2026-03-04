<h2>Add image</h2>
<div class="form-container">

<form action="index.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="order" value="saveImage">

    <label for="image">Select image file:</label><br>
    <input type="file" name="image" id="image" required>
    <br><br>

    <label for="title">Title:</label><br>
    <input type="text" name="title" id="title">
    <br><br>

    <label>Alt text:</label><br>
    <input type="text" name="alt" required>
    <br><br>

    <label for="category">Category:</label><br>
    <select name="category" id="category" required>
        <option value="day">Day</option>
        <option value="night">Night</option>
        <option value="home">Home</option>
    </select>
    <br><br>

    <label>Date:</label><br>
    <textarea name="date" placeholder="January 25, 2026"></textarea><br><br>

    <label>Commentary:</label><br>
    <textarea name="commentary"></textarea><br><br>

    <label for="is_blog">Show in blog?</label><br> 
    <input type="checkbox" name="is_blog" id="is_blog" value="1"> 
    <br><br>



    <button type="submit">Save image</button>
</form>

<br>

<a href="index.php?page=gallery">Back to gallery</a>
</div>