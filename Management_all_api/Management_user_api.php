<?php

require_once("../db_connect/db_connect.php");
require_once("../function/global_function.php");

if(!empty($_POST["type"])){
    switch ($_POST["type"]){
        case 'showdata':

            $respone = [];
            $showAllData = sqlQry( "SELECT * FROM `user` ORDER BY `U_Id` ASC" , []);

            $respone['toShowAllData'] = $showAllData;

            echo json_encode($respone);

        break;

        case 'add':
            $userAddDepartment = $_POST['useradddepartment'];
            $userAddId = $_POST['useraddid'];
            $userAddName = $_POST['useraddname'];
            $userAddPassword = $_POST['useraddpassword'];
            $userAddTel = $_POST['useraddtel'];
            $userAddPermission = $_POST['useraddpermission'];
            $respone = [];
            $checkidtruefalse = false;
            $checkteltruefalse = false;
            $checkdatatruefalse = false;

            $checkidresult = "SELECT * FROM `user` WHERE `U_Id` = ?";
            $checkid = sqlQry( $checkidresult , [ $userAddId ] );

            if ($checkid) {
                $checkidtruefalse = true;
                $respone['checkIdTrueFalse'] = $checkidtruefalse;
            } else {
                $respone['checkIdTrueFalse'] = $checkidtruefalse;
            }

            $checktelresult = "SELECT * FROM `user` WHERE `U_Tel` = ?";
            $checktel = sqlQry( $checktelresult , [ $userAddTel ] );

            if ($checktel) {
                $checkteltruefalse = true;
                $respone['checkTelTrueFalse'] = $checkteltruefalse;
            } else {
                $respone['checkTelTrueFalse'] = $checkteltruefalse;
            }

            if ($checkid) {
                $respone['touserAddId'] = $userAddId;
                $respone['touserAddTel'] = $userAddTel;
            } else {
                if ($checktel) {
                    $respone['touserAddId'] = $userAddId;
                    $respone['touserAddTel'] = $userAddTel;
                } else {

                    $addresult = "INSERT INTO `user` (`U_Id`,`U_Password`,`U_Department`,`U_Name`,`U_Tel`,`U_Permission`) VALUES (?,?,?,?,?,?)";
                    $adddata = sqlEdit( $addresult , [ $userAddId,$userAddPassword, $userAddDepartment,$userAddName,$userAddTel,$userAddPermission ] );

                    if ($adddata) {

                        $checkdatatruefalse = true;
                        $respone['checkDataTrueFalse'] = $checkdatatruefalse;
                        $respone['touserAddId'] = $userAddId;
                        $respone['touserAddTel'] = $userAddTel;

                    } else {

                        $respone['checkDataTrueFalse'] = $checkdatatruefalse;
                        $respone['touserAddId'] = $userAddId;
                        $respone['touserAddTel'] = $userAddTel;

                    }



                }
            }

            echo json_encode($respone);

        break;

        case 'delete':

            $deleteid = $_POST['deleteid'];
            $checkdeletedatatruefalse = false;
            $respone = [];

            $deleteresult = "DELETE FROM `user` WHERE `U_Id` = ?";
            $deletedata = sqlEdit( $deleteresult , [ $deleteid ] );

            if ($deletedata == 1) {
                $checkdeletedatatruefalse = true;
                $respone['tocheckdeletedatatruefalse'] = $checkdeletedatatruefalse;
                $respone['todeletedata'] = $deletedata;
                $respone['todeleteId'] = $deleteid;
            } else {
                $respone['tocheckdeletedatatruefalse'] = $checkdeletedatatruefalse;
                $respone['todeletedata'] = $deletedata;
                $respone['todeleteId'] = $deleteid;
            }

            echo json_encode($respone);
            // print_r($deletedata);

        break;

        case 'update':

            $formuserUpdateDepartment = $_POST['userUpdateDepartment'] ;
            $formuserUpdateId = $_POST['userUpdateId'] ;
            $formuserUpdateName = $_POST['userUpdateName'] ;
            $formuserUpdatePermission = $_POST['userUpdatePermission'] ;
            $formuserUpdateTel = $_POST['userUpdateTel'] ;
            $checkteltruefalse = false;
            $checkuserteltruefalse = false;
            $respone = [];

            $checktelresult = "SELECT * FROM `user` WHERE `U_Tel` = ?";
            $checktel = sqlQry( $checktelresult , [ $formuserUpdateTel ] );

            if ($checktel) {
                $checkteltruefalse = true;

                $checkusertelresult = "SELECT * FROM `user` WHERE `U_Id` = ? AND `U_Tel` = ?";
                $checkusertel = sqlQry( $checkusertelresult , [ $formuserUpdateId , $formuserUpdateTel ] );


                if($checkusertel){
                    $checkteltruefalse = false;
                    $respone['tocheckteltruefalse'] = $checkteltruefalse;
                }
                $respone['tocheckteltruefalse'] = $checkteltruefalse;
            } else {
                $respone['tocheckteltruefalse'] = $checkteltruefalse;
            }
            //
            if($checkteltruefalse){
                $respone['touserUpdateTel'] = $formuserUpdateTel;
            } else {
                $result = "UPDATE `user`
                SET `U_Department` = ?,
                `U_Name` = ?,
                `U_Tel` = ?,
                `U_Permission` =?
                WHERE `U_Id` = ?";
                $updateData = sqlEdit( $result , [ $formuserUpdateDepartment,$formuserUpdateName,$formuserUpdateTel,$formuserUpdatePermission,$formuserUpdateId ] );

                $respone['toupdateData'] = $updateData;
                $respone['touserUpdateTel'] = $formuserUpdateTel;
                $respone['touserUpdateId'] = $formuserUpdateId;
            }

            echo json_encode($respone);
        break;

        case 'updatePassword':

            $formuserUpdateDepartment = $_POST['userUpdateDepartment'];
            $formuserUpdateId = $_POST['userUpdateId'];
            $fromuserUpdateName = $_POST['userUpdateName'];
            $fromuserUpdatePassword = $_POST['userUpdatePassword'];
            $fromuserUpdateTel = $_POST['userUpdateTel'];
            $fromuserUpdatePermission = $_POST['userUpdatePermission'];
            $checkteltruefalse = false;
            $checkuserteltruefalse = false;
            $respone = [];

            $checktelresult = "SELECT * FROM `user` WHERE `U_Tel` = ?";
            $checktel = sqlQry( $checktelresult , [ $fromuserUpdateTel ] );

            if ($checktel) {
                $checkteltruefalse = true;

                $checkusertelresult = "SELECT * FROM `user` WHERE `U_Tel` = ? AND `U_Id` = ?";
                $checkusertel = sqlQry( $checkusertelresult , [ $fromuserUpdateTel,$formuserUpdateId ] );

                if ($checkusertel) {
                    $checkteltruefalse = false;
                }
                $respone['tocheckteltruefalse'] = $checkteltruefalse;
            } else {
                $respone['tocheckteltruefalse'] = $checkteltruefalse;
            }

            if ($checkteltruefalse) {
                $respone['touserUpdateTel'] = $fromuserUpdateTel;
            } else {
                $result = "UPDATE `user`
                SET `U_Department` = ?,
                `U_Name` = ?,
                `U_Tel` = ?,
                `U_Permission` = ?,
                `U_Password` = ?
                WHERE `U_Id` = ?";
                $updatepassword = sqlEdit( $result , [ $formuserUpdateDepartment,$fromuserUpdateName,$fromuserUpdateTel,$fromuserUpdatePermission,$fromuserUpdatePassword,$formuserUpdateId ] );

                $respone['toupdatepassword'] = $updatepassword;
                $respone['touserUpdateId'] = $formuserUpdateId;

            }




            echo json_encode($respone);
        break;

        case 'search':

            $datatruefalse = false ;
            $respone = [];

            if ($_POST['searchvalue'] == "管理員") {

                $result = "SELECT `U_Id`,`U_Department`,`U_Name`,`U_Tel`,`U_Permission` FROM `user` WHERE
                `U_Permission` LIKE ? ORDER BY `U_Id` ASC
                ";
                $searchdata = sqlQry( $result , [ 2 ] );


            } else if ($_POST['searchvalue'] == "訪客") {

                $result = "SELECT `U_Id`,`U_Department`,`U_Name`,`U_Tel`,`U_Permission` FROM `user` WHERE
                `U_Permission` LIKE ? ORDER BY `U_Id` ASC
                ";
                $searchdata = sqlQry( $result , [ 1 ] );

            } else if ($_POST['searchvalue'] == "無權限") {

                $result = "SELECT `U_Id`,`U_Department`,`U_Name`,`U_Tel`,`U_Permission` FROM `user` WHERE
                `U_Permission` LIKE ? ORDER BY `U_Id` ASC
                ";
                $searchdata = sqlQry( $result , [ 0 ] );

            } else {

                $searchValue = "%" . $_POST['searchvalue'] . "%";

                $result = "SELECT `U_Id`,`U_Department`,`U_Name`,`U_Tel`,`U_Permission` FROM `user` WHERE
                `U_Id` LIKE ? OR
                `U_Department` LIKE ? OR
                `U_Name` LIKE ? OR
                `U_Tel` LIKE ?
                ";
                $searchdata = sqlQry( $result , [ $searchValue,$searchValue,$searchValue,$searchValue ] );

            }
            if ($searchdata) {
                $datatruefalse = true;
                $respone['DataTrueFalse'] = $datatruefalse;
                $respone['tosearchdata'] = $searchdata;
            } else {
                $datatruefalse = false;
                $respone['DataTrueFalse'] = $datatruefalse;
            }




            echo json_encode ($respone);
        break;
    }
}

?>