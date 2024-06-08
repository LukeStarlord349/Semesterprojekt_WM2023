<div class="text-center">
    <h1>Erstellen Sie einen Account</h1>
    <hr>

    <?php
    require 'config.php';
    $errorMessages = [];


    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
        $anrede = $_POST["anrede"];
        $vorname = $_POST["vorname"];
        $nachname = $_POST["nachname"];
        $email = $_POST["email"];
        $benutzername = $_POST["username"];
        $password = $_POST["password"];
        $password2 = $_POST["password2"];

        // Überprüfen, ob Benutzername oder Email bereits existieren
        $duplicate = mysqli_query($mysqli, "SELECT * FROM users WHERE benutzername = '$benutzername' OR email = '$email'");

        if (mysqli_num_rows($duplicate) > 0) {
            $errorMessages["duplicate"] = "Benutzername oder Email ist schon vergeben.";
        } else {
            if (empty($anrede)) {
                $errorMessages["anrede"] = "Bitte wählen Sie eine Anrede aus.";
            }
            if (empty($vorname)) {
                $errorMessages["vorname"] = "Vorname darf nicht leer sein.";
            }
            if (empty($nachname)) {
                $errorMessages["nachname"] = "Nachname darf nicht leer sein.";
            }
            if (empty($email)) {
                $errorMessages["email"] = "Email darf nicht leer sein.";
            }
            if (empty($benutzername)) {
                $errorMessages["username"] = "Benutzername darf nicht leer sein.";
            }
            if (empty($password)) {
                $errorMessages["password"] = "Passwort darf nicht leer sein.";
            }
            if (empty($password2)) {
                $errorMessages["password2"] = "Passwort wiederholen darf nicht leer sein.";
            } else {
                if ($password == $password2) {
                    // Hashen des Passworts
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    // SQL-Abfrage mit dem gehashten Passwort
                    $query = "INSERT INTO users (anrede, vorname, nachname, email, benutzername, password) VALUES ('$anrede','$vorname','$nachname','$email','$benutzername','$hashedPassword')";
                    mysqli_query($mysqli, $query);

                    echo "<script> alert('Registration erfolgreich!'); </script>";
                } else {
                    $errorMessages["password"] = "Passwort stimmt nicht überein.";
                }
            }
        }
    }
    ?>

    <form method="POST" action="">
        <select id="anrede" name="anrede">
            <option value="Herr">Herr</option>
            <option value="Frau">Frau</option>
            <option value="Divers">Divers</option>
        </select>
        <?php if(isset($errorMessages["anrede"])) { echo "<p style='color: red;'>".$errorMessages["anrede"]."</p>"; } ?><br>

        <label for="vorname">Vorname:</label><br>
        <input type="text" id="vorname" name="vorname">
        <?php if(isset($errorMessages["vorname"])) { echo "<p style='color: red;'>".$errorMessages["vorname"]."</p>"; } ?><br>

        <label for="nachname">Nachname:</label><br>
        <input type="text" id="nachname" name="nachname">
        <?php if(isset($errorMessages["nachname"])) { echo "<p style='color: red;'>".$errorMessages["nachname"]."</p>"; } ?><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email">
        <?php if(isset($errorMessages["email"])) { echo "<p style='color: red;'>".$errorMessages["email"]."</p>"; } ?><br>

        <label for="username">Benutzername:</label><br>
        <input type="text" id="username" name="username">
        <?php if(isset($errorMessages["username"])) { echo "<p style='color: red;'>".$errorMessages["username"]."</p>"; } ?><br>

        <label for="password">Passwort:</label><br>
        <input type="text" id="password" name="password">
        <?php if(isset($errorMessages["password"])) { echo "<p style='color: red;'>".$errorMessages["password"]."</p>"; } ?><br>

        <label for="password2">Passwort wiederholen:</label><br>
        <input type="text" id="password2" name="password2">
        <?php if(isset($errorMessages["password2"])) { echo "<p style='color: red;'>".$errorMessages["password2"]."</p>"; } ?><br>

        <?php if (isset($errorMessages["duplicate"])) { echo "<p style='color: red;'>" . $errorMessages["duplicate"] . "</p>"; } ?>
        
        <input type="submit" name="submit" value="Bestätigen"><br>
    </form><br>

    <p> Sie haben bereits einen Account?<br>
        <a href="index.php?page=login">Login</a><br>
    </p>
</div>