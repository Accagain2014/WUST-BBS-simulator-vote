<?php
session_start();

$names = array();
$password = array();


$names[0] = 'mmm';
$names[1] = 'lblblb3';
$names[2] = 'lblblb4';


$password[0] = '123';
$password[1] = '12345';
$password[2] = '12345';

//for($nu = 0;$nu <= 4; $nu++)
$nu = $_COOKIE['ID'];
//echo "cookie:".$_COOKIE['local_tmp_id']."</br></br>";
//$nu=0;
	//setcookie('local_tmp_id', trim($m[1]), '0', '/');
if($nu >= count($names))
{
	?>
	<script language="javascript">
		alert("投票结束！");
	</script>
	<?
	exit();
}
echo "第".($nu+1)."位投票</br></br>";

setcookie('name',$names[$nu],'0','/');
setcookie('password',$password[$nu],'0','/');
?>

<html>
	<form action='bbs.php'>
		<input type='submit' value="账户:<? echo $names[$nu]." 投票." ?>">
	</form>    
</html>
