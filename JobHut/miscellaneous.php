<?php

require './library/process.php';

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';

?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
  <title><?php echo COMPANY; ?> - Miscellaneous</title>
  
  <link rel="stylesheet" type="text/css" href="./library/jobhut.css" />
  <script src="./library/process.js"></script>
</head>

<body>
  <div>
    <?php userFeedback(); ?>
  
    <script language="javascript">
      setTimeout("self.close();", 3000);
    </script>
  </div>
</body>

</html>