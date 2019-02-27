<?php

// require_once("./db_connect/db_connect.php");
// require_once("./db_connect/sql.php");
global $db;
$db = new PDO('mysql:host=localhost;dbname=endwork;charset=utf8','root','');

/*
sqlQry( $cmd , $array );
	資料查詢
傳入參數：
	$cmd：SQL指令，string   ex： SELECT * FROM TableName WHERE ColNameA = ? AND ColNameB = ? OR ColNameC = ?
	$array：陣列參數  		ex： array('A','B','C')
傳出參數：
	SQL result array：SQL query集合fetch()後的陣列 ex：array[N]["ColName"]
*/
function sqlQry( $sql, $sql_array ){
	global $db;
	// echo $sql;
	$sth = $db -> prepare($sql);
	$sth -> execute($sql_array);
	if( $sth -> errorCode() != '00000' ){
		$error = $sth -> errorInfo();
		// echo "Error : ".$error[2];
		return false;
	}
	$sth->setFetchMode(PDO::FETCH_ASSOC);

	$result = filter_var_array($sth -> fetchAll(), FILTER_SANITIZE_MAGIC_QUOTES);
	if( count($result) == 0 )
		$result = array();

	return $result;
}


/*
sqlEdit( $cmd , $array );
	資料寫入、更新與刪除
傳入參數：
	$cmd：SQL指令，string	ex： UPDATE TableName SET ColNameA = ? WHERE ColNameB = ? OR ColNameC = ?
	$array：陣列參數  		ex： array('A','B','C')
傳出參數：
	ture or false
*/
function sqlEdit( $sql, $sql_array ){
	global $db;

	//$sql_exec = $db->exec( $cmd );

	$sth = $db -> prepare($sql);
	$sth -> execute($sql_array);
	if( $sth -> errorCode() != '00000' ){
		$error = $sth -> errorInfo();
		//echo "Error : ".$error[2];
		return false;
	}
	return true;
}

function checkLoginStatus(){
    if(!isset($_SESSION["Staff_ID"])) {
        echo "<script>";
        echo "alert('尚未登入！')";
        echo "</script>";
        echo "<script>";
        echo "document.location.href='login.php';";
        echo "</script>";
    } else {

    }
}

function getCSRFToken(){
	if(empty($_SESSION['csrf'])){
		$_SESSION['csrf'] = sha1(microtime());
	}else{
		echo $_SESSION['csrf'];
	}
}

// function isEmptyPostData($postData, $arr)
// {
// 	$result == false;
// 	foreach ($arr as $index) {
// 		if (empty($postData[$index])) {
// 			$result == true;
// 		}
// 	}
// 	return $result;
// }

?>