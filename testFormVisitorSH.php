<?php
include('ajaxAPI.php');
if($_SESSION['login']=='Y')
{

$cityid=0;
$fieldArray = array();
if(isset($_POST['tablename']) && isset($_POST['id']))
{
	$tablename=$_POST['tablename']; $id=$_POST['id']; 
	$userimg='';
	$ubchtunid=$_SESSION['userid'];
	
//if(checkUserLimit($tablename,'userEdit'))
{

function txt($id, $title, $value)
{
	if($value=='') $value='';
	$rrr='';
	$rrr=$rrr.'<tr>';
	
	$rrr=$rrr.'<td>'.$title.'</td>';
	$rrr=$rrr.'<td>'.$value.'</td>';
	
	$rrr=$rrr.'</tr>';	
	return $rrr;
}

function cmd($id, $title, $related,$value)
{
	$rrr='';
	$s="SELECT * FROM ".$related." WHERE `id`='".$value."'";
    $res=mysql_query($s);
	$rrr=$rrr.'<div class="col s6">';
	$rrr=$rrr.'<label>'.$title.'</label>';
	
    WHILE($r = MYSQL_FETCH_ARRAY($res))
    {
    $rrr=$rrr.'<div class="userInfo">'.$r['title'].'</div>';	
    }
	$rrr=$rrr.'</div>';	
	return $rrr;
}

function cmbText($id, $title, $related,$value)
{
	$rrr='';
	$s="SELECT * FROM ".$related." WHERE `id`='".$value."'";
    $res=mysql_query($s);
	$rrr=$rrr.'<div class="col s6">';
	$rrr=$rrr.'<label>'.$title.'</label>';

    WHILE($r = MYSQL_FETCH_ARRAY($res))
    {
    $rrr=$rrr.'<div class="userInfo">'.$r['title'].'</div>';	
    }
	$rrr=$rrr.'</div>';	
	return $rrr;
}






	echo '<div class="card-content black-text" id="visitUbchtunSH" style="padding:20px 20px 10px 20px;">';
	
	
	$sqlD="SELECT t1.*, t2.title as city, t3.title as district, t4.avator
		FROM ubchtun_main t1 
		LEFT JOIN city t2 ON t1.cityid = t2.id 
		LEFT JOIN district t3 ON t1.districtid = t3.id 
		LEFT JOIN ubchtun_main_avator t4 ON t1.id = t4.uid 
		where t1.id='".$ubchtunid."'";
		//echo $sqlD;
		
	$resultD=mysql_query($sqlD);
	WHILE($RowD = MYSQL_FETCH_ARRAY($resultD))
	{
		$systemcode=$RowD['systemcode'];
		$lastname=$RowD['lastname'];
		$firstname=$RowD['firstname'];
		//$occupation=$RowD['occupation'];
		$rd=$RowD['rd'];
		$gender=$RowD['gender'];
		$birthday=$RowD['birthday'];
		$phone=$RowD['phone'];
		$mobile=$RowD['mobile'];
		$email=$RowD['email'];
		$city=$RowD['city'];
		$district=$RowD['district'];
		$address=$RowD['address'];
		$description=$RowD['description'];
		$reguser=$RowD['reguser'];
		$userimg=$RowD['avator'];
		$regdate=$RowD['regdate'];
		
		?>
       
       	<table class="tableUserInfo">
       		<tr><td width="150px"><label>Овог/нэр:</label></td><td><?php echo $lastname.'/'.$firstname;?></td></tr>
            <tr><td><label>Регистерийн дугаар:</label></td><td><?php echo $rd;?></td></tr>
        	<tr><td><label>Төрсөн огноо:</label></td><td><?php echo $birthday;?></td></tr>
        	<tr><td><label>Гар утас:</label></td><td><?php echo $mobile;?></td></tr>
            <tr><td><label>И-майл:</label></td><td><?php echo $email;?></td></tr>
        </table>
        
      
     
        
      
        
        <?php
	}
	
    
    
	//echo '<div class="modal-content">';
	$sql="SELECT * FROM `menu` where 
		`tname`='".$tablename."';";
	if($result=mysql_query($sql))
	{
		WHILE($row = MYSQL_FETCH_ARRAY($result))
		{
			//echo '<div class="card-image"><img src="image/r1.png">';
			echo '<div style="padding:0px;">'.$row['title'].' </div>';
			
			
			//echo '</div>';
		}
	}
	?>
      
	     
	<?php
	//$sql2="select * FROM system_table where `tablename`='".$tablename."' and `id`=".$id.";";
	//$sql2="select * FROM system_table where `id`='".$id."';";
	$sql="SELECT * FROM sh_table where `shtablename`='".$tablename."';";
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



echo '<table class="bordered" id="bioTable">';
	

echo ' <tbody>';
	$s2="SELECT * FROM `".$tablename."` where `id`=".$id." and `ubchtunid`=".$_SESSION['userid'].";";
	$r2=mysql_query($s2);
		//echo $s2;
	WHILE($row2 = MYSQL_FETCH_ARRAY($r2))
	{
			//echo txt($row['field'],$row2[0]); 
		for($x=0;$x<$arrlength;$x++)
		{	
			if($fieldArray[$x]['fieldvisit']=='Y')
			{
				
				if($fieldArray[$x]['type']=='' && $fieldArray[$x]['fieldvisit']=='Y')
				{
					$i++; 
					
					
					echo txt($fieldArray[$x]['field'],$fieldArray[$x]['title'],$row2[$fieldArray[$x]['field']]); 
					
				}
				
				
				
				if($fieldArray[$x]['type']=='combobox' && $fieldArray[$x]['fieldvisit']=='Y')
				{
					$i++;
					echo cmd($fieldArray[$x]['field'],$fieldArray[$x]['title'],$fieldArray[$x]['related'],$row2[$fieldArray[$x]['field']]); 
				}
				
				
				if($fieldArray[$x]['type']=='cmbText' && $fieldArray[$x]['fieldvisit']=='Y')
				{
					$i++;
					echo txt($fieldArray[$x]['field'],$fieldArray[$x]['title'],$row2[$fieldArray[$x]['field']]); 
					//echo cmbText($fieldArray[$x]['field'],$fieldArray[$x]['title'],$fieldArray[$x]['related'],$row2[$fieldArray[$x]['field']]); 
				}
				
				
				
		
				
			
			}
			
		}//END FOR
			
	}

	echo ' </tbody>';
	echo ' </table>';		
	
	
echo ' </div>';				
	?>
     
    
   <div class="modal-footer"> 
    
    	 	<button class="waves-effect waves-green btn-flat modal-action modal-close" type="button" id="btnClose" style="margin-right:10px;">Хаах<i class="mdi-hardware-keyboard-return left"></i></button>
            
		<button class="waves-effect waves-green btn-flat" type="button" id="btnDelgerengui" 
        style="margin-right:10px;" onclick="javascript:printPage();">Хэвлэх<i class="mdi-action-print left"></i></button>
        
     
     
    
 
       
       
   
     	</div>
        
        
       
    
	<?php

?>

    
    
<script src="js/jQuery.print.js"></script>
<script>
$("#btnClose").click(function()
{
	//$('#modalWait').openModal();
	 $('#modalEditor').closeModal(); 
});


function printPage()
{
 //$.print("#visitUbchtunSH");	
 $("#visitUbchtunSH").print({

// Use Global styles
globalStyles : false, 

// Add link with attrbute media=print
mediaPrint : false, 

//Custom stylesheet
stylesheet : "css/print.css", 

//Print in a hidden iframe
iframe : false, 

// Don't print this
noPrintSelector : ".avoid-this",

// Add this on top
append : "Free jQuery Plugins<br/>", 

// Add this at bottom
prepend : "<br/>jQueryScript.net",

// Manually add form values
manuallyCopyFormValues: true,

// resolves after print and restructure the code for better maintainability
deferred: $.Deferred()

});
}


</script>

<?php
}//enf if checkUserLimit
//else echo 'enrh bhgui';


}//end if post
}//end if login
?>