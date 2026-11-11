<?php
  require_once("config.php");
  require_once("system/NTSystem.php");
  require_once("js/class_uzivatelske_parametry.php");
  require_once ("sysdb/class_mysql_select.php");

  //zapis hlavicky html
  echo '
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Strict//EN">
    <html>
    <head>
      <meta http-equiv="content-type" content="text/html; charset=utf-8">
      <title>Konfigurator Triton</title>
      <link rel="icon" href="data:;base64,iVBORw0KGgo=">
      <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Open Sans" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="lib/css/jquery-ui.min.css">
      <link rel="stylesheet" type="text/css" href="lib/css/jquery-ui.structure.min.css">
      <link rel="stylesheet" type="text/css" href="lib/css/jquery-ui.theme.min.css">
      <link rel="stylesheet" type="text/css" href="css/konfigurator.css">
    </head>

    <body>
      <div id="loader2"></div>
      <img id="loader" src="css/img/loading.gif" style="position: absolute; top: 250px; left: 300px;">
      <div id="debug" style="display:none; position: absolute; top: 0px; left: 0px;"></div>

      <div id="main_form" style="display:none;">
        <div id="zahlavi" style="display:none;" class="zahlavi">
          <img style="position: absolute; width: 153px; height: 55px; left: 0px;" alt="Logo" src="images/logo.png" align="top">
          <img style="position: absolute; width: 500px; height: 81px; left: 194px;" alt="Triton" src="images/panorama.jpg" align="top">

          <select id="vyberJazyka"  size="1"  style="position:absolute;  left:10px; top:60px; background-color: white; color: black; width: 130px;">
          <option value="0">čeština</option>
          <option value="1">english</option>
          <option value="2">deutsch</option>
          <option value="3">en français</option>
          <option value="4">polski</option>
          <option value="5">русский</option>
          <option value="6">norsk</option>
          <option value="7">nederlands</option>
          <option value="8">italiano</option>
          </select>
        </div>

        <div id="nadpis" style="display:none; position: absolute; top: 90px; left:0px; width: 715px; text-align: center; margin: 0px auto"></div>
        <div id="user_info" style="display:none; position: absolute; top: 170px; left:0px; width: 715px; text-align: center; margin: 0px auto" ></div>

        <div id="info_triton" style="display:none; position: absolute; top: 10px; left:5px; width: 715px;"></div>


        <div id="cfg_form" style="display:none; position: absolute;" class="cfg_form" > </div>
      </div>

      <div id="send_form" style="display:none; position: absolute;">
        <div id="send_form_produkt"></div>
        <p>
        <div id="send_form_pokyny">Po vyplnění všech polí poptávkového formuláře je možné odeslat dotaz
            ohledně konfigurovaného produktu.<br>Všechna pole označená hvězdičkou jsou povinná.</div>
        </p>
        <span id="send_form_email_info">
          <p>
            <label id="send_form_lname">Jméno:</label><br>
            <input id="send_form_name" type="text"size = "40" name="send_form_name">
            <span id="send_form_err1" style="position: relative; left:10px; color: red;">*</span>
          </p>
          <p>
            <label id="send_form_lfirma">Firma:</label> <br>
            <input id="send_form_firma" size = "40" name="send_form_firma" minlength="2" type="text">
            <span id="send_form_err3" style="position: relative; left:10px; color: red;">*</span>
          </p>
          <p>
            <label id="send_form_lemail">E-mail:</label> <br>
            <input id="send_form_email" type="email" size = "40" name="send_form_email">
            <span id="send_form_err2" style="position: relative; left:10px; color: red;">*</span>
          </p>
          <p id="send_form_ico_p">
            <label id="send_form_lico">IČ:</label> <br>
            <input id="send_form_ico" size = "40" name="send_form_ico" minlength="2" type="text">
            <span id="send_form_err5" style="position: relative; left:10px; color: red;">*</span>
          </p>
          <p>
            <label id="send_form_ltel">Tel:</label> <br>
            <input id="send_form_tel" type="text" size = "40" name="send_form_tel">
            <span id="send_form_err4" style="position: relative; left:10px; color: red;">*</span>
          </p>
        </span>
        <p>
        <label id="send_form_lspecifikace">Specifikace:</label> <br>
          <textarea id="send_form_specifikace" style="width:650px; height:220px;" name="send_form_specifikace"></textarea>
        </p>
        <p>
          <label id="send_form_lmessage">Zpráva:</label> <br>
          <textarea id="send_form_message" style="width:650px; height:100px" name="send_form_specifikace"></textarea>
        </p>
        <p>
          <a style="display:none;font-style: italic;font-size:0.75em;" id="send_form_gdpr" href="">
            Informace o zpracování osobních údajů
          </a>
        </p>
        <button style="position:relative;  left:0px;"  class="tlacitko" id="send_form_send_btn">Odešli poptávku</button>
        <button style="position:relative;  left:20px;"  class="tlacitko" id="send_form_zpet_btn">Zpět</button>
      </div>


      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
      <script type="text/javascript" src="lib/jquery.selectboxes.min.js"></script>
      <script type="text/javascript" src="lib/jquery-ui.min.js"></script>

      <!-- <script type="text/javascript" src="lib/jquery.localisation.min.js"></script>
      <script type="text/javascript" src="lib/jquery.validate.min.js"></script>
      -->

      <script type="text/javascript" src="syspar.js"></script>
      <script type="text/javascript" src="globals.js"></script>
      <script type="text/javascript" src="start.js"></script>

      <script type="text/javascript" src="system/dialogy.js"></script>
      <script type="text/javascript" src="system/funkce.js"></script>
      <script type="text/javascript" src="system/debug.js"></script>


      <script type="text/javascript" src="js/system.js"></script>
      <script type="text/javascript" src="js/preklady.js"></script>
      <script type="text/javascript" src="js/parametry.js"></script>
      <script type="text/javascript" src="js/screen.js"></script>
      <script type="text/javascript" src="js/konfigurator.js"></script>
      <script type="text/javascript" src="js/konfiguratorSR.js"></script>

      <script type="text/javascript" src="js/ceny.js"></script>
      <script type="text/javascript" src="js/mail.js"></script>
      <script type="text/javascript" src="js/nabidka.js"></script>

      <script type="text/javascript" language="javascript">
  ';

  $system = new NTSystem();

  //u interni verze nastavim cfg_ver dle IP adresy
  $myIP =  $system->getIP();

  $curr_session = array();

  if (isset($_REQUEST['v'])){
    $curr_session["cfg_ver"] = $_REQUEST['v'];
  }else{
    if ((DEVELOP_VERSION==1)||($myIP=='192.168.169.23')){
      $curr_session["cfg_ver"] = 'tomik';
    }else{
      if (CFG_PUBLIC==0){
        switch (substr($myIP,0,11)){
          case '192.168.168':
          case '192.168.169':
          case '192.168.171':
            $curr_session["cfg_ver"] = 'materov';
            break;
          case '192.168.164':
            $curr_session["cfg_ver"] = 'chemnitz';
            break;
        };
      }else{
        $curr_session["cfg_ver"] = 'triton';
      };
    };
  };

  if ($curr_session["cfg_ver"] == 'triton'){
    $curr_session["cfg_dist"] = isset($_REQUEST['d'])?$_REQUEST['d']:"";
  }else{
    $curr_session["cfg_dist"] = "";
  }

  $iso_lng = isset($_REQUEST['lang'])?$_REQUEST['lang']:substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

  try{
    $zdroj = new stdClass;

    $zdroj->tables = array();
    $zdroj->tables[] = array('name'=>"jazyky");

    $zdroj->filters  = "   (oznaceni='$iso_lng')";

    $db = new MySQLSelect($zdroj);

    if (!($db->getFirst())){
      throw new Exception("Cannot set proper language $iso_lng");
    }else{
      $curr_session["cfg_lng"] = $db->getCurrRec()['id'];

      $curr_session_utc = time();
      $sql  = "INSERT INTO ".DB_PREFIX."session (id, utc, cfg_ver, cfg_lng, cfg_dist) VALUES (";
      $sql .= "NULL, '".$curr_session_utc."', '".$curr_session["cfg_ver"]."', ".$curr_session["cfg_lng"].",'".$curr_session["cfg_dist"]."'); ";

      $db = new MySQL(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
      if ($ret = $db->query($sql)){
        $curr_session_id= $db->insert_id;
      }else{
        $curr_session_id = 0;
      };
      //echo "console.log('INDEX: NEW ID: ',$curr_session_id);";
      if ($curr_session_id>0){
        $uzivatelskeParametry = new uzivatelskeParametry($curr_session_id,$curr_session_utc);
        $hodnotyUzivatelskychParametru = $uzivatelskeParametry->vratParametry();
        $hodnotyUzivatelskychParametru->par['clientIP'] = $system->getIP();

      }else{
        $hodnotyUzivatelskychParametru = new stClass;
        $hodnotyUzivatelskychParametru->is_error=true;
        $hodnotyUzivatelskychParametru->error_msg = "System error. Cannot set new session!";
      };

      if (!$hodnotyUzivatelskychParametru->is_error){
        foreach ( $hodnotyUzivatelskychParametru->par as $key=>$value) {
          echo "uzivatelskeParametry['$key'] = '$value';";
        };
        echo "uzivatelskeParametry['DEVELOP_VERSION'] = ".DEVELOP_VERSION.";";
        //echo "console.log('INDEX: uzivatelskeParametry:',uzivatelskeParametry);";
        echo 'system_start();';
      }else{
        echo '$("#loader") .hide();';
        echo 'alertUI("'.$hodnotyUzivatelskychParametru->error_msg.'","System Error");';
      }
    };
  }catch   (Exception $e){
    echo '$("#loader") .hide();';
    echo "alertUI('".$e->getMessage()."','System Error');";
  }finally{
    echo '</script>';
    echo '</body></html>';
  };



?>