<?php
if(isset($_REQUEST['btnExit']))
	{
		
		session_unset();
		if(!isset($_SESSION['login'])) $_SESSION['login']='';
		echo '<meta http-equiv="REFRESH" content="0;url=index.php">';
	}
	
if($_SESSION['login']=='Y')
{
	$id=$_SESSION['userid'] ;
	$userimg='';
	
	$resultImg = mysql_query("SELECT `avator` FROM  `ubchtun_main_avator` where `uid`='".$id."';");
		$rowImg=mysql_fetch_assoc($resultImg);
		$userimg=$rowImg['avator'];
	
?>
<!-- Page Layout here -->
<div class="row">
	<div class="col s3">
	<!-- Grey navigation panel -->
    
    <div class="card blue-grey darken-1" id="loginDiv">
			<div class="card-image">
					<img src="image/hep1.png">
					<span class="card-title black-text" style="border:solid 0px; padding-bottom:10px; font-size:18px;"><i class="mdi-action-account-circle left"></i>Хэрэглэгч</span>
			</div>
			<div class="col s12 white-text">
            <div class="center-align">
            <img class="responsive-img" src="<?php if($userimg=="") echo 'image/avator.png';
 else echo $userimg;?>" id="imgAvator" width="100px"></div>
            
            
				<div><span style="font-weight:lighter;">Овог: </span><?php echo $_SESSION['lastname'];?></div>
				<div><span style="font-weight:lighter;">Нэр: </span><?php echo $_SESSION['firstname'];?></div>
				<div><span style="font-weight:lighter;">РД: </span><?php echo $_SESSION['rd'];?></div>
                
                <div style="margin-bottom:20px; position:relative;">
                
                
                <a class="btn-floating blue-grey darken-2" href="javascript:showUserInfo(<?php echo $id;?>);"><i class="mdi-action-settings"></i></a>
            	
                
                
        
               </div>
			</div>
          
                   
			
			</div>  <!--END CARD -->


<ul class="collapsible" data-collapsible="accordion">
	<li>
      <div class="collapsible-header"><i class="mdi-navigation-apps"></i>Ерөнхий</div>
      <div class="collapsible-body">
      	<ul class="leftMenu">
        <li><a href="javascript:showUserInfo();"><div><i class="mdi-action-account-box left"></i>Миний бүртгэл</div></a></li>
      	</ul>
      </div>
    </li>
    
  
    <li>
      <div class="collapsible-header"><i class="mdi-action-settings"></i>Тохиргоо</div>
      <div class="collapsible-body">
      	<ul class="leftMenu">
        <li><a href="javascript:loadInfo('passChange');"><div><i class="mdi-communication-vpn-key left"></i>Нууц үг солих</div></a></li>
        
        <li>
        <div>
        <form name="form" id="form" method="post" ENCTYPE="multipart/form-data">
        <i class="mdi-action-exit-to-app left"></i>
        <input type="submit" name="btnExit" value="Гарах">
        </form>
        </div>
        </li>
        
      	</ul>
      </div>
    </li>
</ul>
    
    
		
	</div><!--END LFT COLUMN-->  
      
	
    
    <div class="col s9" id="rightColumn"><!--RIGHT COLUMN-->  
    <?php include('userInfo.php');?>
	</div>

</div><!--END ROW-->  
  
  
  

  
  
   

   
    
    <script> 
   function showUserInfo()
   {
	   $('#modalWait').openModal();
	   //var formData = $("#loginForm").serializeArray();
	   //var dataString = 'reserv='+ reserv +'&comment='+ comment; 
    	$.ajax({
		  type: "POST",
		  url: "userInfoAjax.php",
		  data: "",
		  cache: false,
		  success: function(html){ 
			  $('#rightColumn').html(html);
			 // toast(html, 4000);
			 // if(html=='success') window.location.href = 'index.php';
		  }
		});
		$('#modalWait').closeModal();
   }
   
   function loadInfo(page)
   {
	   $('#modalWait').openModal();
	   //var formData = $("#loginForm").serializeArray();
	   //var dataString = 'reserv='+ reserv +'&comment='+ comment; 
    	$.ajax({
		  type: "POST",
		  url: page+".php",
		  data: "",
		  cache: false,
		  success: function(html){
			 // alert(html);
			  $('#rightColumn').html(html);
			 // toast(html, 4000);
			 // if(html=='success') window.location.href = 'index.php';
		  } 
		});
		$('#modalWait').closeModal();
   }
   
   
   
   
   
    </script>
    
<?php
}
?>