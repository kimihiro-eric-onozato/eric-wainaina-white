<?php
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE =>
PDO::ERRMODE_WARNING));

//入力フォーム
if( (!empty($_POST["name"])&&($_POST["comment"])&&($_POST["password"])) && (empty($_POST["edit/"]))) {
    $sql = $pdo -> prepare("INSERT INTO EWG20 (name,comment,datetime,password) VALUES (:name, :comment, :datetime, :password)");
    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
    $sql -> bindParam(':datetime', $datetime, PDO::PARAM_STR);
    $sql -> bindParam(':password', $password, PDO::PARAM_STR);
    $name = $_POST["name"];
    $comment = $_POST["comment"];
    $datetime = date("Y:m:d H:i:s");
    $password = $_POST["password"];
    $sql -> execute();
}

//削除
if(!empty($_POST["password2"])) {
    $password2 = $_POST["password2"];
    $sql = 'SELECT * FROM EWG20';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
         $id = $row['id'];
         $password = $row['password'];
         if( ($password == $password2) and ($id == $_POST["delete"]) ) {
              $sql = "delete from EWG20 where id=:id";
              $stmt = $pdo->prepare($sql);
              $stmt->bindParam(':id', $id, PDO::PARAM_INT);
              $stmt->execute();
         }
    }
}

//編集選択
if(!empty($_POST["password3"])) {
    $password3 = $_POST["password3"];
    $sql = 'SELECT * FROM EWG20';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row) {
        $id = $row['id'];
        $name = $row['name'];
        $comment = $row['comment'];
        $password = $row['password'];
        if( ($password == $password3) and ($id == $_POST["editscore"]) ) {
            $password4 = $password;
            $edit_comment = $comment;
            $edit_name = $name;
            $editscore = $_POST["editscore"];
        }
    }
}

//編集
if( (!empty($_POST["name"])&&($_POST["comment"])&&($_POST["password"])&&($_POST["edit/"]))) {
$id = $_POST["edit/"];
$name = $_POST["name"];
$comment = "これはテストです";
$datetime = date("Y:m:d H:i:s");
$password = $_POST["password"];
$sql = 'update EWG20 set name=:name,comment=:comment,datetime=:datetime,password=:password where id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':name', $name, PDO::PARAM_STR);
$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
$stmt->bindParam(':datetime', $datetime, PDO::PARAM_STR);
$stmt->bindParam(':password', $password, PDO::PARAM_STR);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
}
?>

<!DOCTYPE HTML>
<html lang="ja">
<head>
<title>mission_4-1</title>
</head>
<body>
<form action = "mission_4-1-2.php" method = "post">

<p>
<input type = "text" name = "name" value = "<?php echo $edit_name; ?>" placeholder = "名前を記入してください">
</p>
<p>
<input type = "text" name = "comment" value = "<?php echo $edit_comment; ?>" placeholder = "コメントを記入してください">
</p>
<p>
<input type = "text" name = "password" value = "<?php echo $password4; ?>" placeholder = "パスワード">
</p>
<p>
<input type = "hidden" name = "edit/" value = "<?php echo $editscore; ?>" placeholder = "">
</p>
<input type = "submit" value = "送信">

<p>
<input type = "text" name = "delete" placeholder = "削除対象番号">
</p>
<p>
<input type = "text" name = "password2" placeholder = "パスワード">
</p>
<input type = "submit" value = "削除">

<p>
<input type = "text" name = "editscore" placeholder = "編集対象番号">
</p>
<p>
<input type = "text" name = "password3" placeholder = "パスワード">
</p>
<input type = "submit" value = "編集">
</form>

<?php
//入力確認 データ検索
$sql = 'SELECT * FROM EWG20';
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll();
foreach ($results as $row){
  echo $row['id'].',';
  echo $row['name'].',';
  echo $row['comment'].',';
  echo $row['datetime'].'<br>';
}
?>

</body>
</html>
