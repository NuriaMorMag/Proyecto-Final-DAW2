<h1>Shooting Mood</h1>

<section class="contact-container">
    <!-- LEFT COLUMN -->
    <div class="contact-info">
        <h2>LEAVE A MESSAGE</h2>
        <p>If you’re interested in a photoshoot, collaboration or just want to comment something, send me a message.</p><br>

        <p>Connect with me also on social media:</p>
        <p><strong>Email:</strong> <a href="mailto:nuriamormag2@gmail.com">nuriamormag2@gmail.com</a></p>
        <p><strong>Instagram:</strong>
            <a href="https://www.instagram.com/__uria/" target="_blank">@__uria</a>
        </p>
    </div>

    <!-- RIGHT COLUMN -->
    <div class="contact-form">
        <h3>Personal information</h3>

        <form action="/php/Proyecto_Final_Moreno_Nuria_DAW2/contact_process.php" method="POST">
            <label for="nombre">Name or Company: </label>
            <input type="text" id="nombre" name="nombre" placeholder="Your name">

            <label for="email">Email: </label>
            <input type="email" id="email" name="email" placeholder="Your email">

            <label for="telefono">Telephone number: </label>
            <input type="tel" id="telefono" name="telefono" placeholder="Your telephone number">

            <label for="mensaje">Message: </label>
            <textarea id="mensaje" name="mensaje" placeholder="Write your message here..." required></textarea>

            <button type="submit">Send</button>
        </form>
    </div>
</section>