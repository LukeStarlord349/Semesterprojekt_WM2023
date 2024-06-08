<div class="text-center">
 <?php
 require 'config.php';
    // Hier würde normalerweise der Anmeldeprozess stehen
    // Hier fügen Sie Ihre Anmeldeüberprüfung ein, z. B. mit $_SESSION

    // Statische Benutzerdaten nur für Demo-Zwecke
    $loggedInUser = true; // Setzen Sie dies auf true, wenn der Benutzer angemeldet ist

    // Statische Liste aller Reservierungen nur für Demo-Zwecke
    $reservations = array(
        array('id' => 1, 'arrival' => '2023-12-01', 'departure' => '2023-12-05', 'breakfast' => true, 'parking' => false, 'pets' => false),
        array('id' => 2, 'arrival' => '2023-12-10', 'departure' => '2023-12-15', 'breakfast' => false, 'parking' => true, 'pets' => true),
    );

    // Funktion zum Hinzufügen einer neuen Reservierung
    function addReservation($arrival, $departure, $personenzahl, $zimmertyp, $breakfast, $parking, $pets) {
        // Hier würde normalerweise der Code stehen, um die Reservierung in der Datenbank zu speichern
 
        // Für Demo-Zwecke fügen wir es einfach zur statischen Liste hinzu
        global $reservations;
        $newReservation = array(
            'id' => count($reservations) + 1,
            'arrival' => $arrival,
            'departure' => $departure,
            'personenzahl' => $personenzahl,
            'zimmertyp' => $zimmertyp,
            'breakfast' => $breakfast,
            'parking' => $parking,
            'pets' => $pets,
        );
        $reservations[] = $newReservation;
        return $newReservation;
    }

    // Wenn der Benutzer angemeldet ist

        // Neue Zimmerreservierung anlegen
        if (isset($_POST['submitReservation'])) {
            $arrival = $_POST['arrival'];
            $departure = $_POST['departure'];
            $personenzahl = $_POST['personenzahl'];
            $zimmertyp = $_POST['zimmertyp'];
            $breakfast = isset($_POST['breakfast']);
            $parking = isset($_POST['parking']);
            $pets = isset($_POST['pets']);

            // Überprüfung des Zeitraums (Abreisedatum darf nicht <= Anreisedatum sein)
            if ($arrival < $departure) {
                $newReservation = addReservation($arrival, $departure, $personenzahl, $zimmertyp, $breakfast, $parking, $pets);
                $query = "INSERT INTO reservation VALUES('','$arrival','$departure','$personenzahl', '$zimmertyp','$breakfast','$parking','$pets')";
                mysqli_query($mysqli,$query);

                echo "<p>Neue Reservierung angelegt:</p>";
                echo "<ul>";
                echo "<p>Anreise: {$newReservation['arrival']}</p>";
                echo "<p>Abreise: {$newReservation['departure']}</p>";
                echo "<p>Personenzahl: {$newReservation['personenzahl']}</p>";
                echo "<p>Zimmertyp: {$newReservation['zimmertyp']}</p>";
                echo "<p>Mit Frühstück: " . ($newReservation['breakfast'] ? 'Ja' : 'Nein') . "</p>";
                echo "<p>Parkplatz: " . ($newReservation['parking'] ? 'Ja' : 'Nein') . "</p>";
                echo "<p>Mit Haustieren: " . ($newReservation['pets'] ? 'Ja' : 'Nein') . "</p>";
                echo "</ul>";
            } else {
                echo "<p>Fehler: Das Abreisedatum muss nach dem Anreisedatum liegen.</p>";
            }
        }

        // Liste aller eigenen Reservierungen einsehen
        echo "<h2>Meine Reservierungen:</h2>";
        if (count($reservations) > 0) {
            echo "<ul>";
            foreach ($reservations as $reservation) {
                echo "<p>";
                echo "Anreise: {$reservation['arrival']}, ";
                echo "Abreise: {$reservation['departure']}, ";
                //echo "Personenzahl: {$reservation['personenzahl']}, ";
                //echo "Zimmertyp: {$reservation['zimmertyp']}, ";
                echo "Frühstück: " . ($reservation['breakfast'] ? 'Ja' : 'Nein') . ", ";
                echo "Parkplatz: " . ($reservation['parking'] ? 'Ja' : 'Nein') . ", ";
                echo "Haustiere: " . ($reservation['pets'] ? 'Ja' : 'Nein');
                echo "</p>";
            }
            echo "</ul>";
        } else {
            echo "<p>Sie haben noch keine Reservierungen.</p>";
        }

        // Formular für neue Zimmerreservierung
        ?>
        <h2>Neue Zimmerreservierung anlegen:</h2>
        <form method="post" action="">
            <label for="arrival">Anreisedatum:</label>
            <input type="date" name="arrival" id="arrival" required><br>
            <label for="departure">Abreisedatum:</label>
            <input type="date" name="departure" id="departure" required><br>
            <label for="personenzahl">Personen:</label>
            <input type="text" id="personenzahl" name="personenzahl"><br>
            <select id="zimmertyp" name="zimmertyp">
                <option value="1">Zimmer 1</option>
                <option value="2">Zimmer 2</option>
                <option value="3">Zimmer 3</option>
            </select><br>
            <label for="breakfast">Frühstück:</label>
            <input type="checkbox" name="breakfast" id="breakfast"><br>
            <label for="parking">Parkplatz:</label>
            <input type="checkbox" name="parking" id="parking"><br>
            <label for="pets">Mitnahme von Haustieren:</label>
            <input type="checkbox" name="pets" id="pets"><br>
            <input type="submit" name="submitReservation" value="Reservierung anlegen">
        </form>
        <?php
    ?>
</div>