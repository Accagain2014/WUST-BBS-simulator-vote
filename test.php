<?php
	
	//echo "sljdsljf";

function getvid()
{
	$result = file_get_contents("login.html");
    
    $name =array("谭瑶","李柏依","祝晓璐","程璐瑶","汪世志","钟敏");
     
	//preg_match('/谭瑶(.*?)value="(.*?)"/m', $result, $m);
	$res = "";

	for($i = 0;$i < 6 ;$i++)
	{
		preg_match("/$name[$i]<(.*)/s", $result, $m);
		preg_match('/value="(.*?)"/m', $m[1],$mm);
		$res.='|'.$mm[1];
	}
	
	echo $res;
}

echo getvid();
/*	$result = file_get_contents("login.html");

	//preg_match('/谭瑶(.*?)value="(.*?)"/m', $result, $m);
	preg_match('/谭瑶<(.*)/s', $result, $m);
	preg_match('/value="(.*?)"/m', $m[1],$mm);

	echo $mm[1];*/
	

?>