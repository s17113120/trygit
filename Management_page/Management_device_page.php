<?php
    session_start();
    require_once("../db_connect/db_connect.php");
    require_once('../function/global_function.php');

    if ($_SESSION['membername']) {

    } else {
        unset($_SESSION["membername"]);
        header("Location: ../Equipment_management/index.php");
    }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>設備資料</title>
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

                <div class="dropdown" style="" onmouseover="document.getElementById('deviceDropDownMeun').style.display = 'block';" onmouseout="document.getElementById('deviceDropDownMeun').style.display = 'none';">
                    <!-- <button class="btn btn-secondary dropdown-toggle" type="button" id="deviceMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: rgba(0, 0, 0, 0); text" onmouseout="deviceDivFun()">
                        <span style="font-style:oblique; font-weight:bold;">Device</span>
                    </button> -->
                    <li class="nav-item active " id="deviceMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <a class="nav-link pageHeader dropdown-toggle" style="font-style:oblique; font-weight:bold;">Device　</a>
                    </li>
                     <!-- <li class="nav-item active" onmouseout="deviceDivFun()" >
                        <a class="nav-link pageHeader" href="#" id="deviceMenuButton">Device<span class="sr-only">(current)</span></a>
                    </li> -->
                    <div class="dropdown-menu" id="deviceDropDownMeun" aria-labelledby="deviceMenuButton" style="background-color: rgba(255, 202, 229, 0.9); display: none;" onmouseout="document.getElementById('deviceDropDownMeun').style.display = 'none';">
                        <a class="dropdown-item active" href="../Management_page/Management_device_page.php">設備管理</a>
                        <a class="dropdown-item" href="../Management_page/Management_device_normal_page.php">正常</a>
                        <a class="dropdown-item" href="../Management_page/Management_device_damage_page.php">毀損</a>
                        <a class="dropdown-item" href=".//Management_device_scrappeding_page.php">報廢中</a>
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
                <!-- add Buttun -->
                <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#addForm" id="addButtonpage" value="123"><i class="fas fa-plus"></i></button>
            </div>
            <div class="col">


            </div>
            <div class="col-3">
                <!-- search button -->
                <div class="input-group">
                    <input type="text" class="form-control" data-toggle="tooltip" data-html="true" data-placement="bottom" title="<b>財產編號</b>、<b>S/N</b>、<b>財產名稱	</b>、<b>型號</b>、<b>財增日</b>、<b>保管單位</b>、<b>詳細資料</b>、<b>借出狀況</b>"  placeholder="Search" id="searchValue">
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
                        <th scope="col">借出狀況</th>
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


    <!-- add Modal -->
        <div class="modal fade" id="addForm" tabindex="-1" role="dialog" aria-labelledby="addModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div style="background: rgba(0, 157, 255,0.1)" class="modal-header">
                        <h5 class="modal-title" id="addModalCenterTitle">新增設備 (<font style="color:red">　*　</font>必須填寫)</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend" style="min-width:6rem;">
                                <span class="input-group-text w-100" id="basic-addon1"><font style="color:red">*</font>財產編號</span>
                            </div>
                            <input type="text" class="form-control addText" placeholder="" name="addDeviceId" id="addDeviceId" onchange="checkaddmodelvalue(this)">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend" style="min-width:6rem;">
                                <span class="input-group-text w-100" id="basic-addon1"><font style="color:red">*</font>S/N</span>
                            </div>
                            <input type="text" class="form-control addText" placeholder="" name="addDeviceNumber" id="addDeviceNumber" onchange="checkaddmodelvalue(this)">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend" style="min-width:6rem;">
                                <span class="input-group-text w-100" id="basic-addon1"><font style="color:red">*</font>財產名稱</span>
                            </div>
                            <input type="text" class="form-control addText" placeholder="" name="addDeviceName" id="addDeviceName" onchange="checkaddmodelvalue(this)">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend" style="min-width:6rem;">
                                <span class="input-group-text w-100" id="basic-addon1"><font style="color:red">*</font>型號</span>
                            </div>
                            <input type="text" class="form-control addText" placeholder="" name="addDeviceModel" id="addDeviceModel" onchange="checkaddmodelvalue(this)">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend" style="min-width:6rem;">
                                <span class="input-group-text w-100" id="basic-addon1"><font style="color:red">*</font>財增日</span>
                            </div>
                            <input type="date" class="form-control addText" placeholder="" name="addDeviceDay" id="addDeviceDay" onchange="checkaddmodelvalue(this)">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend" style="min-width:6rem;">
                                <span class="input-group-text w-100" id="basic-addon1"><font style="color:red">*</font>保管單位</span>
                            </div>
                            <input type="text" class="form-control addText" placeholder="" name="addDeviceUnit" id="addDeviceUnit" onchange="checkaddmodelvalue(this)">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend" style="min-width:6rem;">
                                <span class="input-group-text w-100" id="basic-addon1">詳細資料</span>
                            </div>
                            <textarea class="form-control" name="addDeviceDetails" id="addDeviceDetails" onchange="checkaddmodelvalue(this)" aria-label="With textarea"></textarea>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend" style="min-width:6rem;">
                                <span class="input-group-text w-100" id="basic-addon1"><font style="color:red">*</font>設備狀態</span>
                            </div>
                            <select class="custom-select addText" id="addDeviceStatus" onchange="checkaddmodelvalue(this)" >
                                <option selected value="0">正常</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="addDeviceClose">關閉</button>
                        <button style="background: rgb(0, 102, 255)" type="button" class="btn" id="addDeviceSubmit"><font color="#ffffff">新增</font></button>
                    </div>
                </div>
            </div>
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
                        <input type="text" class="form-control" placeholder="" name="deviceUpdateId" id="deviceUpdateId" readonly>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend" style="min-width:6rem;">
                            <span class="input-group-text w-100" id="basic-addon1"><font style="color:red">*</font>S/N</span>
                        </div>
                        <input type="text" class="form-control" placeholder="" name="deviceUpdateNumber" id="deviceUpdateNumber">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend" style="min-width:6rem;">
                            <span class="input-group-text w-100" id="basic-addon1"><font style="color:red">*</font>財產名稱</span>
                        </div>
                        <input type="text" class="form-control" placeholder="" name="deviceUpdateName" id="deviceUpdateName">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend" style="min-width:6rem;">
                            <span class="input-group-text w-100" id="basic-addon1"><font style="color:red">*</font>型號</span>
                        </div>
                        <input type="text" class="form-control" placeholder="" name="deviceUpdateModel" id="deviceUpdateModel">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend" style="min-width:6rem;">
                            <span class="input-group-text w-100" id="basic-addon1"><font style="color:red">*</font>財增日</span>
                        </div>
                        <input type="date" class="form-control" placeholder="" name="deviceUpdateDay" id="deviceUpdateDay">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend" style="min-width:6rem;">
                            <span class="input-group-text w-100" id="basic-addon1"><font style="color:red">*</font>保管單位</span>
                        </div>
                        <input type="text" class="form-control" placeholder="" name="deviceUpdateUnit" id="deviceUpdateUnit">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend" style="min-width:6rem;">
                            <span class="input-group-text w-100" id="basic-addon1">詳細資料</span>
                        </div>
                        <textarea class="form-control" aria-label="With textarea" name="deviceUpdateDetails" id="deviceUpdateDetails"></textarea>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend" style="min-width:6rem;">
                            <span class="input-group-text w-100" id="basic-addon1"><font style="color:red">*</font>設備狀態</span>
                        </div>
                        <select class="custom-select" id="deviceUpdateStatus">
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
        // debugger;
        window.onload = function(){
            showDeviceAllDataTable();

            // howManyPageButtunFunc('1');
        }
        let nowClickPage = 0;

        // showdata
        function showDeviceAllDataTable(){
            $.ajax({
                url: '../Management_all_api/Management_device_api.php',
                method: 'post',
                dataType: 'json',
                data: {
                    type: "showAllData",
                }
            }).done( res =>{
                let backShowAllData = res.returnShowAllData;

                let onePageData = 2;
                let howmanypagebutton = Math.ceil(backShowAllData.length / onePageData);
                let pageButtonStr = "";

                for (let i=0 ; i<howmanypagebutton ; i++) {
                    pageButtonStr += `<li class="page-item"><a class="page-link" onclick="pageButtonClcikFun(this.id)" id="${i+1}">${i+1}</a></li>`;
                }
                document.querySelector("#pageButtonTable").innerHTML = pageButtonStr;

                if (backShowAllData.length > 0) {

                    let showAllTable = "";

                    for(let i=0 ; i < backShowAllData.length ; i++){
                        showAllTable +=
                        `<tr data-id="${backShowAllData[i].D_Id}" data-page="${Math.ceil((i+1)/onePageData)}">
                            <td class="addDeviceAll" >
                                <!-- delete button -->
                                <!-- <button type="button" class="btn btn-outline-danger" id="${backShowAllData[i].D_Id}" onclick="deleteFunc(this)"><i class="fas fa-trash-alt"></i></button> -->
                                <!-- update button -->
                                <button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target="#updateModalCenter" id="${backShowAllData[i].D_Id}" onclick="updateFunc(this)"><i class="fas fa-pencil-alt"></i></button>
                            </td>
                            <td class="addDeviceAll" data-type="D_Id">
                                ${backShowAllData[i].D_Id}
                            </td>
                            <td class="addDeviceAll" data-type="D_Number">
                                ${backShowAllData[i].D_Number}
                            </td>
                            <td class="addDeviceAll" data-type="D_Name">
                                ${backShowAllData[i].D_Name}
                            </td>
                            <td class="addDeviceAll" data-type="D_Model">
                                ${backShowAllData[i].D_Model}
                            </td>
                            <td class="addDeviceAll" data-type="D_Day">
                                ${backShowAllData[i].D_Day}
                            </td>
                            <td class="addDeviceAll" data-type="D_Unit">
                                ${backShowAllData[i].D_Unit}
                            </td>
                            <td class="addDeviceAll" data-type="D_Details">
                                ${backShowAllData[i].D_Details}
                            </td>
                            <td class="addDeviceAll" data-type="D_Lend">
                                ${(backShowAllData[i].D_Lend == 1 ? "已借出" : "未借出" )}
                            </td>
                        </tr>`;
                    }
                    document.querySelector("#deviceShowTable").innerHTML = showAllTable;

                    if (nowClickPage == 0) {
                        pageButtonClcikFun("", 1);
                    } else {
                        pageButtonClcikFun(nowClickPage);
                    }

                    //清除 addModel value
                    document.querySelector("#addDeviceId").value = "";
                    document.querySelector("#addDeviceNumber").value = "";
                    document.querySelector("#addDeviceName").value = "";
                    document.querySelector("#addDeviceModel").value = "";
                    document.querySelector("#addDeviceDay").value = "";
                    document.querySelector("#addDeviceUnit").value = "";
                    document.querySelector("#addDeviceDetails").value = "";

                    //清除 addModel border
                    document.querySelector("#addDeviceId").style.borderColor = "";
                    document.querySelector("#addDeviceNumber").style.borderColor = "";
                    document.querySelector("#addDeviceName").style.borderColor = "";
                    document.querySelector("#addDeviceModel").style.borderColor = "";
                    document.querySelector("#addDeviceDay").style.borderColor = "";
                    document.querySelector("#addDeviceUnit").style.borderColor = "";
                    document.querySelector("#addDeviceDetails").style.borderColor = "";


                } else {
                    document.querySelector("#deviceShowTable").innerHTML = "沒資料";
                }

                console.log(res);
            }).fail( e =>{
                alert("showdata錯誤");
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

        //addAll (start)
        //getdate
        document.querySelector("#addButtonpage").onclick = function(){
            var Today=new Date();
            // document.querySelector("#addDeviceDay").value =  Today.getFullYear()+ "-" + ((Today.getMonth()+1) <= 10 ? 0+(Today.getMonth()+1) : (Today.getMonth()+1)) + "-" + Today.getDate();
            document.querySelector("#addDeviceDay").value = Today.getFullYear()+ "-" + ((Today.getMonth()+1) <= 10  ? "0"+(Today.getMonth()+1) : (Today.getMonth()+1)) + "-" + ((Today.getDate()) <= 10  ? "0"+(Today.getDate()) : (Today.getDate()));
            // console.log(data);
        }
        //add
        document.querySelector("#addDeviceSubmit").onclick = function(){

            let addText = document.querySelectorAll(".addText");
            let check = 0;

            for(let totalCheck of addText){
                if(totalCheck.value == "" || totalCheck.value == undefined){
                    totalCheck.style.borderColor = "red";
                    check++;
                } else {
                    totalCheck.style.borderColor = "green";
                }
            }
            if(check > 0){
                Swal({
                    type: 'error',
                    title: '資料尚未填寫完全',
                    text: '紅框請寫完成',
                    animation: false,
                    customClass: 'animated tada'
                })
            } else {

                $.ajax({
                    url: '../Management_all_api/Management_device_api.php',
                    method: 'post',
                    dataTpye: 'json',
                    data: {
                        type: "addDevice",
                        addDeviceId: document.querySelector("#addDeviceId").value,
                        addDeviceNumber: document.querySelector("#addDeviceNumber").value,
                        addDeviceName: document.querySelector("#addDeviceName").value,
                        addDeviceModel: document.querySelector("#addDeviceModel").value,
                        addDeviceDay: document.querySelector("#addDeviceDay").value,
                        addDeviceUnit: document.querySelector("#addDeviceUnit").value,
                        addDeviceDetails: document.querySelector("#addDeviceDetails").value,
                    }
                }).done( res =>{
                    let backAllData = JSON.parse(res);


                    // let checkAllTrueTalse = backAllData.checkAlltruefalse;//檢查id number 有無重複



                    if( backAllData.checkIdtruefalse && backAllData.checkNumbertruefalse ){
                        Swal({
                            type: 'error',
                            title: '財產編號、S/N 都已存在',
                            animation: false,
                            customClass: 'animated tada'
                        })
                    } else if (backAllData.checkIdtruefalse) {
                        Swal({
                            type: 'error',
                            title: '財產編號已存在',
                            animation: false,
                            customClass: 'animated tada'
                        })
                    } else if (backAllData.checkNumbertruefalse) {
                        Swal({
                            type: 'error',
                            title: 'S/N已存在',
                            animation: false,
                            customClass: 'animated tada'
                        })
                    } else {
                        document.querySelector("#addDeviceClose").click();
                        Swal(
                            '設備已新增成功',
                            '',
                            'success'
                        )
                        showDeviceAllDataTable();
                    }

                    console.log(backAllData);
                }).fail( e =>{
                    alert("add錯誤");
                    console.error(e);
                })
            }
        }



        // checkaddmodelvalue
        function checkaddmodelvalue(ob){
            if(ob.value == "" || ob.value == undefined){
                ob.style.borderColor = 'red';
            } else {
                ob.style.borderColor = 'green';
            }
        }

        //addAll (end)


        // reset
        document.querySelector("#resetButton").onclick = function(){

            document.querySelector("#searchValue").value = "";
            showDeviceAllDataTable();

        }

        //search
        document.querySelector("#deviceSearchButton").onclick = function(){
            $.ajax({
                url: '../Management_all_api/Management_device_api.php',
                method: 'post',
                dataType: 'json',
                data: {
                    type: "search",
                    searchvalue: document.querySelector("#searchValue").value.trim(),
                }
            }).done( res =>{
                let backSearchAllData = res.toSearchAllData;

                if (backSearchAllData.length > 0) {
                    let backSearchDataLength = backSearchAllData.length;
                    let showSearchTable = "";

                    let onePageData = 2;
                    let howManyPageButton = Math.ceil(backSearchDataLength / onePageData);
                    let pageButtonStr = "";

                    for (let i=0 ; i<howManyPageButton ; i++) {
                        pageButtonStr += `<li class="page-item"><a class="page-link" onclick="howManyPageButtunFunc(this.id)" id="page${i+1}">${i+1}</a></li>`;
                    }

                    for(let i=0 ; i < backSearchDataLength ; i++){
                        showSearchTable +=
                        `<tr data-id="${backSearchAllData[i].D_Id}" data-page="page${Math.ceil((i+1)/onePageData)}">
                            <td class="addDeviceAll" >
                                <!-- delete button -->
                                <!-- <button type="button" class="btn btn-outline-danger" id="${backSearchAllData[i].D_Id}" onclick="deleteFunc(this)"><i class="fas fa-trash-alt"></i></button> -->
                                <!-- update button -->
                                <button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target="#updateModalCenter" id="${backSearchAllData[i].D_Id}" onclick="updateFunc(this)"><i class="fas fa-pencil-alt"></i></button>
                            </td>
                            <td class="addDeviceAll" data-type="D_Id">
                                ${backSearchAllData[i].D_Id}
                            </td>
                            <td class="addDeviceAll" data-type="D_Number">
                                ${backSearchAllData[i].D_Number}
                            </td>
                            <td class="addDeviceAll" data-type="D_Name">
                                ${backSearchAllData[i].D_Name}
                            </td>
                            <td class="addDeviceAll" data-type="D_Model">
                                ${backSearchAllData[i].D_Model}
                            </td>
                            <td class="addDeviceAll" data-type="D_Day">
                                ${backSearchAllData[i].D_Day}
                            </td>
                            <td class="addDeviceAll" data-type="D_Unit">
                                ${backSearchAllData[i].D_Unit}
                            </td>
                            <td class="addDeviceAll" data-type="D_Details">
                                ${backSearchAllData[i].D_Details}
                            </td>
                            <td class="addDeviceAll" data-type="D_Lend">
                                ${(backSearchAllData[i].D_Lend == 1 ? "已借出" : "未借出" )}
                            </td>
                        </tr>`;
                    }
                    document.querySelector("#deviceShowTable").innerHTML = showSearchTable;
                    document.querySelector("#pageButtonTable").innerHTML = pageButtonStr;

                    //清除 addModel value
                    document.querySelector("#addDeviceId").value = "";
                    document.querySelector("#addDeviceNumber").value = "";
                    document.querySelector("#addDeviceName").value = "";
                    document.querySelector("#addDeviceModel").value = "";
                    document.querySelector("#addDeviceDay").value = "";
                    document.querySelector("#addDeviceUnit").value = "";
                    document.querySelector("#addDeviceDetails").value = "";

                    //清除 addModel border
                    document.querySelector("#addDeviceId").style.borderColor = "";
                    document.querySelector("#addDeviceNumber").style.borderColor = "";
                    document.querySelector("#addDeviceName").style.borderColor = "";
                    document.querySelector("#addDeviceModel").style.borderColor = "";
                    document.querySelector("#addDeviceDay").style.borderColor = "";
                    document.querySelector("#addDeviceUnit").style.borderColor = "";
                    document.querySelector("#addDeviceDetails").style.borderColor = "";

                    document.getElementById("page1").click();
                    console.log("0");
                } else {
                    document.querySelector("#deviceShowTable").innerHTML = "沒資料";
                    console.log("1");
                }

                console.log(res);
            }).fail( e =>{
                alert("search錯誤");
                console.error(e);
            })
        }

        // delete
        // function deleteFunc(ob){

        //     Swal({
        //         title: '確定要刪除?',
        //         text: '財產編號：'+ob.id,
        //         type: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: '確定',
        //         cancelButtonText: '取消',
        //     }).then((result) => {
        //         if (result.value) {
        //                 $.ajax({
        //                     url: '../Management_all_api/Management_device_api.php',
        //                     method: 'post',
        //                     dataType: 'json',
        //                     data: {
        //                         type: "delete",
        //                         deleteid: ob.id,
        //                     }
        //                 }).done( res =>{

        //                     if(res.toDeleteId){
        //                         Swal(
        //                             '刪除財產成功',
        //                             '財產編號：'+ob.id,
        //                             'success'
        //                         )
        //                         showDeviceAllDataTable();
        //                     } else {
        //                         Swal({
        //                             type: 'error',
        //                             title: '無法刪除財產',
        //                             text: '財產編號：'+ob.id,
        //                         })
        //                     }
        //                     console.log(res.toDeleteId);
        //                 }).fail( e =>{
        //                     alert("delete錯誤");
        //                     console.error(e);
        //                 })



        //         }
        //     })
        // }

        //update (start)

        //update value
        function updateFunc(ob){

            let D_Id = document.querySelector("[data-id='"+ob.id+"'] > [data-type=D_Id]").innerHTML.trim();
            let D_Number = document.querySelector("[data-id='"+ob.id+"'] > [data-type=D_Number]").innerHTML.trim();
            let D_Name = document.querySelector("[data-id='"+ob.id+"'] > [data-type=D_Name]").innerHTML.trim();
            let D_Model = document.querySelector("[data-id='"+ob.id+"'] > [data-type=D_Model]").innerHTML.trim();
            let D_Day = document.querySelector("[data-id='"+ob.id+"'] > [data-type=D_Day]").innerHTML.trim();
            let D_Unit = document.querySelector("[data-id='"+ob.id+"'] > [data-type=D_Unit]").innerHTML.trim();
            let D_Details = document.querySelector("[data-id='"+ob.id+"'] > [data-type=D_Details]").innerHTML.trim();

            document.querySelector("#deviceUpdateId").value = D_Id;
            document.querySelector("#deviceUpdateNumber").value = D_Number;
            document.querySelector("#deviceUpdateName").value = D_Name;
            document.querySelector("#deviceUpdateModel").value = D_Model;
            document.querySelector("#deviceUpdateDay").value = D_Day;
            document.querySelector("#deviceUpdateUnit").value = D_Unit;
            document.querySelector("#deviceUpdateDetails").value = D_Details;

        }

        // update model
        document.querySelector("#updateModelSubmit").onclick = function(){

            $.ajax({
                url: '../Management_all_api/Management_device_api.php',
                method: 'post',
                dataType: 'json',
                data: {
                    type: "update",
                    deviceUpdateid: document.querySelector("#deviceUpdateId").value,
                    deviceUpdatenumber: document.querySelector("#deviceUpdateNumber").value,
                    deviceUpdatename: document.querySelector("#deviceUpdateName").value,
                    deviceUpdatemodel: document.querySelector("#deviceUpdateModel").value,
                    deviceUpdateday: document.querySelector("#deviceUpdateDay").value,
                    deviceUpdateunit: document.querySelector("#deviceUpdateUnit").value,
                    deviceUpdatedetails: document.querySelector("#deviceUpdateDetails").value,
                    deviceUpdateStatus: document.querySelector("#deviceUpdateStatus").value,
                }
            }).done( res =>{

                if(res.checkNumberTrueFalse){//重複為true
                    Swal({
                        type: 'error',
                        title: 'S/N已存在',
                        text: '',
                    })
                } else {
                    let backUpdateData = res.toUpdateData;
                    let backUpdateId = res.toDeviceUpdateId;
                    if(backUpdateData){
                        document.querySelector("#updateModelClose").click();
                        Swal(
                            '更新設備資料完成!!!',
                            '財產編號：'+ backUpdateId,
                            'success'
                        )
                        document.querySelector("#searchValue").value = "";
                        showDeviceAllDataTable();
                    } else {
                        Swal({
                            type: 'error',
                            title: '無法更新設備資料',
                            text: '財產編號：'+backUpdateId,
                        })
                        document.querySelector("#searchValue").value = "";
                        showDeviceAllDataTable();
                    }
                }
                console.log(res);
            }).fail( e =>{
                alert("update錯誤");
                console.error(e);
            })


        }
        // update (end)

        //bootstrap
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        // $('#example').tooltip(options)


    </script>
</body>
</html>