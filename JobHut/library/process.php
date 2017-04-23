<?php

session_start();

// ******************************************************************
// START CONFIGURATION
// ******************************************************************
// SERVER CONFIG
define('HOME', 'http://www.yoursite.com/jobhut/');							// FULLY QUALIFIED WEB DOMAIN ADDRESS - WHERE JOBHUT IS LOCATED
define('TEMPORARY', '/home/yoursite/public_html/jobhut/temporary/');		// ABSOLUTE PATH WHERE UPLOADED RESUMES WILL BE STORED

// COMPANY CONFIG
define('COMPANY', 'Your Organization');												// COMPANY NAME
define('EMAIL', 'admin@yoursite');										// DEFAULT EMAIL, FROM WHICH ALL EMAIL WILL BE SENT

// DATABASE CONFIG
define('SERVER', 'localhost');												// WEB SERVER ADDRESS
define('USERNAME', 'root');													// DATABASE USERNAME
define('PASSWORD', 'awesome');														// DATABASE PASSWORD
define('DATABASE_NAME', 'jobhunt');											// DATABASE NAME

// CRYPT CONFIG
define('SALT', 'jobhut');													// CRYPT SALT
// ******************************************************************
// END CONFIGURATION
// ******************************************************************

// ******************************************************************
// DATABASE FUNCTIONS
// ******************************************************************

//////////////////////////////////////////
// CONNECT TO DATABASE
//////////////////////////////////////////
function connectDatabase() {
  mysql_pconnect(SERVER, USERNAME, PASSWORD)
    or die('Could not connect: ' . mysql_error());

  mysql_select_db(DATABASE_NAME)
    or die('Could not select: ' . mysql_error());
}

//////////////////////////////////////////
// QUERY DATABASE
//////////////////////////////////////////
function queryDatabase($query = '') {
  $result = mysql_query($query)
    or die('MYSQL Error: ' . $query . ' ' . mysql_error());
    
  return $result;
}

//////////////////////////////////////////
// SQL ERROR
//////////////////////////////////////////
function sqlError($query = '', $error = '') {
  $dateTime = date("M-j-Y") . ' - ' . date("G:i");
  $message = htmlspecialchars("\nQuery failed ($dateTime):\n{$query}\nMySQL error:\n{$error}\n********************", ENT_QUOTES);
  
  error_log($message, 3, HOME . "MySQL.txt");
  
  return "<div>Query failed</div>";
}

// ******************************************************************
// USER FUNCTIONS
// ******************************************************************

