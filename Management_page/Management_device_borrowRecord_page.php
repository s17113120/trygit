<?php
    session_start();
    require_once("../db_connect/db_connect.php");
    require_once('../function/global_function.php');

    if ($_SESSION['membername']) {

    } else {
        unset($_SESSION["membername"]);
        header("Location: ../../../Equipment_management/index.php");
    }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>設備借出紀錄</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <script src="../js/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="../js/sweetalert2.min.css">
    <link rel="stylesheet" href="../css/Animate.css">

    <style>
        @import url('https://fonts.googleapis.com/css?family=Noto+Sans+TC');
        body {
            /* background-color: #e2f1ff; */
            background-size: cover;
            background-repeat: no-repeat;
            background-image: url("../img/56f508af0c640.jpg");
            font-family: 'Noto Sans TC', serif;
        }
        #borrowRecordShowTable > tr > td{
            width: 14%;
            text-align: center;
        }

        .navbar{
			/* background-color:#3fccca; */
            background: linear-gradient(to right, rgba(255, 220, 106, 0.9) , rgba(255, 81, 0, 0.6));
        }
        .searchButton{
            background-color:#ffe6f4;

        }
        .tableheader{
            background-color:#ffcb6a;
        }

        .tableheader > tr > th {
            width: 14%;
            border-top:0px;
        }
        .pageHeader{
            font-style : italic;
            font-weight  : bold;
        }

        .navbar {
            /* border-radius:50px; */
            /* filter: drop-shadow(0px 0px 3px #999999); */
        }
        .btn{
		    border:none;
        }
        .allTableData{
            border-radius:10px;
            overflow:hidden;
            border: 1px solid #dee2e6;
            background-color:#FFFFFF
        }

        </style>
</head>

<body>
    <!-- page Header -->
    <nav class="navbar navbar-expand-lg navbar-dark ">
        <a class="navbar-brand pageHeader ml-sm-3" href="../Management_menu/Management_menu.php">Home</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">

                <div class="dropdown" onmouseover="document.getElementById('deviceDropDownMeun').style.display = 'block';" onmouseout="document.getElementById('deviceDropDownMeun').style.display = 'none';">

                    <li class="nav-item  " id="deviceMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <a class="nav-link pageHeader dropdown-toggle" style="font-style:oblique; font-weight:bold;">Device　</a>
                    </li>

                    <div class="dropdown-menu" id="deviceDropDownMeun" aria-labelledby="deviceMenuButton" style="background-color: rgba(255, 220, 106, 0.9); display: none;" onmouseout="document.getElementById('deviceDropDownMeun').style.display = 'none';">
                        <a class="dropdown-item" href="../Management_page/Management_device_page.php">設備管理</a>
                        <a class="dropdown-item" href="../Management_page/Management_device_normal_page.php">正常</a>
                        <a class="dropdown-item" href="../Management_page/Management_device_damage_page.php">毀損</a>
                        <a class="dropdown-item " href="../Management_page/Management_device_scrappeding_page.php">報廢中</a>
                        <a class="dropdown-item" href="../Management_page/Management_device_hasBeenScrappes_page.php">已報廢</a>
                    </div>
                </div>
                <li class="nav-item">
                    <a class="nav-link pageHeader" href="../Management_page/Management_user_page.php">Users</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link pageHeader" href="../Management_page/Management_borrow_page.php">Borrow</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link pageHeader active" href="../Management_page/Management_device_borrowRecord_page.php">Lended record</a>
                </li>
            </ul>
            <?php echo $_SESSION["membername"];?>　
            <a href="../index.php?logout=true"><button type="button" class="btn btn-outline-dark"><i class="fas fa-sign-out-alt"></i></button></a><!-- logout -->
        </div>
    </nav>

    <div class="container">
        <div class="row mt-3">
            <div class="col">
                <div class="alert alert-warning" style="width:180px" role="alert">
                    <i class="fas fa-arrow-alt-circle-down"></i>　設備借出紀錄
                </div>
            </div>
            <div class="col">

            </div>
            <div class="col-3">
                <!-- search button -->
                <div class="input-group">
                    <input type="text" class="form-control" data-toggle="tooltip" data-html="true" data-placement="bottom" title="<b>學號</b>、<b>財產編號</b>、<b>財產名稱</b>、<b>借出日期</b>、<b>歸還日期</b>、<b>詳細資料</b>、<b>審核人員</b>"  placeholder="Search" id="searchValue">
                    <div class="input-group-append">
                        <button class="btn btn-secondary channlborder" type="button" id="borrowRecordSearchButton"><i class="fas fa-search"></i></button>
                    </div>
                </div>

                <!-- <input class="form-control mr-sm-3" type="text" placeholder="Search" aria-label="Search" id="searchValue" name="searchValue" value=""> -->
            </div>
            <div class="col-0">
                <!-- reset Button -->
                <button type="button" class="btn btn-dark  " id="resetButton"><i class="fas fa-sync-alt"></i></button>
            </div>


        </div>



        <div class="allTableData mt-3" style="">
            <table class="table text-center">
                <thead class="tableheader">
                    <tr>
                        <th scope="col">借出學號</th>
                        <th scope="col">借出財產編號</th>
                        <th scope="col">借出財產名稱</th>
                        <th scope="col">借出日期</th>
                        <th scope="col">歸還日期</th>
                        <th scope="col">詳細資料</th>
                        <th scope="col">審核人員</th>
                    </tr>
                </thead>
                <tbody id="borrowRecordShowTable">

                </tbody>
            </table>

        </div>

        <nav aria-label="Page navigation example" class="mt-3">
            <ul class="pagination justify-content-center" id="pageButtonTable">

            </ul>
        </nav>


    </div>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>


