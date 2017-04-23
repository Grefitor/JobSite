<?php

require '../library/process.php';

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';

if (isset($_GET['action'])) {
  connectDatabase();
  
  if ($_GET['action'] == 1) {
    $name = $_POST['name'];
    
    queryDatabase("INSERT INTO category (name)
                   VALUES ('$name')");
  } elseif ($_GET['action'] == 2) {
    $pk = $_POST['pk'];
    $name = $_POST['name'];
    
    queryDatabase("UPDATE category
                   SET name = '$name'
                   WHERE pk = $pk");
  } elseif ($_GET['action'] == 3) {
    $pk = $_POST['pk'];
    
    queryDatabase("UPDATE category
                   SET active = 0
                   WHERE pk = $pk");
  }
}

?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
  <title>Manage Category</title>
  
  <script src="../library/process.js"></script>
</head>

<body>
<div>
  <fieldset>
    <legend>Insert Category</legend>
  
    <form name="category" action="./manageCategory.php?action=1" method="post">
      Name: <input name="name" type="text" /><br />
      <input name="submit" type="submit" value="Insert Category" />
    </form>
  </fieldset>
  
  <fieldset>
    <legend>Update Category</legend>
  
    <form name="category" action="./manageCategory.php?action=2" method="post">
      Old Name: <?php listBox('pk', 'SELECT pk AS field1, name AS field2 FROM category ORDER BY name ASC'); ?>
      New Name: <input name="name" type="text" /><br />
      <input name="submit" type="submit" value="Update Category" />
    </form>
  </fieldset>

  <fieldset>
    <legend>Delete Category</legend>
  
    <form name="category" action="./manageCategory.php?action=3" method="post">
      Name: <?php listBox('pk', 'SELECT pk AS field1, name AS field2 FROM category ORDER BY name ASC'); ?><br />
      <input name="submit" type="submit" value="Delete Category" />
    </form>
  </fieldset>
</div>
</body>

</html>
