<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../../library/function.php";
if (
    isset($_POST["cus_pwd"])
    && isset($_POST["cus_mobile"])
    && is_auth()
) {
    $cus_pwd = htmlspecialchars(strip_tags($_POST["cus_pwd"]));
    $cus_mobile = htmlspecialchars(strip_tags($_POST["cus_mobile"]));

    $selectArray = array();
    array_push($selectArray, $cus_pwd);
    array_push($selectArray, $cus_mobile);
    $sql = "select * from customer where cus_pwd = ? and cus_mobile = ?";
    $result = dbExec($sql, $selectArray);
    $arrJson = array();
    if ($result->rowCount() > 0) {
        $arrJson  = $result->fetch();
        $resJson = array("result" => "success", "code" => "200", "message" => $arrJson);
        echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
    } else {
        //bad request
        $resJson = array("result" => "empty", "code" => "400", "message" => "empty");
        echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
    }
} else {
    //bad request
    $resJson = array("result" => "fail", "code" => "400", "message" => "error");
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
}
