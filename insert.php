<?php

//1. POSTデータ取得
$start = $_POST['start'];
$end= $_POST['end'];
$place = $_POST['address'];
$note= $_POST['note'];


//2. DB接続します
try {
  //ID:'root', Password: xamppは 空白 ''
$pdo = new PDO('mysql:dbname=gs_kadai08;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
exit('DBConnectError:'.$e->getMessage());
}

//３．データ登録SQL作成

// 1. SQL文を用意
$stmt = $pdo->prepare("INSERT 
                            INTO 
                        kadai08_dest(id, start, end, place, note) 
                        VALUES(NULL, :start, :end, :place, :note)"
);

//  2. バインド変数を用意
// Integer 数値の場合 PDO::PARAM_INT
// String文字列の場合 PDO::PARAM_STR

$stmt->bindValue(':start', $start, PDO::PARAM_STR);
$stmt->bindValue(':end', $end, PDO::PARAM_STR);
$stmt->bindValue(':place', $place, PDO::PARAM_STR);
$stmt->bindValue(':note', $note, PDO::PARAM_STR);

//  3. 実行
$status = $stmt->execute();

//４．データ登録処理後
if($status === false){
//SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
	$error = $stmt->errorInfo();
	exit('ErrorMessage:'.$error[2]);
}else{
//５．index.phpへリダイレクト
	header("Location: set.php");
}
?>