//////////////////////////////////////////
// LOGIN THE USER
//////////////////////////////////////////
function loginUser() {
  $email = htmlspecialchars(trim($_POST['email']), ENT_QUOTES);
  $password = htmlspecialchars(trim($_POST['password']), ENT_QUOTES);
  
  connectDatabase();
  
  $result = queryDatabase("SELECT pk
                           FROM user
                           WHERE email = '$email' AND
                                 password = '$password' AND
                                 active = 1");

  if (mysql_num_rows($result) == 1) {
    $row = mysql_fetch_object($result);
    $date = date('Y-m-d');
    
    queryDatabase("UPDATE user SET last_login = '$date' WHERE pk = $row->pk");
    $_SESSION['pk'] = crypt($row->pk, SALT);

    header('Location: ' . HOME . 'member.php?feedback=9');
  } else {
    $result = queryDatabase("SELECT pk
                             FROM user
                             WHERE email = '$email' AND
                                   password = '$password' AND
                                   active = 0");

    if (mysql_num_rows($result) >= 1)
      header('Location: ' . HOME . 'login.php?feedback=2');
    else
      header('Location: ' . HOME . 'login.php?feedback=1');
  }
}

//////////////////////////////////////////
// LOGOUT THE USER
//////////////////////////////////////////
function logout() {
  session_unset();
  session_destroy();
  $_SESSION = array();

  header('Location: ' . HOME . 'login.php?feedback=14');
}

//////////////////////////////////////////
// REGISTER THE USER
//////////////////////////////////////////
function registerUser() {
  $org = htmlspecialchars(trim($_POST['org']), ENT_QUOTES);
  $email = htmlspecialchars(trim($_POST['email']), ENT_QUOTES);
  $password = htmlspecialchars(trim($_POST['password1']), ENT_QUOTES);
  $date = date('Y-m-d');
  
  connectDatabase();
  
  $result = queryDatabase("SELECT pk
                           FROM user
                           WHERE email = '$email'");
  
  if (mysql_num_rows($result) == 1) {
    header('Location: ' . HOME . 'login.php?feedback=3');
  } else {
    queryDatabase("INSERT INTO user (email, password, registered) VALUES ('$email', '$password', '$date')");
    
    $emailCrypt = HOME . 'login.php?account=' . crypt($email, SALT);

    $message = "Hello $email,\n\nTo activate your " . COMPANY . " account, please click the link below:\n\n$emailCrypt\n\nThank you,\n" . COMPANY . " support staff - " . date('m/d/Y');

    mail($email, 'Activate ' . COMPANY . ' account', $message, 'From: ' . EMAIL);
    
    header('Location: ' . HOME . 'login.php?feedback=4');
  }
}

//////////////////////////////////////////
// ACTIVATE USER
//////////////////////////////////////////
function activateUser() {
  if (isset($_GET['account'])) {
    $account = htmlspecialchars($_GET['account'], ENT_QUOTES);
    
    connectDatabase();
    
    $result = queryDatabase("SELECT email
                             FROM user
                             WHERE active = 0");

    if (mysql_num_rows($result) > 0){
      while ($row = mysql_fetch_object($result)) {
        if ($account == crypt($row->email, SALT)) {
          queryDatabase("UPDATE user SET active = 1
                         WHERE email = '$row->email'");
        
          echo '<div class="good">Activation successful - Login using EMAIL/USER ID and PASSWORD</div>';
          
          break;
        }
      }
    }
  }
}

//////////////////////////////////////////
// EMAIL USER PASSWORD
//////////////////////////////////////////
function emailPassword() {
  $email = htmlspecialchars(trim($_POST['email']), ENT_QUOTES);
  
  connectDatabase();
  
  $result = queryDatabase("SELECT email, password
                           FROM user
                           WHERE email = '$email' AND
                                 active = 1");

  if (mysql_num_rows($result) >= 1) {
    $row = mysql_fetch_object($result);
    
    $message = "Hello $row->email,\n\nYour " . COMPANY . " password is:\n\n$row->password\n\nTo login, please click the link below:\n\n" . HOME . "login.php\n\nThank you,\n" . COMPANY . " support staff - " . date('m/d/Y');
    
    mail($row->email, COMPANY . ' password', $message, 'From: ' . EMAIL);

    header('Location: ' . HOME . 'login.php?feedback=5');
  } else {
    header('Location: ' . HOME . 'forgot.php?feedback=6');
  }
}

//////////////////////////////////////////
// VALIDATE USER
//////////////////////////////////////////
function validateUser() {
  if (!isset($_SESSION['pk']))
    header('Location: ' . HOME . 'login.php?feedback=7');
}

//////////////////////////////////////////
// DECRYPT USER
//////////////////////////////////////////
function decryptUser() {
  $pk = $_SESSION['pk'];
  $valid = 0;

  connectDatabase();
  
  $result = queryDatabase("SELECT pk
                           FROM user
                           WHERE active = 1");

  if (mysql_num_rows($result) >= 1) {
    while ($row = mysql_fetch_object($result)) {
      if ($pk == crypt($row->pk, SALT)) {
        return $row->pk;
      }
    }
  } else {
    header('Location: ' . HOME . 'login.php?feedback=7');
  }
}

// ******************************************************************
// JOB FUNCTIONS
// ******************************************************************

//////////////////////////////////////////
// INSERT JOB
//////////////////////////////////////////
function insertJob() {
  $title = htmlspecialchars(trim($_POST['title']), ENT_QUOTES);
  $description = str_replace(array("\r\n", "\n", "\r"), "<br />", htmlspecialchars(trim($_POST['description']), ENT_QUOTES));
  $status = $_POST['status'];
  $salary = htmlspecialchars(trim($_POST['salary']), ENT_QUOTES);
  $measure = $_POST['measure'];
  $category = implode(" ", $_POST['category']);
  $location = implode(" ", $_POST['location']);
  $fk_user = decryptUser();
  $date = date('Y-m-d');
  
  connectDatabase();
  
  queryDatabase("INSERT INTO job (title, description, inserted, fk_category, fk_location, fk_user, status, salary, measure)
                 VALUES ('$title', '$description', '$date', '$category', '$location', $fk_user, '$status', '$salary', '$measure')");
  
  header('Location: ' . HOME . 'member.php?feedback=8');
}

//////////////////////////////////////////
// DELETE JOB
//////////////////////////////////////////
function deleteJob() {
  $job = $_POST['job'];
  
  if (count($job) > 1) {
    $default = 1;

    foreach ($job as $value) {
      if ($default == 1)
        $pk = $value;
      else {
        $pk .= " OR pk = $value";
      }
       
      $default++;
    }
  } else {
    $pk = array_shift($job);
  }

  connectDatabase();

  $result = queryDatabase("UPDATE job
                           SET active = 0
                           WHERE pk = $pk");
  header('Location: ' . HOME . 'member.php?feedback=10');
}

//////////////////////////////////////////
// GET JOB
//////////////////////////////////////////
function getJob() {
  $pk = $_GET['pk'];
  
  connectDatabase();
  
  $result = queryDatabase("SELECT title, description, status, salary, measure, fk_category, fk_location
                           FROM job
                           WHERE pk = $pk");

  $row = mysql_fetch_object($result);
  
  $value['title'] = $row->title;
  $value['description'] = $row->description;

  $value['status'][0] = ($row->status === 'F') ? 'checked="checked" ': '';
  $value['status'][1] = ($row->status === 'P') ? 'checked="checked" ': '';
  $value['status'][2] = ($row->status === 'C') ? 'checked="checked" ': '';
  $value['status'][3] = ($row->status === 'O') ? 'checked="checked" ': '';
  
  $value['salary'] = $row->salary;
  
  $value['measure'][0] = ($row->measure === 'H') ? 'checked="checked" ': '';
  $value['measure'][1] = ($row->measure === 'W') ? 'checked="checked" ': '';
  $value['measure'][2] = ($row->measure === 'M') ? 'checked="checked" ': '';
  $value['measure'][3] = ($row->measure === 'A') ? 'checked="checked" ': '';
  $value['measure'][4] = ($row->measure === 'O') ? 'checked="checked" ': '';
  
  $value['fk_category'] = $row->fk_category;
  $value['fk_location'] = $row->fk_location;

  return $value;
}

//////////////////////////////////////////
// MODIFY JOB
//////////////////////////////////////////
function modifyJob() {
  $title = htmlspecialchars(trim($_POST['title']), ENT_QUOTES);
  $description = str_replace(array("\r\n", "\n", "\r"), "<br />", htmlspecialchars(trim($_POST['description']), ENT_QUOTES));
  $status = $_POST['status'];
  $salary = htmlspecialchars(trim($_POST['salary']), ENT_QUOTES);
  $measure = $_POST['measure'];
  $category = implode(" ", $_POST['category']);
  $location = implode(" ", $_POST['location']);
  $pk = $_POST['pk'];
  $date = date('Y-m-d');
  
  connectDatabase();
  
  queryDatabase("UPDATE job SET title = '$title',
                                description = '$description',
                                inserted = '$date',
                                fk_category = '$category',
                                fk_location = '$location',
                                status = '$status',
                                salary = '$salary',
                                measure = '$measure'
                            WHERE pk = $pk");

  header('Location: ' . HOME . 'member.php?feedback=15');
}

//////////////////////////////////////////
// MARK JOB
//////////////////////////////////////////
function markJob() {
  $pk = $_GET['pk'];

  connectDatabase();
    
  queryDatabase("UPDATE job
                 SET marked = marked + 1
                 WHERE pk = $pk");

  header('Location: ' . HOME . 'miscellaneous.php?feedback=13');
}

//////////////////////////////////////////
// VIEW USER JOBS
//////////////////////////////////////////
function viewUserJobs($action = 0) {
  // action
  //   0 = view
  //   1 = delete
  //   2 = update
  $pk = decryptUser();
  
  connectDatabase();
  
  $result = queryDatabase("SELECT pk, title, viewed, applied, inserted
                           FROM job
                           WHERE fk_user = $pk AND
                                 active = 1
                           ORDER BY inserted DESC");

  if ($action == 1) {
    $action = 'Delete';
    $type = 'checkbox';
  } elseif ($action == 2) {
    $action = 'Update';
    $type = 'radio';
  } else
    $input = '';

  if ($action === 'Delete' && mysql_num_rows($result) > 0) {
    echo "<form action=\"./process/process$action.php\" method=\"post\" onsubmit=\"return check$action" . "Form();\">";

    $default = 0;
  }
  
  $counter = 1;

  while ($row = mysql_fetch_object($result)) {
    echo '<table>';
    
    if ($action === 'Delete' || $action === 'Update') {
      $name = ($action == 'Delete') ? "job[$default]": 'job';

      $onclick = ($action === 'Update') ? "onclick=\"javascript:redirect($row->pk)\" ": '';

      $input = "<input type=\"$type\" name=\"$name\" value=\"$row->pk\" $onclick/> ";

      $default++;
    }

    $row->inserted = substr($row->inserted, 5, 2) . "/" . substr($row->inserted, 8, 2) . "/" . substr($row->inserted, 0, 4);
    $row->description = trim(substr($row->description, 0, 50)) . '...';
    
    $row->title = wordwrap($row->title, 50, "\n", true);
    
    echo "<tr><td align=\"right\">$input<strong>Job:</strong></td><td style=\"width:400px;\"><a href=\"javascript:popUp('detail.php?pk=$row->pk')\">$row->title</a></td></tr>
          <tr><td align=\"right\"><strong>Inserted:</strong></td><td>$row->inserted</td></tr>
    	  <tr><td align=\"right\"><strong>Viewed:</strong></td><td>$row->viewed</td></tr>
          <tr><td align=\"right\"><strong>Applied:</strong></td><td>$row->applied</td></tr>";

    echo '</table>';
    
    echo ($counter < mysql_num_rows($result)) ? '<hr />': '<br />';
    
    $counter++;
  }

  if ($action === 'Delete' && mysql_num_rows($result) > 0)
    echo "<input name=\"submit\" type=\"submit\" value=\"$action\" /></form>";
}

//////////////////////////////////////////
// VIEW SEARCHED JOBS
//////////////////////////////////////////
function viewSearchedJobs() {
  connectDatabase();
	
  $pk = mysql_real_escape_string($_GET['pk']);
  if (isset($_GET['start']))
    $start = $_GET['start'];
  else
    $start = 0;
  
  
  $result = queryDatabase("SELECT total, fk_job
                           FROM search
                           WHERE pk = $pk");

  $row = mysql_fetch_object($result);
  
  $total = $row->total;
  
  if ($total > 0) {
    $results = (($start + 15) > $total) ? $total: ($start + 15);
  
    echo "<div class=\"good\">Results " . ($start + 1) . "-$results of $total job(s) found</div><br />";
  } else
    echo "<div class=\"bad\">Your search did not match any jobs in our database</div><br />";

  // fk_job parse
  if ($row->fk_job <> 'EMPTY') {
    $row->fk_job = explode(' ', $row->fk_job);
    
    $row->fk_job = array_slice($row->fk_job, $start, 15);
    
    if (count($row->fk_job) > 1) {
      $default = 1;
      
      foreach ($row->fk_job as $value) {
        if (!empty($value)) {
          if ($default == 1)
            $job_regexp = '[[:<:]]' . $value . '[[:>:]]';
          else
            $job_regexp .= '|[[:<:]]' . $value . '[[:>:]]';

          $default++;
        }
      }
    } elseif (count($row->fk_job) == 1)
      $job_regexp = '[[:<:]]' . $row->fk_job[0] . '[[:>:]]';

    $result = queryDatabase("SELECT pk, title, inserted, fk_location
                             FROM job
                             WHERE pk REGEXP '$job_regexp'
                             ORDER BY pk DESC");
      
    echo '<table cellspacing="0" cellpadding="0">';

    $default = 1;
  
    while ($row = mysql_fetch_object($result)) {
      $location = explodeFK($row->fk_location, 'location', 1);
      $row->inserted = substr($row->inserted, 5, 2) . "/" . substr($row->inserted, 8, 2) . "/" . substr($row->inserted, 0, 4);

      $backgroundColor = ($default%2) ? '#FFFACD': '#FFFFFF';
      
      $row->title = wordwrap($row->title, 30, "\n", true);
      
      echo <<< END
<tr>
<td style="background-color:$backgroundColor; height:77px; text-align:left; vertical-align:top; width:280px;">
<strong>Title:</strong><br />
<a href="javascript:popUp('detail.php?pk=$row->pk&apply=1')">$row->title</a>
</td>
<td style="background-color:$backgroundColor; text-align:left; vertical-align:top; width:100px;">
<strong>Inserted:</strong><br />
$row->inserted
</td>
<td style="background-color:$backgroundColor; text-align:left; vertical-align:top; width:245px;">
<strong>Location:</strong><br />
$location
</td>
</tr>
END;

      $default++;
    }

    echo '</table>';
    
    if (($start - 15) >= 0) {
      $previous = $start - 15;
      echo "<a href=\"./browse.php?pk=$pk&start=$previous\" alt=\"\">Previous 15 Jobs</a>&nbsp;&nbsp;&nbsp;";
    }

    if (($start + 15) < $total) {
      $start += 15;
      $next = (($start + 15) <= $total) ? 15: ($total - $start);
      echo "<a href=\"./browse.php?pk=$pk&start=$start\" alt=\"\">Next $next Job(s)</a>";
    }
    
  }
}

//////////////////////////////////////////
// SEARCH JOBS
//////////////////////////////////////////
function searchJobs() {
  $keyword = htmlspecialchars(trim($_POST['keyword']), ENT_QUOTES);
  $category = $_POST['category'];
  $location = $_POST['location'];
  
  // keyword parse
  if (!empty($keyword)) {
    $keyword = explode(' ', $keyword);
    
    if (count($keyword) > 1) {
      $default = 1;
      
      foreach ($keyword as $value) {
        if (!empty($value)) {
          if ($default == 1)
            $key_regexp = '[[:<:]]' . $value . '[[:>:]]';
          else
            $key_regexp .= '|[[:<:]]' . $value . '[[:>:]]';

          $default++;
        }
      }
    } elseif (count($keyword) == 1)
      $key_regexp = '[[:<:]]' . $keyword[0] . '[[:>:]]';
  
    $keyword = implode(' ', $keyword);
  } else
    $key_regexp = null;

  // category parse
  if (count($category) > 1) {
    $default = 1;
    
    foreach ($category as $value) {
      if (!empty($value)) {
        if ($default == 1)
          $cat_regexp = '[[:<:]]' . $value . '[[:>:]]';
        else
          $cat_regexp .= '|[[:<:]]' . $value . '[[:>:]]';

        $default++;
      }
    }
  } elseif (count($category) == 1)
    $cat_regexp = '[[:<:]]' . $category[0] . '[[:>:]]';
  else
    $cat_regexp = null;

  $category = implode(' ', $category);
  
  // location parse
  if (count($location) > 1) {
    $default = 1;
    
    foreach ($location as $value) {
      if (!empty($value)) {
        if ($default == 1)
          $loc_regexp = '[[:<:]]' . $value . '[[:>:]]';
        else
          $loc_regexp .= '|[[:<:]]' . $value . '[[:>:]]';

        $default++;
      }
    }
  } elseif (count($location) == 1)
    $loc_regexp = '[[:<:]]' . $location[0] . '[[:>:]]';
  else
    $loc_regexp = null;

  $location = implode(' ', $location);
  
  connectDatabase();
  
  if (!empty($key_regexp)) {
    if (ereg("all", $cat_regexp) && ereg("all", $loc_regexp)) {

    $result = queryDatabase("SELECT pk
                             FROM job
                             WHERE active = 1 AND
                                   (title REGEXP '$key_regexp' OR
                                    description REGEXP '$key_regexp')
                             ORDER BY pk DESC");

    } elseif (ereg("all", $cat_regexp) && !ereg("all", $loc_regexp)) {

    $result = queryDatabase("SELECT pk
                             FROM job
                             WHERE active = 1 AND
                                   (title REGEXP '$key_regexp' OR
                                    description REGEXP '$key_regexp') AND
                                   fk_location REGEXP '$loc_regexp'
                             ORDER BY pk DESC");

    } elseif (!ereg("all", $cat_regexp) && ereg("all", $loc_regexp)) {

    $result = queryDatabase("SELECT pk
                             FROM job
                             WHERE active = 1 AND
                                   (title REGEXP '$key_regexp' OR
                                    description REGEXP '$key_regexp') AND
                                   fk_category REGEXP '$cat_regexp'
                             ORDER BY pk DESC");

    } else {

    $result = queryDatabase("SELECT pk
                             FROM job
                             WHERE active = 1 AND
                                   (title REGEXP '$key_regexp' OR
                                    description REGEXP '$key_regexp') AND
                                   fk_category REGEXP '$cat_regexp' AND
                                   fk_location REGEXP '$loc_regexp'
                             ORDER BY pk DESC");

    }
  } else {
    if (ereg("all", $cat_regexp) && ereg("all", $loc_regexp)) {

    $result = queryDatabase("SELECT pk
                             FROM job
                             WHERE active = 1
                             ORDER BY pk DESC");
                             
    } elseif (ereg("all", $cat_regexp) && !ereg("all", $loc_regexp)) {

    $result = queryDatabase("SELECT pk
                             FROM job
                             WHERE active = 1 AND
                                   fk_location REGEXP '$loc_regexp'
                             ORDER BY pk DESC");

    } elseif (!ereg("all", $cat_regexp) && ereg("all", $loc_regexp)) {

    $result = queryDatabase("SELECT pk
                             FROM job
                             WHERE active = 1 AND
                                   fk_category REGEXP '$cat_regexp'
                             ORDER BY pk DESC");

    } else {

    $result = queryDatabase("SELECT pk
                             FROM job
                             WHERE active = 1 AND
                                   fk_category REGEXP '$cat_regexp' AND
                                   fk_location REGEXP '$loc_regexp'
                             ORDER BY pk DESC");

    }
  }

  $ip = ($_SERVER['X_FORWARDED_FOR']) ? $_SERVER['X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
  $date = date('Y-m-d');
  $total = mysql_num_rows($result);
  
  if (mysql_num_rows($result) > 0) {
    $default = 1;
    
    while ($row = mysql_fetch_object($result)) {
      if ($default == 1)
        $fk_job = $row->pk;
      else {
        $fk_job .= " $row->pk";
      }

      $default++;
    }
  } else
    $fk_job = 'EMPTY';

  queryDatabase("INSERT INTO search (ip, keyword, total, searched, fk_category, fk_job, fk_location)
                 VALUES ('$ip', '$keyword', $total, '$date', '$category', '$fk_job', '$location')");

  header('Location: ' . HOME . 'browse.php?pk=' . mysql_insert_id());
}

//////////////////////////////////////////
// JOB DETAIL
//////////////////////////////////////////
function jobDetail() {
  $pk = $_GET['pk'];
  $apply = ($_GET['apply'] == 1) ? "<strong><a href=\"./apply.php?pk=$pk\">APPLY FOR THIS JOB</a></strong><br /><br />": '';
  $mark = ($_GET['apply'] == 1) ? "<br /><br /><strong><a href=\"./process/processMark.php?pk=$pk\">MARK AS INAPPROPRIATE/SPAM</a></strong>": '';
  
  connectDatabase();
  
  queryDatabase("UPDATE job
                 SET viewed = viewed + 1
                 WHERE pk = $pk");

  $result = queryDatabase("SELECT title, description, inserted, status, salary, measure, fk_category, fk_location
                           FROM job
                           WHERE pk = $pk");

  $row = mysql_fetch_object($result);
  
  if ($row->status == 'F')
    $status = 'Full-time';
  elseif ($row->status == 'P')
    $status = 'Part-time';
  elseif ($row->status == 'C')
    $status = 'Contract';
  else
    $status = 'Other';

  if ($row->measure == 'H')
    $measure = 'Hourly';
  elseif ($row->measure == 'W')
    $measure = 'Weekly';
  elseif ($row->measure == 'M')
    $measure = 'Monthly';
  elseif ($row->measure == 'A')
    $measure = 'Annually';
  else
    $measure = 'Other';

  $category = explodeFK($row->fk_category, 'category');
  $location = explodeFK($row->fk_location, 'location');
  
  $row->title = wordwrap($row->title, 60, "\n", true);
  $row->description = wordwrap($row->description, 60, "\n", true);
  
  
  echo <<< END
$apply
<fieldset>
<legend><strong>Title:</strong></legend>
$row->title
</fieldset>
<br />
<br />
<fieldset>
<legend><strong>Description:</strong></legend>
$row->description
$mark
</fieldset>
<br />
<br />
<fieldset>
<legend><strong>Status:</strong></legend>
$status
</fieldset>
<br />
<br />
<fieldset>
<legend><strong>Salary:</strong></legend>
$row->salary - $measure
</fieldset>
<br />
<br />
<fieldset>
<legend><strong>Category:</strong></legend>
$category
</fieldset>
<br />
<br />
<fieldset>
<legend><strong>Location:</strong></legend>
$location
</fieldset>
END;
}

//////////////////////////////////////////
// APPLY FOR JOB
//////////////////////////////////////////
function applyForJob() {
  $pk = $_POST['pk'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $message = str_replace(array("\r\n", "\n", "\r"), "<br />", $_POST['message']);
  $type = array('application/msword', 'application/macwriteii', 'application/pdf', 'application/rtf', 'text/rtf', 'text/plain', 'application/vnd.ms-works');
  
  if ($_FILES["resume"]["size"] < 5000000) {
    $_FILES["resume"]["name"] = str_replace(' ', '', $_FILES["resume"]["name"]);
  
    move_uploaded_file($_FILES["resume"]["tmp_name"], TEMPORARY . $_FILES["resume"]["name"]);
    
    connectDatabase();
    
    queryDatabase("UPDATE job
                   SET applied = applied + 1
                   WHERE pk = $pk");
    $result = queryDatabase("SELECT title, inserted, email
                             FROM job j, user u
                             WHERE j.pk = $pk AND
                                   j.fk_user = u.pk");
                             
    $row = mysql_fetch_object($result);
    $row->inserted = substr($row->inserted, 5, 2) . "/" . substr($row->inserted, 8, 2) . "/" . substr($row->inserted, 0, 4);
    
    $default = "This message was sent to you at the request of $name (email: $email) to notify you that they are interested in the position, $row->title, that you posted on " . rtrim(substr(HOME, 7), '/') . " - $row->inserted.<br />In addition to their attached resume, below you will find a personal message from $name concerning the position/their qualifications.<br /><br />************************************************************<br /><br />";
    
    emailAttachment(EMAIL, $row->email, 'Application for: ' . html_entity_decode($row->title, ENT_QUOTES), $default . $message, TEMPORARY . $_FILES["resume"]["name"]);
    
    unlink(TEMPORARY . $_FILES["resume"]["name"]);
    
    header('Location: ' . HOME . 'miscellaneous.php?feedback=11');
  } else
    header('Location: ' . HOME . 'miscellaneous.php?feedback=12');
}

// ******************************************************************
// MISCELLANEOUS FUNCTIONS
// ******************************************************************

//////////////////////////////////////////
// EXPLODE FK
//////////////////////////////////////////
function explodeFK($input = '', $table = '', $limit = 0) {
  $input = explode(" ", $input);

  if (count($input) > 1) {
    $default = 1;
    
    foreach ($input as $value) {
      if ($default == 1)
        $pk = $value;
      else {
        $pk .= " OR pk = $value";
      }
      
      $default++;
    }
  } else {
    $pk = array_shift($input);
  }

  connectDatabase();
  
  $result = queryDatabase("SELECT name
                           FROM $table
                           WHERE pk = $pk
                           ORDER BY name ASC");

  $default = 1;

  while ($row = mysql_fetch_object($result)) {
    if ($default == 1)
      $input = "$row->name<br />";
    elseif ($default < 4 && $limit == 1)
      $input .= "$row->name<br />";
    elseif ($default == 4 && $limit == 1)
      $input .= "More...<br />";
    elseif ($default > 1 && $limit == 0)
      $input .= "$row->name<br />";

    $default++;
  }

  return $input;
}

//////////////////////////////////////////
// USER FEEDBACK
//////////////////////////////////////////
function userFeedback() {
  if (isset($_GET['feedback'])) {
    switch ($_GET['feedback']) {
      case 1:
        echo '<div class="bad">Login failed - Invalid EMAIL/USER ID and/or PASSWORD</div>';
        break;
      case 2:
        echo '<div class="bad">Login failed - EMAIL/USER ID not activated - Check email</div>';
        break;
      case 3:
        echo '<div class="bad">Registration failed - EMAIL/USER ID already exists</div>';
        break;
      case 4:
        echo '<div class="good">Registration successful - Activate EMAIL/USER ID - Check email</div>';
        break;
      case 5:
        echo '<div class="good">Password retrieval successful - Check email</div>';
        break;
      case 6:
        echo '<div class="bad">Password retrieval failed - Invalid EMAIL/USER ID</div>';
        break;
      case 7:
        echo '<div class="bad">Restricted access - Login required</div>';
        break;
      case 8:
        echo '<div class="good">Insert successful</div><hr />';
        break;
      case 9:
        echo '<div class="good">Login successful</div><hr />';
        break;
      case 10:
        echo '<div class="good">Delete successful</div><hr />';
        break;
      case 11:
        echo '<div class="good">Application successful</div>';
        break;
      case 12:
        echo '<div class="bad">Application failed</div>';
        break;
      case 13:
        echo '<div class="good">System administrator has been notified</div>';
        break;
      case 14:
        echo '<div class="good">Logout successful</div><hr />';
        break;
      case 15:
        echo '<div class="good">Update successful</div><hr />';
        break;
    }
  }
}

//////////////////////////////////////////
// LISTBOX
//////////////////////////////////////////
function listBox($name = '', $query = '', $multiple = 0, $size = 1, $all = 0, $existing = '') {
  $multiple = ($multiple <> 0) ? ' multiple="multiple"' : '';
  $size = " size=\"$size\"";
  $default = 1;
  $existing = (!empty($existing)) ? explode(" ", $existing) : '';

  connectDatabase();
  
  $result = queryDatabase($query);
  
  echo "<select name=\"$name\"$multiple$size>";
  while ($row = mysql_fetch_object($result)) {
    if ($default == 1 && $all == 1)
      echo '<option value="all" selected="selected">--Select All--</option>';
    elseif (!empty($existing) && in_array($row->field1, $existing, true))
      $selected = ' selected="selected"';
    elseif ($default == 1 && $all == 0 && empty($existing))
      $selected = ' selected="selected"';
    else
      $selected = '';
    
    $default++;

    echo "<option value=\"$row->field1\"$selected>$row->field2</option>";
  }  
  echo '</select>';
}

//////////////////////////////////////////
// DYNAMIC LINK
//////////////////////////////////////////
function dynamicLink($url = '', $output = '', $loggedIn = 0) {
  if (!isset($_SESSION['pk']) && $loggedIn == 0)
    echo "&bull;<a href=\"$url\">$output</a><br />";
  elseif (isset($_SESSION['pk']) && $loggedIn == 1)
    echo "&bull;<a href=\"$url\">$output</a><br />";
}

//////////////////////////////////////////
// EMAIL ATTACHMENT
//////////////////////////////////////////
function emailAttachment($from = '', $to = '', $subject = '', $message = '', $attachment = ''){
  $attachment_type = "application/octet-stream";
  $start = (strrpos($attachment, '/') == -1) ? strrpos($attachment, '//'): strrpos($attachment, '/') + 1;
  $attachment_name = substr($attachment, $start, strlen($attachment));

  $headers = "From: " . $from;
  
  $file = fopen($attachment, 'rb');
  $data = fread($file, filesize($attachment));
  fclose($file);
  
  $random = md5(time());
  $boundary = "==Multipart_Boundary_x{$random}x";
  
  $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$boundary}\"";
  $email_message = "This is a multi-part message in MIME format.\n\n" .
                   "--{$boundary}\n" .
                   "Content-Type:text/html; charset=\"iso-8859-1\"\n" .
                   "Content-Transfer-Encoding: 7bit\n\n" .
                   $message . "\n\n";

  $data = chunk_split(base64_encode($data));
  $email_message .= "--{$boundary}\n" .
                    "Content-Type: {$attachment_type};\n" .
                    " name=\"{$attachment_name}\"\n" .
                    "Content-Transfer-Encoding: base64\n\n" .
                    $data . "\n\n" .
                    "--{$boundary}--\n";

  $send = mail($to, $subject, $email_message, $headers);
  
  if (!$send)
    die('<div>Application email failed</div>');
}

?>