<?php

require_once("../db_connect/db_connect.php");
require_once("../function/global_function.php");


if(!empty($_POST["type"])){
    switch ($_POST["type"]){
        case 'showAllData':
            $response = [];

            $result = "SELECT * FROM `borrow` JOIN `device` ON `borrow`.`D_Id` = `device`.`D_Id` WHERE `B_Statement_Status` = 1";
            $showdata = sqlQry( $result , [] );

            $response['toShowData'] = $showdata;

            echo json_encode($response);
            // print_r($showdata);

        break;

        case 'search':
            $response = [];
            $inputvalue = '%' . $_POST['searchvalue'] . '%';

            $result = "SELECT * FROM `borrow` JOIN `device` ON `borrow`.`D_Id` = `device`.`D_Id`
            WHERE
            `borrow`.`B_Statement_Status` = 1 AND `borrow`.`U_Id` LIKE ? OR
            `borrow`.`B_Statement_Status` = 1 AND `borrow`.`D_Id` LIKE ? OR
            `borrow`.`B_Statement_Status` = 1 AND `device`.`D_Name` LIKE ? OR
            `borrow`.`B_Statement_Status` = 1 AND `borrow`.`B_Entity_OutDay` LIKE ? OR
            `borrow`.`B_Statement_Status` = 1 AND `borrow`.`B_Entity_InDay` LIKE ? OR
            `borrow`.`B_Statement_Status` = 1 AND `borrow`.`B_Details` LIKE ? OR
            `borrow`.`B_Statement_Status` = 1 AND `borrow`.`B_Check_Single_User` LIKE ?
            ";
            $searchdata = sqlQry( $result , [$inputvalue,$inputvalue,$inputvalue,$inputvalue,$inputvalue,$inputvalue,$inputvalue] );

            $response['tosearchdata'] = $searchdata;

            echo json_encode($response);
            // print_r($inputvalue);
        break;
    }
}

?>