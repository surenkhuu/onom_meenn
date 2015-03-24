<?php
session_start();
function mbm_sql_quote( $value )
{
	if( get_magic_quotes_gpc() )
	{
	$value = stripslashes( $value );
	}
	//check if this function exists
	if( function_exists( "mysql_real_escape_string" ) )
	{
	$value = mysql_real_escape_string( $value );
	}
	//for PHP version < 4.3.0 use addslashes
	else
	{
	$value = addslashes( $value );
	}
	$value=mbmCleanUpHTML($value);
	return $value;
}

function mbmCleanUpHTML($comment){
        
        $search = array ('@<script[^>]*?>.*?</script>@si', // javascript -� �����
                    '@<[\/\!]*?[^<>]*?>@si',          // HTML ��� ����� �����
                    '@([\r\n])[\s]+@',                // ������ ���� �����
                    '@&(quot|#34);@i',                // HTML �������??���� �����
                    '@&(amp|#38);@i',
                    '@&(lt|#60);@i',
                    '@&(gt|#62);@i',
                    '@&(nbsp|#160);@i',
                    '@&(iexcl|#161);@i',
                    '@&(cent|#162);@i',
                    '@&(pound|#163);@i',
                    '@&(copy|#169);@i',
                    '@&#(\d+);@e');                    
    
        $replace = array (' ',
                         ' ',
                         '\1 ',
                         '" ',
                         '& ',
                         '< ',
                         '> ',
                         '  ',
                         chr(161).' ',
                         chr(162).' ',
                         chr(163).' ',
                         chr(169).' ',
                         'chr(\1) ');
        
        $comment = preg_replace($search, $replace, $comment);
        return $comment;
}


include 'conn.php';

$systemcode='';
$lastname='';
$firstname='';
$rd='';
$gender='';
$birthday='';
$phone='';
$mobile='';
$email='';
$cityid=0;
$districtid=0;
$address='';
$description='';
$reguser='client';
$regdate=date("Y-m-d H:i:s");

$rr='';

$userimg='';

$cc='';

$edit=false;$to=0;
if(ISSET($_GET['edit'])) {$edit=true; $to = $_GET['edit'];}
	else {$edit=false;}
	
