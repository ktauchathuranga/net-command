<?php
    require_once "database.php";
?>

<!DOCTYPE html>
<html style="font-size: 16px;" lang="en"><head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="robots" content="noindex">
    <title>Net Command</title>
    <link rel="icon" type="image/x-icon" href="images/logo.ico">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    
    <script>
        $(document).ready(function(){
            setInterval(function(){
                $("#refresh").load(window.location.href + " #refresh");
            }, 1000);
        });
    </script>


    <link rel="stylesheet" href="nicepage.css" media="screen">
<link rel="stylesheet" href="index.css" media="screen">
    <script class="u-script" type="text/javascript" src="nicepage.js" defer=""></script>
    <meta name="generator" content="Nicepage 5.12.8, nicepage.com">
    <link id="u-theme-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i|Bebas+Neue:400">
    <link id="u-page-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Darker+Grotesque:300,400,500,600,700,800,900">
    
    
    <script type="application/ld+json">{
		"@context": "http://schema.org",
		"@type": "Organization",
		"name": "",
		"url": "/"
}</script>
    <meta name="theme-color" content="#478ac9">
    <meta property="og:title" content="NetCommand">
    <meta property="og:type" content="website">
    <link rel="canonical" href="/">
  <meta data-intl-tel-input-cdn-path="intlTelInput/"></head>
  <body class="u-body u-xl-mode" data-lang="en">
    <section class="u-clearfix u-container-align-center u-image u-section-1" id="sec-9812" data-image-width="1024" data-image-height="683">
      <div class="u-align-center u-container-align-center u-container-style u-grey-80 u-group u-radius-39 u-shape-round u-group-1">
        <div class="u-container-layout u-container-layout-1">
          <h3 class="u-align-center u-text u-text-1">
          <div id="refresh">
                <?php
                  $sql = "SELECT * FROM toggle_state";
                  $results = mysqli_query($conn, $sql);
                  $row = mysqli_fetch_assoc($results);
              
                  if ($row["status"] == 0) {
                    echo '<span style="color: lime; font-family: \'Bebas Neue\';">DEACTIVATED!</span>';
                  } elseif ($row["status"] == 1) {
                      echo '<span style="color: red; font-family: \'Bebas Neue\';">ACTIVATED!</span>';
                  } else {
                      echo "DB ERROR OCCURRED! - #1";
                  }
                ?>
            </div>
          </h3>
          <h5 class="u-align-center u-custom-font u-text u-text-palette-1-dark-1 u-text-2">Net Command</h5>
          <img class="u-image u-image-contain u-image-default u-preserve-proportions u-image-1" src="images/logo.png" alt="" data-image-width="1280" data-image-height="1280">
          <p class="u-align-center u-text u-text-3"> Experience Remote Control Revolution with NetCommand: Unleash Your Power from Anywhere<br>
          </p>
          <form action="index" method="post">
              <button type="submit" name="toggleButton" class="u-active-white u-align-center u-border-none u-btn u-btn-round u-button-style u-hover-feature u-hover-white u-palette-1-dark-1 u-radius-41 u-text-active-black u-text-body-alt-color u-text-hover-black u-btn-1">PRESS</button>
            </form>
          <p class="u-align-center u-text u-text-palette-1-dark-1 u-text-4">
            <a class="u-btn u-button-link u-button-style u-none u-text-palette-1-base u-btn-2" href="https://github.com/ktauchathuranga/net-command" target="_blank">Net Command</a>
          </p>
          <quillbot-extension style="position: absolute; top: 0px; pointer-events: none;" class="u-absolute-hcenter"></quillbot-extension>
          <quillbot-extension-highlights style="position: absolute; top: 0px; pointer-events: none;" class="u-absolute-hcenter"></quillbot-extension-highlights>
        </div>
      </div>
      
    </section>
</body></html>

<?php

    if (isset($_POST["toggleButton"])) {
        $sql = "SELECT * FROM toggle_state";
        $results = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($results);
        
        if ($row["status"] == 0) {
            $update = mysqli_query($conn, "UPDATE toggle_state SET `status` = 1 WHERE `id` = 1");
        } elseif ($row["status"] == 1) {
            $update = mysqli_query($conn, "UPDATE toggle_state SET `status` = 0 WHERE `id` = 1");
        } else {
            echo "DATABASE ERROR OCCURRED! - #2";
        }

    }

?>