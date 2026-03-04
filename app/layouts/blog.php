<h1>Shooting Mood</h1>

<section id="blog">
    <h1>Blog — Behind the Lens</h1>
    <p>Discover the stories, moments, and tricks behind my favorite photographs.</p>

    <?php foreach ($posts as $post): ?>
        <article class="blog-post">
            <img src="<?= $post->path ?>" alt="<?= $post->alt ?>">
            <div class="post-content">
                <h2><?= $post->title ?></h2>

                <p class="date">
                    <?= date("F j, Y", strtotime($post->date)) ?>
                </p>

                <p><?= nl2br($post->commentary) ?></p>
            </div>
        </article>
    <?php endforeach; ?>

</section>