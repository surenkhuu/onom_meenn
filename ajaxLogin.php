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

if(isset($_POST['rd']) && isset($_POST['password']))
{
	include 'conn.php';

	$rd = mbm_sql_quote($_POST['rd']);
	$password =md5($_POST['password']);
	$finish='';
	$json='';
	$m='';	
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
	if(trim($_POST['password'])=='') {$finish='1'; if($m!='') { $m.=',';} $m.='{"msg2":"Нууц үг оруулна уу!","class2":"password"}';}
	
	$json='[{"type":"alert","msg":['.$m.']}]';	
	if($finish!='')  echo $json;
	
	
	
if($finish=='')
{
	
	$sql="SELECT * FROM ubchtun_main  
	WHERE UPPER(`rd`)='".strtoupper($rd)."' and password='".$password."'";
	
	$ifRD=0;
	$r1 = mysql_query("SELECT `rd` FROM `ubchtun_main` WHERE `rd`='".$rd."'");	
	
	
	$ifRD = mysql_num_rows($r1);
	
	if($ifRD>0)
	{  
		$result=mysql_query($sql);
		$ifLogin=false;
		WHILE($Row = MYSQL_FETCH_ARRAY($result))
		{
			$_SESSION['login']='Y';
			$_SESSION['usertype']='ubchtun';
			$_SESSION['rd']=$Row['rd'];
			$_SESSION['lastname'] = $Row['lastname'];
			$_SESSION['firstname'] = $Row['firstname'];
			$_SESSION['email'] = $Row['email'];
			$_SESSION['userid'] = $Row['id'];
			$ifLogin=true;
			break;
		}
		//echo $sql;
		if($ifLogin) echo '[{"type":"success","msg":"Амжилттай нэвтэрлээ."}]';
		else { echo '[{"type":"error","msg":"Нууц үг буруу байна."}]';}
	}
	else
	{
		
		{echo '[{"type":"none","msg":"['.$rd.'] Регистерийн дугаар бүртгэлгүй байна."}]';}
		//WHILE($rr = MYSQL_FETCH_ARRAY($r1))
		//{
		
		//}
		//echo '[{"type":"none","msg":"['.$rd.'] Регистерийн дугаар бүртгэлгүй байна."}]';
		
		//mysql_close();
		
	}
}
	
		
}
else
{ echo 'error';}
?>