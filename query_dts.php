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
$stmt = $db->query("SELECT right(ts,3) as dts, uid, count(*) as count FROM `record_clean` GROUP BY dts, uid");
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($result as $row) {
  if(!isset($table[abs($row['dts'])])) {
    $table[abs($row['dts'])] = array();
    array_pad($table[abs($row['dts'])], count($user), 0);
  }
  $table[abs($row['dts'])][$user_table[$row['uid']]] = $row['count'];
}

echo '""';
foreach($user as $key => $u) {
  echo ',"'.$key.'"';
}
echo "\n";

foreach($table as $ts => $td) {
  echo $ts;
  for($i = 0; $i < count($user); $i++) {
    echo ',';
    echo '"'.(int)$td[$i].'"';
  }
  echo "\n";
}
