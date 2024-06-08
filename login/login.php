<?php
require 'config.php';
$errorMessages = [];
$generalErrorMessage = 'Benutzername oder Passwort ist falsch.';
$reloadPage = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Login
    if (isset($_POST['loginButton'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Hole den Benutzer aus der Datenbank
        $result = mysqli_query($mysqli, "SELECT * FROM users WHERE benutzername = '$username'");
        $row = mysqli_fetch_assoc($result);

        if ($row && password_verify($password, $row['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['userid'] = $row['id'];
            $_SESSION['benutzername'] = $row['benutzername'];
            $_SESSION['anrede'] = $row['anrede'];
            $_SESSION['vorname'] = $row['vorname'];
            $_SESSION['nachname'] = $row['nachname'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['loginTime'] = time();

            //Setze den Admin-Cookie, wenn der Benutzer ein Admin ist
            if ($username === 'admin') {
                $adminCookieDuration = 3600;
                setcookie("adminCookie", true, time() + $adminCookieDuration);
            }
            
            $loginCookieDuration = 3600;
            setcookie("userid", $_SESSION['userid'], time() + $loginCookieDuration);
            setcookie("username", $username, time() + $loginCookieDuration);
            setcookie("loginCookie", $loginCookieDuration, time() + $loginCookieDuration);

            $reloadPage = true;
        } else {
            $errorMessages['general'] = $generalErrorMessage;
        }
    }

    // Logout
    if (isset($_POST['logoutButton'])) {
        echo "Logout Button pressed!";
        session_destroy();
        setcookie("adminCookie", "", time() - 3600); // Lösche den Admin-Cookie beim Logout
        setcookie("userid", $_SESSION['userid'], time() - 3600);
        setcookie("username", $username, time() - 3600);
        setcookie("loginCookie", $loginCookieDuration, time() - 3600);

        header('Location: index.php?page=login');
        exit;
    }
}

// Wenn die Seite neu geladen werden soll, leite weiter
if ($reloadPage) {
    header('Location: index.php?page=login');
    exit;
}
?>

<div class="text-center p-md-5">
    <h1>Login Seite</h1>
    <hr>

    <?php if (isset($_SESSION['login']) && $_SESSION['login']) { ?>
        <p style="color: green; font-size: 20px;">Sie sind eingeloggt!</p>
        <form method="POST" action="" class="login_css">
            <input name="logoutButton" type="submit" value="Logout"><br>
        </form>
    <?php } else { ?>
        <form method="POST" action="" class="login_css">
            <label for="username">Benutzername:</label><br/>
            <input type="text" id="username" name="username" placeholder="Benutzername" autocomplete="username"/><br>

            <?php if (!empty($errorMessages['username'])) { ?>
                <p style="color: red;"><?php echo $errorMessages['username']; ?></p>
            <?php } ?>

            <label for="password">Passwort:</label><br>
            <input type="password" id="password" name="password" placeholder="Passwort" autocomplete="current-password"/><br>

            <?php if (!empty($errorMessages['password'])) { ?>
                <p style="color: red;"><?php echo $errorMessages['password']; ?></p>
            <?php } ?>

            <?php if (!empty($errorMessages['general']) && (empty($errorMessages['username']) || empty($errorMessages['password']))) { ?>
                <p style="color: red; font-size: 17px;"><?php echo $errorMessages['general']; ?></p>
            <?php } ?>

            <input name="loginButton" type="submit" value="Login"><br>
        </form>
    <?php } ?>

    <p> Noch keinen Account?<br>
        <a href="index.php?page=register">Account erstellen</a><br>
    </p>
</div>