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
  $in_confirm = receive_variable("POST", "in_confirm");
  $in_sent = receive_variable("POST", "in_sent");
  $in_name = receive_variable("POST", "in_name");
  $in_email = receive_variable("POST", "in_email");
  $in_message = receive_variable("POST", "in_message");

  echo "$l_contactus<br />\n";
  if ($in_sent == 1) {
    if ($in_confirm == 1) {
      echo "$l_contactussending<br />\n\n";
      echo "<form method=\"post\" action=\"".$_SERVER['REQUEST_URI']."\">\n";
      echo "<table border=\"0\" style=\"border-collapse: collapse; margin: 1.5em; font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif; font-size=10px;\">\n";
      $in_datetime = date("Y-m-d H:i:s");
      echo "<tr>\n";
      echo " <td valign=\"top\" align=\"left\">$l_datetime:</td>\n";
      echo " <td valign=\"top\" align=\"left\">$in_datetime</td>\n";
      echo "</tr>\n";
      echo "<tr>\n";
      echo " <td valign=\"top\" align=\"left\">$l_ip:</td>\n";
      echo " <td valign=\"top\" align=\"left\">$user_ip</td>\n";
      echo "</tr>\n";
      echo "<tr>\n";
      echo " <td valign=\"top\" align=\"left\">$l_name:</td>\n";
      echo " <td valign=\"top\" align=\"left\">$in_name</td>\n";
      echo "</tr>\n";
      echo "<tr>\n";
      echo " <td valign=\"top\" align=\"left\">$l_email:</td>\n";
      echo " <td valign=\"top\" align=\"left\">$in_email</td>\n";
      echo "</tr>\n";
      echo "<tr>\n";
      echo " <td valign=\"top\" align=\"left\">$l_message:</td>\n";
      echo " <td valign=\"top\" align=\"left\">$in_message</td>\n";
      echo "</tr>\n";
      echo "</table>\n";
      echo "</form>\n";
      $email_msg  = $l_contactusemailbef."\n\n";
      $email_msg .= "$l_datetime: $datetime\n";
      $email_msg .= "$l_ip: $user_ip\n";
      $email_msg .= "$l_name: $in_name\n";
      $email_msg .= "$l_email: $in_email\n";
      $email_msg .= "$l_message:\n$in_message\n";
      $email_msg .= "\n\n";
      $mail_headers  = "From: $site_from <$site_email>" . PHP_EOL .
                       "Date: ".date("r (T)") . PHP_EOL .
                       "Reply-To: $site_email" . PHP_EOL .
                       "X-Mailer: PHP/" . phpversion();
      $mail_headers2 = "-f".$site_email;
      mail($site_email, $l_contasctussubject, $email_msg, $mail_headers, $mail_headers2);
      echo "</form>\n";
      opslog("#UserID# $skcv_user #Action# ContactUs #WebHash# $skcv_hash #Result# OK $user_ip $in_name $in_email $in_message");
    } else {
      echo "$l_contactusconfirm:<br />\n\n";
      echo "<form method=\"post\" action=\"".$_SERVER['REQUEST_URI']."\">\n";
      echo "<table border=\"0\" style=\"border-collapse: collapse; margin: 1.5em; font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif; font-size=10px;\">\n";
      $in_datetime = date("Y-m-d H:i:s");
      echo "<tr>\n";
      echo " <td valign=\"top\" align=\"left\">$l_datetime:</td>\n";
      echo " <td valign=\"top\" align=\"left\">$in_datetime</td>\n";
      echo "</tr>\n";
      echo "<tr>\n";
      echo " <td valign=\"top\" align=\"left\">$l_ip:</td>\n";
      echo " <td valign=\"top\" align=\"left\">$user_ip</td>\n";
      echo "</tr>\n";
      echo "<tr>\n";
      echo " <td valign=\"top\" align=\"left\">$l_name:</td>\n";
      echo " <td valign=\"top\" align=\"left\">$in_name</td>\n";
      echo "</tr>\n";
      echo "<tr>\n";
      echo " <td valign=\"top\" align=\"left\">$l_email:</td>\n";
      echo " <td valign=\"top\" align=\"left\">$in_email</td>\n";
      echo "</tr>\n";
      echo "<tr>\n";
      echo " <td valign=\"top\" align=\"left\">$l_message:</td>\n";
      echo " <td valign=\"top\" align=\"left\">$in_message</td>\n";
      echo "</tr>\n";
      echo "<input name=\"in_name\" value=\"$in_name\" type=\"hidden\">\n";
      echo "<input name=\"in_email\" value=\"$in_email\" type=\"hidden\">\n";
      echo "<input name=\"in_message\" value=\"$in_message\" type=\"hidden\">\n";
      echo "<input name=\"in_sent\" value=\"1\" type=\"hidden\">\n";
      echo "<input name=\"in_confirm\" value=\"1\" type=\"hidden\">\n";
      echo "</table>\n";
      $reset = "<a href=\"$PHPSELF\"><button type=\"button\" class=\"btn btn-danger\">$l_no</button></a>";
      $submit = "<button type=\"submit\" class=\"btn btn-success\">$l_confirm</button>";
      echo "$reset &nbsp;&nbsp;&nbsp; $submit";
      echo "</form>\n";
    }
  } else {
    echo "$l_contactuswrite:<br />\n\n";
    echo "<form method=\"post\" action=\"".$_SERVER['REQUEST_URI']."\">\n";
    echo "<table border=\"0\" style=\"border-collapse: collapse; margin: 1.5em; font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif; font-size=10px;\">\n";
    echo "<tr>\n";
    echo " <td valign=\"top\" align=\"left\">$l_name:</td>\n";
    echo " <td valign=\"top\" align=\"left\"><input type=\"text\" value=\"\" name=\"in_name\"></td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo " <td valign=\"top\" align=\"left\">$l_email:</td>\n";
    echo " <td valign=\"top\" align=\"left\"><input type=\"text\" value=\"\" name=\"in_email\"></td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo " <td valign=\"top\" align=\"left\">$l_message:</td>\n";
    echo " <td valign=\"top\" align=\"left\"><textarea name=\"in_message\"></textarea></td>\n";
    echo "</tr>\n";
    echo "<input name=\"in_sent\" value=\"1\" type=\"hidden\">\n";
    echo "</table>\n";
    $reset = "<a href=\"$PHPSELF\"><button type=\"button\" class=\"btn btn-danger\">$l_reset</button></a>";
    $submit = "<button type=\"submit\" class=\"btn btn-success\">$l_send</button>";
    echo "$reset &nbsp;&nbsp;&nbsp; $submit";
    echo "</form>\n";
  }
  include_once("$pathinc/footer.phpinc");
  include_once("$pathinc/dbclose.phpinc");
?>
