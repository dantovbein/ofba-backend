<?php
	header('Access-Control-Allow-Origin: *');
	
	require_once "../Storage.php";	
	
	$uid = md5(uniqid(rand(), true));

	//if(isset($_GET['uid'])) { $uid = $_GET['uid']; }
	//$uid = valueIfExists($array, "uid", md5(uniqid(rand(), true)));
	
	/*function valueIfExists($array, $key, $default)
	{
		if (!array_key_exists($key, $array))
			return $default;
		return $array[$key];

	}*/

	//$query = 'INSERT INTO ofba_jevents_vevent (ev_id,icsid,catid,uid,refreshed,created,created_by,created_by_alias,modified_by,rawdata,recurrence_id,detail_id,state,lockevent,author_notified,access) VALUES ("' . $data['ev_id'] . '","' . $data['icsid'] . '","' . $data['catid'] . '","' . $data['uid'] . '","' . $data['refreshed'] . '","' . $data['created'] . '","' . $data['created_by'] . '","' . $data['created_by_alias'] . '","' . $data['modified_by'] . '","' . $data['rawdata'] . '","' . $data['recurrence_id'] . '","' . $data['detail_id'] . '","' . $data['state'] . '","' . $data['lockevent'] . '","' . $data['author_notified'] . '","' . $data['access'] . '");';
		

	$data = array(
    	"uid" => $uid
    );

    print_r($data);

	//$storage = new Storage();
//	echo $storage->postEvento($data);
?>