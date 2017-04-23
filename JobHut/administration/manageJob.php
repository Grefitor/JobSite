<?php

require '../library/process.php';

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';

if (isset($_GET['action'])) {
  connectDatabase();
  
  if ($_GET['action'] == 1) {
    $pk = $_POST['pk'];
    
    queryDatabase("UPDATE job
                   SET active = 0
                   WHERE pk = $pk");
  }
}



?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
  <title>Manage Job(s)</title>
  
  <script src="../library/process.js"></script>
</head>

<body>
<div>
  <fieldset>
    <legend>View 'Marked' Job(s)</legend>
  
    <form name="job" action="./manageJob.php?action=1" method="post">
      Job: <?php listBox('pk', 'SELECT pk AS field1, CONCAT(title, " - ", marked, " mark(s)") AS field2 FROM job WHERE marked > 0 AND active = 1 ORDER BY pk ASC'); ?><br />
      <input name="submit" type="submit" value="Delete Job" />
    </form>
  </fieldset>
  <fieldset>
    <legend>Browse 'Marked' Job(s)</legend>
<?php
    $result = queryDatabase("SELECT pk, title
                             FROM job
                             WHERE marked > 0 AND active = 1 ORDER BY pk ASC");
      
    while ($row = mysql_fetch_object($result)) {
      echo <<< END
<a href="javascript:popUp('../detail.php?pk=$row->pk&apply=1')">$row->title</a><br />
END;

    }

?>
  </fieldset>
</div>
</body>

</html>
