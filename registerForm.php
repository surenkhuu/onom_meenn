<?php
$cityid=0;
?>

    


<script>
$('#example').photobooth().on("image",function( event, dataUrl ){
	//alert('dd');
});
</script>
	<!-- Page Layout here -->
    <div class="row">
		
      
     	
        
     		<div class="card" id="loginDiv">
        	<div class="card-image">
            <img src="image/r1.png">
            <span class="card-title black-text" style="font-size:34px; padding-left:30px;">Өвчтөний бүртгэл</span>
            </div>
        <div class="row" style="padding-left:20px; padding-right:20px; padding-top:0px;">
        <form class="col s12" id="registerForm">
        
        <div class="col s8">
        <div class="input-field col s6">
        <i class="mdi-action-account-circle prefix"></i>
        <input id="lastname" type="text" class="validate" name="lastname">
        <label for="lastname">Овог</label>
        </div>
        
        <div class="input-field col s6">
        <input id="firstname" type="text" class="validate" name="firstname">
        <label for="firstname">Нэр</label>
      	</div>
        
        <div class="input-field col s12">
        <i class="mdi-action-label-outline prefix"></i>
        <input id="rd" type="text" class="validate" name="rd">
        <label for="rd">Регистерийн дугаар</label>
      	</div>
      
        <div class="input-field col s6">
        <i class="mdi-communication-vpn-key prefix"></i>
        <input id="password" type="password" class="validate" name="password" data-position="bottom" data-delay="50" data-tooltip="I am tooltip">
        <label for="password">Нууц үг</label>
      	</div>
        <div class="input-field col s6">
        <input id="password2" type="password" class="validate" name="password2">
        <label for="password2">Нууц үг давт</label>
      	</div>
        
        <div class="input-field col s12">
        <i class="mdi-hardware-phone-android prefix"></i>
        <input id="mobile" type="text" class="validate" name="mobile">
        <label for="mobile">Гар утас</label>
      	</div>
        
        
        <div class="input-field col s12">
        <i class="mdi-communication-email prefix"></i>
        <input id="email" type="email" class="validate" name="email">
        <label for="email">И-майл</label>
      	</div>
        
        
          <div class="col s6">
          <p>
        <label id="gender">Хүйс</label> <br />
       
        <input class="with-gap" name="gender" type="radio" id="er" value="ЭР"/><label for="er">Эрэгтэй</label>
        <input class="with-gap" name="gender" type="radio" id="em" value="ЭМ" /><label for="em">Эмэгтэй</label>
        </p>
    	</div>
        
        <div class="col s6">
        <label for="birthday"><i class="mdi-editor-insert-invitation prefix"></i>Төрсөн огноо</label>
        
        <input id="birthday" type="date" class="datepicker" name="birthday" value="">
      	</div>
        
        
      
        
        
       	
          
          
        
		
    
        </div>
        
        <div class="col s4 center-align">
        
        <img class=" responsive-img" src="image/avator.png" id="imgAvator" width="200">
        <input name="userimg" id="userimg" type="text" value="" style="display:none;">
        </div>
        
        <div class="col s2 right-align" >
            <button class="btn-flat waves-effect waves-light right" onclick="javascript:ajaxCamera();"  style="width:50px;" type="button" id="btnCamera">
            <i class="mdi-image-camera-alt" style=" font-size:36px;"></i></button>
            </div>
            
            
            <div class="col s2 left-align">
            <button class="btn-flat waves-effect waves-light left" style="width:50px;" id="openImage" type="button">
            <i class="mdi-file-folder-shared" style=" font-size:36px;"></i></button>
            </div>
            
         
            
		
      
        
        
	<div class="col s12">
		<div class="col s12">
		<span class="card-title black-text">Хаяг</span>
		</div>
        
        <div class="col s4">
        <label>Аймаг/Хот</label>
       	<?php
    $sqlCombo="SELECT * FROM city";
    $resultCombo=mysql_query($sqlCombo);
    echo '<select id="selectCity" name="cityid" onchange="javascript:setDistrict(this.value)" class="browser-default">'; 
    echo '<option value=""></option>';	
    WHILE($RowCombo = MYSQL_FETCH_ARRAY($resultCombo))
    {
    $vv='';
    if($RowCombo['id']==$cityid) $vv='selected=selected';
    echo '<option value="'.$RowCombo['id'].'" '.$vv.'>'.$RowCombo['title'].'</option>';	
    }
    echo ' </select>';
    ?>
        </div>
              
        <div class="col s4">
        <label>Сум/Дүүрэг</label>
		<div id="district">
  <?php
    $sqlCombo="SELECT * FROM district where city_id=".$cityid;
    $resultCombo=mysql_query($sqlCombo);
   // echo '<select id="selectDistrict" name="districtid" class="browser-default">'; 
	echo '<select id="selectDistrict" name="districtid" onchange="javascript:setKhoroo('.$cityid.',this.value)" class="browser-default">'; 
    echo '<option value=""></option>';	
    WHILE($RowCombo = MYSQL_FETCH_ARRAY($resultCombo))
    {
    $vv='';
    if($RowCombo['id']==$districtid) $vv='selected=selected';
    echo '<option value="'.$RowCombo['id'].'" '.$vv.'>'.$RowCombo['title'].'</option>';	
    }
    echo ' </select>';
    ?>
  </div>
		</div>
        
        
        <div class="col s4">
        <label>Баг/Хороо</label>
		<div id="khoroo">
  		<select id="selectKhoroo" name="khorooid" class="browser-default">
  		</select>
  		</div>
		</div>
        
        
        
        
        
        
        <div class="col s4">
        <label>Хаяг</label>
        <input id="address" type="text" class="validate" name="address">
        
      	</div>
        
	</div>
      	
  		</form>
        
        
     
        
        
        
        <button class="btn waves-effect right blue-grey lighten-3 black-text" type="submit" name="action" style="margin-right:10px;" onclick="javascript:register();">Бүртгүүлэх
    	<i class="mdi-action-lock-open left"></i>
  		</button>
         
        
        
        </div>
        
  		<div class="card-action">
              <a class="grey-text" href="index.php?page=login"><i class="mdi-action-verified-user"></i> Нэвтрэх</a>
              <a class="grey-text" href='#'><i class="mdi-communication-live-help"></i> Системийн танилцуулга?</a>
        </div>
     </div>  
     
   

	</div><!--END ROW-->  
  
  
  
    
    
    
    <!-- Modal Success -->
	<div id="modalSuccess" class="modal"  style="padding: 5px 25px 0 25px;">
		<h5>Амжилттай бүртгэгдлээ!</h5>
		
 		
        <p>Таны мэдээлэл "ЭРҮҮЛ ЭЛЭГ ҮНДЭСНИЙ ХӨТӨЛБӨР" ийн өвчтөний цахим системд бүртгэгдлээ.</p>
        <p>Та өөрийн эрхээр нэвтэрхийг хүсвэл <a href="index.php?page=login">нэвтрэх</a> хэсэгрүү орно уу.
        </p>
		<div class="modal-footer">
        <a href="index.php?page=login" class="waves-effect waves-green btn-flat modal-action">Нэвтрэх</a>
		<a href="index.php" class="waves-effect waves-green btn-flat modal-action modal-close">Хаах</a>
		</div>
	</div>
  
  
