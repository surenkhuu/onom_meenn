<?php
include('ajaxAPI.php');
if($_SESSION['login']=='Y')
{
	if(isset($_SESSION['userid']))
	{
		$userid=$_SESSION['userid'];
	?>
	<!-- Page Layout here -->
    <div class="row">
		
      
     	<div style=" width:500px;">
        
     		<div class="card" id="loginDiv">
				<div class="card-image">
					<img src="image/test.png">
					<span class="card-title black-text">Нууц үг солих</span>
				</div>
				<div class="row" style="padding-left:30px; padding-right:30px; padding-top:30px;">
				<form class="col s12" id="passChangeForm">
                
                 <input id="userid" type="text" class="validate" name="userid" value="<?php echo $userid;?>" style="display:none;">
                
                  	<div class="input-field col s12">
                    <input id="password" type="password" class="validate" name="password">
                    <label for="password">Нууц үг</label>
                    </div>
                    
                    <div class="input-field col s6">
                    <input id="newpassword" type="password" class="validate" name="newpassword">
                    <label for="newpassword">Шинэ нууц үг</label>
                    </div>
                    <div class="input-field col s6">
                    <input id="newpassword2" type="password" class="validate" name="newpassword2">
                    <label for="newpassword2">Шинэ нууц үг давт</label>
                    </div>
				</form>
    
				<button class="btn waves-effect right blue-grey lighten-3 black-text" type="submit" name="action" style="margin-right:20px; margin-top:20px;" onclick="javascript:passChange();">Нууц үг солих
				<i class="mdi-action-lock-open left"></i>
				</button>
				</div>
  
				
			</div>  <!--END CARD -->
     
		</div><!--END COL -->

	</div><!--END ROW-->  
  
  
  
	 
    
    
  
  
 
   
    
    <script> 
   function passChange()
   {
	   $('#modalWait').openModal();
	   var formData = $("#passChangeForm").serializeArray();
	   // alert(formData);
    	$.ajax({
		  type: "POST",
		  url: "ajaxPassChange.php",
		  data: formData,
		  cache: false,
		  success: function(html){
			  
			 //  alert(html);
			  $("#password").attr('class', 'validate');
			  $("#newpassword").attr('class', 'validate');
			  $("#newpassword2").attr('class', 'validate');
			  
			  var obj = $.parseJSON(html);
			  
			  $.each(obj, function(index, element) {
				  
				if(element.type=='alert')
				{
				  	$.each(element.msg, function(index2, element2) {
					  $("#"+element2.class2).attr('class', 'invalid');
					  toast(element2.msg2, 1000);
					});
				}
				if(element.type=='error')
				{
					toast(element.msg, 3000);
				}
				if(element.type=='success')
				{
					toast(element.msg, 3000); window.location.href = 'index.php';
					// if(html=='success') window.location.href = 'index.php';
				}
				if(element.type=='none')
				{
					toast(element.msg, 3000);
					$('#modalNone').openModal();
				}
				if(element.type=='eleg')
				{
					toast(element.msg, 3000);
					$('#modalEleg').openModal();
				}
				
			  });
			  
		
		  }
		});
		$('#modalWait').closeModal();
   }
    </script>
    
<?php 
	}
} 
?>