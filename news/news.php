<div class="text-center">
    <h1>NEWS</h1>
    <hr>

    <!-- Bild-Upload -->
    <div class="upload-section">
        

        <?php
        require 'config.php';
        $uploadDirectory = __DIR__ . '/newsPictures';

        if (!isset($uploadDirectory)) {
            echo "<h1>Upload-Verzeichnis nicht definiert!</h1>";
        } else {
            if (isset($_POST['uploadButton'])) {
                if (isset($_FILES["picture"])) {
                    $source = $_FILES["picture"]["tmp_name"];
                    $dest = "$uploadDirectory/" . $_FILES["picture"]["name"];
                    $text = $_POST["text"];

                    $allowedTypes = ['image/jpeg', 'image/pn  g', 'image/gif'];
                    if (isset($_FILES['picture']['type']) && in_array($_FILES['picture']['type'], $allowedTypes)) {
                        list($width, $height) = getimagesize($source);

                        // Verkleinere das Bild auf maximal 720x480 Pixel
                        $maxWidth = 720;
                        $maxHeight = 480;

                        if ($width > $maxWidth || $height > $maxHeight) {
                            $aspectRatio = $width / $height;
                            if ($aspectRatio > 1) {
                                $newWidth = $maxWidth;
                                $newHeight = $maxWidth / $aspectRatio;
                            } else {
                                $newWidth = $maxHeight * $aspectRatio;
                                $newHeight = $maxHeight;
                            }

                            $resizedImage = imagecreatetruecolor($newWidth, $newHeight);

                            switch ($_FILES['picture']['type']) {
                                case 'image/jpeg':
                                    $sourceImage = imagecreatefromjpeg($source);
                                    break;
                                case 'image/png':
                                    $sourceImage = imagecreatefrompng($source);
                                    break;
                                case 'image/gif':
                                    $sourceImage = imagecreatefromgif($source);
                                    break;
                                default:
                                    $sourceImage = null;
                            }
                            
                            if ($sourceImage !== null) {
                                imagecopyresampled($resizedImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

                                // Speichere das verkleinerte Bild
                                switch ($_FILES['picture']['type']) {
                                    case 'image/jpeg':
                                        imagejpeg($resizedImage, $dest);
                                        break;
                                    case 'image/png':
                                        imagepng($resizedImage, $dest);
                                        break;
                                    case 'image/gif':
                                        imagegif($resizedImage, $dest);
                                        break;
                                }

                                imagedestroy($resizedImage);
                                imagedestroy($sourceImage);

                                echo "<h1>Upload erfolgreich!</h1>";

                                // Speichere Informationen zum Bild in einer Datei
                                $infoFile = fopen("$uploadDirectory/info.txt", "a");
                                fwrite($infoFile, basename($dest) . "|$text\n");
                                fclose($infoFile);

                            $date = date("Y-m-d H:i:s");
                            $imagePath = "news/newsPictures/" . basename($dest);
                            $sql = "INSERT INTO `news` (`picture_path`, `date`, `text`) VALUES (?, ?, ?)";
                            $stmt = $mysqli->prepare($sql);
                            $stmt->bind_param("sss", $imagePath, $date, $text);

                            $stmt->execute();
                            } else {
                                echo "<h1>Fehler beim Verkleinern des Bildes</h1>";
                            }
                        } else {
                            // Bild ist bereits klein genug, speichere es ohne Verkleinerung
                            move_uploaded_file($source, $dest);
                            echo "<h1>Upload erfolgreich!</h1>";

                            // Speichere Informationen zum Bild in einer Datei
                            $infoFile = fopen("$uploadDirectory/info.txt", "a");
                            fwrite($infoFile, basename($dest) . "|$text\n");
                            fclose($infoFile);
                            
                            $date = date("Y-m-d H:i:s");
                            $imagePath = "news/newsPictures/" . basename($dest);
                            $sql = "INSERT INTO `news` (`picture_path`, `date`, `text`) VALUES (?, ?, ?)";
                            $stmt = $mysqli->prepare($sql);
                            $stmt->bind_param("sss", $imagePath, $date, $text);

                            $stmt->execute();
                        }
                    } else {
                        echo "<h1>Fehler beim Upload oder falsches Format</h1>";
                    }
                } else {
                    echo "<h1>Formular nicht gesendet!</h1>";
                }
            }
        }

        // Anzeige aller hochgeladenen Bilder mit Texten aus der Datenbank
        $sqlSelect = "SELECT picture_path, text FROM news";
        $result = $mysqli->query($sqlSelect);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $imagePath = $row['picture_path'];
                $text = $row['text'];

                echo "<div class='news-entry'>";
                echo "<img src='$imagePath' alt='$imagePath'/>";
                echo "<p>$text</p>";
                echo "</div>";
            }
        } else {
            echo "<h1>Keine News vorhanden</h1>";
        }
        ?>
        <?php if ($isAdmin) { ?>
        <h1>Upload:</h1>
        <form enctype="multipart/form-data" method="POST" action="">
            <label for="picture">Bild auswählen:</label>
            <input type="file" name="picture" id="picture" accept="image/*" required>
            <br>
            <label for="text">Text zum Bild:</label>
            <textarea name="text" id="text" rows="4" cols="50" required></textarea>
            <input name="uploadButton" type="submit" value="Hochladen">
        </form>
        <?php } ?>
    </div>
</div>