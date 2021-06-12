<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../../library/function.php";


if (
    isset($_POST["cus_id"])
    && isset($_POST["data"])
  
) {
	//==============get paramter for table bill
    $cus_id = $_POST["cus_id"];
	$bil_address = $_POST["bil_address"];
	$bil_before_note = $_POST["bil_before_note"];
	
	
    $insertArray = array();
    array_push($insertArray, htmlspecialchars(strip_tags($cus_id)));
    array_push($insertArray, htmlspecialchars(strip_tags($bil_address)));
	array_push($insertArray, htmlspecialchars(strip_tags($bil_before_note)));
	
	  

    $sql = "insert into bill
        (cus_id , bil_address , bil_before_note , bil_regdate )
            values(? , ? , ? ,  now())";
    $result = dbExec($sql, $insertArray);

	
	 $readArray = array();
	
    array_push($readArray, htmlspecialchars(strip_tags($cus_id)));
	
	$new_bil_id = 0;
    $sql = "select * from bill where cus_id = ?  order by bil_id desc limit 0,1";
    $result = dbExec($sql, $readArray);
    
    if ($result->rowCount() > 0) {
        $row  = $result->fetch();		
		$new_bil_id = $row["bil_id"];
	}
	
	//==============end
	$data = $_POST["data"];
	$arr = explode("#",$data);
	foreach($arr as $key => $val)
	{
		if(trim($val) != "")
		{
			$myarr = explode("," , $val);

			$bil_id = $new_bil_id;			
			$detailArray = array();
			array_push($detailArray, htmlspecialchars(strip_tags($bil_id)));
			array_push($detailArray, htmlspecialchars(strip_tags($myarr[0]))); //ite_id
			array_push($detailArray, htmlspecialchars(strip_tags($myarr[1]))); // qty
			array_push($detailArray, htmlspecialchars(strip_tags($myarr[2]))); //price
			$sql = "insert into detail_bill
			(bil_id , foo_id , det_qty , det_price )
			values(? , ? , ? ,  ?)";
			$result = dbExec($sql, $detailArray);
		}
	}
	//==============for each string from appliction 
	
	

	

    $resJson = array("result" => "success", "code" => "200", "message" => "done");
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
} else {
    //bad request
    $resJson = array("result" => "fail", "code" => "400", "message" => "error");
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
}
