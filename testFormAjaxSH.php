<?php
include('ajaxAPI.php');

function txt($id, $title)
{
	$rrr='';
	$rrr=$rrr.'<div class="input-field col s6">';
	//$rrr=$rrr.'<i class="mdi-action-account-circle prefix"></i>';
	$rrr=$rrr.'<input id="'.$id.'" type="text" class="validate" name="'.$id.'">';
	$rrr=$rrr.'<label for="'.$id.'">'.$title.'</label>';
	$rrr=$rrr.'</div>';	
	return $rrr;
}

function cmd($id, $title, $related)
{
	$rrr='';
	$s="SELECT * FROM ".$related;
    $res=mysql_query($s);
	$rrr=$rrr.'<div class="col s6">';
	$rrr=$rrr.'<label>'.$title.'</label>';
    $rrr=$rrr.'<select id="selectCity" name="'.$id.'" onchange="javascript:setDistrict(this.value)" class="browser-default">'; 
    $rrr=$rrr.'<option value=""></option>';
    WHILE($r = MYSQL_FETCH_ARRAY($res))
    {
    $vv='';
   // if($RowCombo['id']==$id) $vv='selected=selected';
    $rrr=$rrr.'<option value="'.$r['id'].'" '.$vv.'>'.$r['title'].'</option>';	
    }
    $rrr=$rrr.' </select>';
	$rrr=$rrr.'</div>';	
	return $rrr;
}

function password()
{
	$rrr='';
	$rrr=$rrr.'<div class="input-field col s6">';
	$rrr=$rrr.'<i class="mdi-communication-vpn-key prefix"></i>';
	$rrr=$rrr.'<input id="password" type="password" class="validate" name="password" data-position="bottom" data-delay="50" data-tooltip="I am tooltip">';
	$rrr=$rrr.'<label for="password">Нууц үг</label>';
	$rrr=$rrr.'</div>';
	$rrr=$rrr.'<div class="input-field col s6">';
	$rrr=$rrr.'<input id="password2" type="password" class="validate" name="password2">';
	$rrr=$rrr.'<label for="password2">Нууц үг давт</label>';
	$rrr=$rrr.'</div>';
	return $rrr;
}

function gender()
{
	$rrr='';
	$rrr=$rrr.'<div class="col s6">';
	$rrr=$rrr.'<label id="gender">Хүйс</label> <br />';
	$rrr=$rrr.'<input class="with-gap" name="gender" type="radio" id="er" value="ЭР"/><label for="er">Эрэгтэй</label>';
	$rrr=$rrr.'<input class="with-gap" name="gender" type="radio" id="em" value="ЭМ" /><label for="em">Эмэгтэй</label>';    
	$rrr=$rrr.'</div>';
	return $rrr;
}

function city($id, $title)
{
	$rrr='';
	$s="SELECT * FROM city";
    $res=mysql_query($s);
	$rrr=$rrr.'<div class="col s4">';
	$rrr=$rrr.'<label>'.$title.'</label>';
    $rrr=$rrr.'<select id="selectCity" name="'.$id.'" onchange="javascript:setDistrict(this.value)" class="browser-default">'; 
    $rrr=$rrr.'<option value=""></option>';
    WHILE($r = MYSQL_FETCH_ARRAY($res))
    {
    $vv='';
   // if($RowCombo['id']==$id) $vv='selected=selected';
    $rrr=$rrr.'<option value="'.$r['id'].'" '.$vv.'>'.$r['title'].'</option>';	
    }
    $rrr=$rrr.' </select>';
	$rrr=$rrr.'</div>';	
	return $rrr;
}

