<?php
include('ajaxAPI.php');
if($_SESSION['login']=='Y')
{

$finish='';
$json='';
$m='';	
$ifRD=0;
$id='';
$password=''; $newpassword=''; $newpassword2='';	
if(isset($_POST['userid']) && isset($_POST['password']) && isset($_POST['newpassword']) && isset($_POST['newpassword2']))
{
	
	
	$userid=$_POST['userid']; $password=$_POST['password']; $newpassword=$_POST['newpassword']; $newpassword2=$_POST['newpassword2'];
	
	if($userid==$_SESSION['userid'])
	{
		
		if(trim($password)=='') {$finish='1'; if($m!='') { $m.=',';} $m.='{"msg2":"Нууц үг оруулна уу!","class2":"password"}';}
		
		if(trim($newpassword)=='') {$finish='1'; if($m!='') { $m.=',';} $m.='{"msg2":"Шинэ нууц үг оруулна уу!","class2":"newpassword"}';}
		else
		{
			if(trim($newpassword)!=trim($newpassword2)) 
			{$finish='1'; if($m!='') { $m.=',';} $m.='{"msg2":"Нууц үг давтана уу!","class2":"newpassword2"}';}
		}
		
		if($finish!='')  echo '[{"type":"alert","msg":['.$m.']}]';	
		
		if($finish=='')
		{
			//md5($password);
			$result = mysql_query("SELECT * FROM `ubchtun_main` WHERE `password`='".md5($password)."' AND id='".$userid."';");	
			//echo $result;
			$ifRD = mysql_num_rows($result);
			if($ifRD>0)
			{
				$sqlU="UPDATE `ubchtun_main` SET `password`='".md5($newpassword)."' WHERE id='".$userid."';";
				if(!($res = mysql_query($sqlU)))	
				{
						echo '[{"type":"error","msg":"Алдаа гарлаа."}]';
				}
				else
				{
					echo '[{"type":"success","msg":"Нууц үг солигдлоо"}]';
				}
			}
			else
			{
				//echo '[{"type":"error","msg":"Нууц үг буруу байна."}]';
				$m.='{"msg2":"Нууц үг буруу байна!'.$userid.'","class2":"password"}';
				echo '[{"type":"alert","msg":['.$m.']}]';	
			
			}
		}
	}//END IF SESSION USERID
	else echo '[{"type":"error","msg":"Алдаа гарлаа."}]';
	
	
}

}
?>