<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../../library/function.php";
include_once "../../library/create_image.php";

if (isset($_POST["cus_name"])
    && isset($_POST["cus_pwd"])
    && isset($_POST["cus_mobile"])
	&& isset($_POST["cus_email"])
	
	&& is_auth()
  
) {
  
     $cus_name = $_POST["cus_name"];
    $cus_pwd = $_POST["cus_pwd"];
	$cus_mobile = $_POST["cus_mobile"];
	
	$cus_email = $_POST["cus_email"] == null ?"" : $_POST["cus_email"] ;
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


    $insertArray = array();
	
    array_push($insertArray, htmlspecialchars(strip_tags($cus_name)));
    array_push($insertArray, htmlspecialchars(strip_tags($cus_pwd)));
	array_push($insertArray, htmlspecialchars(strip_tags($cus_mobile)));
    array_push($insertArray, htmlspecialchars(strip_tags($cus_email)));
    
	
	  array_push($insertArray, htmlspecialchars(strip_tags($img_image)));
    array_push($insertArray, htmlspecialchars(strip_tags($img_thumbnail)));


    $sql = "insert into customer
        (cus_name , cus_pwd ,
		cus_mobile ,cus_email ,
		cus_image , cus_thumbnail
		, cus_regdate )
            values(?,? ,
			? , ? ,
			? , ? ,
			
			 now())";	
    $result = dbExec($sql, $insertArray);
	
	
    $readArray = array();
	
    array_push($readArray, htmlspecialchars(strip_tags($cus_mobile)));
	
    $sql = "select * from customer where cus_mobile = ?  order by cus_id desc limit 0,1";
    $result = dbExec($sql, $readArray);
    $arrJson = array();
    if ($result->rowCount() > 0) {
        $arrJson  = $result->fetch();
	}

    $resJson = array("result" => "success", "code" => "200", "message" => $arrJson);
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
} else {
    //bad request
    $resJson = array("result" => "fail", "code" => "400", "message" => "error");
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
}
