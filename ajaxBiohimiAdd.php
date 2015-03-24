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

$ubchtun_id=$_SESSION['userid'];

$date='';
	$address='';
	
	  $b1=''; /*niit bilirubin*/
	  $b2=''; /*mes zasal*/
	  $b3=''; /*hepatit A*/
	  $b4=''; /*hepatit B*/
	  $b5=''; /*hepatit C*/
	  $b6=''; /*bambai bulchirhai*/
	  $b7=''; /*zurhnii uvchin*/
	  $b8=''; /*zurhnii bagtraa*/
	  $b9=''; /*guursan hooloin bargtraa*/
	  $b10=''; /*suriee*/
	  $b11=''; /*tsusnii daralt*/
	  $b12=''; /*chihriin shijin*/
	  $b13=''; /*emfizema/cord*/
	  $b14=''; /*boornii ovchin*/
	  $b15=''; /*DOX*/
	  $reguser='';
	  $regdate=date("Y-m-d H:i:s");

$rr='';

$userimg='';

$cc='';

$edit=false;$to=0;
if(ISSET($_GET['edit'])) {$edit=true; $to = $_GET['edit'];}
	else {$edit=false;}
	
$ifRD=0;



		
	
if(isset($_POST['date']))
{
	$finish='';
	$json='';
	$m='';	
	
	$date=$_POST['date'];
	$address=$_POST['address'];
	
	$b1=$_POST['b1'];
	$b2=$_POST['b2'];
	$b3=$_POST['b3'];
	$b4=$_POST['b4'];
	$b5=$_POST['b5'];
	$b6=$_POST['b6'];
	$b7=$_POST['b7'];
	$b8=$_POST['b8'];
	$b9=$_POST['b9'];
	$b10=$_POST['b10'];
	$b11=$_POST['b11'];
	$b12=$_POST['b12'];
	$b13=$_POST['b13'];
	$b14=$_POST['b14'];
	$b15=$_POST['b15'];
	
 
	
	$checkRD=false;
	
	
	
	
	
	if(trim($date)=='') {$finish='1'; if($m!='') { $m.=',';} $m.='{"msg2":"Шинжилгээ хийлгэсэн огноо оруулна уу! [YYYY-MM-DD]","class2":"date"}';}
	else
	{
	//	if (!preg_match("/^[0-9]{4}-[0-1][0-9]-[0-3][0-9]$/",$date))
		//{$finish='1'; if($m!='') { $m.=',';} $m.='{"msg2":"огноо буруу байна! [YYYY-MM-DD]","class2":"date"}';}
	}
	

	$json='[{"type":"alert","msg":['.$m.']}]';	
	if($finish!='')  echo $json;
	
	
	
	
	if(!$edit && $finish=='')
	{
		
		{
			
		$sql="INSERT INTO `sh_biohimi`(`id`, `ubchtun_id`, `title`, `niiit_bilirubin`, `shuud_bilirubin`, `holestrin`, `shultleg_fosfotaz`, `niit_uurag`, `alibumin`, `AST`, `ALT`, `GGT`, `glukoz`, `kreatinin`, `sheesnii_huchil`, `fosfor`, `kaltsi`, `tumur`, `date`, `reguser`)   VALUES(
	  '',
	  ".$ubchtun_id.",
	  '".$address."','".$b1."','".$b2."','".$b3."','".$b4."','".$b5."','".$b6."','".$b7."','".$b8."',
	  '".$b9."','".$b10."','".$b11."','".$b12."','".$b13."','".$b14."','".$b15."','".date("Y-m-d", strtotime($date))."','".$reguser."'
	  )";
					
				if(mysql_query($sql))
		        {
					echo '[{"type":"success","msg":"Амжилттай хадгаллаа."}]';
					if(!$edit)
					{
						//date("M jS, Y", strtotime($date));
					}
		        }
				else
				{
					echo '[{"type":"error","msg":"Алдаа гарлаа. [Server Error]"}]';
					
				}//END Exec Insert
		}//END IF RD
	}//IF !Edit
	
				
					
					
					
				
				
 }
?>