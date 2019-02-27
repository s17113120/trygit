<?php
    session_start();
    // echo $_SESSION['membername'];
    if ($_SESSION['membername']) {
        // echo ($_SESSION['membername']);
    } else {
        unset($_SESSION["membername"]);
        header("Location: ../index.php");
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>menu</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <style>
        /* body{
            background-image: url('../img/1-1F513095438.jpg');
            background-size: cover;
            background-repeat: no-repeat;
        }
        .btn{
            margin:5px;
            width:300px;
            height: 75px;
            border-radius:75px;
            font-size:20px;
        }
        .container{
			display:relative;
			top: 50%;
			position: absolute;
			left: 50%;
			transform: translate(-50%,-50%);
        }
        .btn{
            background-color:rgba(255, 255, 255, 1);
        } */
        body {
        margin: 0;
        padding: 0;
        font-family: sans-serif;
        background: #20024a;
    }

    .container {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
        width: 1000px;
        height: 500px;
        display: flex;
    }

    .container .box {
        position: relative;
        width: 250px;
        height: 500px;
        background: #ccc;
        transition: 0.5s;
    }

    .container .box:hover {
        transform: scale(1.1);
        z-index: 1;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 1)
    }

    .container .box .thumb {
        position: absolute;
        width: 100%;
        height: 250px;
        overflow: hidden;
    }

    .container .box:nth-child(odd) .thumb {
        bottom: 0;
        left: 0;
    }

    .container .box .thumb img {
        width: 100%;
    }

    .container .box .details {
        position: absolute;
        width: 100%;
        height: 250px;
        overflow: hidden;
        background: #262626;
    }
    .container .box:nth-child(even) .details {
        bottom: 0;
        left: 0;
    }
    .container .box:nth-child(1) .details {
        background: #8553cb;
    }
    .container .box:nth-child(2) .details {
        background: #fe8f01;
    }
    .container .box:nth-child(3) .details {
        background: #79d400;
    }
    .container .box:nth-child(4) .details {
        background: #ff3b34;
    }

    .container .box .details .content {
        position: absolute;
        top: calc(50% + 16px);
        transform: translateY(-50%);
        width: 100%;
        padding: 20px;
        box-sizing: border-box;
        text-align: center;
        transition: 0.5s;
    }

    .container .box:hover .details .content {
        top:calc(50%);
    }

    .container .box .details .content .fas {
        font-size: 80px;
        color: #fff;
    }

    .container .box .details .content h3 {
        margin: 0;
        padding: 0;
        padding: 10px 0;
        color: #fff;
    }

    .container .box .details .content a {
        display: inline-block;
        padding: 5px 20px;
        color: #fff;
        border: 2px solid #fff;
        text-decoration: none;
        transition: 0.5s;
        border-radius: 20px;
        transform: scale(0);
    }

    .container .box:hover .details .content a {
        transform: scale(1);
    }

    .container .box .details .content a:hover {
        background: #fff;
        color: #262626;
    }

    .container .box .thumb img {
        width: 500px;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }

    </style>
</head>
<body>
        <div class="container">
            <div class="box">
                <div class="thumb">
                    <img src="../img/20180116113429-c67dd036.jpg">
                </div>
                <div class="details">
                    <div class="content">
                        <i class="fas fa-desktop"></i>
                        <h3>Equipment management</h3>
                        <a href="../Management_page/Management_device_page.php">Read More</a>
                    </div>
                </div>
            </div>
            <div class="box">
                <div class="thumb">
                    <img src="../img/20170915_020223_43e8378c_w1920.jpg">
                </div>
                <div class="details">
                    <div class="content">
                        <i class="fas fa-users-cog"></i>
                        <h3>User management</h3>
                        <a href="../Management_page/Management_user_page.php">Read More</a>
                    </div>
                </div>
            </div>
            <div class="box">
                <div class="thumb">
                    <img src="../img/images.jpg">
                </div>
                <div class="details">
                    <div class="content">
                        <i class="fas fa-globe"></i>
                        <h3>borrow</h3>
                        <a href="../Management_page/Management_borrow_page.php">Read More</a>
                    </div>
                </div>
            </div>
            <div class="box">
                <div class="thumb">
                    <img src="../img/56f508af0c640.jpg">
                </div>
                <div class="details">
                    <div class="content">
                    <i class="fas fa-address-card"></i>
                        <h3>Lended record</h3>
                        <a href="../Management_page/Management_device_borrowRecord_page.php">Read More</a>
                    </div>
                </div>
            </div>
            <div class="box">
                <div class="thumb">
                    <img src="../img/1-1F513095438.jpg">
                </div>
                <div class="details">
                    <div class="content">
                        <i class="fas fa-sign-out-alt"></i>
                        <a href="../index.php?logout=true">Logout</a>
                    </div>
                </div>
            </div>
        </div>



<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</body>
</html>