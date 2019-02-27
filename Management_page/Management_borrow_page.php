<?php
    session_start();
    require_once("../db_connect/db_connect.php");
    require_once('../function/global_function.php');

    if ($_SESSION['membername']) {
        // echo ($_SESSION['membername']);
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

    <link rel="stylesheet" href="../js/sweetalert2.min.css">

    <title>借出設備</title>

    <style>
        @import url('https://fonts.googleapis.com/css?family=Noto+Sans+TC');
        body {
            /* background-color: #e2f1ff; */
            font-family: 'Noto Sans TC', serif;
            background-size: cover;
            background-repeat: no-repeat;
            background-image: url("../img/images.jpg");
        }

        .navbar{
			/* background-color:#3fccca; */
            background:  rgba(255, 255, 255, 0.5);
        }
        .searchButton{
            background-color:#00fea5;

        }
        .underTableHeader{
            background-color: rgba(255, 255, 255, 0.5);
        }

        .underTableHeader > tr > th {
            border-top:0px;
        }
        .topTableHeader{
            background-color: rgba(255, 255, 255, 0.5);
        }

        .topTableHeader > tr > th {
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
        .channlborder {
            border: none;
        }
        .allTableData{
            border-radius:10px;
            overflow:hidden;
            border: 1px solid #dee2e6;
            background-color: rgba(255, 255, 255, 0.5);
        }
        .widthstyle{
            min-width:9rem;
        }

    </style>


</head>

<body onload="showTopTable() , showUnderTable()">

    <nav class="navbar navbar-expand-lg navbar-dark ">
        <a class="navbar-brand pageHeader ml-sm-3" href="../Management_menu/Management_menu.php">Home</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- <ul class="navbar-nav mr-auto">
                <li class="nav-item ">
                    <a class="nav-link pageHeader" href="../Management_page/Management_device_page.php">Device<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link pageHeader" href="../Management_page/Management_user_page.php">Users</a>
                </li>
                <li class="nav-item dropdown active">
                    <a class="nav-link pageHeader" href="../Management_page/Management_borrow_page.php">Borrow</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#"></a>
                </li>
            </ul> -->
            <ul class="navbar-nav mr-auto">
            <div class="dropdown" onmouseover="document.getElementById('borrowDropDownMeun').style.display = 'block';" onmouseout="document.getElementById('borrowDropDownMeun').style.display = 'none';">
                <li class="nav-item  " id="deviceMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <a class="nav-link pageHeader dropdown-toggle" style="font-style:oblique; font-weight:bold;">Device　</a>
                </li>
                <div class="dropdown-menu dDropMenu" id="borrowDropDownMeun" aria-labelledby="deviceMenuButton" style="background-color: rgba(255, 255, 255, 0.8); display: none;" onmouseout="document.getElementById('borrowDropDownMeun').style.display = 'none';">
                    <a class="dropdown-item" href="../Management_page/Management_device_page.php">設備管理</a>
                    <a class="dropdown-item" href="../Management_page/Management_device_normal_page.php">正常</a>
                    <a class="dropdown-item" href="../Management_page/Management_device_damage_page.php">毀損</a>
                    <a class="dropdown-item" href="../Management_page/Management_device_scrappeding_page.php">報廢中</a>
                    <a class="dropdown-item" href="../Management_page/Management_device_hasBeenScrappes_page.php">已報廢</a>
                </div>
            </div>
            <li class="nav-item">
                <a class="nav-link pageHeader" href="../Management_page/Management_user_page.php">Users</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link pageHeader active" href="../Management_page/Management_borrow_page.php">Borrow</a>
            </li>
            <li class="nav-item">
                <a class="nav-link pageHeader" href="../Management_page/Management_device_borrowRecord_page.php">Lended record</a>
            </li>
        </ul>
            <?php echo $_SESSION["membername"]; ?>　
            <a href="../index.php?logout=true"><button type="button" class="btn btn-outline-dark channlborder"><i class="fas fa-sign-out-alt"></i></button></a>  <!-- logout -->
        </div>
    </nav>

    <div class="container-fluid mt-5">
        <div class="row">

            <div class="col-5">
                <!-- add Button -->
                <button type="button" class="btn btn-primary mb-3 ml-3 channlborder" data-toggle="modal" data-target="#addModal" id="borrowAddButton"><i class="fas fa-plus"></i></button>

            </div>
            <div class="col">
                <div class="alert alert-primary" role="alert">
                    <i class="fas fa-arrow-alt-circle-down"></i>
                    需要簽核借出單
                </div>
            </div>
            <div class="col">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" data-toggle="tooltip" data-html="true" data-placement="bottom" title="<b>學號</b>、<b>財產編號</b>、<b>財產名稱</b>、<b>預計借出時間</b>、<b>預計歸還時間</b>、<b>詳細資料</b>" placeholder="Search" aria-label="" aria-describedby="" id="topSearchValue">
                    <div class="input-group-append">
                        <button class="btn btn-secondary channlborder" type="button" id="topSearchButton"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-1">
                <!-- reset -->
                <button type="button" class="btn btn-dark mb-3 ml-3 channlborder" id="topResetButton"><i class="fas fa-sync-alt"></i></i></button>
            </div>


        </div>

        <div class="row">
            <div class="col-sm">
                <div class="allTableData">
                    <table class="table text-center">
                        <thead class="topTableHeader">
                            <tr>
                                <th scope="col">簽核</th>
                                <th scope="col">學號</th>
                                <th scope="col">財產編號</th>
                                <th scope="col">財產名稱</th>
                                <th scope="col">預計借出時間</th>
                                <th scope="col">預計歸還時間</th>
                                <th scope="col">詳細資料</th>
                            </tr>
                        </thead>
                        <tbody id="topBorrowTable">

                        </tbody>
                    </table>
                </div>
            </div>



        </div>

        <div class="row">
            <div class="col-5">

            </div>
            <div class="col">
                <div class="alert alert alert-success mb-3 mt-4" role="alert">
                    <i class="fas fa-arrow-alt-circle-down"></i>
                    已簽核借出單
                </div>
            </div>
            <div class="col">
                <div class="input-group mb-3 mt-4">
                    <input type="text" class="form-control" data-toggle="tooltip" data-html="true" data-placement="bottom" title="<b>學號</b>、<b>財產編號</b>、<b>財產名稱</b>、<b>預計借出時間</b>、<b>預計歸還時間</b>、<b>實際借出時間</b>、<b>實際歸還時間</b>、<b>詳細資料</b>" placeholder="Search" aria-label="" aria-describedby="" id="underSearchValue" >
                    <div class="input-group-append">
                        <button class="btn btn-secondary channlborder" type="button" id="underSearchButton"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-1">
                <button type="button" class="btn btn-dark  channlborder mt-4 ml-3" id="underResetButton"><i class="fas fa-sync-alt"></i></button>
            </div>
        </div>
        <div class="row">
            <div class="col-sm">
                <div class="allTableData">
                    <table class="table text-center">
                        <thead class="underTableHeader">
                            <tr>
                                <th scope="col">簽核</th>
                                <th scope="col">學號</th>
                                <th scope="col">財產編號</th>
                                <th scope="col">財產名稱</th>
                                <th scope="col">預計借出時間</th>
                                <th scope="col">預計歸還時間</th>
                                <th scope="col">實際借出時間</th>
                                <th scope="col">實際歸還時間</th>
                                <th scope="col">詳細資料</th>
                            </tr>
                        </thead>
                        <tbody id="underBorrowTable">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- add Modal -->
    <form id="borrowAddForm" method="post" action="borrow_page.php">
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div style="background: rgba(0, 157, 255,0.1)" class="modal-header">
                        <h5 class="modal-title" id="addModalCenterTitle">新增借出單</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="input-group mb-3">
                            <div class="input-group-prepend widthstyle">
                                <span class="input-group-text w-100" id="basic-addon1">借出者學號</span>
                            </div>
                            <input type="text" class="form-control borrowAddCheck" placeholder="不用加 s" name="borrowAddOutUserId" id="borrowAddOutUserId" onchange="checkaddmodelvalue(this)">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend widthstyle">
                                <span class="input-group-text w-100" id="basic-addon1">借出財產編號</span>
                            </div>
                            <input type="text" class="form-control borrowAddCheck" placeholder="" name="borrowAddOutDeviceId" id="borrowAddOutDeviceId" onchange="checkaddmodelvalue(this)">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend widthstyle">
                                <span class="input-group-text w-100" id="basic-addon1">預計借出時間</span>
                            </div>
                            <input type="date" class="form-control borrowAddCheck" placeholder="XXXX / XX / XX" name="borrowAddExpectedOutDay" id="borrowAddExpectedOutDay" onchange="checkaddmodelvalue(this)">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend widthstyle">
                                <span class="input-group-text w-100" id="basic-addon1">預計攜入時間</span>
                            </div>
                            <input type="date" class="form-control borrowAddCheck" placeholder="XXXX / XX / XX" name="borrowAddExpectedInDay" id="borrowAddExpectedInDay" onchange="checkaddmodelvalue(this)">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend widthstyle">
                                <span class="input-group-text w-100" id="basic-addon1">詳細資料(備註)</span>
                            </div>
                            <textarea class="form-control" aria-label="With textarea" name="borrowAddDetails" id="borrowAddDetails" placeholder="非本實驗室生，要外借基本資料請填這(科系 學號 姓名 聯絡方式)" onchange="checkaddmodelvalue(this)"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="borrowAddClose">關閉</button>
                        <button style="background: rgb(0, 195, 255)" type="button" class="btn" id="borrowAddSubmit"><font color="#ffffff">新增</font></button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- <script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script> -->
    <script src="../js/sweetalert2.all.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

    <script>

        //show dataTable
        function showTopTable() {
            $.ajax({
                url: '../Management_all_api/Management_borrow_api.php',
                method: 'post',
                dataType: 'json',
                data: {
                    type: "showTopTable"
                }
            }).done( res => {

                let showTopTable = res.showTopAllTable;
                let showTopTableStr = "";

                for(let i=0 ; i<showTopTable.length ; i++){
                    showTopTableStr +=
                    `<tr>
                        <td>
                            <button type="button" class="btn ${(showTopTable[i].B_Checkoutnumber == 2 ? "btn-outline-danger" : "btn-outline-primary" )}" value="${showTopTable[i].B_Out_Id}" id="${showTopTable[i].D_Id}" onclick="changeTopButtonFun(this)">${(showTopTable[i].B_Checkoutnumber == 2 ? "未審核" : "已審核" )}</button>
                        </td>
                        <td>
                            ${showTopTable[i].U_Id}
                        </td>
                        <td>
                            ${showTopTable[i].D_Id}
                        </td>
                        <td>
                            ${showTopTable[i].D_Name}
                        </td>
                        <td>

                            ${showTopTable[i].B_Expected_OutDay}
                        </td>
                        <td>
                            ${showTopTable[i].B_Expected_InDay}
                        </td>
                        <td>
                            ${showTopTable[i].B_Details}
                        </td>
                    </tr>`;
                }


                document.querySelector("#topBorrowTable").innerHTML = showTopTableStr;
                console.log(res);
            }).fail( e => {
                console.log(e);
            })
        }

        function showUnderTable() {
            $.ajax({
                url: '../Management_all_api/Management_borrow_api.php',
                method: 'post',
                dataType: 'json',
                data: {
                    type: "showUnderAllData"
                }
            }).done( res => {

                let showUnderTable = res.showUnderAllTable;
                let showUnderTableStr = "";

                for(let i=0 ; i<showUnderTable.length ; i++){
                    showUnderTableStr +=
                    `<tr data-id="${showUnderTable[i].B_Out_Id}">
                        <td>
                            <button type="button" class="btn ${(showUnderTable[i].B_Checkoutnumber == 2 ? "btn-outline-danger" : "btn-outline-primary" )}" value="${showUnderTable[i].B_Out_Id}" id="${showUnderTable[i].D_Id}" onclick="changeUnderButtonFun(this)">${(showUnderTable[i].B_Checkoutnumber == 2 ? "未審核" : "已審核" )}</button>
                        </td>
                        <td>
                            ${showUnderTable[i].U_Id}
                        </td>
                        <td data-type="D_Id">
                            ${showUnderTable[i].D_Id}
                        </td>
                        <td>
                            ${showUnderTable[i].D_Name}
                        </td>
                        <td>
                            ${showUnderTable[i].B_Expected_OutDay}
                        </td>
                        <td>
                            ${showUnderTable[i].B_Expected_InDay}
                        </td>
                        <td data-Day="OutDay">

                            ${(showUnderTable[i].B_Entity_OutDay == "" ? `<div class="input-group mb-3" data-div="OutDay"><input type="date" class="form-control" id="basic-url" aria-describedby="basic-addon3"><button type="buttom" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="點後填入實際借出時間" onclick="writeOutDay(this)" value="${showUnderTable[i].B_Out_Id}"><i class="fas fa-calendar-alt"></i></button></div>` : showUnderTable[i].B_Entity_OutDay)}

                        </td>
                        <td data-Day="InDay">

                            ${(showUnderTable[i].B_Entity_InDay == "" ? `<div class="input-group mb-3" data-div="InDay"><input type="date" class="form-control" id="basic-url" aria-describedby="basic-addon3"><button type="button" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="點後填入實際歸回時間" onclick="writeInDay(this)" value="${showUnderTable[i].B_Out_Id}"><i class="fas fa-calendar-alt"></i></button>` : showUnderTable[i].B_Entity_InDay)}
                        </td>
                        <td>
                            ${showUnderTable[i].B_Details}
                        </td>
                    </tr>`;
                }


                document.querySelector("#underBorrowTable").innerHTML = showUnderTableStr;
                console.log(res);
            }).fail( e => {
                console.erroe(e);
            })
        }

        //add
        document.querySelector("#borrowAddSubmit").onclick = function(){
            $.ajax({
                url: '../Management_all_api/Management_borrow_api.php',
                method: 'post',
                dataType: 'json',
                data: {
                    type: "add",
                    addOutUserId: document.querySelector("#borrowAddOutUserId").value,
                    addOutDeviceId: document.querySelector("#borrowAddOutDeviceId").value,
                    addExpectedOutDay: document.querySelector("#borrowAddExpectedOutDay").value,
                    addExpectedInDay: document.querySelector("#borrowAddExpectedInDay").value,
                    addDetails: document.querySelector("#borrowAddDetails").value,
                }
            }).done( res => {

                if (res.toOutUserIdHaveValue) {
                    Swal({
                        type: 'error',
                        title: '請輸入借出者學號',
                        text: '',
                    })
                } else if (res.toOutDeviceIdHaveValue) {
                    Swal({
                        type: 'error',
                        title: '請輸入借出財產編號',
                        text: '',
                    })
                } else if (res.toExpectedOutDayHavaValue) {
                    Swal({
                        type: 'error',
                        title: '請輸入借出時間',
                        text: '',
                    })
                } else if (res.toExpectedInDayHaveValue) {
                    Swal({
                        type: 'error',
                        title: '請輸入攜入時間',
                        text: '',
                    })
                } else if (res.toCheckhaveuser) {
                    Swal({
                        type: 'error',
                        title: '沒有此學號',
                        text: '',
                    })
                } else if (res.toCheckhavedevice) {
                    Swal({
                        type: 'error',
                        title: '沒有此設備',
                        text: '',
                    })
                } else if (res.toCheckhavedeviceout) {
                    Swal({
                        type: 'error',
                        title: '設備已有人借',
                        text: '',
                    })
                } else if (res.toCheckdata) {
                    Swal({
                        type: 'error',
                        title: '攜入時間錯誤',
                        text: '',
                    })
                } else {
                    if (res.toaddDatatruefalse) {
                    Swal(
                        '借出單已送出，請等待相關人員審核',
                        '',
                        'success'
                    )
                    document.querySelector("#borrowAddClose").click();
                    } else {
                        Swal({
                            type: 'error',
                            title: '借出失敗!!!',
                            text: '請確認有無產編 或 是否為管理員',
                        })
                    }
                }



                showTopTable();

                console.log(res);
            }).fail( e => {
                console.error(e);
            })
        }

        // checkaddmodelvalue
        function checkaddmodelvalue(ob){
            if(ob.value == "" || ob.value == undefined){
                ob.style.borderColor = 'red';
            } else {
                ob.style.borderColor = 'green';
            }
        }


        //changebutton class

        function changeTopButtonFun(ob){

            var ss = <?php echo $_SESSION["membername"];?>

            $.ajax({
                url: '../Management_all_api/Management_borrow_api.php',
                method: 'post',
                dataType: 'json',
                data: {
                    type: "changeTopButton",
                    changeid: ob.value,
                    checkuser: ss,
                    deviceid: ob.id,

                }
            }).done( res => {

                if (res.toChangeData) {
                    showTopTable()
                    showUnderTable();
                } else {

                }

                console.log(res);
            }).fail( e => {
                console.error(e);
            })


            }

        function changeUnderButtonFun(ob){


            $.ajax({
                url: '../Management_all_api/Management_borrow_api.php',
                method: 'post',
                dataType: 'json',
                data: {
                    type: "changeUnderButton",
                    changeid: ob.value,
                    deviceid: ob.id,

                }
            }).done( res => {

                if (res.tocheckOutDay) {
                    Swal({
                        type: 'error',
                        title: '已借出無法取消審核!!!',
                        text: '',
                    })
                } else {
                    showTopTable();
                    showUnderTable();
                }

                console.log(res);
            }).fail( e => {
                console.error(e);
            })

            // console.log(ob.value);
        }

        //search
        document.querySelector("#topSearchButton").onclick = function(){ //topsearch

            let topsearchvalue = document.querySelector("#topSearchValue").value;

            if (topsearchvalue == '' || topsearchvalue == undefined) {
                Swal({
                    type: 'error',
                    title: '請輸入搜尋值',
                    text: '',
                })
            } else {
                $.ajax({
                url: '../Management_all_api/Management_borrow_api.php',
                method: 'post',
                dataType: 'json',
                data: {
                    type: "topsearch",
                    searchvalue: topsearchvalue,
                }
                }).done( res => {

                    if (res.totopSearch.length > 0) {


                        let searchData = res.totopSearch;
                        let searchDataStr = "";
                        for (let i=0 ; i<searchData.length ; i++) {
                            searchDataStr +=
                            `<tr>
                                <td>

                                    <button type="button" class="btn ${(searchData[i].B_Checkoutnumber == 2 ? "btn-outline-danger" : "btn-outline-primary" )}" value="${searchData[i].B_Out_Id}" onclick="changeTopButtonFun(this)">${(searchData[i].B_Checkoutnumber == 2 ? "未審核" : "已審核" )}</button>
                                </td>
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
                                    ${searchData[i].B_Expected_OutDay}
                                </td>
                                <td>
                                    ${searchData[i].B_Expected_InDay}
                                </td>
                                <td>
                                    ${searchData[i].D_Details}
                                </td>
                            </tr>`;
                        }

                        document.querySelector("#topBorrowTable").innerHTML = searchDataStr;
                    } else {
                        document.querySelector("#topBorrowTable").innerHTML = "查無資料";
                    }


                    console.log(res);
                }).fail( e => {
                    console.error(e);
                })
            }

        }

        document.querySelector("#underSearchButton").onclick = function(){ //undersearch

            let undersearchvalue = document.querySelector("#underSearchValue").value;

            if (undersearchvalue == '' || undersearchvalue == undefined) {
                Swal({
                    type: 'error',
                    title: '請輸入搜尋值',
                    text: '',
                })
            } else {
                $.ajax({
                url: '../Management_all_api/Management_borrow_api.php',
                method: 'post',
                dataType: 'json',
                data: {
                    type: "undersearch",
                    searchvalue: undersearchvalue,
                }
                }).done( res => {

                    if (res.toUnderSearch.length > 0) {

                        let searchData = res.toUnderSearch;
                        let searchDataStr = "";
                        for (let i=0 ; i<searchData.length ; i++) {
                            searchDataStr +=
                            `<tr data-id="${searchData[i].U_Id}">
                            <td>

                                <button type="button" class="btn ${(searchData[i].B_Checkoutnumber == 2 ? "btn-outline-danger" : "btn-outline-primary" )}" value="${searchData[i].B_Out_Id}" onclick="changeUnderButtonFun(this)">${(searchData[i].B_Checkoutnumber == 2 ? "未審核" : "已審核" )}</button>
                            </td>
                            <td>
                                ${searchData[i].U_Id}
                            </td>
                            <td data-type="D_Id">
                                ${searchData[i].D_Id}
                            </td>
                            <td>
                                ${searchData[i].D_Name}
                            </td>
                            <td>
                                ${searchData[i].B_Expected_OutDay}
                            </td>
                            <td>
                                ${searchData[i].B_Expected_InDay}
                            </td>
                            <td data-Day="OutDay">

                                ${(searchData[i].B_Entity_OutDay == "" ? `<div class="input-group mb-3" data-div="OutDay"><input type="date" class="form-control" id="basic-url" aria-describedby="basic-addon3"><button type="buttom" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="點後填入實際借出時間" onclick="writeOutDay(this)" value="${searchData[i].B_Out_Id}"><i class="fas fa-calendar-alt"></i></button></div>` : searchData[i].B_Entity_OutDay)}

                            </td>
                            <td data-Day="InDay">

                                ${(searchData[i].B_Entity_InDay == "" ? `<div class="input-group mb-3" data-div="InDay"><input type="date" class="form-control" id="basic-url" aria-describedby="basic-addon3"><button type="button" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="點後填入實際歸回時間" onclick="writeInDay(this)" value="${searchData[i].B_Out_Id}"><i class="fas fa-calendar-alt"></i></button>` : searchData[i].B_Entity_InDay)}
                            </td>
                            <td>
                                ${searchData[i].B_Details}
                            </td>
                        </tr>`;
                        }

                        document.querySelector("#underBorrowTable").innerHTML = searchDataStr;
                    } else {
                        document.querySelector("#underBorrowTable").innerHTML = "查無資料";
                    }



                    console.log(res);
                }).fail( e => {
                    console.error(e);
                })
            }

        }

        //resrt
        document.querySelector("#topResetButton").onclick = function() {
            document.querySelector("#topSearchValue").value = "";

            showTopTable();
        }
        document.querySelector("#underResetButton").onclick = function() {
            document.querySelector("#underSearchValue").value = "";
            showUnderTable();
        }

        function writeOutDay(ob) {

            Swal.fire({
                title: '確定要借出???',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '確定',
                cancelButtonText: '取消',
            }).then((result) => {
                if (result.value) {
                    // Swal.fire(
                    //     'Deleted!',
                    //     'Your file has been deleted.',
                    //     'success'
                    // )
                    $.ajax({
                        url: '../Management_all_api/Management_borrow_api.php',
                        method: 'post',
                        dataType: 'json',
                        data: {
                            type: "writeoutday",
                            getdate: document.querySelector("[data-id='"+ob.value+"'] > [data-Day=OutDay] > [data-div=OutDay] > [type=date]").value,
                            writeid: ob.value,
                        }
                    }).done( res => {

                        showUnderTable();
                        console.log(res);
                    }).fail( e => {
                        console.error(e);
                    })
                }
            })



        }

        function writeInDay(ob) {

            Swal.fire({
                title: '確定要歸還???',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '確定',
                cancelButtonText: '取消',
            }).then((result) => {
                if (result.value) {
                    // Swal.fire(
                    //     'Deleted!',
                    //     'Your file has been deleted.',
                    //     'success'
                    // )
                    $.ajax({
                        url: '../Management_all_api/Management_borrow_api.php',
                        method: 'post',
                        dataType: 'json',
                        data: {
                            type: "writeinday",
                            getdate: document.querySelector("[data-id='"+ob.value+"'] > [data-day=InDay] > [data-div=InDay] > [type=date]").value,
                            writeid: ob.value,
                            deviceid: document.querySelector("[data-id='"+ob.value+"'] > [data-type=D_Id]").innerHTML.trim(),
                        }
                    }).done( res => {

                        showUnderTable();
                        console.log(res);
                    }).fail( e => {
                        console.error(e);
                    })
                }
            })

        }

        //bootstrap
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>

</body>
</html>