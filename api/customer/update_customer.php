<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../../library/function.php";
include_once "../../library/create_image.php";
if (
    isset($_POST["cus_id"])
    && is_numeric($_POST["cus_id"])
    && isset($_POST["cus_name"])
    && isset($_POST["cus_pwd"])
    && isset($_POST["cus_mobile"])
	&& isset($_POST["cus_email"])
	
    
    && is_auth()
) {
		if (!empty($_FILES["file"]['name']) )
	{
		$images = uploadImage("file" , '../../images/customer/' , 200 , 600);
		$img_image = $images["image"];
		$img_thumbnail = $images["thumbnail"];
    
	}
	else
	{
		$img_image = "";
		$img_thumbnail = "";
	}

	
    $cus_name = $_POST["cus_name"];
    $cus_pwd = $_POST["cus_pwd"];
	$cus_mobile = $_POST["cus_mobile"];
	$cus_email = $_POST["cus_email"] == null ? "" : $_POST["cus_email"]  ;
  
    
   
    $cus_id = $_POST["cus_id"];

    $updateArray = array();
    array_push($updateArray, htmlspecialchars(strip_tags($cus_name)));
    array_push($updateArray, htmlspecialchars(strip_tags($cus_pwd)));
	array_push($updateArray, htmlspecialchars(strip_tags($cus_mobile)));
    array_push($updateArray, htmlspecialchars(strip_tags($cus_email)));

	if($img_image != "")
	{
		array_push($updateArray, htmlspecialchars(strip_tags($img_image)));
		array_push($updateArray, htmlspecialchars(strip_tags($img_thumbnail)));
	}
    array_push($updateArray, htmlspecialchars(strip_tags($cus_id)));

	if($img_image != "")
	{
		$sql = "update customer 
		set cus_name=?,cus_pwd=?,
		set cus_mobile=?,cus_email=?,
	
		cus_image = ? , cus_thumbnail = ? 
		where cus_id=?";
	}
	else
	{
			$sql = "update customer 
		set cus_name=?,cus_pwd=?,
		set cus_mobile=?,cus_email=?,

		
		
		where cus_id=?";
	}
    $result = dbExec($sql, $updateArray);


    $resJson = array("result" => "success", "code" => "200", "message" => "done");
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
} else {
    //bad request
    $resJson = array("result" => "fail", "code" => "400", "message" => "error");
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
}
