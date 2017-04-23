<?php

  if (isset($_POST['newColor'])) {
    $colorDirPath = "color";
	$color = $_POST['newColor'];
    $newColor = "$colorDirPath/$color";
    $save = "background-image:url($newColor);";
    $file = "../library/banner.css";
    $fp = fopen($file, "w+");
      $write = fwrite($fp, "div.banner { $save }");
    fclose($fp); 
		
    if ($write) {
	  //color has been changed
	  header("location: {$_SERVER['HTTP_REFERER']}");
	} else {
	    echo "Color Change Failed";
		exit;
	  }
  }

  echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';

?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title>Manage Banner Color</title>
  
  <link rel="stylesheet" type="text/css" href="../library/jobhut.css" />
  <link rel="stylesheet" type="text/css" href="../library/banner.css" />
</head>

<body>

<div class="content">
  <div class="banner">
    Jobhut
      <img src="../library/logo.gif" alt="logo" class="logo" />
  </div>

  <div class="leftLinks">
  </div>

  <div class="pageHead">
    Select banner color
  </div>

  <div class="info">
    <form name="colors" id="colors" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <select name="newColor" id="newColor">
        <option value="banner_bg.jpg">Original</option>
		<option value="bg_red.jpg">Red</option>
		<option value="bg_silverred.jpg">Red Steel</option>
		<option value="bg_pink.jpg">Pink</option>
		<option value="bg_orange.jpg">Orange</option>
		<option value="bg_silverorange.jpg">Orange Steel</option>
		<option value="bg_yellow.jpg">Yellow</option>
		<option value="bg_yellow2.jpg">Yellow Steel</option>
		<option value="bg_gold.jpg">Gold</option>
		<option value="bg_green.jpg">Green</option>
        <option value="bg_darkgreen.jpg">Dark Green</option>
		<option value="bg_silvergreen.jpg">Green Steel</option>
		<option value="bg_lightsilvergreen.jpg">Light Green Steel</option>
        <option value="bg_darkblue.jpg">Dark Blue</option>
		<option value="bg_lightblue.jpg">Light Blue</option>
		<option value="bg_silverblue.jpg">Blue Steel</option>
		<option value="bg_lightsilverblue.jpg">Light Blue Steel</option>
		<option value="bg_purple.jpg">Purple</option>
		<option value="bg_lightpurple.jpg">Light Purple</option>
		<option value="bg_silverpurple.jpg">Purple Steel</option>
        <option value="bg_brown.jpg">Brown</option>
        <option value="bg_gray.jpg">Gray</option>
		<option value="bg_steel.jpg">Steel</option>
		<option value="bg_black.jpg">Black</option>
      </select>
      
      <input type="submit" value="Change Color" /> 
    </form>
  </div>
</div>

</body>

</html>
