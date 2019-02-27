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
    <title>設備正常</title>
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
            background-image: url("../img/20180116113429-c67dd036.jpg");
            font-family: 'Noto Sans TC', serif;
        }
        #deviceShowTable > tr > td{
            width: 11%;
            text-align: center;
        }

        .navbar{
			/* background-color:#3fccca; */
            background: linear-gradient(to right, rgba(255, 113, 201, 0.5) , rgba(255, 243, 166, 0.5));
        }
        .searchButton{
            background-color:#ffe6f4;

        }
        .tableheader{
            background-color:#ffe6f4;
        }

        .tableheader > tr > th {
            width: 11%;
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

                    <li class="nav-item active " id="deviceMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <a class="nav-link pageHeader dropdown-toggle" style="font-style:oblique; font-weight:bold;">Device　</a>
                    </li>

                    <div class="dropdown-menu" id="deviceDropDownMeun" aria-labelledby="deviceMenuButton" style="background-color: rgba(255, 202, 229, 0.9); display: none;" onmouseout="document.getElementById('deviceDropDownMeun').style.display = 'none';">
                        <a class="dropdown-item" href="../Management_page/Management_device_page.php">設備管理</a>
                        <a class="dropdown-item active" href="../Management_page/Management_device_normal_page.php">正常</a>
                        <a class="dropdown-item" href="../Management_page/Management_device_damage_page.php">毀損</a>
                        <a class="dropdown-item" href="../Management_page/Management_device_scrappeding_page.php">報廢中</a>
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
                    <a class="nav-link pageHeader " href="../Management_page/Management_device_borrowRecord_page.php">Lended record</a>
                </li>
            </ul>
            <?php echo $_SESSION["membername"]; ?>　
            <a href="../index.php?logout=true"><button type="button" class="btn btn-outline-dark"><i class="fas fa-sign-out-alt"></i></button></a>  <!-- logout -->
        </div>
    </nav>

    <div class="container">
        <div class="row mt-3">
            <div class="col">
                <div class="alert alert-primary" style="width:180px" role="alert">
                    <i class="fas fa-arrow-alt-circle-down"></i>　設備正常
                </div>
            </div>
            <div class="col">

            </div>
            <div class="col-3">
                <!-- search button -->
                <div class="input-group">
                    <input type="text" class="form-control" data-toggle="tooltip" data-html="true" data-placement="bottom" title="<b>財產編號</b>、<b>S/N</b>、<b>財產名稱	</b>、<b>型號</b>、<b>財增日</b>、<b>保管單位</b>、<b>詳細資料</b>"  placeholder="Search" id="searchValue">
                    <div class="input-group-append">
                        <button class="btn btn-secondary channlborder" type="button" id="deviceSearchButton"><i class="fas fa-search"></i></button>
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
                        <th scope="col">編輯</th>
                        <th scope="col">財產編號</th>
                        <th scope="col">S/N</th>
                        <th scope="col">財產名稱</th>
                        <th scope="col">型號</th>
                        <th scope="col">財增日</th>
                        <th scope="col">保管單位</th>
                        <th scope="col">詳細資料</th>
                        <th scope="col">設備狀況</th>
                    </tr>
                </thead>
                <tbody id="deviceShowTable">

                </tbody>
            </table>

        </div>

        <nav aria-label="Page navigation example" class="mt-3">
            <ul class="pagination justify-content-center" id="pageButtonTable">

            </ul>
        </nav>


    </div>


    <!-- update Modal -->
    <div class="modal fade" id="updateModalCenter" tabindex="-1" role="dialog" aria-labelledby="updateCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div style="background: rgba(255, 213, 0,0.1)" class="modal-header">
                    <h5 class="modal-title" id="updateModalCenterTitle">更新資料 (<font style="color:red">　*　</font>必須填寫)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend" style="min-width:6rem;">
                            <span class="input-group-text w-100" id="basic-addon1"><font style="color:red">*</font>財產編號</span>
                        </div>
                        <input type="text" class="form-control updatecheck" placeholder="" name="deviceUpdateId" id="deviceUpdateId" readonly>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend" style="min-width:6rem;">
                            <span class="input-group-text w-100" id="basic-addon1"><font style="color:red">*</font>S/N</span>
                        </div>
                        <input type="text" class="form-control updatecheck" placeholder="" name="deviceUpdateNumber" id="deviceUpdateNumber" onchange="checkvalueFun(this)">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend" style="min-width:6rem;">
                            <span class="input-group-text w-100" id="basic-addon1"><font style="color:red">*</font>財產名稱</span>
                        </div>
                        <input type="text" class="form-control updatecheck"  placeholder="" name="deviceUpdateName" id="deviceUpdateName" onchange="checkvalueFun(this)">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend" style="min-width:6rem;">
                            <span class="input-group-text w-100" id="basic-addon1"><font style="color:red">*</font>型號</span>
                        </div>
                        <input type="text" class="form-control updatecheck" placeholder="" name="deviceUpdateModel" id="deviceUpdateModel" onchange="checkvalueFun(this)">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend" style="min-width:6rem;">
                            <span class="input-group-text w-100" id="basic-addon1"><font style="color:red">*</font>財增日</span>
                        </div>
                        <input type="date" class="form-control updatecheck" placeholder="" name="deviceUpdateDay" id="deviceUpdateDay" readonly>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend" style="min-width:6rem;">
                            <span class="input-group-text w-100" id="basic-addon1"><font style="color:red">*</font>保管單位</span>
                        </div>
                        <input type="text" class="form-control updatecheck" placeholder="" name="deviceUpdateUnit" id="deviceUpdateUnit" onchange="checkvalueFun(this)">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend" style="min-width:6rem;">
                            <span class="input-group-text w-100" id="basic-addon1">詳細資料</span>
                        </div>
                        <input type="text" class="form-control " placeholder="" name="deviceUpdateDetails" id="deviceUpdateDetails">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend" style="min-width:6rem;">
                            <span class="input-group-text w-100" id="basic-addon1"><font style="color:red">*</font>設備狀態</span>
                        </div>
                        <select class="custom-select updatecheck" id="deviceUpdateStatus" onchange="checkvalueFun(this)">
                            <option selected value="0">正常</option>
                            <option value="1">毀損</option>
                            <option value="2">報廢中</option>
                            <option value="3">已報廢</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="updateModelClose">關閉</button>
                    <button style="background: rgba(255, 213, 0)" type="button" class="btn" id="updateModelSubmit">更新</button>
                </div>
            </div>
        </div>
    </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>


    <script>
        window.onload = function(){

            showDeviceNormalTable();


        }
        let nowClickPage = 0;


        function showDeviceNormalTable(){
            $.ajax({
                url: '../Management_all_api/Management_device_normal_api.php',
                method: 'post',
                dataType: 'json',
                data: {
                    type: "showdevicenormaldata",
                }
            }).done( res => {

                let allNormalData = res.toshowdata;
                let onePageHowData = 2;
                let howPage = Math.ceil(allNormalData.length / onePageHowData);

                let pageButtomStr = "";
                for(let i=0 ; i<howPage ; i++){
                    pageButtomStr +=
                    `<li class="page-item"><a class="page-link" onclick="pageButtonClcikFun(this.id)" id="${i+1}">${i+1}</a></li>`;
                }
                document.querySelector("#pageButtonTable").innerHTML = pageButtomStr;

                if (allNormalData.length > 0) {

                    let allNormalDataStr = "";
                    for (let i=0 ; i<allNormalData.length ; i++) {
                        allNormalDataStr +=
                        `<tr data-id="${allNormalData[i].D_Id}" data-page="${Math.ceil((i+1)/onePageHowData)}">
                            <td>
                                <!-- update Button -->
                                <button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target="#updateModalCenter" id="${allNormalData[i].D_Id}" onclick="updateFunc(this)"><i class="fas fa-pencil-alt"></i></button>

                            </td>
                            <td data-type="D_Id">
                                ${allNormalData[i].D_Id}
                            </td>
                            <td data-type="D_Number">
                                ${allNormalData[i].D_Number}
                            </td>
                            <td data-type="D_Name">
                                ${allNormalData[i].D_Name}
                            </td>
                            <td data-type="D_Model">
                                ${allNormalData[i].D_Model}
                            </td>
                            <td data-type="D_Day">
                                ${allNormalData[i].D_Day}
                            </td>
                            <td data-type="D_Unit">
                                ${allNormalData[i].D_Unit}
                            </td>
                            <td data-type="D_Details">
                                ${allNormalData[i].D_Details}
                            </td>
                            <td data-type="D_Lend">
                                ${(allNormalData[i].D_Status == 0 ? "正常" : "怪怪的")}
                            </td>
                        </tr>`;
                    }

                    document.querySelector("#deviceShowTable").innerHTML = allNormalDataStr;

                    if (nowClickPage == 0) {
                        pageButtonClcikFun("", 1);
                    } else {
                        pageButtonClcikFun(nowClickPage);
                    }
                } else {
                    document.querySelector("#deviceShowTable").innerHTML = "沒資料";
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

        //search
        document.querySelector("#deviceSearchButton").onclick = function (){
            let searchValue = document.querySelector("#searchValue");
            if (searchValue.value == "" || searchValue.value == undefined) {
                Swal.fire({
                    type: 'error',
                    title: '請輸入搜尋值',
                    text: '',
                })
            } else {
                $.ajax({
                    url: '../Management_all_api/Management_device_normal_api.php',
                    method: 'post',
                    dataType: 'json',
                    data: {
                        type: "searchdata",
                        searchvalue: searchValue.value.trim(),
                    }
                }).done( res => {
                    let searchData = res.tosearchData;
                    let searchDataStr = "";

                    let onePageHowData = 2;
                    let howPage = Math.ceil(searchData.length / onePageHowData);

                    let pageButtomStr = "";
                    for(let i=0 ; i<howPage ; i++){
                        pageButtomStr +=
                        `<li class="page-item"><a class="page-link" onclick="pageButtonClcikFun(this.id)" id="${i+1}">${i+1}</a></li>`;
                    }

                    document.querySelector("#pageButtonTable").innerHTML = pageButtomStr;

                    if (searchData.length > 0) {
                        for (let i=0 ; i<searchData.length ; i++) {
                            searchDataStr +=
                                `<tr data-id="${searchData[i].D_Id}" data-page="${Math.ceil((i+1)/onePageHowData)}">
                                <td>
                                    <!-- update Button -->
                                    <button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target="#updateModalCenter" id="${searchData[i].D_Id}" onclick="updateFunc(this)"><i class="fas fa-pencil-alt"></i></button>

                                </td>
                                <td data-type="D_Id">
                                    ${searchData[i].D_Id}
                                </td>
                                <td data-type="D_Number">
                                    ${searchData[i].D_Number}
                                </td>
                                <td data-type="D_Name">
                                    ${searchData[i].D_Name}
                                </td>
                                <td data-type="D_Model">
                                    ${searchData[i].D_Model}
                                </td>
                                <td data-type="D_Day">
                                    ${searchData[i].D_Day}
                                </td>
                                <td data-type="D_Unit">
                                    ${searchData[i].D_Unit}
                                </td>
                                <td data-type="D_Details">
                                    ${searchData[i].D_Details}
                                </td>
                                <td data-type="D_Lend">
                                    ${(searchData[i].D_Status == 0 ? "正常" : "怪怪的")}
                                </td>
                            </tr>`;
                        }

                        document.querySelector("#deviceShowTable").innerHTML = searchDataStr;

                        nowClickPage = 1;

                        if (nowClickPage == 0) {
                            pageButtonClcikFun("", 1);
                        } else {
                            pageButtonClcikFun(nowClickPage);
                        }

                    } else {
                        document.querySelector("#deviceShowTable").innerHTML = "沒資料";
                    }

                    console.log(res);
                }).fail( e => {
                    console.error(e);
                })
            }

        }

        //reset
        document.querySelector("#resetButton").onclick = function(){
            document.querySelector("#searchValue").value = "";
            showDeviceNormalTable();
        }

        //update
        function updateFunc(ob){
            let deviceUpdateId = document.querySelector("#deviceUpdateId");
            let deviceUpdateNumber = document.querySelector("#deviceUpdateNumber");
            let deviceUpdateName = document.querySelector("#deviceUpdateName");
            let deviceUpdateModel = document.querySelector("#deviceUpdateModel");
            let deviceUpdateDay = document.querySelector("#deviceUpdateDay");
            let deviceUpdateUnit = document.querySelector("#deviceUpdateUnit");
            let deviceUpdateDetails = document.querySelector("#deviceUpdateDetails");
            let deviceUpdateStatus = document.querySelector("#deviceUpdateStatus");

            deviceUpdateId.value = document.querySelector("[data-id='"+ob.id+"'] > [data-type=D_Id]").innerHTML.trim();
            deviceUpdateNumber.value = document.querySelector("[data-id='"+ob.id+"'] > [data-type=D_Number]").innerHTML.trim();
            deviceUpdateName.value = document.querySelector("[data-id='"+ob.id+"'] > [data-type=D_Name]").innerHTML.trim();
            deviceUpdateModel.value = document.querySelector("[data-id='"+ob.id+"'] > [data-type=D_Model]").innerHTML.trim();
            deviceUpdateDay.value = document.querySelector("[data-id='"+ob.id+"'] > [data-type=D_Day]").innerHTML.trim();
            deviceUpdateUnit.value = document.querySelector("[data-id='"+ob.id+"'] > [data-type=D_Unit]").innerHTML.trim();
            deviceUpdateDetails.value = document.querySelector("[data-id='"+ob.id+"'] > [data-type=D_Details]").innerHTML.trim();
            deviceUpdateStatus.value = 0;

            console.log();
        }

        document.querySelector("#updateModelSubmit").onclick = function(){

            let datecheck =document.querySelectorAll(".updatecheck");
            let noValueTime = 0;
            for(let totalCheck of datecheck){
                if(totalCheck.value == "" || totalCheck.value == undefined){
                    totalCheck.style.borderColor = "red";
                    noValueTime++;
                } else {
                    totalCheck.style.borderColor = "green";
                }
            }
            if (noValueTime > 0) {
                Swal({
                    type: 'error',
                    title: '資料尚未填寫完全',
                    text: '紅框請寫完成',
                    animation: false,
                    customClass: 'animated tada'
                })
            } else {
                $.ajax({
                    url: '../Management_all_api/Management_device_normal_api.php',
                    method: 'post',
                    dataType: 'json',
                    data: {
                        type: "update",
                        deviceUpdateId: document.querySelector("#deviceUpdateId").value,
                        deviceUpdateNumber: document.querySelector("#deviceUpdateNumber").value,
                        deviceUpdateName: document.querySelector("#deviceUpdateName").value,
                        deviceUpdateModel: document.querySelector("#deviceUpdateModel").value,
                        deviceUpdateDay: document.querySelector("#deviceUpdateDay").value,
                        deviceUpdateUnit: document.querySelector("#deviceUpdateUnit").value,
                        deviceUpdateDetails: document.querySelector("#deviceUpdateDetails").value,
                        deviceUpdateStatus: document.querySelector("#deviceUpdateStatus").value,
                    }
                }).done( res => {

                    if (res.tocheckallnumbertruefalse) {
                        Swal.fire({
                            type: 'error',
                            title: 'S/N已存在',
                            text: '',
                        })
                    } else {
                        if (res.toupdatedata) {
                            Swal.fire(
                                '更新成功',
                                '',
                                'success'
                            )

                            document.querySelector("#updateModelClose").click();

                            showDeviceNormalTable();

                            // console.log("now"+nowClickPage);

                        } else {
                            Swal.fire({
                            type: 'error',
                            title: '更新失敗',
                            text: '',
                            })
                        }
                    }

                    console.log(res);
                }).fail( e => {
                    console.error(e);
                })

            }
            // console.log(res);
        }

        function checkvalueFun(ob){
            if (ob.value == "") {
                ob.style.borderColor = "red";
            } else {
                ob.style.borderColor = "green";
            }
        }

        //bootstrap
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        // $('#example').tooltip(options)


    </script>
</body>
</html>