<div id="divCamera" title="camera" class="modal" style="width:500px;">
</div>
  


  <script src="js/ajaxupload.3.5.js"></script> 
    
<script> 


function checkFilter(f,o)
{
	if (!f.test($(o).val()))
	{
		//alert($(o).attr('data-tooltip'));
		 $(o).attr('class', 'invalid');
		 return false;
	}
	else 
	{
		//alert($(o).attr('data-tooltip'));
		$(o).attr('class', 'validate');
		return true;
	}
}


function setDistrict(value)
{
	$.ajax({
		type: "GET",
		  url: "ajaxDistrict.php",
		  data: "cityid="+value,
		  cache: false,
		  success: function(html){ $('#district').html(html);
		  }
		});
	//$('#district').load('ajaxDistrict.php?cityid='+value);
}		

function setKhoroo(cityid,districtid)
{
	
	$.ajax({
		type: "GET",
		  url: "ajaxKhoroo.php",
		  data: "cityid="+cityid+"&districtid="+districtid,
		  cache: false,
		  success: function(html){ $('#khoroo').html(html);
		  }
		});
	//$('#khoroo').load('ajaxKhoroo.php?cityid='+cityid+'&districtid='+districtid);
}
	
function register()
{   
	//$("#loadGif").css('display','block');
	$('#modalWait').openModal();
	
	var formData = $("#registerForm").serializeArray();
	
    $.ajax({
		  type: "POST",
		  url: "ajaxRegister.php",
		  data: formData,
		  cache: false,
		  success: function(html){
			 //alert(html);
			 $('#modalWait').closeModal();  
			  allValidate();
			  var obj = $.parseJSON(html);
			  $.each(obj, function(index, element) {
				  
				if(element.type=='alert')
				{
				  	$.each(element.msg, function(index2, element2) {
					  $("#"+element2.class2).attr('class', 'invalid');
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
					$('#modalSuccess').openModal();
				}
				
			  });
			 
		  	
		  }
		});
		
}
 
 
function allValidate()
{
	$("#lastname").attr('class', 'validate');
	$("#firstname").attr('class', 'validate');
	$("#rd").attr('class', 'validate');
	$("#password").attr('class', 'validate');
	$("#password2").attr('class', 'validate');
	$("#mobile").attr('class', 'validate');
	$("#email").attr('class', 'validate');
	$("#birthday").attr('class', 'validate');
}
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
	  dismissible: true, // Modal can be dismissed by clicking outside of the modal
      opacity: .5, // Opacity of modal background
      in_duration: 300, // Transition in duration
      out_duration: 200, // Transition out duration
	  ready: function() { 
	  		$('#divCamera').html('<div id="example"></div><a href="javascript:closeCamera();" class="waves-effect waves-green btn-flat right">Хаах</a>');
			$('#example').photobooth().on("image",function( event, dataUrl ){
			$('#imgAvator').attr( 'src', dataUrl );
			$('#userimg').val(dataUrl);
			//image.attr( 'src', imageSource );
	});	
			}, // Callback for Modal open
      complete: function() { closeCamera(); }
	});
	//$('#divCamera').html('<div id="example"></div>');
	//$( "#divCamera" ).dialog({modal: false,height: "auto", width: "auto",
	//close: function (event, ui) {closeCamera();}
	//});
}

function closeCamera()
{
	$('#example').data( "photobooth" ).destroy();
	$('#divCamera').closeModal();  
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