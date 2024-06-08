<?php
require_once ('config.php'); //to retrieve connection details

$sql ="INSERT INTO `users` (`anrede`, `vorname`,`nachname`, `email`, `benutzername`, `password`) VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $mysqli->prepare($sql);


$stmt -> bind_param("ssssss", $arede, $vname, $nname, $mail, $uname, $pass);


$arede = "Herr"; $vname = "Test3"; $nname = "Test3"; $mail = "test3@3333.com"; $uname = "Test3"; $pass = "3333";

$stmt->execute();