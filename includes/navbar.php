<nav class="bg-warning navbar navbar-expand-md fixed-top w-100 px-2">
    
    <div class="container-fluid">
        <a class="navbar-brand navbar-brand">Catheaven</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a href="index.php" class="nav-link" aria-current="page">Home</a>
                </li>
                <li class="nav-item">
                    <a href="index.php?page=help" class="nav-link" href="#">Hilfe</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Unsere Zimmer
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="index.php?page=rooms">Zimmerübersicht</a></li>
                        <?php if ($isLoggedIn || $isAdmin) { ?>
                            <li><a class="dropdown-item" href="index.php?page=booking">Buchen</a></li>
                        <?php } ?>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="index.php?page=login" class="nav-link" aria-disabled="true">Login</a>
                </li>
                <li class="nav-item">
                    <a href="index.php?page=register" class="nav-link" href="#">Registrieren</a>
                </li>
                <li class="nav-item">
                    <a href="index.php?page=news" class="nav-link" href="#">News</a>
                </li>
                <?php if ($isLoggedIn || $isAdmin) { ?>
                    <li class="nav-item">
                        <a href="index.php?page=account" class="nav-link" href="#">Account</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>