<?php

require '../library/process.php';

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';

if (isset($_GET['action'])) {
  connectDatabase();
  
  if ($_GET['action'] == 1) {
    $name = $_POST['name'];
    
    queryDatabase("INSERT INTO location (name)
                   VALUES ('$name')");
  } elseif ($_GET['action'] == 2) {
    $pk = $_POST['pk'];
    $name = $_POST['name'];
    
    queryDatabase("UPDATE location
                   SET name = '$name'
                   WHERE pk = $pk");
  } elseif ($_GET['action'] == 3) {
    $pk = $_POST['pk'];
    
    queryDatabase("UPDATE location
                   SET active = 0
                   WHERE pk = $pk");
  }
}

?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
  <title>Manage Location</title>
  
  <script src="../library/process.js"></script>
</head>

<body>
<div>
  <fieldset>
    <legend>Insert Location</legend>
  
    <form name="location" action="./manageLocation.php?action=1" method="post">
      Name: <input name="name" type="text" /><br />
      <input name="submit" type="submit" value="Insert Location" />
    </form>
  </fieldset>
  
  <fieldset>
    <legend>Update Location</legend>
  
    <form name="location" action="./manageLocation.php?action=2" method="post">
      Old Name: <?php listBox('pk', 'SELECT pk AS field1, name AS field2 FROM location ORDER BY name ASC'); ?>
      New Name: <input name="name" type="text" /><br />
      <input name="submit" type="submit" value="Update Location" />
    </form>
  </fieldset>

  <fieldset>
    <legend>Delete Location</legend>
  
    <form name="location" action="./manageLocation.php?action=3" method="post">
      Name: <?php listBox('pk', 'SELECT pk AS field1, name AS field2 FROM location ORDER BY name ASC'); ?><br />
      <input name="submit" type="submit" value="Delete Location" />
    </form>
  </fieldset>
</div>
</body>

</html>
