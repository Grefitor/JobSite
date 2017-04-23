<div >
  &bull;<a href="./index.php">Home</a><br />
  <br />
  <?php dynamicLink('./login.php', 'Employer Login', 0); ?>
  <?php dynamicLink('./process/processLogout.php', 'Logout', 1); ?>
  <?php dynamicLink('./register.php', 'Employer Register', 0); ?>
  <br />
  &bull;<a href="./search.php">Search Jobs</a><br />
  <br />
  <?php dynamicLink('./insert.php', 'Insert Job(s)', 1); ?>
  <?php dynamicLink('./update.php', 'Update Job(s)', 1); ?>
  <?php dynamicLink('./delete.php', 'Delete Job(s)', 1); ?>
</div>