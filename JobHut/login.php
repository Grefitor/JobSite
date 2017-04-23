<?php

require './library/process.php';
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';

?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title><?php echo COMPANY; ?> - Login</title>
  
  <script src="./library/process.js"></script>
  <link rel="stylesheet" type="text/css" href="./library/jobhut.css" />
  <link rel="stylesheet" type="text/css" href="./library/banner.css" />
</head>

<body>

<div class="content">
  <div class="banner">
    <?php echo COMPANY; ?>
    <img src="./library/logo.gif" alt="logo" class="logo" />
  </div>
  <div class="leftLinks">
    <div class="leftHead">Navigate</div>

    <div>
      <?php require './library/navigate.php'; ?>
    </div>
  </div>
  <div class="pageHead">
    Login to <?php echo COMPANY; ?> 
  </div>
  <div class="info"> <!-- CONTENT GOES HERE-->

  <?php userFeedback();
        activateUser(); ?>
  
  <div>
    <form action="./process/processLogin.php" method="post" onsubmit="return checkLoginForm(this);">
      <table>
        <tr>
          <td style="text-align:right;">
            <strong>Email/User ID:</strong>
          </td>
          <td>
            <input name="email" type="text" />
          </td>
        </tr>
        <tr>
          <td style="text-align:right;">
            <strong>Password:</strong>
          </td>
          <td>
            <input name="password" type="password" /> <a href="./forgot.php">Forgot password?</a>
          </td>
        </tr>
        <tr>
          <td>
            &nbsp;
          </td>
          <td>
            <input name="submit" type="submit" value="Login" />
          </td>
        </tr>
      </table>
    </form>
  </div>

  </div>
</div>

<div class="ad"> <!-- AD GOES HERE -->
<script type="text/javascript"><!--
google_ad_client = "pub-5053320853549583";
//120x600, created 12/26/07
google_ad_slot = "9579571877";
google_ad_width = 120;
google_ad_height = 600;
//--></script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>

</body>

</html>