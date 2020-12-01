<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../../library/function.php";
if (
    isset($_GET["use_id"])
    && is_numeric($_GET["use_id"])
    && is_auth()
) {
    $use_id = htmlspecialchars(strip_tags($_GET["use_id"]));

    $deleteArray = array();
    array_push($deleteArray, $use_id);
    $sql = "delete from users where use_id = ?";
    $result = dbExec($sql, $deleteArray);

    $resJson = array("result" => "success", "code" => "200", "message" => "done");
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
} else {
    //bad request
    $resJson = array("result" => "fail", "code" => "400", "message" => "error");
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
}
