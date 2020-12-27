<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../../library/function.php";
if (
    isset($_GET["use_pwd"])
    && isset($_GET["use_mobile"])
    && is_auth()
) {
    $use_pwd = htmlspecialchars(strip_tags($_GET["use_pwd"]));
    $use_mobile = htmlspecialchars(strip_tags($_GET["use_mobile"]));

    $selectArray = array();
    array_push($selectArray, $use_pwd);
    array_push($selectArray, $use_mobile);
    $sql = "select * from users where use_pwd = ? and use_mobile = ?";
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
