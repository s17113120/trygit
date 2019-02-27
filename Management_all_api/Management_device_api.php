<?php

require_once("../db_connect/db_connect.php");
require_once("../function/global_function.php");


if(!empty($_POST["type"])){
    switch ($_POST["type"]){
        case "showAllData":
            $response = [];
            $showAllData = sqlQry("SELECT * FROM `device` WHERE `D_Status` = ? ORDER BY `D_Id` ASC;",[ 0 ]);

            $response['returnShowAllData'] = $showAllData;
            echo json_encode($response);
        break;

        case "addDevice":

            $addDeviceId = $_POST['addDeviceId'];
            $addDeviceNumber = $_POST['addDeviceNumber'];
            $addDeviceName = $_POST['addDeviceName'];
            $addDeviceModel = $_POST['addDeviceModel'];
            $addDeviceDay = $_POST['addDeviceDay'];
            $addDeviceUnit = $_POST['addDeviceUnit'];
            $addDeviceDetails = $_POST['addDeviceDetails'];
            $checkdatatruefalse = false;
            $checkidtruefalse = false;
            $checknumbertruefalse = false;
            $response = [];

            $chceckidresult = "SELECT * FROM `device` WHERE `D_Id` = ? ";
            $chceckid = sqlQry( $chceckidresult , [ $addDeviceId ]);

            $chcecknumberresult = "SELECT * FROM `device` WHERE `D_Id` = ? ";
            $chcecknumber = sqlQry( $chcecknumberresult , [ $addDeviceNumber ]);

            if($chceckid) {
                $checkidtruefalse = true;
                $response['checkIdtruefalse'] = $checkidtruefalse;
            } else {
                $response['checkIdtruefalse'] = $checkidtruefalse;
            }
            if($chcecknumber){
                $checknumbertruefalse = true;
                $response['checkNumbertruefalse'] = $checknumbertruefalse;
            } else {
                $response['checkNumbertruefalse'] = $checknumbertruefalse;
            }
            if ($chceckid) {

            } else {
                if ($chcecknumber) {

                } else {

                    $result = "INSERT INTO `device` (`D_Id`,`D_Number`,`D_Name`,`D_Model`,`D_Day`,`D_Unit`,`D_Details`,`D_Lend`) VALUES (?,?,?,?,?,?,?,0);";
                    $addDeviceValue = sqlEdit($result , [$addDeviceId,$addDeviceNumber,$addDeviceName,$addDeviceModel,$addDeviceDay,$addDeviceUnit,$addDeviceDetails]);

                    $response['checkDatatruefalse'] = $addDeviceValue;

                }
            }


            echo json_encode($response);

        break;

        case "search":

            if($_POST['searchvalue'] == "已借出"){
                $searchAllData = sqlQry("SELECT * FROM `device` WHERE
                `D_Lend` = 1 AND
                `D_Status` = 0
                ORDER BY `D_Id`",[]);
                $response['toSearchAllData'] = $searchAllData;
            } else if ($_POST['searchvalue'] == "未借出") {
                $searchAllData = sqlQry("SELECT * FROM `device` WHERE
                `D_Lend` = 0 AND
                `D_Status` = 0
                ORDER BY `D_Id`",[]);
                $response['toSearchAllData'] = $searchAllData;
            } else {
                $searchValue = "%" . $_POST['searchvalue'] . "%";
                $response = [];

                $result = "SELECT * FROM `device` WHERE
                `D_Status` = 0 AND
                `D_Id` LIKE ? OR
                `D_Status` = 0 AND
                `D_Number` LIKE ? OR
                `D_Status` = 0 AND
                `D_Name` LIKE ? OR
                `D_Status` = 0 AND
                `D_Model` LIKE ? OR
                `D_Status` = 0 AND
                `D_Day` LIKE ? OR
                `D_Status` = 0 AND
                `D_Unit` LIKE ? OR
                `D_Status` = 0 AND
                `D_Details` LIKE ? OR
                `D_Status` = 0 AND
                `D_Lend` LIKE ?
                ORDER BY `D_Id`";
                $searchAllData = sqlQry( $result, [$searchValue , $searchValue , $searchValue , $searchValue , $searchValue , $searchValue , $searchValue ,$searchValue]);
                $response['toSearchAllData'] = $searchAllData;
            }



            echo json_encode($response);

        break;

        // case "delete":

        //     $deleteId = $_POST['deleteid'];
        //     $responsen = [];

        //     $result = "DELETE FROM `device` WHERE `D_Id` = ?;";
        //     $deletedata = sqlEdit( $result , [ $deleteId ] );

        //     $response['toDeleteId'] = $deletedata;

        //     echo json_encode($response);

        // break;

        case "update":

            $deviceUpdateId = $_POST['deviceUpdateid'];
            $deviceUpdateNumber = $_POST['deviceUpdatenumber'];
            $deviceUpdateName = $_POST['deviceUpdatename'];
            $deviceUpdateModel = $_POST['deviceUpdatemodel'];
            $deviceUpdateDay = $_POST['deviceUpdateday'];
            $deviceUpdateUnit = $_POST['deviceUpdateunit'];
            $deviceUpdateDetails = $_POST['deviceUpdatedetails'];
            $deviceUpdateStatus = $_POST['deviceUpdateStatus'];
            $checknumbertruefalse = false;
            $response = [];

            $checkresult1 = "SELECT * FROM `device` WHERE `D_Number` = ? AND `D_Id` = ?";
            $chcecknumber1 = sqlQry( $checkresult1 , [$deviceUpdateNumber , $deviceUpdateId] );

            if ($chcecknumber1) {

                $response['checkNumberTrueFalse'] = $checknumbertruefalse;

                $result = "UPDATE `device`
                SET `D_Number` = ?
                , `D_Name` = ?
                , `D_Model` = ?
                , `D_Day` = ?
                , `D_Unit` = ?
                , `D_Details` = ?
                , `D_Status` = ?
                WHERE `D_Id` = ?";
                $toupdatedata = sqlEdit( $result , [$deviceUpdateNumber,$deviceUpdateName,$deviceUpdateModel,$deviceUpdateDay,$deviceUpdateUnit,$deviceUpdateDetails,$deviceUpdateStatus,$deviceUpdateId]);

                if ($toupdatedata == 1) {
                    $response['toUpdateData'] = $toupdatedata;
                    $response['toDeviceUpdateId'] = $deviceUpdateId;
                } else {

                }

            } else  {
                $checkresult2 = "SELECT * FROM `device` WHERE `D_Number` = ? ";
                $chcecknumber2 = sqlQry( $checkresult2 , [$deviceUpdateNumber] );

                if($chcecknumber2){
                    $checknumbertruefalse = true;
                    $response['checkNumberTrueFalse'] = $checknumbertruefalse;
                } else {
                    $response['checkNumberTrueFalse'] = $checknumbertruefalse;

                    $result = "UPDATE `device`
                    SET `D_Number` = ?
                    , `D_Name` = ?
                    , `D_Model` = ?
                    , `D_Day` = ?
                    , `D_Unit` = ?
                    , `D_Details` = ?
                    , `D_Status` = ?
                    WHERE `D_Id` = ?";
                    $toupdatedata = sqlEdit( $result , [$deviceUpdateNumber,$deviceUpdateName,$deviceUpdateModel,$deviceUpdateDay,$deviceUpdateUnit,$deviceUpdateDetails,$deviceUpdateStatus,$deviceUpdateId]);

                    if ($toupdatedata == 1) {
                        $response['toUpdateData'] = $toupdatedata;
                        $response['toDeviceUpdateId'] = $deviceUpdateId;
                    } else {

                    }
                }
            }








            // print_r($toupdatedata);
            echo json_encode($response);
        break;
    }
}

?>