function district($id, $title,$cityid)
{
	$rrr='';
	$s="SELECT * FROM district where city_id=".$cityid;
    $res=mysql_query($s);
	$rrr=$rrr.'<div class="col s4">';
	$rrr=$rrr.'<label>'.$title.'</label>';
	$rrr=$rrr.'<div id="district">';
    $rrr=$rrr.'<select id="selectDistrict" name="'.$id.'" onchange="javascript:setKhoroo('.$cityid.',this.value)" class="browser-default">'; 
    $rrr=$rrr.'<option value=""></option>';
    WHILE($r = MYSQL_FETCH_ARRAY($res))
    {
    $vv='';
   // if($RowCombo['id']==$id) $vv='selected=selected';
    $rrr=$rrr.'<option value="'.$r['id'].'" '.$vv.'>'.$r['title'].'</option>';	
    }
    $rrr=$rrr.' </select>';
	$rrr=$rrr.'</div>';	
	$rrr=$rrr.'</div>';	
	return $rrr;
}

function khoroo($id, $title,$cityid,$districtid)
{
	$rrr='';
	$s="SELECT * FROM khoroo where city_id=".$cityid." and district_id=".$districtid;
    $res=mysql_query($s);
	$rrr=$rrr.'<div class="col s4">';
	$rrr=$rrr.'<label>'.$title.'</label>';
	$rrr=$rrr.'<div id="khoroo">';
    $rrr=$rrr.'<select id="selectKhoroo" name="'.$id.'" class="browser-default">'; 
    $rrr=$rrr.'<option value=""></option>';
    WHILE($r = MYSQL_FETCH_ARRAY($res))
    {
    $vv='';
   // if($RowCombo['id']==$id) $vv='selected=selected';
    $rrr=$rrr.'<option value="'.$r['id'].'" '.$vv.'>'.$r['title'].'</option>';	
    }
    $rrr=$rrr.' </select>';
	$rrr=$rrr.'</div>';	
	$rrr=$rrr.'</div>';	
	return $rrr;
}



$fieldArray = array();
$paraArray = array();

