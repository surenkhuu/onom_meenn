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

if(isset($_POST['rd']) && isset($_POST['mobile']))
{
	include 'conn.php';

	$rd = mbm_sql_quote($_POST['rd']);
	$mobile=mbm_sql_quote($_POST['mobile']);
	
	$finish='';
	$json='';
	$m='';	
	$checkRD=false;
	if(trim($mobile)=='') {$finish='1'; if($m!='') { $m.=',';} $m.='{"msg2":"Гар утас оруулна уу!","class2":"mobile"}';}
	{
		if (!preg_match("/^[0-9]{8}$/",$mobile)) {$finish='1'; if($m!='') { $m.=',';} $m.='{"msg2":"Гар утас оруулна уу!","class2":"mobile"}';}
		else
		{
			if (substr($mobile,0,1)!='9' && substr($mobile,0,1)!='8' && substr($mobile,0,1)!='7')
			{$finish='1'; if($m!='') { $m.=',';} $m.='{"msg2":"Гар утас [Mobicom, Skytel, Unitel, Gmobile!]","class2":"mobile"}';}
		}
	}
	
	$json='[{"type":"alert","msg":['.$m.']}]';	
	if($finish!='')  echo $json;
	
$ifUser=false;	
 $name='';
  $ovog='';
  
		 $email='';
		 
	
if($finish=='')
{
	$sql="SELECT t1.*,t2.avator 
	FROM ubchtun_main t1
	LEFT JOIN user_avator t2 ON t1.id = t2.ubchtun_id 
	WHERE UPPER(t1.`rd`)='".strtoupper($rd)."' and mobile='".$mobile."';";
	$result=mysql_query($sql);
	$ifRD=0;
	WHILE($Row = MYSQL_FETCH_ARRAY($result))
	{
		$randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4);
		$email=$Row['email'];
		$name=$Row['firstname'];
 		$ovog=$Row['lastname'];
		$sqlU="UPDATE `ubchtun_main` SET `password`='".md5($randomString)."' WHERE id=".$Row['id'];
		if(!($res = mysql_query($sqlU)))
		{  
			//die("zasvar hadgalhad aldaa garlaa!".$sql);
		}
		else
		{
			$ifUser=true;
			$m=$randomString;
		}
		//$m='{"lastname":"'.$lastname.'","firstname":"'.$firstname.'","email":"'.$email.'"}';
		break;
	}
	
	
	if($ifUser)
	{  
		require 'PHPMailer/class.phpmailer.php';
		$mail = new PHPMailer(); // defaults to using php "mail()"
		$mail->CharSet = 'UTF-8';
		$body='Эрүүл Элэг Хѳтѳлбѳрийн Эмчлүүлэгчидийн<br>Нарийвчилсан Бүртгэлийн Системд нэвтрэх нууд үг солигдлоо.<br><hr>';
		$body=$body.'Хэрэглэгчийн нэр: '.$ovog.''.$name.'<br>';
		$body=$body.'Регистерийн дугаар: ['.$rd.']<br>';
		$body=$body.'Шинэ нууц үг: <span style="font-weight:bold;">'.$randomString.'</span><br><hr>';
		$body=$body.'<span style="font-weight:bold;">Анхааруулга!</span><br>';
		$body=$body.'Та шинэ нууц үгээр нэвтэрсэний дараа нууц үгийг солихыг зөвлөж байна.<br>';
		$body=$body.'<a class="grey-text" href="www.burtgel.eleg.mn">www.burtgel.eleg.mn</a><br>';
		$body=$body.'Огноо: '.date("Y-m-d H:i:s")."<br>";
		
		$mail->SetFrom('burtgel@eleg.mn');
		//$address = "burtgel@eleg.mn";
		$mail->AddAddress($email);
		$mail->Subject    = "Эрүүл Элэг Үндэсний хөтөлбөр";
		//$mail->AltBody    = "Сүүлийн 10 хоногийн статистик ".date("Y-m-d H:i:s"); // optional, comment out and test
		$mail->MsgHTML($body);
		if(!$mail->Send()) {
		  //echo ": "; //. $mail->ErrorInfo;
		}
		//$headers = "From:burtgel@eleg.mn";
		//$text='солигдлоо'.$randomString;
		//$subject='Эрүүл элэг';
		//mail($email,$subject,$text,$headers);
		
		
	
	
		echo '[{"type":"success","msg":"'.$m.'"}]';	
	}
	else
	{
		echo '[{"type":"none","msg":"['.$rd.'] Регистерийн дугаар бүртгэлгүй байна."}]';
	}
}
	
		
}
else
{ echo 'error';}
?>