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
    <script src="../js/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="../js/sweetalert2.min.css">
    <title>使用者</title>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Noto+Sans+TC');
        body {
            /* background-color: #e2f1ff; */
            font-family: 'Noto Sans TC', serif;
            background-image: url("../img/20170915_020223_43e8378c_w1920.jpg");
            background-size: cover;
            background-repeat: no-repeat;
        }

        .navbar{
			/* background-color:#3fccca; */
            background: linear-gradient(to right, rgba(0, 162, 255, 0.5) , rgba(255, 255, 255, 0.5));
        }
        .searchButton{
            background-color:#00fea5;

        }
        .tableheader{
            background-color:#d6fbff;
        }

        .tableheader > tr > th {
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
            background-color:#ffffff;
        }
        .searchButton{
            background-color:#ffffff;
        }
        .userShowAllDataTable > tr > td{
            text-align: center;
            width: 16%;
        }
        .userShowAllDataTable > tr{
            width: 100%;
        }
        .tableheader > tr > th{
            text-align: center;
            width: 16%;
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
        <!-- <ul class="navbar-nav mr-auto">
            <li class="nav-item ">
                <a class="nav-link pageHeader" href="../Management_page/Management_device_page.php">Device<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link pageHeader" href="../Management_page/Management_user_page.php">Users</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link pageHeader" href="../Management_page/Management_borrow_page.php">Borrow</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#"></a>
            </li>
        </ul> -->
        <ul class="navbar-nav mr-auto">
            <div class="dropdown" onmouseover="document.getElementById('userDropDownMeun').style.display = 'block';" onmouseout="document.getElementById('userDropDownMeun').style.display = 'none';">
                <li class="nav-item  " id="deviceMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <a class="nav-link pageHeader dropdown-toggle" style="font-style:oblique; font-weight:bold;">Device　</a>
                </li>
                <div class="dropdown-menu dDropMenu" id="userDropDownMeun" aria-labelledby="deviceMenuButton" style="background-color: rgba(255, 255, 255, 0.8); display: none;" onmouseout="document.getElementById('userDropDownMeun').style.display = 'none';">
                    <a class="dropdown-item" href="../Management_page/Management_device_page.php">設備管理</a>
                    <a class="dropdown-item" href="../Management_page/Management_device_normal_page.php">正常</a>
                    <a class="dropdown-item" href="../Management_page/Management_device_damage_page.php">毀損</a>
                    <a class="dropdown-item" href="../Management_page/Management_device_scrappeding_page.php">報廢中</a>
                    <a class="dropdown-item" href="../Management_page/Management_device_hasBeenScrappes_page.php">已報廢</a>
                </div>
            </div>
            <li class="nav-item">
                <a class="nav-link pageHeader active" href="../Management_page/Management_user_page.php" >Users</a>
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


</div>
	<div class="container ">
        <div class="row mt-3 mb-3">
            <div class="col">
		        <!-- add Button -->
		        <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#addModalCenter"><i class="fas fa-plus"></i></button>
            </div>
            <div class="col">

            </div>
            <div class="col-3">
                <!-- search button -->
                <div class="input-group">
                    <input type="text" class="form-control" data-toggle="tooltip" data-html="true" data-placement="bottom" title="<b>系所</b>、<b>學號</b>、<b>姓名</b>、<b>聯絡電話	</b>、<b>權限</b>" placeholder="Search" id="saerchValue">
                    <div class="input-group-append">
                        <button class="btn btn-secondary channlborder" type="button" id="userSearchButton"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-0">
                <!-- reset Button -->
                <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#resetModalCenter" id="userResetdata"><i class="fas fa-sync-alt"></i></button>
            </div>
        </div>



        <div class="allTableData">
            <table class="table text-center">
                <thead class="tableheader">
                    <tr>
                        <th scope="col">編輯</th>
						<th scope="col">系所</th>
                        <th scope="col">學號</th>
						<th scope="col">姓名</th>
                        <th scope="col">聯絡電話</th>
                        <th scope="col">權限</th>
                    </tr>
                </thead>
                <tbody id="userShowAllDataTable">

                </tbody>
            </table>
        </div>
        <!-- 分頁 -->
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center mt-3" id="pageButtonTable">

            </ul>
        </nav>


	</div>

	<!-- add Modal -->
	<div class="modal fade" id="addModalCenter" tabindex="-1" role="dialog" aria-labelledby="addModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div style="background: rgba(0, 157, 255,0.1)" class="modal-header">
					<h5 class="modal-title" id="addModalCenterTitle">新增使用者 (<font style="color:red">　*　</font>必須填寫)</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
                    <div class="input-group mb-3">
						<div class="input-group-prepend" style="min-width:6rem;">
							<span class="input-group-text w-100" id=""><font style="color:red">*</font>系所</span>
						</div>
						<input type="text" class="form-control userAddText" placeholder="" aria-label="" aria-describedby="basic-addon1" name="userAddDepartment" id="userAddDepartment" onchange="checkaddmodelvalue(this)">
					</div>
					<div class="input-group mb-3">
						<div class="input-group-prepend" style="min-width:6rem;">
							<span class="input-group-text w-100" id=""><font style="color:red">*</font>學號</span>
						</div>
						<input type="text" class="form-control userAddText" placeholder="" aria-label="" aria-describedby="basic-addon1" name="userAddId" id="userAddId" onchange="checkaddmodelvalue(this)">
					</div>
					<div class="input-group mb-3">
						<div class="input-group-prepend" style="min-width:6rem;">
							<span class="input-group-text w-100" id=""><font style="color:red">*</font>姓名</span>
						</div>
						<input type="text" class="form-control userAddText" placeholder="" aria-label="" aria-describedby="basic-addon1" name="userAddName" id="userAddName" onchange="checkaddmodelvalue(this)">
					</div>
					<div class="input-group mb-3">
						<div class="input-group-prepend" style="min-width:6rem;">
							<span class="input-group-text w-100" id=""><font style="color:red">*</font>密碼</span>
						</div>
						<input type="password" class="form-control userAddText" placeholder="" aria-label="" aria-describedby="basic-addon1" name="userAddPassword" id="userAddPassword" onchange="checkaddmodelvalue(this)">
					</div>
                    <div class="input-group mb-3">
						<div class="input-group-prepend" style="min-width:6rem;">
							<span class="input-group-text w-100" id=""><font style="color:red">*</font>確認密碼</span>
						</div>
						<input type="password" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1" name="userAddAgainPassword" id="userAddAgainPassword" onchange="againPasswordFun(this)">
					</div>
					<div class="input-group mb-3">
						<div class="input-group-prepend" style="min-width:6rem;">
							<span class="input-group-text w-100" id=""><font style="color:red">*</font>聯絡電話</span>
						</div>
						<input type="text" class="form-control userAddText" placeholder="" aria-label="" aria-describedby="basic-addon1" name="userAddTel" id="userAddTel" onchange="checkaddmodelvalue(this)">
					</div>
					<div class="input-group mb-3">
						<div class="input-group-prepend" style="min-width:6rem;">
							<span class="input-group-text w-100" id=""><font style="color:red">*</font>權限</span>
						</div>
                        <select class="custom-select userAddText" name="userAddPermission" id="userAddPermission" onchange="checkaddmodelvalue(this)">
                            <option selected value="1">訪客</option>
                            <option value="2">管理員</option>
                        </select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" id="userAddClose">關閉</button>
					<button style="background: rgb(0, 195, 255)" type="button" class="btn" id="userAddSubmit"><font color="#ffffff">新增</font></button>

				</div>
			</div>
		</div>
	</div>

    <!-- delete Modal -->
    <div class="modal fade" id="deleteModalCenter" tabindex="-1" role="dialog" aria-labelledby="deleteModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div style="background: rgba(255, 0, 0,0.1)" class="modal-header">
                <h5 class="modal-title" id="deleteModalCenterTitle">刪除使用者</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <p id="deletecontent"></p>
                    <input type="text" class="form-control" placeholder="" aria-label="" aria-describedby="" id="deleteInput" name="deleteInput" hidden>
            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button style="background: rgba(255, 0, 0,0.1);" type="button" class="btn" id="userDeleteSubmit"><font color="#FF0000">Save changes</font></button>
            </div>
            </div>
        </div>
    </div>

    <!-- update Model -->
    <div class="modal fade" id="updateModalCenter" tabindex="-1" role="dialog" aria-labelledby="updateModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div style="background: rgba(255, 213, 0,0.1)" class="modal-header">
                    <h5 class="modal-title" id="updateModalCenterTitle">更改資料 (<font style="color:red">　*　</font>必須填寫)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend" style="min-width:6rem;">
                            <span class="input-group-text w-100" id="basic-updateon1"><font style="color:red">*</font>科系</span>
                        </div>
                        <input type="text" class="form-control userUpdateText" placeholder="" aria-label="" aria-describedby="basic-updateon1" name="userUpdateDepartment" id="userUpdateDepartment">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend" style="min-width:6rem;">
                            <span class="input-group-text w-100" id="basic-updateon1"><font style="color:red">*</font>學號</span>
                        </div>
                        <input type="text" class="form-control userUpdateText" placeholder="" aria-label="" aria-describedby="basic-updateon1" name="userUpdateId" id="userUpdateId" readonly>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend" style="min-width:6rem;">
                            <span class="input-group-text w-100" id="basic-updateon1"><font style="color:red">*</font>姓名</span>
                        </div>
                        <input type="text" class="form-control userUpdateText" placeholder="" aria-label="" aria-describedby="basic-updateon1" name="userUpdateName" id="userUpdateName">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend" style="min-width:6rem;">
                            <span class="input-group-text w-100" id="basic-updateon1">密碼</span>
                        </div>
                        <input type="text" class="form-control userUpdateText" placeholder="" aria-label="" aria-describedby="basic-updateon1" name="userUpdatePassword" id="userUpdatePassword">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend" style="min-width:6rem;">
                            <span class="input-group-text w-100" id="basic-updateon1">確認密碼</span>
                        </div>
                        <input type="text" class="form-control userUpdateText" placeholder="" aria-label="" aria-describedby="basic-updateon1" name="userUpdateAgainPassword" id="userUpdateAgainPassword">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend" style="min-width:6rem;">
                            <span class="input-group-text w-100" id="basic-updateon1"><font style="color:red">*</font>聯絡電話</span>
                        </div>
                        <input type="text" class="form-control userUpdateText" placeholder="" aria-label="" aria-describedby="basic-updateon1" name="userUpdateTel" id="userUpdateTel" >
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend" style="min-width:6rem;">
                            <span class="input-group-text w-100" id="basic-updateon1"><font style="color:red">*</font>權限</span>
                        </div>
                        <select class="custom-select" name="userUpdatePermission" id="userUpdatePermission">
                            <option value="0">無權限</option>
                            <option value="1">訪客</option>
                            <option value="2">管理員</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="userUpdateClose">Close</button>
                    <button style="background: rgba(255, 213, 0)" type="button" class="btn" id="userUpdateSubmit">Save changes</button>
                </div>
            </div>
        </div>
    </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>


<script>
        window.onload = function(){
            userShowAllData();
        }

        let nowClickPage = 0;

        // showdata
        function userShowAllData() {
            $.ajax({
                url: '../Management_all_api/Management_user_api.php',
                method: 'post',
                dataType: 'json',
                data: {
                    type: "showdata",
                }
            }).done( res =>{

                let backAllData = res.toShowAllData;
                let onePageHowData = 2;


                let howmanypagebutton = Math.ceil(backAllData.length / onePageHowData);

                let pageButtonStr = "";
                for (let i=0 ; i<howmanypagebutton ; i++) {
                    pageButtonStr +=
                    `<li class="page-item"><a class="page-link" onclick="pageButtonClcikFun(this.id)" id="${i+1}">${i+1}</a></li>`;
                }

                document.querySelector("#pageButtonTable").innerHTML = pageButtonStr;

                if (backAllData.Length != 0) {

                    let backAllDataStr = "";

                    for(let i=0 ; i < backAllData.length ; i++){
                        backAllDataStr +=
                        `<tr data-id="${backAllData[i].U_Id}" data-page="${Math.ceil((i+1)/onePageHowData)}">
                            <td>
                                <!-- delete button -->
                                <!--<button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#" id="${backAllData[i].U_Id}" onclick="uesrDeleteFunc(this)"><i class="fas fa-trash-alt"></i></button>-->
                                <!-- update button -->
                                <button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target="#updateModalCenter" id="${backAllData[i].U_Id}" onclick="updateFunc(this)"><i class="fas fa-pencil-alt"></i></button>
                            </td>
                            <td data-type="U_Department">
                                ${backAllData[i].U_Department}
                            </td>
                            <td data-type="U_Id">
                                ${backAllData[i].U_Id}
                            </td>
                            <td data-type="U_Name">
                                ${backAllData[i].U_Name}
                            </td>
                            <td data-type="U_Tel">
                                0${backAllData[i].U_Tel}
                            </td>
                            <td data-type="U_Permission">
                                ${(backAllData[i].U_Permission == 2 ? "管理員" : (backAllData[i].U_Permission == 1 ? "訪客" : "無權限" ) )}
                            </td>
                        </tr>`;
                    }

                    document.querySelector("#userShowAllDataTable").innerHTML = backAllDataStr;

                    if (nowClickPage == 0) {
                        pageButtonClcikFun("", 1);
                    } else {
                        pageButtonClcikFun(nowClickPage);
                    }

                } else {
                    document.querySelector("#userShowAllDataTable").innerHTML = "沒資料";
                    console.log(2);

                }

                console.log(backAllData.length);
            }).fail( e =>{
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
                nowClickPage = 1;

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


        // add (start)
        // checkaddmodelvalue
        function checkaddmodelvalue(ob){
            if(ob.value == "" || ob.value == undefined){
                ob.style.borderColor = 'red';
            } else {
                ob.style.borderColor = 'green';
            }
        }

        document.querySelector("#userAddSubmit").onclick = function() {

            let checkAllText = document.querySelectorAll(".userAddText");
            let check = 0;

            for(let totalCheck of checkAllText){
                if(totalCheck.value == "" || totalCheck.value == undefined){
                    totalCheck.style.borderColor = "red";
                    check++;
                } else {
                    totalCheck.style.borderColor = "green";
                }
            }

            let checkagainvalue = document.querySelector("#userAddAgainPassword");

            if (checkagainvalue.value == "" || checkagainvalue.value == undefined) {
                checkagainvalue.style.borderColor = "red";
            } else {
                checkagainvalue.style.borderColor = "green";
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

                let password = document.querySelector("#userAddPassword").value;
                let againPassword = document.querySelector("#userAddAgainPassword").value;

                if (password === againPassword) {

                    $.ajax({
                    url: '../Management_all_api/Management_user_api.php',
                    method: 'post',
                    dataType: 'json',
                    data: {
                        type: 'add',
                        useradddepartment: document.querySelector("#userAddDepartment").value,
                        useraddid: document.querySelector("#userAddId").value,
                        useraddname: document.querySelector("#userAddName").value,
                        useraddpassword: document.querySelector("#userAddPassword").value,
                        useraddtel: document.querySelector("#userAddTel").value,
                        useraddpermission: document.querySelector("#userAddPermission").value,
                    }
                    }).done( res => {

                        if (res.checkIdTrueFalse && res.checkTelTrueFalse) {
                            Swal({
                                type: 'error',
                                title: '學號、電話都已存在',
                                text: '學號：'+res.touserAddId+' 電話：'+res.touserAddTel,
                                animation: false,
                                customClass: 'animated tada'
                            })
                        } else if (res.checkIdTrueFalse) {
                            Swal({
                                type: 'error',
                                title: '學號已存在',
                                text: '學號：'+res.touserAddId,
                            })
                        } else if (res.checkTelTrueFalse) {

                            Swal({
                                type: 'error',
                                title: '電話已存在',
                                text: '電話：'+res.touserAddTel,
                            })
                        } else {
                            document.querySelector("#userAddClose").click();
                                Swal(
                                '新增使用者成功',
                                '使用者：'+res.touserAddId,
                                'success'
                            )
                            document.querySelector("#userAddDepartment").value = "";
                            document.querySelector("#userAddId").value = "";
                            document.querySelector("#userAddName").value = "";
                            document.querySelector("#userAddPassword").value = "";
                            document.querySelector("#userAddAgainPassword").value = "";
                            document.querySelector("#userAddTel").value = "";

                            //清除 addModel border
                            document.querySelector("#userAddDepartment").style.borderColor = "";
                            document.querySelector("#userAddId").style.borderColor = "";
                            document.querySelector("#userAddName").style.borderColor = "";
                            document.querySelector("#userAddPassword").style.borderColor = "";
                            document.querySelector("#userAddAgainPassword").style.borderColor = "";
                            document.querySelector("#userAddTel").style.borderColor = "";
                            document.querySelector("#userAddPermission").style.borderColor = "";
                        }
                        userShowAllData();
                        console.log(res);
                    }).fail( e =>{
                        console.error(e);
                    })

                } else {
                    Swal({
                        type: 'error',
                        title: '密碼不一致',
                        text: '',
                    })
                    document.querySelector("#userAddAgainPassword").style.bodercolor = "red";
                }
            }
        }

        function againPasswordFun(ob) {
            let checkagain = document.querySelector("#userAddPassword").value;
            if (ob.value == checkagain) {
                ob.style.borderColor = 'green';
            } else {
                ob.style.borderColor = 'red';

            }
            console.log(checkagain);
        }
        // add (end)


        // delete
        function uesrDeleteFunc(ob){
            Swal({
                title: '確定要刪除使用者',
                text: "使用者："+ob.id,
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '確定',
                cancelButtonText: '取消',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '../Management_all_api/Management_user_api.php',
                        method: 'post',
                        dataType: 'json',
                        data: {
                            type: "delete",
                            deleteid: ob.id,
                        }
                    }).done( res => {
                        if (res.tocheckdeletedatatruefalse) {
                            Swal(
                                '使用者已刪除',
                                '使用者：'+res.todeleteId,
                                'success'
                            )
                        } else {
                            Swal({
                                type: 'error',
                                title: '無法刪除使用者',
                                text: '使用者：'+res.todeleteId,
                            })

                        }
                        userShowAllData();
                        console.log(res);
                    }).fail( e => {
                        console.error(e);
                    })
                }
            })
        }

        //update (start)

        // updata value
        function updateFunc(ob){

            let passwordValue = document.querySelector("#userUpdatePassword");



            let U_Department = document.querySelector("[data-id='"+ob.id+"'] > [data-type=U_Department]").innerHTML.trim();
            let U_Id = document.querySelector("[data-id='"+ob.id+"'] > [data-type=U_Id]").innerHTML.trim();
            let U_Name = document.querySelector("[data-id='"+ob.id+"'] > [data-type=U_Name]").innerHTML.trim();
            let U_Tel = document.querySelector("[data-id='"+ob.id+"'] > [data-type=U_Tel]").innerHTML.trim();



            let U_Permission = document.querySelector("[data-id='"+ob.id+"'] > [data-type=U_Permission]").innerHTML.trim();

            if(U_Permission == "管理員"){
                U_Permission = 2;
            } else if (U_Permission == "訪客"){
                U_Permission = 1;
            } else if (U_Permission == "無權限"){
                U_Permission = 0;
            }

            document.querySelector("#userUpdateDepartment").value = U_Department;
            document.querySelector("#userUpdateId").value = U_Id;
            document.querySelector("#userUpdateName").value = U_Name;
            document.querySelector("#userUpdateTel").value = U_Tel;
            document.querySelector("#userUpdatePermission").value = U_Permission;



            document.querySelector("#userUpdateSubmit").onclick = function () {
                if (passwordValue.value == "" || passwordValue.value == undefined) {
                    $.ajax({
                        url: '../Management_all_api/Management_user_api.php',
                        method: 'post',
                        dataType: 'json',
                        data: {
                            type: "update",
                            userUpdateDepartment: document.querySelector("#userUpdateDepartment").value,
                            userUpdateId: document.querySelector("#userUpdateId").value,
                            userUpdateName: document.querySelector("#userUpdateName").value,
                            userUpdateTel: document.querySelector("#userUpdateTel").value,
                            userUpdatePermission: document.querySelector("#userUpdatePermission").value,
                            // originalUpdateTel: ,

                        }
                    }).done( res => {

                        if (res.tocheckteltruefalse) {
                            Swal({
                                type: 'error',
                                title: '電話已存在',
                                text: '電話：'+res.touserUpdateTel,

                            })
                        } else {
                            Swal(
                                '已更新使用者資料',
                                '使用者：'+res.touserUpdateId,
                                'success'
                            )
                            document.querySelector("#userUpdateClose").click();
                            userShowAllData();
                        }

                        console.log(res);
                    }).fail( e => {
                        console.error(e);
                    })
                    // console.log("00");
                } else if (passwordValue != "" || passwordValue != undefined) {
                    // console.log("0");
                    let password = document.querySelector("#userUpdatePassword").value;
                    let passwordAgain = document.querySelector("#userUpdateAgainPassword").value;

                    if (passwordAgain === password) {
                        $.ajax({
                            url: '../Management_all_api/Management_user_api.php',
                            method: 'post',
                            dataType: 'json',
                            data: {
                                type: "updatePassword",
                                userUpdateDepartment: document.querySelector("#userUpdateDepartment").value,
                                userUpdateId: document.querySelector("#userUpdateId").value,
                                userUpdateName: document.querySelector("#userUpdateName").value,
                                userUpdatePassword: document.querySelector("#userUpdatePassword").value,
                                userUpdateTel: document.querySelector("#userUpdateTel").value,
                                userUpdatePermission: document.querySelector("#userUpdatePermission").value,
                            }
                        }).done( res => {

                            if (res.tocheckteltruefalse) {
                                Swal({
                                    type: 'error',
                                    title: '電話已存在',
                                    text: '電話：'+res.touserUpdateTel,
                                })
                            } else {
                                if (res.toupdatepassword) {
                                    Swal(
                                        '已更新使用者資料',
                                        '使用者：'+res.touserUpdateId,
                                        'success'
                                    )
                                } else {
                                    Swal({
                                        type: 'error',
                                        title: '變更失敗',
                                        text: '使用者：'+res.touserUpdateId,
                                    })
                                }
                            }

                            document.querySelector("#userUpdateClose").click();
                            userShowAllData();

                            document.querySelector("#userUpdatePassword").value = "";
                            document.querySelector("#userUpdateAgainPassword").value = "";

                            console.log(res);
                        }).fail( e => {
                            console.error(e);
                        })
                    } else {
                        Swal({
                            type: 'error',
                            title: '密碼不一致',
                            text: '',

                        })
                    }
                }
            }

        }





        //update (end)

        //search
        document.querySelector("#userSearchButton").onclick = function () {

            let saerchValue = document.querySelector("#saerchValue").value;

            if (saerchValue == "" || saerchValue == undefined) {
                Swal(
                    '請輸入搜尋值',
                    '',
                    'question'
                )
            } else {
                $.ajax({
                    url: '../Management_all_api/Management_user_api.php',
                    method: 'post',
                    dataType: 'json',
                    data: {
                        type: "search",
                        searchvalue: saerchValue.trim(),
                    }
                }).done( res => {
                    let bsckSearchData = res.tosearchdata;

                    if (bsckSearchData.length != 0) {


                        let onePageData = 2;
                        let howmanypagebutton = Math.ceil(bsckSearchData.length / onePageData);

                        let pageButtonStr = "";
                        for (let i=0 ; i<howmanypagebutton ; i++) {
                            pageButtonStr += `<li class="page-item"><a class="page-link" onclick="pageButtonClcikFun(this.id)" id="${i+1}">${i+1}</a></li>`;
                        }

                        document.querySelector("#pageButtonTable").innerHTML = pageButtonStr;

                        let bsckSearchDataStr = "";

                        for(let i=0 ; i<bsckSearchData.length ; i++){
                            bsckSearchDataStr +=
                            `<tr data-id="${bsckSearchData[i].U_Id}" data-page="${Math.ceil((i+1)/onePageData)}">
                                <td>
                                    <!-- delete button -->
                                    <!--<button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#" id="${bsckSearchData[i].U_Id}" onclick="uesrDeleteFunc(this)"><i class="fas fa-trash-alt"></i></button>-->
                                    <!-- update button -->
                                    <button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target="#updateModalCenter" id="${bsckSearchData[i].U_Id}" onclick="updateFunc(this)"><i class="fas fa-pencil-alt"></i></button>
                                </td>
                                <td data-type="U_Department">
                                    ${bsckSearchData[i].U_Department}
                                </td>
                                <td data-type="U_Id">
                                    ${bsckSearchData[i].U_Id}
                                </td>
                                <td data-type="U_Name">
                                    ${bsckSearchData[i].U_Name}
                                </td>
                                <td data-type="U_Tel">
                                    0${bsckSearchData[i].U_Tel}
                                </td>
                                <td data-type="U_Permission">
                                    ${(bsckSearchData[i].U_Permission == 2 ? "管理員" : (bsckSearchData[i].U_Permission == 1 ? "訪客" : "無權限" ) )}
                                </td>
                            </tr>`;
                        }

                        document.querySelector("#userShowAllDataTable").innerHTML = bsckSearchDataStr;

                        nowClickPage = 1;

                        if (nowClickPage == 0) {
                            pageButtonClcikFun("", 1);
                        } else {
                            pageButtonClcikFun(nowClickPage);
                        }

                    } else {
                        document.querySelector("#userShowAllDataTable").innerHTML = "沒資料";
                    }

                    console.log(res);
                }).fail( e => {
                    console.error(e);
                })
            }
        }

        //reset
        document.querySelector("#userResetdata").onclick = function () {
            document.querySelector("#saerchValue").value = "";
            userShowAllData();
        }

        //bootstrap
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        // $('#example').tooltip(options)
</script>

</body>
</html>