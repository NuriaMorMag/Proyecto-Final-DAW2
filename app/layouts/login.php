<h2>Access to Shooting Mood</h2>
<div class="form-container">

<?= $message ?>

<?php if (isset($_GET['timeout'])): ?>
    <p>Session expired</p>
<?php endif; ?>

<form method="POST">
    <p>   
        Username: <input type="text" name="login">
    </p>
    <p>
        Password: <input type="password" name="password">
    </p>
    <input type="submit" name="order" value="Sign in"><br>
</form>

<form> <!-- Dos form para que “Register” solo envíe order=Register, sin campos vacíos -->
    <input type="submit" name="order" value="Sign up">

    <input type="submit" name="order" value="Sign in as a guest">
</form>
</div>