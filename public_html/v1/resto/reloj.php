#!/usr/bin/php
<?php
  date_default_timezone_set('America/La_Paz');
  echo "Hola\n";
  $hora = date("H:i:s");
  echo "La hora actual es $hora\n";
  if ($hora > "15:30:00") {
    echo "Hora es mayor que 10:30:00\n";
  } else {
    echo "Hora es menor que 10:30:00\n";
  }
?>
