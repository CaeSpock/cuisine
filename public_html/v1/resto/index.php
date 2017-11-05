<?php
       $user_ip = $_SERVER['REMOTE_ADDR'];
     $user_host = (isset($_SERVER['REMOTE_HOST']) ? $_SERVER['REMOTE_HOST'] : null); // $_SERVER['REMOTE_HOST'];
     $user_user = (isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : null); // $_SERVER['REMOTE_USER'];
  $user_client = $_SERVER['HTTP_USER_AGENT'];
  date_default_timezone_set('America/La_Paz');
            $date = date("Y-m-d");
             $time = date("H:i:s");
         $timediff = 4*60*60;
         $datebol = gmdate("Y-m-d", time()-$timediff);
          $timebol = gmdate("H:i:s", time()-$timediff);
          $PHPSELF = $_SERVER["PHP_SELF"];

     $pathinc = "inc";
     $pathimg = "img";
  $pathlogops = "/home/cuisine/logs/operaciones";
  $pathlogsql = "/home/cuisine/logs/sql";
  $pathphotos = "/home/cuisine/public_html/photos";
   $webphotos = "/cuisine/photos";
    $pathppal = ".";

  // This include uses the full path to the file, as its loated outside of the web directory
  include_once("/home/cuisine/conf/resto.conf.phpinc");
  include_once("$pathinc/langs/$language.phpinc");
  include_once("$pathinc/func.phpinc");
  include_once("$pathinc/dbopen.phpinc");

  include_once("$pathinc/expire.phpinc");
  include_once("$pathinc/header.phpinc");

  // Receive variables
  $cat_sent = receive_variable("POST", "cat_sent");
  $categorie = receive_variable("POST", "categorie");

  if ($cat_sent ==1 && $categorie != 0) {
    // Get catogorie data
    $s_c = "select * from CATEGORIES where cat_id='$categorie' limit 1;";
    $q_c = db_query($s_c);
    $p_c = $q_c->fetch_object();
    echo "<h1>$p_c->cat_name</h1>\n";
    echo "<hr width=\"50%\" align=\"left\"><br />\n";
    $s_p = "select * from PRODUCTS where prod_status='1' and cat_id='$categorie' order by prod_name;";
    $q_p = db_query($s_p);
    echo "<table border=\"0\" style=\"border-collapse: collapse; margin: 1.5em; font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif; font-size=10px;\">\n";
    while ($p_p = $q_p->fetch_object()) {
      // echo "<tr style=\"border-bottom: 1px solid red\">\n";
      echo "<tr>\n";
      echo "  <td valign=\"top\" align=\"left\">";
      $s_ph = "select * from PHOTOS where photo_status='1' and photo_cat='2' and photo_prodcat='$p_p->prod_id' order by rand() limit 1;";
      $q_ph = db_query($s_ph);
      if ($q_ph->num_rows != 0) {
        $p_ph = $q_ph->fetch_object();
        echo "<img src=\"$webphotos/$p_ph->photo_filename\" alt=\"$p_ph->photo_desc\" width=\"200\">";
      }
      echo "</td>\n";
      echo "  <td><font size=\"1\">&nbsp;</font></td>\n";
      echo "  <td style=\"border-bottom: 1px solid \"valign=\"top\" align=\"left\">$p_p->prod_name</td>\n";
      echo "  <td style=\"border-bottom: 1px solid \"><font size=\"1\">&nbsp;</font></td>\n";
      $showprice = $l_currency. " ";
      $s_price = "select * from PRICES where prod_id='$p_p->prod_id' and price_status='1' order by price_createddate limit 1;";
      $q_price = db_query($s_price);
      $p_price = $q_price->fetch_object();
      $showprice .= number_format($p_price->price_price,2);
      echo "  <td style=\"border-bottom: 1px solid \"valign=\"top\" align=\"left\">$showprice</td>\n";
      echo "  <td style=\"border-bottom: 1px solid \"><font size=\"1\">&nbsp;</font></td>\n";
      echo "  <td style=\"border-bottom: 1px solid \"><font size=\"1\">&nbsp;</font></td>\n";
      echo "  <td style=\"border-bottom: 1px solid \"valign=\"top\" align=\"left\">$p_p->prod_desc</td>\n";
      echo "</tr>\n";
    }
    echo "</table>\n";
    echo "<br />\n";
    echo "<hr width=\"50%\" align=\"left\"><br />\n";
    go_back();
  } else {
    echo "$l_catchoose\n";
    echo "<br />\n";
    echo "<br />\n";
    $s_c = "select * from CATEGORIES where cat_status='1' order by cat_name;";
    $q_c = db_query($s_c);
    echo "<table border=\"0\">\n";
    while ($p_c = $q_c->fetch_object()) {
      echo "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">\n"; 
      echo "<tr>\n";
      echo "  <td valign=\"top\" align=\"left\">$p_c->cat_name</td>\n";
      echo "  <td valign=\"top\" align=\"left\">";
      $s_p = "select * from PHOTOS where photo_status='1' and photo_cat='1' and photo_prodcat='$p_c->cat_id' order by rand() limit 1;";
      $q_p = db_query($s_p);
      $p_p = $q_p->fetch_object();
      echo "<img src=\"$webphotos/$p_p->photo_filename\" alt=\"$p_p->photo_desc\" width=\"200\">";
      echo "</td>\n";
      echo "<input type=\"hidden\" name=\"cat_sent\" value=\"1\">\n";
      echo "<input type=\"hidden\" name=\"categorie\" value=\"$p_c->cat_id\">\n";
      echo "<td><input type=\"submit\" value=\"$l_choose\"></td>\n";
      echo "</tr>\n";
      echo "</form>\n";
    }
    echo "</table>\n";
  }
  include_once("$pathinc/footer.phpinc");
  include_once("$pathinc/dbclose.phpinc");
?>
