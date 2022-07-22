<?php
  // Session starten (auch wenn vorher schonmal vorhanden)
  session_start();
  // Leeren des Wertes in der Session
  unset($_SESSION['captchacode']);

  // Zeichen, die der Captchacode enthalten darf
  $moeglicheZeichen = "abcdefghikmnpqrstuvwxy123456789";
  // Anzahl der Zeichen, die der Captchacode enthalten soll
  $anzahlZeichen = 4;

  // Definieren der Captchacode-Variable und "vorsorgliches" Leeren
  $captchacode = "";

  // Füllen der Captchacode-Variable mit der festgelegten Anzahl zufälliger Zeichen
  for($i = 0; $i < $anzahlZeichen; $i++)
    {
      $captchacode .= substr($moeglicheZeichen, (rand()%(strlen($moeglicheZeichen))), 1);
    }

  // Schreiben des Captchacodes in die Session
  $_SESSION['evC'] = '#/-'.$captchacode.'-Uhgtf';

  // Dem Browser vormachen, das Dokument wäre eine .jpg-Datei (Bildtyp)
  header('Content-type: image/jpg');

  // Ein Bild aus einem vorhandenem Bild erstellen
  $img = ImageCreateFromJPEG('images/xxxx.jpg');

  // Festlegen einer Farbe für die Schrift (mit Zufallswerten)
  $farbe = ImageColorAllocate($img, rand(200, 255), rand(200, 255), rand(200, 255));
//  $farbe = ImageColorAllocate($img, 255, 255, 255);
  // Bestimmen der Schriftart relativ zum Dokumentroot
  $ttf = "page/arial.ttf";
  // Schriftgröße
  $groesse = 14;
  // Winkel der Schrift (Zufallswert)
  $winkel = rand(0, 3);
  // Horizontale Position (Zufallswert)
  $x = rand(5, 15);
  // Vertikale Position (Schriftgröße + Abstand zum Rand)
  $y = 20;

  // Belegen des Hintergrundbildes mit dem Code
  imagettftext($img, $groesse, $winkel, $x, $y, $farbe, $ttf, $captchacode);
  // Ausgabe des fertigen Bildes
  imagejpeg($img);
  // Löschen des Bildes aus dem Zwischenspeicher
  imagedestroy($img);

?>