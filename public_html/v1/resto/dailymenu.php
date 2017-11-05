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
  $in_reserve = receive_variable("POST", "in_reserve");
  $in_verify = receive_variable("POST", "in_verify");
  $in_confirm = receive_variable("POST", "in_confirm");
  $in_email = receive_variable("POST", "in_email");
  $in_name = receive_variable("POST", "in_name");
  $in_code = receive_variable("REQUEST", "code");
  $in_del = receive_variable("POST", "in_del");
  $in_delete = receive_variable("REQUEST", "delete");

  $today = date("Y-m-d", strtotime("Today"));
  if (!is_null($in_code) and strlen($in_code) == 5) {
    if ( ($time > $dmtime_start) and ($time < $dmtime_end) ) {
      if ($in_delete == "OK") {
        echo "$l_dmreservationdeleted<br />\n";
        echo "<table border=\"0\" style=\"border-collapse: collapse; margin: 1.5em; font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif; font-size=10px;\">\n";
        $s_r = "select * from RESERVATIONS r, PRODUCTS p where r.prod_id=p.prod_id and res_code='$in_code';";
        $q_r = db_query($s_r);
        $res_name = "";
        $res_email = "";
        $txtdailymenu = "";
        while ($p_r=$q_r->fetch_object()) {
          $res_name = $p_r->res_name;
          $res_email = $p_r->res_email;
          $txtdailymenu .= "$p_r->prod_name - $l_currency ";
          $txtprice = "";
          $s_pr = "select * from PRICES where price_status='1' and prod_id='$p_r->prod_id' order by price_createddate limit 1;";
          $q_pr = db_query($s_pr);
          $p_pr = $q_pr->fetch_object();
          $txtprice = number_format($p_pr->price_price,2);
          $txtdailymenu .= "$txtprice<br />\n";
        }
        echo "<tr>\n";
        echo " <td valign=\"top\" align=\"left\">$l_name:</td>\n";
        echo " <td valign=\"top\" align=\"left\">$res_name</td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo " <td valign=\"top\" align=\"left\">$l_email:</td>\n";
        echo " <td valign=\"top\" align=\"left\">$res_email</td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo " <td valign=\"top\" align=\"left\">$l_menu:</td>\n";
        echo " <td valign=\"top\" align=\"left\">$txtdailymenu</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "<br />\n";
        echo "$l_dmreservationconfirmemail<br />\n";
        $email_msg  = $l_dmreservationdeletedbefore."\n\n";
        $email_msg .= "$l_name: $res_name\n";
        $email_msg .= "$l_email: $res_email\n";
        $email_msg .= "$l_menu:\n";
        $email_msg .= str_replace("<br />", "", $txtdailymenu)."\n";
        $email_msg .= $l_dmreservationdeletedafter;
        $email_msg .= "\n\n";
        $email_msg .= $l_dmreservationemailfooter;
        $email_msg = str_replace("%name%", $in_name, $email_msg);
        $mail_headers  = "From: $site_from <$site_email>" . PHP_EOL .
                         "Date: ".date("r (T)") . PHP_EOL .
                         "Reply-To: $site_email" . PHP_EOL .
                         "X-Mailer: PHP/" . phpversion();
        $mail_headers2 = "-f".$site_email;
        mail($res_email, $l_dmreservationemailsubject, $email_msg, $mail_headers, $mail_headers2);
        $doindb  = "update RESERVATIONS set res_status='0', res_code='', res_modip='$user_ip', res_moddate='$date $time' ";
        $doindb .= "where res_code='$in_code';";
        $doit = db_query($doindb);
        echo "</form>\n";
        opslog("#UserID# $skcv_user #Action# DailyMenu #WebHash# $skcv_hash #Result# OK $l_dmdeletereserve $l_code: $in_code");
      } elseif ($in_del == 1) {
        if ($in_confirm != 1) {
          echo "$l_dmreservationconfirmdelete<br />\n";
        }
        echo "<form method=\"post\" action=\"".$_SERVER['REQUEST_URI']."\">\n";
        echo "<table border=\"0\" style=\"border-collapse: collapse; margin: 1.5em; font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif; font-size=10px;\">\n";
        $s_r = "select * from RESERVATIONS r, PRODUCTS p where r.prod_id=p.prod_id and res_code='$in_code';";
        $q_r = db_query($s_r);
        $res_name = "";
        $res_email = "";
        $txtdailymenu = "";
        while ($p_r=$q_r->fetch_object()) {
          $res_name = $p_r->res_name;
          $res_email = $p_r->res_email;
          $txtdailymenu .= "$p_r->prod_name - $l_currency ";
          $txtprice = "";
          $s_pr = "select * from PRICES where price_status='1' and prod_id='$p_r->prod_id' order by price_createddate limit 1;";
          $q_pr = db_query($s_pr);
          $p_pr = $q_pr->fetch_object();
          $txtprice = number_format($p_pr->price_price,2);
          $txtdailymenu .= "$txtprice<br />\n";
        }
        echo "<tr>\n";
        echo " <td valign=\"top\" align=\"left\">$l_name:</td>\n";
        echo " <td valign=\"top\" align=\"left\">$res_name</td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo " <td valign=\"top\" align=\"left\">$l_email:</td>\n";
        echo " <td valign=\"top\" align=\"left\">$res_email</td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo " <td valign=\"top\" align=\"left\">$l_menu:</td>\n";
        echo " <td valign=\"top\" align=\"left\">$txtdailymenu</td>\n";
        echo "</tr>\n";
        if ($in_confirm == 1) {
          echo "</table>\n";
          echo "<br />\n";
          echo "$l_dmreservationconfirmemail<br />\n";
          $email_msg  = $l_dmreservationdeletebefore."\n";
          $email_msg .= "$l_name: $res_name\n";
          $email_msg .= "$l_email: $res_email\n";
          $email_msg .= "$l_menu:\n";
          $email_msg .= str_replace("<br />", "", $txtdailymenu)."\n";
          $email_msg .= $l_dmreservationdeleteafter;
          $email_msg .= $site_url."/v1/resto/dailymenu.php?code=$in_code&delete=OK\n";
          $email_msg .= "\n";
          $email_msg .= $l_dmreservationemailfooter;
          $email_msg = str_replace("%name%", $in_name, $email_msg);
          $mail_headers  = "From: $site_from <$site_email>" . PHP_EOL .
                           "Date: ".date("r (T)") . PHP_EOL .
                           "Reply-To: $site_email" . PHP_EOL .
                           "X-Mailer: PHP/" . phpversion();
          $mail_headers2 = "-f".$site_email;
          mail($res_email, $l_dmreservationemailsubject, $email_msg, $mail_headers, $mail_headers2);
        } else {
          echo "<input name=\"in_reserve\" value=\"1\" type=\"hidden\">\n";
          echo "<input name=\"in_confirm\" value=\"1\" type=\"hidden\">\n";
          echo "<input name=\"in_del\" value=\"1\" type=\"hidden\">\n";
          echo "<input name=\"code\" value=\"$in_code\" type=\"hidden\">\n";
          echo "</table>\n";
          $reset = "<a href=\"$PHPSELF\"><button type=\"button\" class=\"btn btn-danger\">$l_no</button></a>";
          $submit = "<button type=\"submit\" class=\"btn btn-success\">$l_confirm</button>";
          echo "$reset &nbsp;&nbsp;&nbsp; $submit";
        }
        echo "</form>\n";
      } else {
        echo "$l_dmreservationthankyou<br />\n";
        echo "<form method=\"post\" action=\"".$_SERVER['REQUEST_URI']."\">\n";
        echo "<table border=\"0\" style=\"border-collapse: collapse; margin: 1.5em; font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif; font-size=10px;\">\n";
        $s_r = "select * from RESERVATIONS r, PRODUCTS p where r.prod_id=p.prod_id and res_code='$in_code';";
        $q_r = db_query($s_r);
        $res_name = "";
        $res_email = "";
        $txtdailymenu = "";
        while ($p_r=$q_r->fetch_object()) {
          $res_name = $p_r->res_name;
          $res_email = $p_r->res_email;
          $txtdailymenu .= "$p_r->prod_name - $l_currency ";
          $txtprice = "";
          $s_pr = "select * from PRICES where price_status='1' and prod_id='$p_r->prod_id' order by price_createddate limit 1;";
          $q_pr = db_query($s_pr);
          $p_pr = $q_pr->fetch_object();
          $txtprice = number_format($p_pr->price_price,2);
          $txtdailymenu .= "$txtprice<br />\n";
        }
        echo "<tr>\n";
        echo " <td valign=\"top\" align=\"left\">$l_name:</td>\n";
        echo " <td valign=\"top\" align=\"left\">$res_name</td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo " <td valign=\"top\" align=\"left\">$l_email:</td>\n";
        echo " <td valign=\"top\" align=\"left\">$res_email</td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo " <td valign=\"top\" align=\"left\">$l_menu:</td>\n";
        echo " <td valign=\"top\" align=\"left\">$txtdailymenu</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        $email_msg  = $l_dmreservationconfirmedbefore."\n";
        $email_msg .= "$l_name: $res_name\n";
        $email_msg .= "$l_email: $res_email\n";
        $email_msg .= "$l_menu:\n";
        $email_msg .= str_replace("<br />", "", $txtdailymenu)."\n";
        $email_msg .= $l_dmreservationconfirmedafter;
        $email_msg = str_replace("%name%", $in_name, $email_msg);
        $mail_headers  = "From: $site_from <$site_email>" . PHP_EOL .
                         "Date: ".date("r (T)") . PHP_EOL .
                         "Reply-To: $site_email" . PHP_EOL .
                         "X-Mailer: PHP/" . phpversion();
        $mail_headers2 = "-f".$site_email;
        mail($res_email, $l_dmreservationemailsubject, $email_msg, $mail_headers, $mail_headers2);
        $doindb  = "update RESERVATIONS set res_status='1', res_modip='$user_ip', res_moddate='$date $time' ";
        $doindb .= "where res_code='$in_code';";
        $doit = db_query($doindb);
        echo "</form>\n";
        opslog("#UserID# $skcv_user #Action# DailyMenu #WebHash# $skcv_hash #Result# OK $l_dmconfirmreserve $l_code: $in_code");
        echo "$l_dmreservationactions<br />\n";
        echo "<form method=\"post\" action=\"".$_SERVER['REQUEST_URI']."\">\n";
        echo "<input name=\"in_del\" value=\"1\" type=\"hidden\">\n";
        echo "<input name=\"code\" value=\"$in_code\" type=\"hidden\">\n";
        echo "<input name=\"in_reserve\" value=\"1\" type=\"hidden\">\n";
        echo "<button type=\"submit\" class=\"btn btn-xs btn-link\"><i class=\"fa fa-plus\"> $l_presshere</i></button> $l_dmreservationdelete\n";
        echo "</form>\n";
      }
    } else {
      echo "$l_dmreservationofftime<br />\n";
    }
  } else {
    if ($in_reserve == 1) {
      if ($in_verify == 1) {
        if ($in_confirm != 1) { 
          echo "$l_dmreservationconfirm<br />\n";
        }
        $error = 0;
        $errortext = "";
        $errorgraph = "";
        eval_null("$in_name", $l_name);
        eval_null("$in_email", $l_email);
        eval_repdb("$in_email", "RESERVATIONS", "res_email", "and res_status='1' and res_date='$today'", $l_nullemail);
        $txtdailymenu = "";
        $selprods = 0;
        echo "<form method=\"post\" action=\"".$_SERVER['REQUEST_URI']."\">\n";
        echo "<table border=\"0\" style=\"border-collapse: collapse; margin: 1.5em; font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif; font-size=10px;\">\n";
        $s_p = "select * from DAILYMENU d, PRODUCTS p where d.prod_id=p.prod_id and dm_date='$today' and dm_status='1' order by prod_name;";
        $q_p = db_query($s_p);
        while ($p_p = $q_p->fetch_object()) {
          $txtprice = "";
          $s_pr = "select * from PRICES where price_status='1' and prod_id='$p_p->prod_id' order by price_createddate limit 1;";
          $q_pr = db_query($s_pr);
          $p_pr = $q_pr->fetch_object();
          $txtprice = number_format($p_pr->price_price,2);
          $valvalue = receive_variable("POST", "dm_".$p_p->prod_id);
          if ($valvalue == "on") {
            $txtdailymenu .= "  $p_p->prod_name - $l_currency $txtprice<br />\n";
            $txtdailymenu .= "  <input type=\"hidden\" name=\"dm_$p_p->prod_id\" value=\"on\">\n";
            $selprods++;
          } else {
            // $txtdailymenu .= "  [_] $p_p->prod_name - $l_currency $txtprice<br />\n";
          }
        }
        echo "<tr>\n";
        echo " <td valign=\"top\" align=\"left\">$l_name:</td>\n";
        echo " <td valign=\"top\" align=\"left\">$in_name</td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo " <td valign=\"top\" align=\"left\">$l_email:</td>\n";
        echo " <td valign=\"top\" align=\"left\">$in_email</td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo " <td valign=\"top\" align=\"left\">$l_menu:</td>\n";
        echo " <td valign=\"top\" align=\"left\">$txtdailymenu</td>\n";
        echo "</tr>\n";
        eval_zero($selprods, $l_nullselprods);
        echo "<tr>\n";
        echo " <td valign=\"top\" align=\"left\">$l_verifying:</td>\n";
        echo " <td valign=\"top\" align=\"left\">$errorgraph</td>\n";
        echo "</tr>\n";
        if ($error == 1) {
          echo "<tr>\n";
          echo " <td valign=\"top\" align=\"left\">$l_errorsfound:</td>\n";
          echo " <td valign=\"top\" align=\"left\">$errortext</td>\n";
          echo "</tr>\n";
          echo "<tr><td colspan=\"2\">\n";
          go_back();
          echo "</td></tr>\n";
          echo "</table>\n";
          // Check for active Reservations
          $s_r = "select * from RESERVATIONS where res_status='1' and res_email='$in_email' and res_date='$today' limit 1;";
          $q_r = db_query($s_r);
          $p_r = $q_r->fetch_object();
          echo "<form method=\"post\" action=\"".$_SERVER['REQUEST_URI']."\">\n";
          echo "<input name=\"in_del\" value=\"1\" type=\"hidden\">\n";
          echo "<input name=\"code\" value=\"$p_r->res_code\" type=\"hidden\">\n";
          echo "<input name=\"in_reserve\" value=\"1\" type=\"hidden\">\n";
          echo "<button type=\"submit\" class=\"btn btn-xs btn-link\"><i class=\"fa fa-plus\"> $l_presshere</i></button> $l_dmreservationdeleteactives\n";
          echo "</form>\n";
        } else {
          if ($in_confirm == 1) {
            $q_p->data_seek(0);
            $ins_result = "";
            $rescode = generateRandomString(5);
            while ($p_p = $q_p->fetch_object()) {
              $valvalue = receive_variable("POST", "dm_".$p_p->prod_id);
              if ($valvalue == "on") {
                $p_ins  = "insert into RESERVATIONS (res_date, res_name, res_email, prod_id, ";
                $p_ins .= "res_code, res_status, res_createddate, res_createdip) VALUES(";
                $p_ins .= "'$today', '$in_name', '$in_email', '$p_p->prod_id', '$rescode', '0', ";
                $p_ins .= "'$date $time', '$user_ip');";
                $q_ins = db_query($p_ins);
                if ($dblink->error == null) {
                  $ins_result .= $label_ok;
                } else {
                  $ins_result .= $label_nook;
                }
                opslog("#UserID# $skcv_user #Action# DailyMenu #WebHash# $skcv_hash #Result# OK $l_dmaddreserve $l_name: $in_name $l_email: $in_email $l_date: $today $l_product: $p_p->prod_id $l_code: $rescode");
              }
            }
            echo "<tr>\n";
            echo " <td valign=\"top\" align=\"left\">$l_updatingok:</td>\n";
            echo " <td valign=\"top\" align=\"left\">$ins_result</td>\n";
            echo "</tr>\n";
            echo "</table>\n";
            echo "$l_important:<br />$l_dmreservationwaitemail<br />";
            // Now, send the email
            $email_msg  = $l_dmreservationemailbefore;
            $q_p->data_seek(0);
            while ($p_p = $q_p->fetch_object()) {
              $txtprice = "";
              $s_pr = "select * from PRICES where price_status='1' and prod_id='$p_p->prod_id' order by price_createddate limit 1;";
              $q_pr = db_query($s_pr);
              $p_pr = $q_pr->fetch_object();
              $txtprice = number_format($p_pr->price_price,2);
              $valvalue = receive_variable("POST", "dm_".$p_p->prod_id);
              if ($valvalue == "on") {
                $email_msg .= " - $p_p->prod_name - $l_currency $txtprice\n";
                $selprods++;
              }
            }
            $email_msg .= "\n";
            $email_msg .= $l_dmreservationemailafter;
            $email_msg .= $site_url."/v1/resto/dailymenu.php?code=$rescode\n";
            $email_msg .= "\n";
            $email_msg .= $l_dmreservationemailfooter;
            $email_msg = str_replace("%name%", $in_name, $email_msg);
            $mail_headers  = "From: $site_from <$site_email>" . PHP_EOL .
                             "Date: ".date("r (T)") . PHP_EOL .
                             "Reply-To: $site_email" . PHP_EOL .
                             "X-Mailer: PHP/" . phpversion(); 
            $mail_headers2 = "-f".$site_email;
            mail($in_email, $l_dmreservationemailsubject, $email_msg, $mail_headers, $mail_headers2);
          } else {
            echo "<input type=\"hidden\" name=\"in_name\" value=\"$in_name\">\n";
            echo "<input type=\"hidden\" name=\"in_email\" value=\"$in_email\">\n";
            echo "<input name=\"in_reserve\" value=\"1\" type=\"hidden\">\n";
            echo "<input name=\"in_verify\" value=\"1\" type=\"hidden\">\n";
            echo "<input name=\"in_confirm\" value=\"1\" type=\"hidden\">\n";
            echo "</table>\n";
            $reset = "<a href=\"$PHPSELF\"><button type=\"button\" class=\"btn btn-danger\">$l_no</button></a>";
            $submit = "<button type=\"submit\" class=\"btn btn-success\">$l_confirm</button>";
            echo "$reset &nbsp;&nbsp;&nbsp; $submit";
          }
        }
        echo "</form>\n";
      } else {
        echo "<b>$l_dmreservations</b><br />\n";
        echo "$l_dmreservationstext<br />\n";
        echo "<form method=\"post\" action=\"".$_SERVER['REQUEST_URI']."\">\n";
        echo "<table border=\"0\" style=\"border-collapse: collapse; margin: 1.5em; font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif; font-size=10px;\">\n";
        echo " <tr>\n";
        echo "  <td>$l_date:</td>\n";
        echo "  <td>$today</td>\n";
        echo " </tr>\n";
        echo " <tr>\n";
        echo "  <td>$l_name:</td>\n";
        echo "  <td><input type=\"text\" value=\"\" name=\"in_name\" placeholder=\"$l_name\"></td>\n";
        echo " </tr>\n";
        echo " <tr>\n";
        echo "  <td>$l_email:</td>\n";
        echo "  <td><input type=\"text\" value=\"\" name=\"in_email\" placeholder=\"$l_email\"></td>\n";
        echo " </tr>\n";
        echo " <tr>\n";
        echo "  <td valign=\"top\" align=\"left\">$l_menu:</td>\n";
        $txtdailymenu = "";
        $s_p = "select * from DAILYMENU d, PRODUCTS p where d.prod_id=p.prod_id and dm_date='$today' and dm_status='1' order by prod_name;";
        $q_p = db_query($s_p);
        while ($p_p = $q_p->fetch_object()) {
          $txtprice = "";
          $s_pr = "select * from PRICES where price_status='1' and prod_id='$p_p->prod_id' order by price_createddate limit 1;";
          $q_pr = db_query($s_pr);
          $p_pr = $q_pr->fetch_object();
          $txtprice = number_format($p_pr->price_price,2);
          $txtdailymenu .= "  <input type=\"checkbox\" name=\"dm_$p_p->prod_id\"> $p_p->prod_name - $l_currency $txtprice<br />\n";
        }
        echo "  <td valign=\"top\" align=\"left\">$txtdailymenu</td>";
        echo " </tr>\n";
        echo "<input name=\"in_reserve\" value=\"1\" type=\"hidden\">\n";
        echo "<input name=\"in_verify\" value=\"1\" type=\"hidden\">\n";
        echo "</table>\n";
        $reset = "<a href=\"$PHPSELF\"><button type=\"button\" class=\"btn btn-danger\">$l_no</button></a>";
        $submit = "<button type=\"submit\" class=\"btn btn-success\">$l_dmaddreserve</button>";
        echo "$reset &nbsp;&nbsp;&nbsp; $submit";
        echo "</form>\n";
      }
    } else {
      // Search menu for today
      $s_dm = "select * from DAILYMENU d, PRODUCTS p where d.prod_id=p.prod_id and dm_status='1' and dm_date='$today' order by p.prod_name;";
      $q_dm = db_query($s_dm);
      if ($q_dm->num_rows <= 0) {
        echo "$l_dmnomenu<br />\n";
      } else {
        echo "$l_dmtoday<br />\n";
        echo "<table border=\"0\" style=\"border-collapse: collapse; margin: 1.5em; font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif; font-size=10px;\">\n";
        while ($p_dm=$q_dm->fetch_object()) {
          echo "<tr>\n";
          echo "  <td valign=\"top\" align=\"left\">";
          $s_ph = "select * from PHOTOS where photo_status='1' and photo_cat='2' and photo_prodcat='$p_dm->prod_id' order by rand() limit 1;";
          $q_ph = db_query($s_ph);
          if ($q_ph->num_rows != 0) {
            $p_ph = $q_ph->fetch_object();
            echo "<img src=\"$webphotos/$p_ph->photo_filename\" alt=\"$p_ph->photo_desc\" width=\"200\">";
          }
          echo "</td>\n";
          echo "  <td><font size=\"1\">&nbsp;</font></td>\n";
          echo "  <td style=\"border-bottom: 1px solid \"valign=\"top\" align=\"left\">$p_dm->prod_name</td>\n";
          echo "  <td style=\"border-bottom: 1px solid \"><font size=\"1\">&nbsp;</font></td>\n";
          $showprice = $l_currency. " ";
          $s_price = "select * from PRICES where prod_id='$p_dm->prod_id' and price_status='1' order by price_createddate limit 1;";
          $q_price = db_query($s_price);
          $p_price = $q_price->fetch_object();
          $showprice .= number_format($p_price->price_price,2);
          echo "  <td style=\"border-bottom: 1px solid \"valign=\"top\" align=\"left\">$showprice</td>\n";
          echo "  <td style=\"border-bottom: 1px solid \"><font size=\"1\">&nbsp;</font></td>\n";
          echo "  <td style=\"border-bottom: 1px solid \"><font size=\"1\">&nbsp;</font></td>\n";
          echo "  <td style=\"border-bottom: 1px solid \"valign=\"top\" align=\"left\">$p_dm->prod_desc</td>\n";
          echo "</tr>\n";
        }
        echo "</table>\n";
        echo "<br /><br />\n";
        if ( ($time > $dmtime_start) and ($time < $dmtime_end) ) {
          echo "<form method=\"post\" action=\"".$_SERVER['REQUEST_URI']."\">\n";
          echo "<input name=\"in_reserve\" value=\"1\" type=\"hidden\">\n";
          echo "<button type=\"submit\" class=\"btn btn-xs btn-link\"><i class=\"fa fa-plus\"> $l_presshere</i></button> $l_dmdoreservation\n";
          echo "</form>\n";
        } else {
          echo "Lo siento,ya no es hora de hacer reservas";
        }
      }
    }
  }
  include_once("$pathinc/footer.phpinc");
  include_once("$pathinc/dbclose.phpinc");
?>
