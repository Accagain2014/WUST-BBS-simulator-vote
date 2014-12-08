<?php

//echo "lsdjsf";
session_start();

//echo $_COOKIE['name']."</br></br>";
//echo $_COOKIE['password']."</br></br>";

$login_url 	= "http://bbs.wust.edu.cn/vote/vote/member/index.php";
$pic_url 	= "http://bbs.wust.edu.cn/vote/vote/includes/rand_func.php";
$main_url 	= "http://bbs.wust.edu.cn/vote/vote/";
//$sso_url 	= 'http://jwxt.wust.edu.cn/whkjdx/Logon.do?method=logonBySSO';
//$score_url 	= 'http://jwxt.wust.edu.cn/whkjdx/xszqcjglAction.do?method=queryxscj';
$cookie = dirname(__FILE__).'/cookie';

if( !empty($_GET['action']) && $_GET['action']=='getimg' ){
	// 获取cookie
	$curl_option = array(

		CURLOPT_URL 			=> $pic_url,//.'?rc='.rand(10000, 99999),
		CURLOPT_RETURNTRANSFER 	=> TRUE,
		CURLOPT_COOKIEJAR 		=> $cookie,
	);

	$curl = curl_init();
	curl_setopt_array($curl, $curl_option);
	$result = curl_exec($curl);
    curl_close($curl);
	preg_match('/PHPSESSID(.*)/m', file_get_contents($cookie), $m);

	$fp = fopen("bbs.html","w");
	fwrite($fp,$result);
	fclose($fp);

	setcookie('local_tmp_id', trim($m[1]), '0', '/');
	echo end(explode("\r\n\r\n", $result, 2)); //没有输出头

	echo "</br></br>cookie: $m[1] </br></br>";
	//echo $result;

	exit();
} elseif( !empty($_GET['code']) ){
	$post_arr = array(
		//'user' => 'lblblb4',
		'user' => $_COOKIE['name'],
		//'password' => '12345',
		'password' => $_COOKIE['password'], 
		'code' => $_GET['code'],
		'login' => '%E7%99%BB%E5%BD%95', //这个必须要，否则登陆不成功
	);
	// 登录
	require_once 'snoopy.cls.php';
	$snoopy = new Snoopy;
	$snoopy->maxredirs = 3;
	$snoopy->offsiteok = FALSE;
	$snoopy->expandlinks = FALSE;
	$snoopy->cookies["PHPSESSID"] = $_COOKIE['local_tmp_id'];
	$snoopy->submit($login_url, $post_arr);//$formvars为提交的数组

	$snoopy->fetch($main_url);
	$output = trim($snoopy->results);
	//echo $output;
	preg_match('/rc=([0-9]{1,10})/', $output,$rc);

	$fp = fopen("login.html","w");
	fwrite($fp,$output);
	fclose($fp);

	setcookie('local_rc',$rc[0],'0','/');
	//echo "$rc[1]";
	//echo $output;

	if(preg_match('/欢迎/',$output))
	{
		echo "恭喜你!</br></br>".$_COOKIE['name']."  登陆成功！</br></br>";
		?>
		<html>
			<body>
				<form action="post.php">
					<input type="submit" value="投票">
			</body>
		</html>
		<?php
		exit();
	}
	else
	{
		?>
		<script language="javascript">
			alert("验证码输入错误!!请重输!");
		</script>
		<?php
	}
}

?><html>

	<body>
		<img src="bbs.php?action=getimg&t=<?=rand(10000, 99999)?>" alt="">
		<form action="bbs.php">
			<input type="text" name="code">
			<input type="submit">
		</form>
	</body>
</html>
