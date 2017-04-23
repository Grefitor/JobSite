<?php

require './library/process.php';

validateUser();

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';

?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title><?php echo COMPANY; ?> - Insert</title>
  
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
    Insert job into <?php echo COMPANY; ?>
  </div>
  <div class="info"> <!-- CONTENT GOES HERE-->

    <form action="./process/processInsert.php" method="post" onsubmit="return checkInsertForm(this);">
      <strong>Title:</strong><br /><input name="title" type="text" size="50" /><br />
      <br />
      <strong>Description:</strong><br /><textarea class="input" name="description" cols="70" rows="8"></textarea><br />
      <br />
      <strong>Status:</strong><br /><input type="radio" name="status" value="F" />Full-time&nbsp;
                                    <input type="radio" name="status" value="P" />Part-time&nbsp;
                                    <input type="radio" name="status" value="C" />Contract&nbsp;
                                    <input type="radio" name="status" value="O" checked="checked" />Other<br />
	  <br />
      <strong>Salary:</strong><br /><input name="salary" type="text" />&nbsp;
                                    <input type="radio" name="measure" value="H" />Hourly&nbsp;
                                    <input type="radio" name="measure" value="W" />Weekly&nbsp;
                                    <input type="radio" name="measure" value="M" />Monthly&nbsp;
                                    <input type="radio" name="measure" value="A" />Annually&nbsp;
                                    <input type="radio" name="measure" value="O" checked="checked" />Other<br />
	  <br />
      <strong>Category:</strong><br /><?php listBox('category[]', 'SELECT pk AS field1, name AS field2 FROM category WHERE active = 1 ORDER BY name ASC', 1, 5, 0); ?><br />
      <br />
      <strong>Location:</strong><br /><?php listBox('location[]', 'SELECT pk AS field1, name AS field2 FROM location WHERE active = 1 ORDER BY name ASC', 1, 5, 0); ?><br />
      <br />
      <input name="submit" type="submit" value="Insert" />
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