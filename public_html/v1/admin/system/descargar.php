<?php
     $pathinc = "../inc";
     $pathimg = "../img";
    $pathserv = "../servicios";
     $pathsys = "sistema";
    $pathfpdf = "../inc/fpdf17";
 $pathjpgraph = "../inc/jpgraph/src";

  include_once("$pathinc/conf.phpinc");
  include_once("$pathinc/func.phpinc");

  $fichero = (isset($_GET['fichero']) ? $_GET['fichero'] : null);
  if ($fichero!="") {
    $file="/home/kappa/public_html/v2/kappa/".$fichero; //file location
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Content-Length: ' . filesize($file));
    readfile($file);
  }
?>

