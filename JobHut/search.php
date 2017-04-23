<?php

require './library/process.php';
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';

?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title><?php echo COMPANY; ?> - Search</title>
  
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
    Search for jobs in <?php echo COMPANY; ?> 
  </div>
  <div class="info"> <!-- CONTENT GOES HERE-->

    <form action="./process/processSearch.php" method="post">
      <strong>Keyword(s):</strong><br /><input name="keyword" type="text" size="50" /><br />
      <br />
      <strong>Category:</strong><br /><?php listBox('category[]', 'SELECT pk AS field1, name AS field2 FROM category WHERE active = 1 ORDER BY name ASC', 1, 5, 1); ?><br />
      <br />
      <strong>Location:</strong><br /><?php listBox('location[]', 'SELECT pk AS field1, name AS field2 FROM location WHERE active = 1 ORDER BY name ASC', 1, 5, 1); ?><br />
      <br />
      <input name="submit" type="submit" value="Search" />
    </form>

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