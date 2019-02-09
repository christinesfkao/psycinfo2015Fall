<?php
$db = new PDO('mysql:host=127.0.0.1;dbname=psycho', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
$stmt = $db->query("SELECT * FROM user ORDER BY uid ASC");
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$user = array();
$user_table = array();
foreach($result as $key => $value) {
  $user[] = $value;
  $user_table[$value['uid']] = $key;
}

$table = array();
$stmt = $db->query("SELECT * FROM record_clean ORDER BY ts ASC");
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($result as $row) {
  if(!isset($table[$row['ts']])) {
    $table[$row['ts']] = array();
    array_pad($table[$row['ts']], count($user), 0);
  }
  $table[$row['ts']][$user_table[$row['uid']]] = 1;
}

echo '""';
foreach($user as $u) {
  echo ',"'.$u['name'].'"';
}
echo "\n";

echo '"time"';
foreach($user as $u) {
  echo ',"'.$u['uid'].'"';
}
echo "\n";

foreach($table as $ts => $td) {
  echo $ts;
  for($i = 0; $i < count($user); $i++) {
    echo ',';
    if($td[$i] == 1) {
      echo '"1"';
    } else {
      echo '"0"';
    }
  }
  echo "\n";
}
