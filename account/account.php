<?php

require 'config.php';
// Stelle sicher, dass der Benutzer eingeloggt ist
if (!isset($_SESSION['login'])) {
    // Falls nicht eingeloggt, leite auf die Login-Seite weiter
    header('Location: index.php?page=login');
    exit;
}

// Daten aus der Datenbank abrufen
$userid = $_SESSION['userid'];
$result = mysqli_query($mysqli, "SELECT * FROM users WHERE id = '$userid'");
$row = mysqli_fetch_assoc($result);

// Überprüfe, ob das Formular abgeschickt wurde
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateButton'])) {
    // Hole die eingegebenen Daten
    $newAnrede = $_POST['anrede'];
    $newUsername = $_POST['newname'];
    $newVorname = $_POST['newvorname'];
    $newNachname = $_POST['newnachname'];
    $newEmail = $_POST['newemail'];

    // Führe die Aktualisierung durch
    $updateQuery = "UPDATE users SET anrede = '$newAnrede', benutzername = '$newUsername', vorname = '$newVorname', nachname = '$newNachname', email = '$newEmail' WHERE id = '$userid'";
    $updateResult = mysqli_query($mysqli, $updateQuery);

    if ($updateResult) {
        echo '<p style="color: green; font-size: 20px;">Benutzerdaten erfolgreich aktualisiert!</p>';
        // Aktualisiere die Benutzerdaten in der aktuellen Session
        $_SESSION['anrede'] = $newAnrede;
        $_SESSION['benutzername'] = $newUsername;
        $_SESSION['vorname'] = $newVorname;
        $_SESSION['nachname'] = $newNachname;
        $_SESSION['email'] = $newEmail;
    } else {
        echo '<p style="color: red; font-size: 17px;">Fehler beim Aktualisieren der Benutzerdaten.</p>';
    }
}
?>

<div class="text-center p-md-5">
    <h1>Benutzerdaten</h1>
    <hr>

    <form method="POST" action="" class="user-data-form">
        <!-- Hier füge die bereits in der Datenbank gespeicherten Informationen ein -->
        <label for="anrede">Anrede:</label><br>
        <select id="anrede" name="anrede">
            <option value="Herr" <?php echo ($_SESSION['anrede'] === 'Herr') ? 'selected' : ''; ?>>Herr</option>
            <option value="Frau" <?php echo ($_SESSION['anrede'] === 'Frau') ? 'selected' : ''; ?>>Frau</option>
            <option value="Divers" <?php echo ($_SESSION['anrede'] === 'Divers') ? 'selected' : ''; ?>>Divers</option>
        </select><br>

        <label for="newname">Neue Benutzername:</label><br/>
        <input type="text" id="newname" name="newname" value="<?php echo $_SESSION['benutzername']; ?>"><br>

        <label for="newvorname">Neuer Vorname:</label><br>
        <input type="text" id="newvorname" name="newvorname" value="<?php echo $_SESSION['vorname']; ?>"><br>

        <label for="newnachname">Neuer Nachname:</label><br>
        <input type="text" id="newnachname" name="newnachname" value="<?php echo $_SESSION['nachname']; ?>"><br>

        <label for="newemail">Neue E-Mail:</label><br>
        <input type="email" id="newemail" name="newemail" value="<?php echo $_SESSION['email']; ?>"><br>

        <input name="updateButton" type="submit" value="Aktualisieren"><br>
    </form><br>

    <p><a href="index.php?page=logout">Logout</a></p>
</div>
