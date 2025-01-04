<nav class="navbar navbar-expand navbar-dark bg-info" style="margin-bottom: 80px;">
    <div class="container">
        <a href="view-items.php" class="navbar-brand">
            <h1 class="h4 mb-0 text-uppercase text-white">Company xyz</h1>
        </a>

        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="view-items.php" class="nav-link">Items</a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="sections.php" class="nav-link">Sections</a>
            </li>
        </ul>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a href="profile.php" class="nav-link fw-bold">
                    <?= $_SESSION['username'] ?>
                </a>
            </li>
            <li class="nav-item">
                <a href="sign-out.php" class="nav-link">Log out</a>
            </li>
        </ul>
    </div>
</nav>