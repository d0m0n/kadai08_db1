<?php

// POSTデータ取得
$date = $_POST["date"];
$address = $_POST["address"];
$note = $_POST["note"];

// CSVファイルに書き込み
$c = ",";
$time = date("Y-m-d H:i:s");
$data = $time . $c . $date . $c . $address . $c . $note;
$file = fopen("./data/data.csv", "a");
fwrite($file, $data . "\n");
fclose($file);

//index.phpへリダイレクト
  header("Location: index.php");
exit;
?>