<?php
include('ajaxAPI.php');
if($_SESSION['login']=='Y')
{

//$_SESSION['userid'];
	
$cityid=0;
$tablename=''; $fieldArray = array(); $ubchtunid='';

if(isset($_POST['tablename']) && isset($_POST['ubchtunid']))
{
	$tablename=$_POST['tablename'];  $ubchtunid=$_POST['ubchtunid']; 

if($_SESSION['userid']==$ubchtunid)
{	


function cmdYN($id, $title)
{
	$rrr='';
	$rrr=$rrr.'<tr>';
	$rrr=$rrr.'<td style="text-align:right;"><label>'.$title.':</label></td>';
	$rrr=$rrr.'<td>';
	$rrr=$rrr.'<select id="'.$id.'" name="'.$id.'" class="browser-default" style="width:110px; padding:0; margin:3px;">'; 
	 $rrr=$rrr.'<option value=""></option><option value="Y">Y</option><option value="N">N</option>';
	 $rrr=$rrr.'</select>';
	//$rrr=$rrr.'<input id="'.$id.'" type="text" class="validate" name="'.$id.'" value="'.$value.'">';
	$rrr=$rrr.'</td>';
	$rrr=$rrr.'</tr>';	
	return $rrr;
}

function txt($id, $title, $value)
{
	$rrr='';
	$rrr=$rrr.'<tr>';
	$rrr=$rrr.'<td style="text-align:right;"><label>'.$title.':</label></td>';
	$rrr=$rrr.'<td>';
	//$rrr=$rrr.'<div class="input-field col s6">';
	$rrr=$rrr.'<input id="'.$id.'" type="text" class="validate" name="'.$id.'" value="'.$value.'">';
	//$rrr=$rrr.'</div>';
	$rrr=$rrr.'</td>';
	$rrr=$rrr.'</tr>';	
	return $rrr;
}

function txtDate($id, $title, $value)
{
	$rrr='';
	$rrr=$rrr.'<tr>';
	$rrr=$rrr.'<td style="text-align:right;"><label>'.$title.':</label></td>';
	$rrr=$rrr.'<td>';
	//$rrr=$rrr.'<div class="input-field col s6">';
	$rrr=$rrr.'<input id="'.$id.'" type="text" class="validate" name="'.$id.'" value="'.$value.'">';
	//$rrr=$rrr.'</div>';
	$rrr=$rrr.'</td>';
	$rrr=$rrr.'</tr>';	
	return $rrr;
}

function txtLavel($id, $title, $value)
{
	$rrr='';
	$rrr=$rrr.'<div class="col s6">';
	$rrr=$rrr.'<label for="'.$id.'" class="active">'.$title.': </label>';
	$rrr=$rrr.'<span">'.$value.'</span>';
	$rrr=$rrr.'</div>';	
	return $rrr;
}



function cmd($id, $title, $related,$value)
{
	$cmbField='title'; $cmbFieldID='id';
	$rrr=''; 
	if($related=='doctors_main') { $cmbField='userid'; $cmbFieldID='userid';}
	
	
	$s="SELECT * FROM ".$related;
	if($related=='usergroup' && $_SESSION['usergroupid']==1)  {$s="SELECT * FROM `".$related."` where `id`!=1;";}
	if($related=='usergroup' && $_SESSION['usergroupid']==2)  {$s="SELECT * FROM `".$related."` where `id`!=1 and `id`!=2;";}
	
	
    $res=mysql_query($s);
	$rrr=$rrr.'<div class="col s6">';
	$rrr=$rrr.'<label>'.$title.'</label>';
    $rrr=$rrr.'<select id="'.$id.'" name="'.$id.'" class="browser-default">'; 
    $rrr=$rrr.'<option value=""></option>';
    WHILE($r = MYSQL_FETCH_ARRAY($res))
    {
    $vv='';
    if($r[$cmbFieldID]==$value) $vv='selected=selected';
	$rrr=$rrr.'<option value="'.$r[$cmbFieldID].'" '.$vv.'>'.$r[$cmbField].'</option>';	
    }
    $rrr=$rrr.' </select>';
	$rrr=$rrr.'</div>';	
	return $rrr;
}


	
	$reguser=$_SESSION['userid'];
	$regdate=date("Y-m-d H:i:s");
	
	$sql="SELECT * FROM `menu` where 
		`tname`='".$tablename."';";
	if($result=mysql_query($sql))
	{
		WHILE($row = MYSQL_FETCH_ARRAY($result))
		{
			echo '<div style="padding:10px;">';
			echo '<span class="card-title black-text">'.$row['title'].' бүртгэх</span>';
			echo '</div>';
		}
	}
	?>
    
	<form class="col s12" id="registerAddFormSH">
	<input id="tablename" type="text" name="tablename" value="<?php echo $tablename;?>" style="display:none;">
           
	<?php
	//$sql2="select * FROM system_table where `tablename`='".$tablename."' and `id`=".$id.";";
	//$sql2="select * FROM system_table where `id`='".$id."';";
	$sql="SELECT * FROM sh_table where `shtablename`='".$tablename."' ORDER BY `sortid` ASC;";
	//Field 	Type 	Null 	Key 	Default 	Extra 
	//id 	   int(11)	NO 	    PRI 	NULL	    auto_increment
	$result=mysql_query($sql);
			
	$i=1;	
	$allValidate='';
	//echo $sql2;
	
WHILE($row = MYSQL_FETCH_ARRAY($result))
{
	$fieldArray[] = $row;
}
$arrlength=count($fieldArray);


	//if($tablename=='doctors_main') echo '<div class="col s8">';
	
	echo '<table class="bordered" id="bioTable">';
	
	echo ' <tbody>';
	
	
	
	for($x=0;$x<$arrlength;$x++)
	{	
		
		if($fieldArray[$x]['related']!='')
		{
			
		}
		
		if($fieldArray[$x]['fieldvisit']=='Y')
		{
			$allValidate.='$("#'.$fieldArray[$x]['field'].'").attr("class", "validate"); ';
			//	if($i==1) echo '<div style="border: solid 0px #F00; position:related; display: table;width: 100%;">';	
			if($fieldArray[$x]['type']=='' && $fieldArray[$x]['fieldvisit']=='Y')
			{
				
				switch ($fieldArray[$x]['field']) {
				case 'reguser': case 'regdate':
					{ 
					//if($fieldArray[$x]['field']=='reguser') $regText=$reguser;
					//if($fieldArray[$x]['field']=='regdate') $regText=$regdate;
					//echo txtLavel($fieldArray[$x]['field'],$fieldArray[$x]['title'],$regText); 
					break;
					}
				case 'ubchtunid':
					echo '<input id="ubchtunid" type="text" class="validate" name="ubchtunid" value="'.$ubchtunid.'" style="display:none;">';
					break;
				case 'date':
					echo txtDate($fieldArray[$x]['field'],$fieldArray[$x]['title'],$regdate=date("Y-m-d"));
					break;	
				default:
					echo txt($fieldArray[$x]['field'],$fieldArray[$x]['title'],'');
					break;
					}
			}
			
			if($fieldArray[$x]['type']=='comboYN' && $fieldArray[$x]['fieldvisit']=='Y')
			{
				//	$i++;
				echo cmdYN($fieldArray[$x]['field'],$fieldArray[$x]['title']); 
			}
			
				
			if($fieldArray[$x]['type']=='combobox' && $fieldArray[$x]['fieldvisit']=='Y')
			{
				//	$i++;
				echo cmd($fieldArray[$x]['field'],$fieldArray[$x]['title'],$fieldArray[$x]['related'],''); 
			}
			//if($i==3) {echo '</div>'; $i=1;}
		}
	}//END FOR
			
		
		
			echo ' </tbody>';
	echo ' </table>';		
	?>     
	</form>
    
    
    
    
    <div class="modal-footer"> 
    
    
    
    	<button class="waves-effect waves-green btn-flat modal-action modal-close" type="button" id="btnClose" style="margin-right:10px;">Болих<i class="mdi-hardware-keyboard-return left"></i></button>
        
     	<button class="waves-effect waves-green btn-flat modal-action" type="button" id="btnAdd" style="margin-right:10px;">Хадгалах
    	<i class="mdi-action-done left"></i>
  		</button>
     
       
</div>
    
	<?php

?>

  
  
<script>


function allValidate()
{
	<?php echo $allValidate;?>
}


$("#btnClose").click(function()
{
	//$('#modalWait').openModal();
	 $('#modalEditor').closeModal(); 
});

$("#btnAdd").click(
function()
{   
	//$("#loadGif").css('display','block');
	//$('#modalWait').openModal();
	
	var formData = $("#registerAddFormSH").serializeArray();
	
    $.ajax({
		  type: "POST",
		  url: "testFormAjaxSH.php",
		  data: formData,
		  cache: false,
		  success: function(html){
			// alert(html);
			 //$('#modalWait').closeModal();  
			  //allValidate();
			  var obj = $.parseJSON(html);
			  $.each(obj, function(index, element) {
				  
				if(element.type=='alert')
				{
				  	$.each(element.msg, function(index2, element2) {
						
						//alert(element2.class2);
					    $("#"+element2.class2).attr('class', $("#"+element2.class2).attr('class')+' invalid');
					
					  
					  toast(element2.msg2, 5000);
					});
				}
				if(element.type=='error')
				{
					toast(element.msg, 5000);
				}
				if(element.type=='success')
				{
					toast(element.msg, 5000);
					//testFormListSH('<?php echo $tablename;?>');
					showUserInfo();
					$('#modalEditor').closeModal();  
					//$('#modalSuccess').openModal();
				}
				
			  });		 	  	
		  }
		});
		
});

</script>


<?php
}//enf if checkUserLimit
else echo 'enrh bhgui';

}//enf if post

}//enf if login

?>