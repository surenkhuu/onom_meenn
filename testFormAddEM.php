<?php
include('ajaxAPI.php');
if($_SESSION['login']=='Y')
{


	
$cityid=0;
$tablename=''; $fieldArray = array(); $ubchtunid='';

if(isset($_POST['tablename']) && isset($_POST['ubchtunid']))
{
	$tablename=$_POST['tablename'];  $ubchtunid=$_POST['ubchtunid']; 

if(checkUserLimit($tablename,'userAdd'))
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
	$rrr=$rrr.'<label>'.$title.':</label><br>';
	//$rrr=$rrr.'<div class="input-field col s6">';
	$rrr=$rrr.'<input id="'.$id.'" type="text" class="validate" name="'.$id.'" value="'.$value.'">';
	//$rrr=$rrr.'</div>';
	return $rrr;
}

function txtHiden($id, $value)
{
	$rrr='';
	$rrr=$rrr.'<input id="'.$id.'" type="text" name="'.$id.'" value="'.$value.'" style="display:none;">';
	return $rrr;
}

function txtArea($id, $title, $value)
{
	$rrr='';
	
	$rrr=$rrr.'<label>'.$title.':</label><br>';

	//<textarea rows="4" cols="50">
	$rrr=$rrr.'<textarea id="'.$id.'" class="materialize-textarea" name="'.$id.'" style="height:50px;">'.$value;
	$rrr=$rrr.'</textarea>';
	
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
		`tname`='".$tablename."' AND 
		`usergroupid` LIKE '%".$_SESSION['usergroupid']."%' AND 
		`userAdd` LIKE '%".$_SESSION['usergroupid']."%';";
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
					echo txt($fieldArray[$x]['field'],$fieldArray[$x]['title'],$regdate=date("Y-m-d"));
					break;	
				
				default:
					echo txt($fieldArray[$x]['field'],$fieldArray[$x]['title'],'');
					break;
					}
			}
			
			if($fieldArray[$x]['type']=='textarea' && $fieldArray[$x]['fieldvisit']=='Y')
			{
				echo txtArea($fieldArray[$x]['field'],$fieldArray[$x]['title'],'');
			}
			
			if($fieldArray[$x]['type']=='hiden')
			{
				echo txtHiden($fieldArray[$x]['field'],$fieldArray[$x]['title']);
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
			
		
			
	?>     
	</form>
    
    
    
    
    <div class="action-bar"> 
    
    
    
    	<button class="waves-effect waves-green btn-flat modal-action modal-close" type="button" id="btnClose" style="margin-right:10px;">Болих<i class="mdi-hardware-keyboard-return left"></i></button>
        
     	<button class="waves-effect waves-green btn-flat modal-action" type="button" id="btnAdd" style="margin-right:10px;">Хадгалах
    	<i class="mdi-action-done left"></i>
  		</button>
        
       
</div>
    
	<?php

?>
<!-- Modal Success -->
	<div id="modalSuccess" class="modal" style="width:200px;">
		<h5>Амжилттай бүртгэгдлээ!</h5>
		
 		
        <p>Таны мэдээлэл "ЭРҮҮЛ ЭЛЭГ ҮНДЭСНИЙ ХӨТӨЛБӨР" ийн өвчтөний цахим системд бүртгэгдлээ.</p>
        <p>Та өөрийн эрхээр нэвтэрхийг хүсвэл <a href="index.php?page=login">нэвтрэх</a> хэсэгрүү орно уу.
        </p>
		<div class="action-bar">
        <a href="index.php?page=login" class="waves-effect waves-green btn-flat modal-action">Нэвтрэх</a>
		<a href="" class="waves-effect waves-green btn-flat modal-action modal-close">Хаах</a>
		</div>
	</div>
  
  
  
	<div id="divCamera" title="camera" class="modal" style="width:550px;">
	<div id="cam"></div>
  
	<div class="action-bar">
	<button class="waves-effect waves-green btn-flat modal-action modal-close" type="button" id="btnCloseCam" style="margin-right:10px;">хаах
	<i class="mdi-hardware-keyboard-return left"></i>
	</button>
    </div>
	</div>






 <script src="js/ajaxupload.3.5.js"></script> 
    
<script>
$("#rd").change(function(){ 
var uRD=   $("#rd").val();    
	f_rd = /[А-Яа-яӨөҮү]{2}[0-9]{8}/;
	if (f_rd.test(uRD))
	{
		if(uRD.substring(8,9) % 2) { $("#er").prop("checked", true);}
		else $("#em").prop("checked", true);
		
		if(uRD.substring(2,4)>19) 
		{
			//alert('19'+uRD.substring(2,4)+'-'+uRD.substring(4,6)+'-'+uRD.substring(6,8));
			$('#birthday').val('19'+uRD.substring(2,4)+'-'+uRD.substring(4,6)+'-'+uRD.substring(6,8));
			
		}
	}
	else
	{
		//toast('<span style=" background:#fff;">Регистерийн дугаар буруу</span>', 3000, 'rounded');
	}
	
});


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
					visitUserInfo('ubchtun_main','<?php echo $ubchtunid;?>');
					// $('ul.tabs').tabs('select_tab', '#tab11');
					
					
					$('#modalEditor').closeModal();  
					//$('#modalSuccess').openModal();
					$("#tabli11 a").attr('class', 'active');
				}
				
			  });		 	  	
		  }
		});
		
});
 



function ajaxCamera()
{
	/*$('#divCamera').leanModal({
      dismissible: true, // Modal can be dismissed by clicking outside of the modal
      opacity: .5, // Opacity of modal background
      in_duration: 300, // Transition in duration
      out_duration: 200, // Transition out duration
      ready: function() { alert('Ready'); }, // Callback for Modal open
      complete: function() { alert('Closed'); } // Callback for Modal close
    }
  );*/
  
  
	$('#divCamera').openModal({
		dismissible: false, // Modal can be dismissed by clicking outside of the modal
      opacity: .5, // Opacity of modal background
      in_duration: 300, // Transition in duration
      out_duration: 200, // Transition out duration
	  ready: function() { 
	  		$('#divCamera #cam').html('<div id="example"></div>');
			$('#example').photobooth().on("image",function( event, dataUrl ){
			$('#imgAvatorNew').attr( 'src', dataUrl );
			$('#userimg').val(dataUrl);
			//image.attr( 'src', imageSource );
	});	
			}, // Callback for Modal open
      complete: function() { closeCamera(); }
	});
	
	
	//$('#divCamera').html('<div id="example"></div>');
	//$( "#divCamera" ).dialog({modal: false,height: "auto", width: "auto",
	//	close: function (event, ui) {closeCamera();}
	//	});
		
	
}


function closeCamera()
{
	$( '#example' ).data( "photobooth" ).destroy();
}



$(function(){
	var btnUpload=$('#openImage');
	var ff;
	new AjaxUpload(btnUpload, {
		action: 'upload-file.php',
		name: 'uploadfile',
			onClick: function(file, ext){
				if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
					return false;
				}
			},
			onComplete: function(file, response){
				if(response!=1 && response!=2){
				$('#imgAvatorNew').attr( 'src', 'data:image/jpg;base64,'+response);
				$('#userimg').val('data:image/jpg;base64,'+response);}
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