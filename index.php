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
        $view .= '<div id="xxx" class="balloon">';
        $view .= '<div><p class="date">';
        $view .= $result['start'] . '→' . $result['end'] . '</p></div>';
        $view .= '<div class="destination">';
        $view .= '<p>' . $result['place'] . '</p>';
        // $view .= '<img id="delete" class="delete" data-key="xxx" src="./img/x.svg" alt="バツボタン">';
        $view .= '</div>';
        $view .= '<div>';
        $view .= '<p class="note">';
        $view .= $result['note'] . '</p>';
        $view .= '</div>';
        $view .= '</div>';
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
    <div class="navtext">たびのしおり（表示画面）</div>
    </div>
    <input type="checkbox" class="menu-btn" id="menu-btn">
    <label for="menu-btn" class="menu-icon"><span class="navicon"></span></label>
    <ul class="menu">
    <li class="top"><a href=index.php>トップ画面</a></li>
    <li><a href=set.php>目的地を登録</a></li>
    </ul>
    </header>
    <!-- リストとマップのテーブル表示 -->
    <div class="formArea">
        <?= $view ?>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="module" src="./js/main.js"></script>
</body>
</html>
