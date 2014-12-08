<?php

session_start();

$post_url 	= "http://bbs.wust.edu.cn/vote/vote/ajax.php";
$pic_url 	= "http://bbs.wust.edu.cn/vote/vote/includes/rand_func.php";
$main_url 	= "http://bbs.wust.edu.cn/vote/vote/";
//$sso_url 	= 'http://jwxt.wust.edu.cn/whkjdx/Logon.do?method=logonBySSO';
//$score_url 	= 'http://jwxt.wust.edu.cn/whkjdx/xszqcjglAction.do?method=queryxscj';

//echo $pic_url.$_COOKIE['local_rc'];

function getvid()
{
	$result = file_get_contents("login.html");
    
    $name =array("谭瑶","李柏依");

    $otname =array("祝晓璐","程璐瑶","汪世志","钟敏","龚娜","朱彦虹","徐佳慧","胡梦蝶","王嫣云","张路鑫");

    for($i = 2 ;$i <= 5; $i++)
    	$name[$i] = $otname[rand(0,count($otname)-1)];
     
	//preg_match('/谭瑶(.*?)value="(.*?)"/m', $result, $m);
	$res = "";

	for($i = 0;$i < 6 ;$i++)
	{
		preg_match("/$name[$i]<(.*)/s", $result, $m);
		preg_match('/value="(.*?)"/m', $m[1],$mm);
		$res.='|'.$mm[1];
	}

	//echo $res."</br></br>";
	return $res;

}

if( !empty($_GET['action']) && $_GET['action']=='getimg2' ){
	
	//echo $
	require_once 'snoopy.cls.php';
	$snoopy = new Snoopy;
	$snoopy ->maxredirs = 3;
	$snoopy ->offsiteok = FALSE;
	$snoopy ->expandlinks = FALSE;
	$snoopy ->cookies['PHPSESSID'] = $_COOKIE['local_tmp_id'];

	//echo $_COOKIE['local_rc'];
	$snoopy->fetch($pic_url.'?'.$_COOKIE['local_rc']);

	echo trim($snoopy->results);
	exit();

} elseif( !empty($_GET['code2']) ){
	$post_arr = array(
		'nt' => '3123196417340',
		'user' => $_COOKIE['name'],
		'vid' => getvid(),
		'randcode' => $_GET['code2'],
		'time' => '102627072481841',
         '_' => '',
		//'vid' => '|D95F56AAUABQMEAgYCBgABBAYBBgIMBgcNDQIFBQYFVlAB|406BF0AgUABQMEAgYCBgBXAgZSVQQGAgwGBw0NAQ0CDVJQ|26E469AAUABQMEAgYCBgANBwwABgIMBgcNDQIEDFIGBQdS|DA9D56BgUABQMEAgYCBgBRAQYCDAYHDQ0CBQYEAwUMVgwN|86A695BQUABQMEAgYCBgBSBgIMBgcNDQIEAQYADAEBB1JX|38D930BgUABQMEAgYCBgBSDQYCDAYHDQ0CBAQFBVdRDFcB|342B7ABwUABQMEAgYCBgBSVQUGAgwGBw0NAgQNDAAHDFAD',
	);
	// 登录
	require_once 'snoopy.cls.php';
	$snoopy = new Snoopy;
	$snoopy->maxredirs = 3;
	$snoopy->offsiteok = FALSE;
	$snoopy->expandlinks = FALSE;
	$snoopy->cookies["PHPSESSID"] = $_COOKIE['local_tmp_id'];
	$snoopy->submit($post_url, $post_arr);//$formvars为提交的数组

	//echo $snoopy->results;
	//$snoopy->fetch($main_url);
	$output = trim($snoopy->results);
	echo $output;

	?>
	<script language="javascript">

	var re=<? echo $output?>

	//alert(re);

	if(re>99)
			alert('不在投票范围内');   
	else if(re>8)
		alert('请勿重复投票！');   
	else if(re>7)
		alert('请勿重复投票！！');   
	else if(re>6)
	   alert('你不是投票用户,只有登陆的投票用户才可以投票!参赛选手不可以投票！');       
	else if(re>5)
	{
	   alert('请输入正确的验证码!请刷新以后再试一次!');
	   /*<?
	   header("post.php");
	   ?>*/
	   window.location.href='post.php';
	}
	else if(re>4)
		alert('不在投票的时间范围内!');	       
	else if(re>3)
	{
		alert('请登陆以后再进行投票!');
		//window.location.href='index.php';	       
	}
	else if (re>2)
	{
       alert('你可能登陆超时了!请重新登陆以后再投票!');
	   //window.location.href='index.php';
	}
	else if (re>1)		
		alert("请勿重复投票!!!");
	else if (re>0)
	  alert('投票成功,非常感谢你的支持!');
	else
		alert('请勿重复投票!!!!');
	</script>

	<?
	
	$id = $_COOKIE['ID']; 
	$id +=1;

	//echo "id：$id </br></br>";
	setcookie('ID',$id,'0','/');
	setcookie("local_tmp_id", "value", time()-12124);
	?>

	<script language="javascript">
	window.location.href='user.php';
	</script>

	<?
	//exit();
}
?>

<html>

	<body>
		<img src="post.php?action=getimg2" >
		
		<form action="post.php">
			<input type="text" name="code2">
			<input type="submit">
		</form>
		
	</body>
</html>