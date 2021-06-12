<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../../library/function.php";
if (    
	 isset($_GET["bil_id"])
    && is_numeric($_GET["bil_id"])
	
    && is_auth()
) {
    
	$bil_id = $_GET["bil_id"];
	$sql = "select detail_bill.* 
		, food.foo_name 
		, foo_image 
		from detail_bill inner join food on detail_bill.foo_id = food.foo_id
		where bil_id = $bil_id  order by det_id ";
	
		$result = dbExec($sql, []);

    $arrJson = array();
    if ($result->rowCount() > 0) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            // extract($row);
            $arrJson[] = $row;
        }
    }
    $resJson = array("result" => "success", "code" => "200", "message" => $arrJson);
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
} else {
    //bad request
    $resJson = array("result" => "fail", "code" => "400", "message" => "error");
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
}
