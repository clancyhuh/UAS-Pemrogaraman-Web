<nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark" data-bs-theme="dark">
    <div class="container">
        <a class="navbar-brand">Agung Febryanto</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link" href="/">Home</a>
                <a class="nav-link" href="/pages/about">About</a>
                <a class="nav-link" href="/komik/">Komik</a>
            </div>
            <ul class="navbar-nav ms-auto">
                <?php if (logged_in()) : ?>
                    <a class="nav-item nav-link" href="/logout">Logout</a>
                <?php else : ?>
                    <a class="nav-item nav-link" href="/login">Login</a>
                <?php endif ?>
            </ul>
        </div>
    </div>
</nav>