<?php
    session_start();
    require_once('function/global_function.php');
    // print_r($_POST);
    if (!isset($_SESSION["membername"]) || ($_SESSION["membername"] == "")) {
        if (isset($_POST["loginUser"]) && isset ($_POST["loginPassowrd"])) {
            $result = "SELECT `U_Id`,`U_Name`,`U_Permission` FROM `user` WHERE `U_Id`= ? AND `U_Password` = ?;";
            $check = sqlQry( $result , [$_POST["loginUser"],$_POST["loginPassowrd"]] );//SQL語法查詢資料 ?對應後面值

            if ($check) {
                // var_dump($check);
                $_SESSION["membername"] = $check[0]['U_Id'];//陣列Array()
            } else {

                // echo "<script>alert('帳號或密碼輸入錯誤');</script>";


            }

        }
    }
    if(isset($_GET["logout"]) && ($_GET["logout"]) == "true"){
		unset($_SESSION["membername"]);
		header("Location: ../Equipment_management/index.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=big5">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <!-- <meta http-equiv="X-UA-Compatible" content="ie=edge"> -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <!-- <script src="../js/sweetalert2.all.min.js"></script> -->
    <!-- <link rel="stylesheet" href="../js/sweetalert2.min.css"> -->
    <title>登入</title>
</head>
<style>

.widthstyle{
    min-width:4rem;
}

body {
    margin: 0;
    padding: 0;
    font-family: sans-serif;
    background-image: url("../Equipment_management/img/DSC04612.JPG");
    background-size: cover;
    background-repeat: no-repeat;
}

.box {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
    width: 400px;
    /* height: 40px; */
    padding: 40px;
    background: rgba(0,0,0,.8);
    box-sizing: border-box;
    box-shadow: 0 15px 25px rgba(0,0,0,.5);
    border-radius: 10px;
}
.box h2{
    margin: 0 0 30px;
    padding: 0;
    color: #FFF;
    text-align: center;
}

.box .inputBox {
    position: relative;
}

.box .inputBox input {
    width: 100%;
    padding: 10px 0;
    font-size: 16px;
    color: #FFF;
    letter-spacing: 1px;
    margin-bottom: 30px;
    border: none;
    border-bottom: 1px solid #FFF;
    outline: none;
    background: transparent;
}

.box .inputBox label {
    position: absolute;
    top: 0;
    left: 0;
    padding: 10px 0;
    font-size: 16px;
    color: #FFF;
    letter-spacing: 1px;
    pointer-events: none;
    transition: .5s;
}


.box .inputBox input:focus ~ label,
.box .inputBox input:valid ~ label{
    top: -18px;
    left: 0;
    color: #03a9f4;
    font-size: 12px;
}

/* .box input[type="submit"]{
    background: transparent;
    border: none;
    outline: none;
    color: #fff;
    background: #03a9f4;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
} */

#loginSubmit {
    float:right ;
}

</style>


<body>

<?php
	if(!isset($_SESSION["membername"]) || ($_SESSION["membername"] == "")){
?>

<div class="box">
    <h2>Login</h2>
    <form id="loginFrom" method="post" action="index.php">
        <div class="inputBox">
            <input type="text" class="" required="" aria-label="" aria-describedby="" name="loginUser" id="loginUser">
            <label>Username</label>
        </div>
        <div class="inputBox">
            <input type="password" class="" required="" aria-label="" aria-describedby="" name="loginPassowrd" id="loginPassowrd">
            <label>password</label>
        </div>

        <button type="button" class="btn btn-outline-primary" name="loginSubmit" id="loginSubmit"><i class="fas fa-sign-in-alt"></i></button>

    </form>

<?php

} else {

    $check = sqlQry("SELECT `U_Permission` FROM `user` WHERE `U_Id`= ?;",[$_SESSION["membername"]]);

        if( $check[0]['U_Permission'] == 2){
            header("Location:Management_menu/Management_menu.php");
        } else if ($check[0]['U_Permission'] == 1){
            header("Location:Visitor_menu/Visitor_menu.php");
        }



}
?>


</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

<script>

    document.querySelector("#loginSubmit").onclick = function(){

        let loginUser = document.querySelector("#loginUser").value;
        let loginPassowrd = document.querySelector("#loginPassowrd").value;

        if (loginUser == "" || loginUser == undefined && loginPassowrd == "" || loginPassowrd == undefined) {
            alert("請輸入帳號密碼");
        } else if (loginUser == "" || loginUser == undefined) {
            alert("請輸入帳號");
        } else if (loginPassowrd == "" || loginPassowrd == undefined) {
            alert("請輸入密碼");
        } else {
            document.getElementById("loginFrom").submit()
        }

    }

</script>

</body>
</html>