$checkField=false;
if(isset($_POST['tablename']) && isset($_POST['ubchtunid']))
{
	$tablename=$_POST['tablename']; //$id=$_POST['id']; 
	
	$userimg='';
	$userid='';
	$rd='';
	
	if($tablename=='doctors_main' || $tablename=='ubchtun_main')  
	{
	$userimg='';
	if(isset($_POST['userimg']))	$userimg=$_POST['userimg'];
	}
	
	$ubchtunid='';
	if(isset($_POST['ubchtunid']))  $ubchtunid=$_POST['ubchtunid'];
	
	$alert='';
	$reguser='client';
	$regdate=date("Y-m-d H:i:s");
	
	
	$sql="select * FROM sh_table where `shtablename`='".$tablename."' ORDER BY `sortid` ASC";
    if($result=mysql_query($sql))
	{
	
	
	WHILE($row = MYSQL_FETCH_ARRAY($result))
	{
		$fieldArray[] = $row;
		if($row['field']=='reguser' || $row['field']=='regdate' || $row['field']=='id' || $row['field']=='ubchtunid' || $row['field']=='active')
		{
			if($row['field']=='id'){$paraArray[]= '';}
			if($row['field']=='reguser'){$paraArray[]= $reguser;}
			if($row['field']=='reguser'){$paraArray[]= $regdate;}
			if($row['field']=='active'){$paraArray[]= '';}
			if($row['field']=='ubchtunid'){$paraArray[]= $ubchtunid;}
		}
		else
		{
		$f='';
			if(isset($_POST[$row['field']]))
			{
				$f=$_POST[$row['field']];
				
				if($row['field']=='userid') $userid=$f;
				
				if($row['filter']!='')
				{
					
					switch($row['field'])
					{
						case 'rd':
						{
							$rd=$f;
							if(strlen($f)==12) 
							{
								if(preg_match("/[А-Яа-яӨөҮү]/",substr($f,0,2)) && preg_match("/[0-9]/",substr($f,2,8))) 
								{$paraArray[]= $f;}
								else {if($alert!='') { $alert.=',';} $alert.='{"msg2":"'.$row['filtertext'].'","class2":"'.$row['field'].'"}';}
							}else {if($alert!='') { $alert.=',';} $alert.='{"msg2":"'.$row['filtertext'].'","class2":"'.$row['field'].'"}';}
							break;
						}
						case 'password':
						{
							if (!preg_match($row['filter'],$f)) 
							{
								if($alert!='') { $alert.=',';} $alert.='{"msg2":"'.$row['filtertext'].'","class2":"'.$row['field'].'"}';
							}
							else
							{
								if(trim($f)!=trim($password2)) 
								{if($alert!='') { $alert.=',';} $alert.='{"msg2":"Нууц үг давтана уу!","class2":"password2"}';}
								else {$paraArray[]= md5($f);}
							}
							break;
						}
						default:
						{
							if (!preg_match($row['filter'],$_POST[$row['field']])) 
							{
								
								if($alert!='') { $alert.=',';} $alert.='{"msg2":"'.$row['filtertext'].'","class2":"'.$row['field'].'"}';
							}
							else
							{
								$paraArray[]= $_POST[$row['field']];
							}
							break;
						}
						
						
					}
					
					
				
				}
				else
				{
					$paraArray[]= $_POST[$row['field']];
				}
				
				
				
				
				
				
				
				
				if($row['primerykey']=='Y')
				{
					$resultKey = mysql_query("SELECT `rd` FROM `".$tablename."` WHERE `".$row['field']."`='".$f."'");	
					$ifKey = mysql_num_rows($resultKey);
					if($ifKey>0)
					{
						if($alert!='') { $alert.=',';} $alert.='{"msg2":"'.$row['title'].' бүртгэлтэй байна!","class2":"'.$row['field'].'"}';
						
					}
				}
				
				
				
				
				
				
				
				
				
				
				
			}
			else
			{
				//$paraArray[]= '';
				if($alert!='') { $alert.=',';} $alert.='{"msg2":"'.$row['title'].' оруулна уу.","class2":"'.$row['field'].'"}';
			}
		}
		$checkField=true;
	}
	}//END IF mysql_query
	else
	{ echo '[{"type":"error","msg":"Алдаа гарлаа. [Server Error1]"}]'; }
	
	$arrlength=count($fieldArray);
	
	if($alert!='')  echo '[{"type":"alert","msg":['.$alert.']}]';	
	
	
	if($type='insert' && $alert=='' && $checkField)
	{
		$sqlInsert=""; $value=""; $parameter="";
		for($x=0;$x<$arrlength;$x++)
		{
			$value.="`".$fieldArray[$x]['field']."`";
			$parameter.="'".$paraArray[$x]."'";
			if($arrlength>$x+1) { $value.=", "; $parameter.=", ";}
			else {$value.=" ";  $parameter.=" ";}
		}
		$sqlInsert="INSERT INTO `".$tablename."` (".$value.") VALUES(".$parameter.");";
		//echo $sqlInsert;
		
		if(mysql_query($sqlInsert))
		        {
					if($tablename=='doctors_main' || $tablename=='ubchtun_main') 
					{
						echo '[{"type":"success","msg":"Амжилттай хадгаллаа."}]';
						
						if($userimg!='')
						{
							$sss='';
							if($tablename=='doctors_main') $sss="SELECT `id` FROM `".$tablename."` where `userid`='".$userid."';";
							if($tablename=='ubchtun_main') $sss="SELECT `id` FROM `".$tablename."` where `rd`='".$rd."';";
							$rowid = mysql_query($sss);
						
						
							$row2=mysql_fetch_assoc($rowid);
							$id2=$row2['id'];
						
						
						 	$sqlImg="INSERT INTO `".$tablename."_avator` (`id`, `uid`, `avator`) 
						 	VALUES ('','".$id2."','".$userimg."');";
						 	if(mysql_query($sqlImg)) 
						 	{
								//echo '[{"type":"success","msg":"Амжилттай хадгаллаа."}]';
						 	}
						}
					}
					else
					{
						echo '[{"type":"success","msg":"Амжилттай хадгаллаа."}]';
					}
					
					
					
					
					
		        }
				else
				{
					echo '[{"type":"error","msg":"Алдаа гарлаа. [Server Error2] '.$sqlInsert.'"}]';
					
				}//END Exec Insert
		
		
		
	}
}
		
		?>
