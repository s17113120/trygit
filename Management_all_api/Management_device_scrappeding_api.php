<?php

require_once("../db_connect/db_connect.php");
require_once("../function/global_function.php");


if(!empty($_POST["type"])){
    switch ($_POST["type"]){
        case 'showdevicescrappedingdata':

            $response = [];

            $result = "SELECT * FROM `device` WHERE `D_Status` = ? ORDER BY `D_Id` ASC ;";
            $showdata = sqlQry( $result , [2] );

            $response['toshowdata'] = $showdata;

            echo json_encode($response);

        break;

        case 'searchdata':

            $searchValue = '%' . $_POST['searchvalue'] . '%';

            $result = "SELECT * FROM `device` WHERE
            `D_Status` = 2 AND
            `D_Id` LIKE ? OR
            `D_Status` = 2 AND
            `D_Number` LIKE ? OR
            `D_Status` = 2 AND
            `D_Name` LIKE ? OR
            `D_Status` = 2 AND
            `D_Model` LIKE ? OR
            `D_Status` = 2 AND
            `D_Day` LIKE ? OR
            `D_Status` = 2 AND
            `D_Unit` LIKE ? OR
            `D_Status` = 2 AND
            `D_Details` LIKE ?
            ";
            $searchData = sqlQry( $result , [ $searchValue,$searchValue,$searchValue,$searchValue,$searchValue,$searchValue,$searchValue ] );

            $response['tosearchData'] = $searchData;

            echo json_encode($response);
        break;

        case 'update':

            $formdeviceUpdateId = $_POST['deviceUpdateId'];
            $formdeviceUpdateNumber = $_POST['deviceUpdateNumber'];
            $formdeviceUpdateName = $_POST['deviceUpdateName'];
            $formdeviceUpdateModel = $_POST['deviceUpdateModel'];
            $formdeviceUpdateDay = $_POST['deviceUpdateDay'];
            $formdeviceUpdateUnit = $_POST['deviceUpdateUnit'];
            $formdeviceUpdateDetails = $_POST['deviceUpdateDetails'];
            $formdeviceUpdateStatus = $_POST['deviceUpdateStatus'];

            $response = [];

            //檢查重複number
            $checkthisidnumbertruefalse = false;
            $checkthisidnumberresult = "SELECT * FROM `device` WHERE `D_Id` = ? AND `D_Number` = ?";
            $checkthisidnumber = sqlQry( $checkthisidnumberresult , [ $formdeviceUpdateId,$formdeviceUpdateNumber ] );

            $checkallnumbertruefalse = false;
            $checkallnumberresult = "SELECT * FROM `device` WHERE `D_Number` = ?";
            $checkallnumber = sqlQry( $checkallnumberresult , [ $formdeviceUpdateNumber ] );

            if ($checkallnumber) {
                $checkallnumbertruefalse = true;

                $checkthisidnumberresult = "SELECT * FROM `device` WHERE `D_Id` = ? AND `D_Number` = ?";
                $checkthisidnumber = sqlQry( $checkthisidnumberresult , [ $formdeviceUpdateId,$formdeviceUpdateNumber ] );

                if ($checkthisidnumber) {
                    $checkallnumbertruefalse = false;

                } else {
                }
                $response['tocheckallnumbertruefalse'] = $checkallnumbertruefalse;
                if ($checkallnumbertruefalse) {

                } else {

                    $result = "UPDATE `device` SET
                    `D_Number` = ?,
                    `D_Name` = ?,
                    `D_Model` = ?,
                    `D_Day` = ?,
                    `D_Unit` = ?,
                    `D_Details` = ?,
                    `D_Status` = ?
                    WHERE `D_Id` = ?;
                    ";

                    $updatedata = sqlEdit( $result , [ $formdeviceUpdateNumber,$formdeviceUpdateName,$formdeviceUpdateModel,$formdeviceUpdateDay,$formdeviceUpdateUnit,$formdeviceUpdateDetails,$formdeviceUpdateStatus,$formdeviceUpdateId ] );

                    $response['toupdatedata'] = $updatedata;
                }


                // if ($updatedata == 1) {
                //     $response['update'] = true;
                //     $response['toupdatedata'] = $updatedata;
                // } else {
                //     $response['update'] = false;
                // }

            } else {

                $result = "UPDATE `device` SET
                `D_Number` = ?,
                `D_Name` = ?,
                `D_Model` = ?,
                `D_Day` = ?,
                `D_Unit` = ?,
                `D_Details` = ?,
                `D_Status` = ?
                WHERE `D_Id` = ?;
                ";

                $updatedata = sqlEdit( $result , [ $formdeviceUpdateNumber,$formdeviceUpdateName,$formdeviceUpdateModel,$formdeviceUpdateDay,$formdeviceUpdateUnit,$formdeviceUpdateDetails,$formdeviceUpdateStatus,$formdeviceUpdateId ] );

                $response['toupdatedata'] = $updatedata;

            }

            echo json_encode($response);
            // print_r($updatedata);

        break;

    }
}