<?php

require_once("../db_connect/db_connect.php");
require_once("../function/global_function.php");


if(!empty($_POST["type"])){
    switch ($_POST["type"]){

        case 'showTopTable':

            $response = [];

            $showtopalltable = sqlQry("SELECT *
            FROM `borrow` JOIN `device` ON `borrow`.`D_Id` = `device`.`D_Id`
            WHERE `B_Checkoutnumber` = 2 AND `B_Statement_Status` = 0" ,[ ]);

            $response['showTopAllTable'] = $showtopalltable;

            echo json_encode($response);

        break;

        case 'showUnderAllData':

            $response = [];

            $showUnderalltable = sqlQry("SELECT *
            FROM `borrow` JOIN `device` ON `borrow`.`D_Id` = `device`.`D_Id`
            WHERE `B_Checkoutnumber` = 1 AND `B_Statement_Status` = 0" ,[ ]);

            $response['showUnderAllTable'] = $showUnderalltable;

            echo json_encode($response);

        break;

        case 'add':

            $outUserId = $_POST['addOutUserId'];
            $outDeviceId = $_POST['addOutDeviceId'];
            $expectedOutDay = $_POST['addExpectedOutDay'];
            $expectedInDay = $_POST['addExpectedInDay'];
            $details = $_POST['addDetails'];

            $outUserIdHaveValue = false;
            $outDeviceIdHaveValue = false;
            $expectedOutDayHavaValue = false;
            $expectedInDayHaveValue = false;

            $checkhaveuser = false;
            $checkhavedevice = false;
            $checkhavedeviceout = false;
            $checkdata = false;

            $addDatatruefalse = false;

            $response = [];



            if ($outUserId == "") {
                $outUserIdHaveValue = true;
                $response['toOutUserIdHaveValue'] = $outUserIdHaveValue;
            } else {
                $response['toOutUserIdHaveValue'] = $outUserIdHaveValue;

                if ($outDeviceId == "") {
                    $outDeviceIdHaveValue = true;
                    $response['toOutDeviceIdHaveValue'] = $outDeviceIdHaveValue;
                } else {
                    $response['toOutDeviceIdHaveValue'] = $outDeviceIdHaveValue;

                    if ($expectedOutDay == "") {
                        $expectedOutDayHavaValue = true;
                        $response['toExpectedOutDayHavaValue'] = $expectedOutDayHavaValue;
                    } else {
                        $response['toExpectedOutDayHavaValue'] = $expectedOutDayHavaValue;

                        if ($expectedInDay == "") {
                            $expectedInDayHaveValue = true;
                            $response['toExpectedInDayHaveValue'] = $expectedInDayHaveValue;
                        } else {
                            $response['toExpectedInDayHaveValue'] = $expectedInDayHaveValue;

                            if ($expectedOutDay <= $expectedInDay) {
                                $response['toCheckdata'] = $checkdata;

                                $checkuserresult = "SELECT * FROM `user` WHERE `U_Id` = ?";
                                $checkuser = sqlQry( $checkuserresult , [ $outUserId ] );

                                if ($checkuser) {

                                    $response['toCheckhaveuser'] = $checkhaveuser;

                                    $checkdeviceresult = "SELECT *  FROM `device` WHERE `D_Id` = ?";
                                    $checkdevice = sqlQry( $checkdeviceresult , [ $outDeviceId ] );

                                    if ($checkdevice) {

                                        $response['toCheckhavedevice'] = $checkhavedevice;

                                        $checkdeviceoutresult = "SELECT *  FROM `device` WHERE `D_Id` = ? AND `D_Lend` = 0";
                                        $checkdeviceout = sqlQry( $checkdeviceoutresult , [ $outDeviceId ] );

                                        if ($checkdeviceout) {

                                            $response['toCheckhavedeviceout']  = $checkhavedeviceout;

                                            $result = "INSERT INTO `borrow` (`U_Id`,`D_Id`,`B_Expected_OutDay`,`B_Expected_InDay`,`B_Details`) VALUES (?,?,?,?,?)";
                                            $addData = sqlEdit( $result , [ $outUserId,$outDeviceId,$expectedOutDay,$expectedInDay,$details  ] );

                                            if ($addData) {
                                                $addDatatruefalse = true;
                                                $response['toaddDatatruefalse'] = $addDatatruefalse;
                                            } else {
                                                $response['toaddDatatruefalse'] = $addDatatruefalse;
                                            }

                                        } else {
                                            $checkhavedeviceout = true;
                                            $response['toCheckhavedeviceout']  = $checkhavedeviceout;
                                        }

                                    } else {
                                        $checkhavedevice = true;
                                        $response['toCheckhavedevice'] = $checkhavedevice;
                                    }

                                } else {
                                    $checkhaveuser = true;
                                    $response['toCheckhaveuser'] = $checkhaveuser;
                                }


                            } else {
                                $checkdata = true;
                                $response['toCheckdata'] = $checkdata;
                            }
                        }
                    }
                }
            }


            echo json_encode($response);

        break;

        case 'changeTopButton':

            $changeId = $_POST['changeid'];
            $checkUser = $_POST['checkuser'];
            $changedevicelend = $_POST['deviceid'];
            $response = [];

            $changeD_LendResult = "UPDATE `device` SET `D_Lend` = ? WHERE `D_Id` = ?";
            $changeD_Lend = sqlEdit( $changeD_LendResult , [ 1,$changedevicelend ] );

            $response['tochangeD_Lend'] = $changeD_Lend;

            $result = "UPDATE `borrow`
            SET `B_Checkoutnumber` = ? , `B_Check_Single_User` = ?
            WHERE `B_Out_Id` = ?";
            $changedata = sqlEdit( $result , [ 1,$checkUser,$changeId] );

            $response['toChangeData'] = $changedata;

            echo json_encode($response);
            // print_r($_POST);

        break;

        case 'changeUnderButton':

            $changeId = $_POST['changeid'];
            $deviceid = $_POST['deviceid'];
            $checkOutDay = false;
            $response = [];

            $checkoutdayresult = "SELECT * FROM `borrow` WHERE `B_Out_Id` = ? AND `B_Entity_OutDay` = ?";
            $checkoutday = sqlQry( $checkoutdayresult , [ $changeId,"" ] );
            $response['tocheckoutday'] = $checkoutday;

            if ($checkoutday) {
                $response['tocheckOutDay'] = $checkOutDay;

                $result = "UPDATE `borrow`
                SET `B_Checkoutnumber` = ? , `B_Check_Single_User` = ? , `B_Entity_OutDay` = ? , `B_Entity_InDay` = ?
                WHERE `B_Out_Id` = ?";
                $changedata = sqlEdit( $result , [ 2,"","","",$changeId ] );

                $devicelendnumber = sqlEdit("UPDATE `device` SET `D_Lend` = ? WHERE `D_Id` = ?" , [ 0,$deviceid ] );

                $response['toChangeData'] = $changedata;
            } else {
                $checkOutDay = true;
                $response['tocheckOutDay'] = $checkOutDay;
            }


            echo json_encode($response);

        break;

        case 'topsearch':
            $searchvalue = '%' . $_POST['searchvalue'] . '%';
            $response = [];

            $result = "SELECT * FROM `borrow` JOIN `device` ON `borrow`.`D_Id` = `device`.`D_Id` WHERE
            `B_Checkoutnumber` = 2 AND
            `borrow`.`U_Id` LIKE ? OR
            `B_Checkoutnumber` = 2 AND
            `borrow`.`D_Id` LIKE ? OR
            `B_Checkoutnumber` = 2 AND
            `device`.`D_Name` LIKE ? OR
            `B_Checkoutnumber` = 2 AND
            `borrow`.`B_Expected_OutDay` LIKE ? OR
            `B_Checkoutnumber` = 2 AND
            `borrow`.`B_Expected_InDay` LIKE ? OR
            `B_Checkoutnumber` = 2 AND
            `borrow`.`B_Details` LIKE ?

            ORDER BY `borrow`.`B_Out_Id`;";

            $topSearch = sqlQry( $result , [$searchvalue,$searchvalue,$searchvalue,$searchvalue,$searchvalue,$searchvalue] );
            $response['totopSearch'] = $topSearch;
            // $response['searchSQL'] = $result;

            echo json_encode($response);
        break;

        case 'undersearch':
            $searchvalue = '%' . $_POST['searchvalue'] . '%';
            $response = [];

            $result = "SELECT * FROM `borrow` JOIN `device` ON `borrow`.`D_Id` = `device`.`D_Id` WHERE
            `B_Checkoutnumber` = 1 AND
            `B_Entity_InDay` = '' AND
            `borrow`.`U_Id` LIKE ? OR
            `B_Checkoutnumber` = 1 AND
            `B_Entity_InDay` = '' AND
            `borrow`.`D_Id` LIKE ? OR
            `B_Checkoutnumber` = 1 AND
            `B_Entity_InDay` = '' AND
            `device`.`D_Name` LIKE ? OR
            `B_Checkoutnumber` = 1 AND
            `B_Entity_InDay` = '' AND
            `borrow`.`B_Expected_OutDay` LIKE ? OR
            `B_Checkoutnumber` = 1 AND
            `B_Entity_InDay` = '' AND
            `borrow`.`B_Expected_InDay` LIKE ? OR
            `B_Checkoutnumber` = 1 AND
            `B_Entity_InDay` = '' AND
            `borrow`.`B_Details` LIKE ?

            ORDER BY `borrow`.`B_Out_Id`;";

            $underSearch = sqlQry( $result , [$searchvalue,$searchvalue,$searchvalue,$searchvalue,$searchvalue,$searchvalue] );
            $response['toUnderSearch'] = $underSearch;
            // $response['searchSQL'] = $result;

            echo json_encode($response);
        break;

        case 'writeoutday':

            $formGetDate = $_POST['getdate'];
            $formWriteId = $_POST['writeid'];
            $response = [];

            $result = "UPDATE `borrow`
            SET `B_Entity_OutDay` = ?
            WHERE `B_Out_Id` = ?";
            $updatedate = sqlEdit( $result , [ $formGetDate,$formWriteId ] );

            if ($updatedate) {
                $response['toUpdateDate'] = $updatedate;
            }

            echo json_encode($response);

        break;

        case 'writeinday':

            $formGetDate = $_POST['getdate'];
            $formWriteId = $_POST['writeid'];
            $formDeviceId = $_POST['deviceid'];
            $response = [];

            $deviceresult = "UPDATE `device` SET `D_Lend` = ? WHERE `D_Id` = ?";
            $deviceIdData = sqlEdit( $deviceresult , [ 0,$formDeviceId ] );

            $result = "UPDATE `borrow`
            SET `B_Entity_InDay` = ? , `B_Statement_Status` = 1
            WHERE `B_Out_Id` = ?";
            $updatedate = sqlEdit( $result , [ $formGetDate,$formWriteId ] );

            if ($updatedate) {
                $response['toUpdateDate'] = $updatedate;
            }

            echo json_encode($response);
            // print_r($_POST);
        break;

    }
}

?>