<?php
$view = ""; // 変数を初期化

//1.  DB接続
// ローカルのデータベースにアクセスするための必要な情報を変数に渡す
$db_name = 'plan-gs_gs_kadai08';  // データベース名
$db_host = 'mysql3105.db.sakura.ne.jp'; // DBホスト
$db_id   = 'plan-gs_gs_kadai08';  // ユーザー名(さくらサーバはDB名と同一)
$db_pw   = 'password08';  // パスワード

// try catch構文でデータベースの情報取得を実施
try {
  $server_info = 'mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host;
  $pdo = new PDO($server_info, $db_id, $db_pw);
} catch (PDOException $e) {
  // エラーだった場合の情報を返す処理
  // exitした時点でそれ以降の処理は行われません
  exit('DB Connection Error:' . $e->getMessage());
}
//２．データ取得SQL作成
$stmt = $pdo->prepare('SELECT * FROM kadai08_dest');
$status = $stmt->execute();

//３．データ表示
$view = '';
if ($status === false) {
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt->errorInfo();
    exit('ErrorQuery:' . $error[2]);
} else {
    // Selectデータの数だけ自動でループしてくれる
    // FETCH_ASSOC = http://php.net/manual/ja/pdostatement.fetch.php
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $view .= '<p>';
        $view .= $result['start'] . ':' . $result['end'] . ' ' . $result['place'] . ' ' . $result['note'];
        $view .= '</p>';
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>たびのしおり</title>
    <link rel="icon" href="./img/favicon.svg" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
    href="https://fonts.googleapis.com/css2?family=DotGothic16&family=M+PLUS+Rounded+1c&family=Zen+Kurenaido&display=swap"
    rel="stylesheet"
    />
    <link rel="stylesheet" href="css/reset.css" />
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
    <header class="header">
    <div class="navtext-container">
    <div class="navtext">たびのしおり（登録画面）</div>
    </div>
    <input type="checkbox" class="menu-btn" id="menu-btn">
    <label for="menu-btn" class="menu-icon"><span class="navicon"></span></label>
    <ul class="menu">
    <li class="top"><a href=index.php>トップ画面</a></li>
    <li><a href=set.php>目的地を登録</a></li>
    </ul>
    </header>

    <div class="formArea">
    <form method="post" action="insert.php">
        <table class="set">
        <tr>
            <td>いつから</td>
            <td><input type="datetime-local" id="date_start" class="form" name="start" value="" step="900" placeholder="日時を入力してください" /></td>
        </tr>
        <tr>
            <td>いつまで</td>
            <td><input type="datetime-local" id="date_end" class="form" name="end" value="" step="900" placeholder="日時を入力してください" /></td>
        </tr>
        <tr>
            <td>場所</td>
            <td><input type="text" id="address" class="form" name="address" placeholder="場所を入力してください" /></td>
        </tr>
        <tr>
            <td>メモ</td>
            <td><textarea id="note" class="form" name="note" placeholder="メモを入力してください" ></textarea></td>
        </tr>
        </table>
        <div><input type="submit" class="send" value="フォームに入力したらこのボタンを押して目的地を設定してください"></div>
        </form>
    </div>
	<div>
		<!-- ここにデータベースから取得したデータを表示 -->
		<div id="output"><?= $view ?></div>
	</div>
    <script src="http://maps.google.com/maps/api/js?key=AIzaSyAFYEWMM7hftSeZ56wsth8MzFNG5ESjEmc&language=ja"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="module" src="./js/main.js"></script>
    <script type="module" src="./js/map.js"></script>
</body>
</html>
