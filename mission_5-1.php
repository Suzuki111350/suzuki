<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_5-1</title>
</head>
<body>
<?php
    
     //DB接続設定
    $dsn = 'データベース名';
    $user = 'ユーザー名';
    $password ='パスワード';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	$sql = "CREATE TABLE IF NOT EXISTS tbtest"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "name char(32),"
	. "comment TEXT,"
	. "time TEXT"
	.");";
	$stmt = $pdo->query($sql);


    //INSERT文：データ入力(データレコードの挿入)
    //投稿機能開始
    if(isset($_POST['submit'])){
        $name = $_POST['name']; 
        $comment = $_POST['comment'];
        $pass = $_POST['password'];
        $time = date("Y/m/d H:i:s");
            
        if($pass== "1212") { //投稿番号のパスワード「1212」が一致すれば
            $sql = $pdo -> prepare('INSERT INTO tbtest (name, comment, time ) VALUES (:name, :comment, :time)');
             
	        $sql -> bindParam(':name', $name, PDO::PARAM_STR);
            $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
            $sql -> bindParam(':time', $time, PDO::PARAM_STR);
            
            $sql -> execute();
            
            $sql = 'SELECT * FROM tbtest';  // テーブル名(tbtest)からデータを戻り値として返させる
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();  
            foreach ($results as $row){ //ループさせる
            echo $row['id'].',';
            echo $row['name'].',<br>';
            echo $row['comment'].',<br>';
            echo $row['time'].'<br>';
            echo '<hr>';
                }
            }
        }
        //投稿機能終了
        
        
        //削除機能開始
        if(isset($_POST['delete'])){
            $deletenumber = $_POST['deletenumber'];//変数にポストされた内容を入れる
            $passkey = $_POST['pass'];//変数にポストされたパスワードを入れる
            if($passkey== "1212") { //削除番号のパスワード「1212」が一致すれば
                if(isset($_POST['pass'])){
                    $id = $deletenumber;
                    $sql = 'delete from tbtest where id=:id';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();

                    $sql = 'SELECT * FROM tbtest';  // テーブル名(tbtest)からデータを戻り値として返させる
	                $stmt = $pdo->query($sql);
                    $results = $stmt->fetchAll();  
	                foreach ($results as $row){ //ループさせる
	    	        echo $row['id'].',';
	    	        echo $row['name'].',<br>';
                    echo $row['comment'].'<br>';
                    echo '<hr>';
                    }
                    }else{
                        $error2 = "パスワードの入力が必要です";
                        echo "$error2<br>";
                        }
                    }       
                }
                
        //削除機能終了
        
        
        //編集機能開始
                
        if(isset($_POST['edit'])){//編集したい投稿番号が入力されたとき
            $edit = $_POST['editnumber'];
            $edpass = $_POST['editpass'];
            
            if($edpass== "1212") { //編集番号のパスワード「1212」が一致すれば
            
            if($edit != ''){                
                $id = $edit; //変更する投稿番号
                $name = $_POST['editname'];
    	        $comment = $_POST['editcomment']; 
    	        $sql = 'UPDATE tbtest SET name=:name,comment=:comment WHERE id=:id';
    	        $stmt = $pdo->prepare($sql);
    	        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    	        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    	        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                        
                $sql = 'SELECT * FROM tbtest';  //テーブル名(tbtest)からデータを戻り値として返させる
    	        $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();  
    	        foreach ($results as $row){ //ループさせる
    	        echo $row['id'].',';
    	    	echo $row['name'].',<br>';
                echo $row['comment'].'<br>';
                echo '<hr>';
                }
                }else{
                $error3 = "番号の入力が必要です";
                echo "$error3<br>";
                    }
                }
            }
        
        //編集機能終了  
    ?>
    
    <form action=""method="post">
    【投稿】<br>
    <input type="text" name="name" placeholder="名前">
    <input type="text" name="comment" placeholder="コメント">
    <input type="text" name="password" placeholder="パスワード">
    <input type="submit" name="submit" value="送信">
    <br>【削除】<br>
    <input type="number" name="deletenumber" placeholder="番号を入力">
    <input type="text" name="pass" placeholder="パスワード">
    <input type="submit" name="delete" value="削除">
    <br>【編集】<br>
    <input type="number" name="editnumber" placeholder="番号を入力">
    <input type="text" name="editname" placeholder="変更後の名前">
    <input type="text" name="editcomment" placeholder="変更後のコメント">
    <input type="text" name="editpass" placeholder="パスワード">
    <input type="submit" name="edit" value="変更">


</form>
</body>
</html>