$ifRD=0;


	
if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['birthday']) && isset($_POST['mobile']) 
&& isset($_POST['email']) && isset($_POST['cityid']) && isset($_POST['districtid']) 
&& isset($_POST['address']) && isset($_POST['password']) && isset($_POST['password2']))
{
	$finish='';
	$json='';
	$m='';	
	
	$lastname=$_POST['lastname'];
	$firstname=$_POST['firstname'];
	$rd=$_POST['rd'];
	if(isset($_POST['gender']))
	$gender=$_POST['gender'];
	else {$finish='1';	}
	
	
	$birthday=$_POST['birthday'];
	$phone='';
	$mobile=$_POST['mobile'];
	$email=$_POST['email'];
	$cityid=$_POST['cityid'];
	$districtid=$_POST['districtid'];
	$address=$_POST['address'];
	$password=$_POST['password'];
	$password2=$_POST['password2'];
	
    $description='';
	
	$userimg='';
	
	if(isset($_POST['userimg']))	$userimg=$_POST['userimg'];
	
	$checkRD=false;
	if(trim($rd)=='') {$finish='1'; if($m!='') { $m.=',';} $m.='{"msg2":"Регистерийн дугаар оруулна уу!","class2":"rd"}';}
	else 
	{ 
		if(strlen($rd)==12) 
			{
				if(preg_match("/[А-Яа-яӨөҮү]/",substr($rd,0,2)) && preg_match("/[0-9]/",substr($rd,2,8))) {$checkRD=true;}
				else $checkRD=false;
			}
	
		if(!$checkRD) 
		{ $finish='1'; if($m!='') { $m.=',';} $m.='{"msg2":"Регистерийн дугаар buruu!","class2":"rd"}'; } 
	}
	
	
	if(trim($lastname)=='') {$finish='1'; if($m!='') { $m.=',';} $m.='{"msg2":"Овог оруулна уу!","class2":"lastname"}';}
	else
	{
		if (!preg_match("/^[а-яА-ЯөүӨҮ]/",$lastname)) 
		{$lastname='1'; if($m!='') { $m.=',';} $m.='{"msg2":"Овог оруулна уу! Крилл үсгээр бичнэ.","class2":"lastname"}';}
	}
	
	if(trim($firstname)=='') {$finish='1'; if($m!='') { $m.=',';} $m.='{"msg2":"Нэр оруулна уу!","class2":"firstname"}';}
	else
	{
		if (!preg_match("/^[а-яА-ЯөүӨҮ]/",$firstname)) 
		{$finish='1'; if($m!='') { $m.=',';} $m.='{"msg2":"Нэр оруулна уу! Крилл үсгээр бичнэ.","class2":"firstname"}';}
	}
	
	if(trim($mobile)=='') {$finish='1'; if($m!='') { $m.=',';} $m.='{"msg2":"Гар утас оруулна уу!","class2":"mobile"}';}
	{
		if (!preg_match("/^[0-9]{8}$/",$mobile)) {$finish='1'; if($m!='') { $m.=',';} $m.='{"msg2":"Гар утас оруулна уу!","class2":"mobile"}';}
		else
		{
			if (substr($mobile,0,1)!='9' && substr($mobile,0,1)!='8' && substr($mobile,0,1)!='7')
			{$finish='1'; if($m!='') { $m.=',';} $m.='{"msg2":"Гар утас [Mobicom, Skytel, Unitel, Gmobile!]","class2":"mobile"}';}
		}
	}
	
	if(trim($email)=='') {$finish='1'; if($m!='') { $m.=',';} $m.='{"msg2":"И-майл утас оруулна уу!","class2":"email"}';}
	
	
	if(isset($_POST['gender'])) $gender=$_POST['gender'];
	else {$finish='1'; if($m!='') { $m.=',';} $m.='{"msg2":" Хүйсээ сонгоно уу!","class2":"gender"}';	}
	
	if(trim($birthday)=='') {$finish='1'; if($m!='') { $m.=',';} $m.='{"msg2":"Төрсөн огноо оруулна уу! [YYYY-MM-DD]","class2":"birthday"}';}
	else
	{
		if (!preg_match("/^[0-9]{4}-[0-1][0-9]-[0-3][0-9]$/",$birthday))
		{$finish='1'; if($m!='') { $m.=',';} $m.='{"msg2":"Төрсөн огноо буруу байна! [YYYY-MM-DD]","class2":"birthday"}';}
	}
	
	if(trim($cityid)=='') {$finish='1'; if($m!='') { $m.=',';} $m.='{"msg2":"cityid оруулна уу!","class2":"cityid"}';}
	if(trim($districtid)=='') {$finish='1'; if($m!='') { $m.=',';} $m.='{"msg2":"districtid оруулна уу!","class2":"districtid"}';}

	if(trim($password)=='') {$finish='1'; if($m!='') { $m.=',';} $m.='{"msg2":"Нууц үг оруулна уу!","class2":"password"}';}
	{
		if(trim($password)!=trim($password2)) 
		{$finish='1'; if($m!='') { $m.=',';} $m.='{"msg2":"Нууц үг давтана уу!","class2":"password2"}';}
	}


	$json='[{"type":"alert","msg":['.$m.']}]';	
	if($finish!='')  echo $json;
	
	

	
	if(!$edit && $finish=='')
	{
		$result = mysql_query("SELECT `rd` FROM `ubchtun_main` WHERE `rd`='".$_POST['rd']."'");	
		$ifRD = mysql_num_rows($result);
		if($ifRD>0)	{ echo '[{"type":"alert","msg":[{"msg2":"Регистерийн дугаар burtgeltei bn!","class2":"rd"}]}]';	 }
		else
		{
			$id = mysql_query("SELECT MAX(`id`) as id FROM `ubchtun_main`;");
				
			$row=mysql_fetch_assoc($id);
			$InfID=$row['id']+1;
			$to=$InfID;
			$ss='00000000';
			$systemcode=substr($ss,0,strlen($ss)-strlen($InfID)).$InfID;
			$sql="INSERT INTO `ubchtun_main` (
				`id`, 
				`systemcode`, 
				`lastname`, 
				`firstname`, 
				`rd`, 
				`password`,
				`gender`, 
				`birthday`, 
				`phone`, 
				`mobile`, 
				`email`, 
				`cityid`, 
				`districtid`, 
				`address`, 
				`description`,
				`hynagch`,  
				`reguser`, 
				`regdate`) 
				VALUES (
					".$InfID.", 
					'".$systemcode."',
					'".mbm_sql_quote($lastname)."',
					'".mbm_sql_quote($firstname)."',
					'".mbm_sql_quote(strtoupper($rd))."',
					'".md5($password)."',
					'".mbm_sql_quote(strtoupper($gender))."',
					'".mbm_sql_quote($birthday)."',
					'".mbm_sql_quote($phone)."',
					'".mbm_sql_quote($mobile)."',
					'".mbm_sql_quote($email)."',
					'".mbm_sql_quote($cityid)."',
					'".mbm_sql_quote($districtid)."',
					'".mbm_sql_quote($address)."',
					'".mbm_sql_quote($description)."',
					'".mbm_sql_quote($reguser)."',
					'".mbm_sql_quote($reguser)."',
					'".mbm_sql_quote($regdate)."'
					)";
					
				if(mysql_query($sql))
		        {
					echo '[{"type":"success","msg":"Амжилттай бүртгэгдлээ."}]';
					if(!$edit)
					{
						if($userimg!='')
						{
						 $sql="INSERT INTO `ubchtun_main_avator` (`id`, `uid`, `avator`) 
						 VALUES ('','".$to."','".$userimg."');";
						 if(!mysql_query($sql)) 
							 {
								 //echo $sql;
							 }
						}
					}
		        }
				else
				{
					echo '[{"type":"error","msg":"Алдаа гарлаа. [Server Error]"}]';
					
				}//END Exec Insert
		}//END IF RD
	}//IF !Edit
	
				
					
					
					
				
				
 }
 else
 echo '[{"type":"error","msg":"Алдаа гарлаа. [Server Error]"}]';
?>