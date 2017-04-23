<?php

require './library/process.php';

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';

?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
  <title><?php echo COMPANY; ?> - Apply</title>
  
  <link rel="stylesheet" type="text/css" href="./library/jobhut.css" />
  <script src="./library/process.js"></script>
</head>

<body>
  <div>
    <form action="./process/processApply.php" method="post" onsubmit="return checkApplyForm(this);" enctype="multipart/form-data">
      <table cellpadding="5">
        <tr>
          <td align="right"><strong>Your name:</strong></td>
          <td><input name="name" type="text" /></td>
        </tr>
        <tr>
          <td align="right"><strong>Your email address:</strong></td>
          <td><input name="email" type="text" /></td>
        </tr>
        <tr>
          <td align="right"><strong>Attach your resume:</strong></td>
          <td><input type="hidden" name="MAX_FILE_SIZE" value="5000000" /><input name="resume" type="file" /></td>
        </tr>
        <tr>
          <td colspan="2"><strong>Insert your text message here:</strong></td>
        </tr>
        <tr>
          <td colspan="2"><textarea class="input" name="message" cols="55" rows="10"></textarea></td>
        </tr>
        <tr>
          <td><input name="submit" type="submit" value="Apply" /></td>
          <td>&nbsp;</td>
        </tr>
      </table>
      
      <?php echo "<input name=\"pk\" type=\"hidden\" value=\"" . $_GET['pk'] . "\" />"; ?>
    </form>
  </div>
</body>

</html>