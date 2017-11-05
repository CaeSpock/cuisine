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
   session_start();
   $user_session = session_id();
  header('Content-Type: text/html; charset=iso-8859-1');

     $pathsys = "sistema";
     $pathinc = "../inc";
     $pathimg = "../img";
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
  $logout_attempt = (isset($_REQUEST['logout_attempt']) ? $_REQUEST['logout_attempt'] : null);
  $login_attempt = (isset($_POST['login_attempt']) ? $_POST['login_attempt'] : null);
  $login_username = (isset($_POST['login_username']) ? $_POST['login_username'] : null);
  $login_password = (isset($_POST['login_password']) ? $_POST['login_password'] : null);
  $skcv_user = (isset($_SESSION["skcv_user"]) ? $_SESSION["skcv_user"] : null);
  $skcv_hash = (isset($_SESSION["skcv_hash"]) ? $_SESSION["skcv_hash"] : null);

  if ($logout_attempt == 1) {
    // Forzar Logout del sistema
    opslog("#UserID# $skcv_user #Action# Logout #WebHash# $skcv_hash");
    // Actualizar base de datos
    $q_logout  = "update USERS set user_login='0', user_loginhash='', user_loginexpires='', ";
    $q_logout .= "user_loginsession='' where user_id='$skcv_user' and user_loginhash='$skcv_hash' ";
    $q_logout .= "and user_loginsession='$user_session';";
    $p_logout = db_query($q_logout);
    // Borrar variables
    $skcv_user = null;
    $skcv_hash = null;
    $skcv_user_id = null;
    $skcv_level_id = null;
    $skcv_user_email = null;
    $skcv_phonenumber = null;
    $skcv_user_name = null;
    $user_session = null;
    // Borrar cookies
    unset($_SESSION["skcv_user"]);
    unset($_SESSION["skcv_hash"]);
    // Listo, reiniciar
    // session_destroy();
    // session_start();
    // session_regenerate_id(true);
    $header = "Location: ../";
    header($header);
    exit;
  }

  if ($skcv_user!= null && $skcv_hash != null && $user_session != null) {
    $q_checklogin  = "select * from USERS where user_id='$skcv_user' and user_loginhash='$skcv_hash' ";
    $q_checklogin .= "and user_loginsession='$user_session' ";
    $q_checklogin .= "and user_status='2' and user_login='1' and user_loginexpires>'$date $time';";
    $p_checklogin = db_query($q_checklogin);
    if ($p_checklogin->num_rows == 1) {
      // Hay usuario, renovar tiempos y setear variables
      $us = $p_checklogin->fetch_object();
      // Resetear cookies con nuevo tiempo de expiración
      $expire=time()+60*60*3;
      $_SESSION["skcv_user"] = $skcv_user;
      $_SESSION["skcv_hash"] = $skcv_hash;
      // Actualizar Base
      $expirafecha = date("Y-m-d H:i:s", $expire);
      $q_updbase  = "update USERS set user_loginexpires='$expirafecha' ";
      $q_updbase .= "where user_id='$us->user_id' and user_status='2';";
      $p_updbase = db_query($q_updbase);
      // Crear datos de usuario
      $skcv_user_id = $us->user_id;
      $skcv_level_id = $us->level_id;
      $skcv_user_email = $us->user_email;
      $skcv_phonenumber = $us->user_phonenumber;
      $skcv_user_name = $us->user_name;
      // opslog("#UserID# $us->user_id #Action# Login[R] #WebHash# $us->usuario_loginhash");
      $webpage = $_SERVER['REQUEST_URI'];
      opslog("#UserID# $us->user_id #Action# WebPage #WebHash# $us->user_loginhash #Username# $us->user_username #WebPage# $webpage");
    } else {
      // NO hay usuario o ha expirado todo, borrar cookies, y reiniciar
      opslog("#UserID# $skcv_user #Action# Logout Forzado #WebHash# $skcv_hash");
      $skcv_user = null;
      $skcv_hash = null;
      $skcv_user_id = null;
      $skcv_level_id = null;
      $skcv_user_email = null;
      $skcv_phonenumber = null;
      $skcv_user_name = null;
      // Borrar cookies
      unset($_SESSION["skcv_user"]);
      unset($_SESSION["skcv_hash"]);
      // Listo, reiniciar
      $header = "Location: ../";
      header($header);
      exit;
    }
  } else {
    // NO hay usuario o ha expirado todo, borrar cookies y reiniciar
    opslog("#UserID# $skcv_user #Action# Logout Forzado #WebHash# $skcv_hash");
    $skcv_user = null;
    $skcv_hash = null;
    $skcv_user_id = null;
    $skcv_level_id = null;
    $skcv_user_email = null;
    $skcv_phonenumber = null;
    $skcv_user_name = null;
    // Borrar cookies
    unset($_SESSION["skcv_user"]);
    unset($_SESSION["skcv_hash"]);
    // Listo, reiniciar
    $header = "Location: ../";
    header($header);
    exit;
  }
  // OK Estamos adentro ahora si leemos las paginas a mostrar
  echo "<font size=\"1\">&nbsp;<br /></font>";
  $action = (isset($_GET['action']) ? $_GET['action'] : null);
  $verlog = (isset($_POST['verlog']) ? $_POST['verlog'] : null);
  if ($action == null) { $action = "dashboard"; }
  include_once("$pathinc/header.phpinc");
  include_once("$pathinc/permisos.phpinc");
  include_once("$pathinc/footer.phpinc");
  include_once("$pathinc/dbclose.phpinc");
?>
