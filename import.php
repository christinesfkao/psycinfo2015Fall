<?php
echo "USE psycho;";
echo "SET NAMES UTF8;";
$file = fopen($argv[1],"r");
date_default_timezone_set("UTC");
$time = '';
$u = array();
while(($line = fgets($file))!==FALSE){
  $line = trim($line);
  if($line == '') continue;
  if(strpos($line, '#') == false){
    $time = strtotime($line);
    $time -= 300;
  }else{
    $data = explode("#", $line);
    if(!isset($u[$data[1]])){
      echo "INSERT INTO user (uid, name) VALUES('".$data[1]."','".$data[0]."');\n";
      $u[$data[1]] = 1;
    }
    echo "INSERT INTO record (ts, uid) VALUES(FROM_UNIXTIME(".$time."),'".$data[1]."');\n";
  }
}
fclose($file);
