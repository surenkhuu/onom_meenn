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
           		<?php if(!isset($_REQUEST['search'])) { ?>
				<div class="card-image">
					<img src="image/test.png">
                    <span class="card-title black-text">Нууц үг сэргээх</span>
				</div><?php } else { ?><div style=" padding-left:30px; padding-top:20px;"><span class="card-title black-text">Нууц үг сэргээх</span></div><?php } ?>
                
				<div class="row" style="padding-left:30px; padding-right:30px; padding-top:0px;">
                <?php
				$rd='';
				$lastname = '';
				$firstname = '';
				$email = '';
				$mobile ='';
				$ifUser=false;	
				$finish=''; 
				$m='';
				//echo $_POST['rd'];
				if(isset($_POST['rd']) && isset($_REQUEST['search']))
				{
					$rd = mbm_sql_quote($_POST['rd']);
					$checkRD=false; 
					if(trim($rd)=='') 
					{$finish='1'; $m='Регистерийн дугаар оруулна уу!';}
					else 
					{ 
						if(strlen($rd)==12) 
						{
							if(preg_match("/[А-Яа-яӨөҮү]/",substr($rd,0,2)) && preg_match("/[0-9]/",substr($rd,2,8))) {$checkRD=true;}
							else $checkRD=false;
						}
						if(!$checkRD) 
						{ $finish='1'; $m='Регистерийн дугаар буруу байна!'; } 
					}
					
					
					if($finish=='')
					{
						
						$sql="SELECT t1.*,t2.avator 
						FROM ubchtun_main t1
						LEFT JOIN user_avator t2 ON t1.id = t2.ubchtun_id 
						WHERE UPPER(t1.`rd`)='".strtoupper($rd)."';";
						$result=mysql_query($sql);
						$ifRD=0;
						WHILE($Row = MYSQL_FETCH_ARRAY($result))
							{
								$lastname = $Row['lastname'];
								$firstname = $Row['firstname'];
								$email = $Row['email'];
								
								$mobile = substr($Row['mobile'],4,8);
								$ifUser=true;
								//$m='{"lastname":"'.$lastname.'","firstname":"'.$firstname.'","email":"'.$email.'"}';
								break;
							}
						
						
						
					}
				}
				
				
				
			
				?>
                
                
                
                <?php
				if(!$ifUser)
				{
					
					if($finish!='')
					{ ?>
                    <div class="card-panel yellow lighten-4">
                    <?php echo $m;?>
                    </div>
						
					<?php } 
					else
					{
						if(isset($_REQUEST['search']))
						{
						echo '<div class="card-panel yellow lighten-4">';
						echo $rd.' бүртгэл байхгүй байна.';
						echo '</div>';
						}
					}
					
					
				?>
                
                
				<form class="col s12" id="restoreForm" method="post">
                    <div class="input-field col s12">
                    <i class="mdi-action-account-circle prefix"></i>
                    <input id="rd" type="text" class="validate" name="rd" value="<?php echo $rd;?>">
                    <label for="rd">Регистерийн дугаар</label>
                    </div>
                    
                    <button class="btn waves-effect right blue-grey lighten-3 black-text" type="submit" name="search" style="margin-right:10px;" onclick="javascript:search();">Хайх
					<i class="mdi-action-search left"></i>
					</button>
                    <a class="btn waves-effect right blue-grey lighten-3 black-text" href="index.php"><i class="mdi-navigation-arrow-back left"></i>Буцах</a>
                   
				</form>
    			<?php 
				}
				else
				{ ?> 
                <div class="col s12">
                Та нууц үгээ солихын тулд бүртгүүлсэн гар утасны дугаар үнэн зөв оруулж баталгаажуулах ёстой.
                Хүсэлт баталгаажсан тохиолдолд таны нууц үгийг системээс автоматаар солих ба шинэ нууц үгийг таны и-майл хаягруу илгээх болно.
               </div> <br />
                <div class="col s4"><img src="image/avator.png" width="100" /></div>
                <div class="col s2"><label>Нэр:</label></div><div class="col s6"><?php echo $lastname.' '.$firstname;?></div>
                <div class="col s2"><label>Регистер:</label></div><div class="col s6"><?php echo $rd ;?></div>
                <div class="col s2"><label>И-майл:</label></div><div class="col s6"><?php echo $email;?></div>
                
                <div class="col s2"><label>Утас:</label></div><div class="col s6">****<?php echo $mobile ;?></div>
                
                
                
                <div class="col s8">
                	<form  id="restoreFormPhone">
                    <div class="input-field col s12">
                    <i class="mdi-hardware-phone-android prefix"></i>
                    <input id="mobile" type="text" class="validate" name="mobile">
                    <input id="rd" type="text" name="rd" value="<?php echo $rd;?>" style="display:none;">
                    <label for="mobile">Гар утас</label>
                    
                    </div>
       				</form>
                       
                </div>
                
                 <div class="col s12">
                <button class="btn waves-effect right blue-grey lighten-3 black-text" type="submit" name="action" style="margin-right:10px;" onclick="javascript:restorePass();">Солих
				<i class="mdi-action-lock-open left"></i>
				</button>
                <a class="btn waves-effect right blue-grey lighten-3 black-text" href="index.php"><i class="mdi-navigation-arrow-back left"></i>Буцах</a>
                
                
                </div>
					
                    
                <script>
				function restorePass()
				{
				   $('#modalWait').openModal();
				   var formData = $("#restoreFormPhone").serializeArray();
				   // alert(formData);
					$.ajax({
					  type: "POST",
					  url: "ajaxPassRestore.php",
					  data: formData,
					  cache: false,
					  success: function(html){ //alert(html);
						  $("#rd").attr('class', 'validate');
						  
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
								//alert('ddd');
								toast(element.msg, 3000);
								$('#modalSuccess').openModal();
								//if(html=='success') window.location.href = 'index.php';
							}
							if(element.type=='none')
							{
								toast(element.msg, 3000);
								$('#modalNone').openModal();
							}
							
						  });
						  
						  
						  
					  }
					});
					$('#modalWait').closeModal();
				}
				
				</script>    
                    
                    
                    
                    
				<?php }
				
				?>
				
				</div>
  
				<div class="card-action">
				<a class="grey-text" href="index.php?page=register">Бүртгүүлэх</a>
				<a class="grey-text" href="javascript:showHelp('login');">Нууц үгээ мартсан уу?</a>
				</div>
			</div>  <!--END CARD -->
     
		</div><!--END COL -->

	</div><!--END ROW-->  
  
  
  
	<!-- Modal Structure -->
  	<div id="modalNone" class="modal">
    <h4>Анхаар</h4>
    <p>Таны мэдээлэл цахим системд бүртгэгдээгүй байна.</p>
        <p>Та өөрийн мэдээллийг бүртгүүлэхийг хүсвэл <a href="index.php?page=register">БҮРТГЭЛ</a> хэсэгрүү орно уу.
        </p>
		<div class="action-bar">
        <a href="index.php?page=register" class="waves-effect waves-green btn-flat modal-action">Бүртгүүлэх</a>
		<a href="" class="waves-effect waves-green btn-flat modal-action modal-close">Хаах</a>
		</div>
	</div> 
    
    <!-- Modal Structure -->
  	<div id="modalSuccess" class="modal">
    <h4>Таны нууц үг амжилттай солигдлоо</h4>
    <p>Таны шинэ нууц үг [<span style="color:#F00"><?php echo $email; ?></span>] и-майл хаягаар илгээгдлээ.</p>
    <p>Системээс илгээсэн и-майл таны inbox хавтсанд ороогүй байвал spam хавтасаа шалгана уу.</p>
    <p>Анхааруулга!</p>
    <p>Та шинэ нууц үгээр нэвтэрсэний дараа нууц үгийг солихыг зөвлөж байна.</p>
		<div class="action-bar">
        <a href="index.php?page=login" class="waves-effect waves-green btn-flat modal-action">Нэвтрэх</a>
		<a href="" class="waves-effect waves-green btn-flat modal-action modal-close">Хаах</a>
		</div>
	</div> 
  
  
   
   <!-- Modal Wait -->
	<div id="modalWait" class="modal">
		<h5>Түр хүлээнэ үү!</h5>
		<div class="progress"><div class="indeterminate"></div></div>
 		<p>Мэдээллийг шалгаж байна</p>
		<div class="action-bar">
		<a href="#" class="waves-effect waves-green btn-flat modal-action modal-close">close</a>
		</div>
	</div> 
   
    
    <script> 
   function search()
   {
	   $('#modalWait').openModal();
	   var formData = $("#restoreForm").serializeArray();
	   // alert(formData);
    	$.ajax({
		  type: "POST",
		  url: "ajaxPassRestore.php",
		  data: formData,
		  cache: false,
		  success: function(html){
			  $("#rd").attr('class', 'validate');
			  
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
					if(html=='success') window.location.href = 'index.php';
				}
				if(element.type=='none')
				{
					toast(element.msg, 3000);
					$('#modalNone').openModal();
				}
				
			  });
			  
			  
			  
		  }
		});
		$('#modalWait').closeModal();
   }
    </script>