<script>

    window.onload = function(){

        showBorrowRecordFunc();

    }

    let nowClickPage = 0;

    function showBorrowRecordFunc() {
        $.ajax({
            url: '../Management_all_api/Management_device_borrowRecord_api.php',
            method: 'post',
            dataType: 'json',
            data: {
                type: "showAllData",
            }
        }).done( res => {
            let showData = res.toShowData;
            let onePageHowData = 2;
            let howPage = Math.ceil(showData.length / onePageHowData);

            let pageButtomStr = "";
            for(let i=0 ; i<howPage ; i++){
                pageButtomStr +=
                `<li class="page-item"><a class="page-link" onclick="pageButtonClcikFun(this.id)" id="${i+1}">${i+1}</a></li>`;
            }
            document.querySelector("#pageButtonTable").innerHTML = pageButtomStr;



            if (showData.length > 0) {
                showDataStr = "";


                for (let i=0 ; i<showData.length ; i++) {
                    showDataStr +=
                    `<tr data-id="${showData[i].D_Id}" data-page="${Math.ceil((i+1)/onePageHowData)}">
                        <td>
                            ${showData[i].U_Id}
                        </td>
                        <td>
                            ${showData[i].D_Id}
                        </td>
                        <td>
                            ${showData[i].D_Name}
                        </td>
                        <td>
                            ${showData[i].B_Entity_OutDay}
                        </td>
                        <td>
                            ${showData[i].B_Entity_InDay}
                        </td>
                        <td>
                            ${showData[i].B_Details}
                        </td>
                        <td>
                            ${showData[i].B_Check_Single_User}
                        </td>
                    </tr>`;
                }

                document.querySelector("#borrowRecordShowTable").innerHTML = showDataStr;

                if (nowClickPage == 0) {
                        pageButtonClcikFun("", 1);
                    } else {
                        pageButtonClcikFun(nowClickPage);
                    }
            } else {
                document.querySelector("#borrowRecordShowTable").innerHTML = "沒資料";
            }

            console.log(res);
        }).fail( e => {
            console.error(e);
        })
    }

    //pagebuttonclcik
    function pageButtonClcikFun(ob = undefined , page){
        let tr = document.querySelectorAll("tbody > tr");
        if (ob == "" | ob == undefined) {
            for (let i=0 ; i<tr.length ; i++) {
                tr[i].style.display = 'none';
                if (tr[i].dataset.page == 1) {
                    tr[i].style.display = '';
                }
            }
        } else {
            for (let i=0 ; i<tr.length ; i++) {
                tr[i].style.display = 'none';
                if (tr[i].dataset.page == ob) {
                    tr[i].style.display = '';
                }
            }
            nowClickPage = ob;
        }
    }

    // search
    document.querySelector("#borrowRecordSearchButton").onclick = function() {
        $.ajax({
            url: '../Management_all_api/Management_device_borrowRecord_api.php',
            method: 'post',
            dataType: 'json',
            data: {
                type: "search",
                searchvalue: document.querySelector("#searchValue").value.trim(),
            }
        }).done( res => {
            let searchData = res.tosearchdata;
            let onePageHowData = 2;
            let howPage = Math.ceil(searchData.length / onePageHowData);

            let pageButtomStr = "";
            for(let i=0 ; i<howPage ; i++){
                pageButtomStr +=
                `<li class="page-item"><a class="page-link" onclick="pageButtonClcikFun(this.id)" id="${i+1}">${i+1}</a></li>`;
            }
            document.querySelector("#pageButtonTable").innerHTML = pageButtomStr;

            if (searchData.length > 0) {
                searchDataStr = "";


                for (let i=0 ; i<searchData.length ; i++) {
                    searchDataStr +=
                    `<tr data-id="${searchData[i].D_Id}" data-page="${Math.ceil((i+1)/onePageHowData)}">
                         <td>
                             ${searchData[i].U_Id}
                         </td>
                         <td>
                             ${searchData[i].D_Id}
                         </td>
                         <td>
                             ${searchData[i].D_Name}
                         </td>
                         <td>
                             ${searchData[i].B_Entity_OutDay}
                         </td>
                         <td>
                             ${searchData[i].B_Entity_InDay}
                         </td>
                         <td>
                             ${searchData[i].B_Details}
                         </td>
                         <td>
                             ${searchData[i].B_Check_Single_User}
                         </td>
                     </tr>`;
                 }

                document.querySelector("#borrowRecordShowTable").innerHTML = searchDataStr;

                if (nowClickPage == 0) {
                    pageButtonClcikFun("", 1);
                } else {
                    pageButtonClcikFun(nowClickPage);
                }
            } else {
                document.querySelector("#borrowRecordShowTable").innerHTML = "沒資料";
            }

            console.log(res);
        }).fail( e => {
            console.error(e);
        })
    }

    // reset
    document.querySelector("#resetButton").onclick = function(){
        showBorrowRecordFunc();
        document.querySelector("#searchValue").value = "";
    }




</script>
</body>
</html>