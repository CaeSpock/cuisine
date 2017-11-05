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
  // session_destroy();
  session_start();
 // session_regenerate_id(true);
   $user_session = session_id();
  header('Content-Type: text/html; charset=iso-8859-1');

     $pathinc = "inc";
     $pathimg = "img";
  $pathlogops = "/home/cuisine/logs/operaciones";
  $pathlogsql = "/home/cuisine/logs/sql";
  $pathphotos = "/home/cuisine/public_html/photos";
   $webphotos = "/cuisine/photos";
    $pathppal = ".";

  // This include uses the full path to the file, as its loated outside of the web directory
  include_once("/home/cuisine/conf/admin.conf.phpinc");
  include_once("$pathinc/langs/$language.phpinc");
  include_once("$pathinc/func.phpinc");
  include_once("$pathinc/dbopen.phpinc");

  // Vaciamos variables
  $skcv_user_id = null;
  $skcv_level_id = null;
  $skcv_user_email = null;
  $skcv_phonenumber = null;
  $skcv_user_name = null;

  // Leemos variables
  $logout_attempt = (isset($_POST['logout_attempt']) ? $_POST['logout_attempt'] : null);
  $login_attempt = (isset($_POST['login_attempt']) ? $_POST['login_attempt'] : null);
  $login_username = (isset($_POST['login_username']) ? $_POST['login_username'] : null);
  $login_password = (isset($_POST['login_password']) ? $_POST['login_password'] : null);
  $skcv_user = (isset($_SESSION["skcv_user"]) ? $_SESSION["skcv_user"] : null);
  $skcv_hash = (isset($_SESSION["skcv_hash"]) ? $_SESSION["skcv_hash"] : null);

  // Intento de ingreso al sistema
  if ($login_attempt == 1) {
    $q_login  = "select * from USERS where user_username='$login_username' and user_password='$login_password' ";
    $q_login .= "and user_status='2';";
    $p_login = db_query($q_login);
    if ($p_login->num_rows == 1) {
      $us = $p_login->fetch_object();
      // Crear cookies
      // 2 horas de validez (Si está idle por más de este tiempo la cookie expira)
      $expire=time()+60*60*2;
      $key = md5(microtime().rand());
      $_SESSION["skcv_user"] = $us->user_id;
      $_SESSION["skcv_hash"] = $key;
      // Update a la base
      $expirafecha = date("Y-m-d H:i:s", $expire);
      $q_update  = "update USERS set user_login='1', user_loginhash='$key', ";
      $q_update .= "user_loginsession='$user_session', ";
      $q_update .= "user_loginfrom='$user_ip', user_loginclient='$user_client', ";
      $q_update .= "user_logindatetime='$date $time', user_loginexpires='$expirafecha' ";
      $q_update .= "where user_id='$us->user_id' and user_status='2';";
      $p_update = db_query($q_update);
      opslog("#UserID# $us->user_id #Action# Login #WebHash# $key #Username# $us->user_username");
      // Listo, logueado
      $header = "Location: system/";
      header($header);
      exit;
    }
  }
  include_once("$pathinc/expire.phpinc");
  echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
  echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">\n";
  echo "  <head>\n";
  echo "    <meta charset=\"iso-8859-1\" />\n";
  echo "    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\n";
  echo "    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\n";
  echo "    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />\n";
  echo "    <meta name=\"keywords\" content=\"admin restaurant food\" />\n";
  echo "    <meta name=\"description\" content=\"$site_name - $site_slogan\" />\n";
  echo "    <meta name=\"publisher\" content=\"Whitesith Solutions\" />\n";
  echo "    <meta name=\"copyright\" content=\"&copy; 2017 - WhiteSith Solutions\" />\n";
  echo "    <meta name=\"author\" content=\"Carlos Anibarro <CAnibarro(at)whitesith(dot)com>\" />\n";
  echo "    <meta name=\"distribution\" content=\"IU\" />\n";
  echo "    <!-- Web Design based on the SIMINTA Bootstrap Design by Randy Riolis https://github.com/r4nd1/template-cpanel-siminta -->\n";
  include_once("$pathinc/rightclick.phpinc");
  echo "    <title>.: $site_name :.</title>\n";
  // echo "    <!-- Core CSS - Include with every page -->\n";
  echo "    <link href=\"assets/plugins/bootstrap/bootstrap.css\" rel=\"stylesheet\" />\n";
  echo "    <link href=\"assets/font-awesome/css/font-awesome.css\" rel=\"stylesheet\" />\n";
  echo "    <link href=\"assets/plugins/pace/pace-theme-big-counter.css\" rel=\"stylesheet\" />\n";
  echo "    <link href=\"assets/css/style.css\" rel=\"stylesheet\" />\n";
  echo "    <link href=\"assets/css/main-style.css\" rel=\"stylesheet\" />\n";
  echo "  </head>\n";
  echo "  <body class=\"body-Login-back\">\n";
  echo "    <div class=\"container\">\n";
  echo "      <div class=\"row\">\n";
  echo "        <div class=\"col-md-4 col-md-offset-4 text-center logo-margin \">\n";
  echo "          <img src=\"assets/img/logo.png\" alt=\"\"/>\n";
  echo "        </div>\n";
  echo "        <div class=\"col-md-4 col-md-offset-4\">\n";
  echo "          <div class=\"login-panel panel panel-default\">\n";
  echo "            <div class=\"panel-heading\">\n";
  echo "              <h3 class=\"panel-title\">$l_pleaselogin</h3>\n";
  echo "            </div>\n";
  echo "            <div class=\"panel-body\">\n";
  echo "              <form role=\"form\" method=\"post\" action=\"".$_SERVER['PHP_SELF']."\" autocomplete=\"off\">\n";
  echo "                <fieldset>\n";
  echo "                  <div class=\"form-group\">\n";
  echo "                    <input class=\"form-control\" placeholder=\"$l_username\" name=\"login_username\" type=\"text\" autofocus>\n";
  echo "                  </div>\n";
  echo "                  <div class=\"form-group\">\n";
  echo "                    <input class=\"form-control\" placeholder=\"$l_password\" name=\"login_password\" type=\"password\" value=\"\">\n";
  echo "                  </div>\n";
  echo "                  <input type=\"hidden\" name=\"login_attempt\" value=\"1\">\n";
  echo "                  <button type=\"submit\" class=\"btn btn-success\">$l_login</button>\n";
  echo "                </fieldset>\n";
  /*
  echo "              <hr /> <br />\n";
  echo "              <font size=\"1\">\n";
  echo "              <i class=\"fa fa-bookmark\" > $user_ip</i><br />\n";
  echo "              <i class=\"fa fa-clone\" > $user_client</i>\n";
  echo "              </font>\n";
  */
  echo "              </form>\n";
  echo "            </div>\n";
  echo "          </div>\n";
  echo "        </div>\n";
  echo "      </div>\n";
  echo "    </div>\n";
  // echo "    <!-- Core Scripts - Include with every page -->\n";
  echo "    <script src=\"assets/plugins/jquery-1.10.2.js\"></script>\n";
  echo "    <script src=\"assets/plugins/bootstrap/bootstrap.min.js\"></script>\n";
  echo "    <script src=\"assets/plugins/metisMenu/jquery.metisMenu.js\"></script>\n";
  echo "  </body>\n";
  echo "</html>\n";
  include_once("$pathinc/dbclose.phpinc");
?>
