<?php

require '../library/process.php';

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';

if (isset($_GET['action'])) {
  connectDatabase();
  
  if ($_GET['action'] == 1) {
    $pk = $_POST['pk'];
    
    queryDatabase("UPDATE user
                   SET active = 1
                   WHERE pk = $pk");
  } elseif ($_GET['action'] == 2) {
    $pk = $_POST['pk'];
    $password = $_POST['password'];
    
    queryDatabase("UPDATE user
                   SET password = '$password'
                   WHERE pk = $pk");
  } elseif ($_GET['action'] == 3) {
    $pk = $_POST['pk'];
    
    queryDatabase("UPDATE user
                   SET active = 0
                   WHERE pk = $pk");
  }
}

?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
  <title>Manage User</title>
  
  <script src="../library/process.js"></script>
</head>

<body>
<div>
  <fieldset>
    <legend>Activate User</legend>
  
    <form name="user" action="./manageUser.php?action=1" method="post">
      Email: <?php listBox('pk', 'SELECT pk AS field1, email AS field2 FROM user WHERE active = 0 ORDER BY email ASC'); ?><br />
      <input name="submit" type="submit" value="Activate User" />
    </form>
  </fieldset>

  <fieldset>
    <legend>Update User Password</legend>
  
    <form name="user" action="./manageUser.php?action=2" method="post">
      Email: <?php listBox('pk', 'SELECT pk AS field1, email AS field2 FROM user WHERE active = 1 ORDER BY email ASC'); ?><br />
      New Password: <input name="password" type="password" /><br />
      <input name="submit" type="submit" value="Update User Password" />
    </form>
  </fieldset>

  <fieldset>
    <legend>Delete User</legend>
  
    <form name="user" action="./manageUser.php?action=3" method="post">
      Email: <?php listBox('pk', 'SELECT pk AS field1, email AS field2 FROM user WHERE active = 1 ORDER BY email ASC'); ?><br />
      <input name="submit" type="submit" value="Delete User" />
    </form>
  </fieldset>
</div>
</body>

</html>
