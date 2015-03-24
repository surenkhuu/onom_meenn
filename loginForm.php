	<!-- Page Layout here -->
    <div class="row">
		<div class="col s6">
        <!-- Grey navigation panel -->
        
        
        
        <div class="row">
	<div class="card" id="loginDiv">
    
    	<div class="card-content">
        <h6>Эрүүл Элэг Хѳтѳлбѳрийн Эмчлүүлэгчидийн Нарийвчилсан Бүртгэлийн Систем</h6>

        <p style="font-weight:lighter;">Та бүхэн энэ нарийвчилсан бүртгэлийн системд бүртгүүлж мэдээлэлээ оруулснаар  Эрүүл Элэг Хѳтѳлбѳрийн Эмчилгээний дэд хѳтѳлбѳрт хамрагдах бэлтгэлээ хангах юм.</p>
        
        <br />
        
         <div class="video-container">
        <iframe width="853" height="480" src="//www.youtube.com/embed/jQH3xsYkFZk" frameborder="0" allowfullscreen></iframe>
      </div>  
        
        
        </div></div></div>
        
        
        
        
      	
      	</div>
      
     	<div class="col s6">
        
     		<div class="card" id="loginDiv">
				<div class="card-image">
					<img src="image/test.png">
					<span class="card-title black-text">Нэвтрэх</span>
				</div>
				<div class="row" style="padding-left:30px; padding-right:30px; padding-top:30px;">
				<form class="col s12" id="loginForm">
                    <div class="input-field col s12">
                    <i class="mdi-action-account-circle prefix"></i>
                    <input id="rd" type="text" class="validate" name="rd">
                    <label for="rd">Регистерийн дугаар</label>
                    </div>
          
                    <div class="input-field col s12">
                    <i class="mdi-communication-vpn-key prefix"></i>
                    <input id="password" type="password" class="validate" name="password">
                    <label for="password">Password</label>
                    </div>
				</form>
    
				<button class="btn waves-effect right blue-grey lighten-3 black-text" type="submit" name="action" style="margin-right:10px;" onclick="javascript:login();">Нэвтрэх
				<i class="mdi-action-lock-open left"></i>
				</button>
				</div>
  
				<div class="card-action">
				<a class="grey-text" href="index.php?page=register">Бүртгүүлэх</a>
				<a class="grey-text" href='index.php?page=restore'>Нууц үгээ мартсан уу?</a>
				</div>
			</div>  <!--END CARD -->
     
		</div><!--END COL -->

	</div><!--END ROW-->  
  
  
  
	<!-- Modal Structure -->
  	<div id="modalNone" class="modal"  style="padding: 5px 25px 0 25px;">
    <h4>Анхаар</h4>
    <p>Таны мэдээлэл цахим системд бүртгэгдээгүй байна.</p>
        <p>Та өөрийн мэдээллийг бүртгүүлэхийг хүсвэл <a href="index.php?page=register">БҮРТГЭЛ</a> хэсэгрүү орно уу.
        </p>
		<div class="modal-footer">
        <a href="index.php?page=register" class="waves-effect waves-green btn-flat modal-action">Бүртгүүлэх</a>
        
      
        
		<a href="" class="waves-effect waves-green btn-flat modal-action modal-close">Хаах</a>
		</div>
	</div> 
    
    
  
  
   
    
    <script> 
   function login()
   {
	   $('#modalWait').openModal();
	   var formData = $("#loginForm").serializeArray();
	   // alert(formData);
    	$.ajax({
		  type: "POST",
		  url: "ajaxLogin.php",
		  data: formData,
		  cache: false,
		  success: function(html){
			  
			 //  alert(html);
			  $("#rd").attr('class', 'validate');
			  $("#password").attr('class', 'validate');
			  
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
					toast(element.msg, 3000);
					 if(element.type=='success') window.location.href = 'index.php';
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