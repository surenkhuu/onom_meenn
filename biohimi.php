<?php
session_start();
include 'conn.php';
?>

<?php
//if(ISSET($_GET['id']))

	$id=$_SESSION['userid'];
	function getConstant_Biohimi($column)
	{ 
		$sql="SELECT * FROM `sh_constant`
			   where `sh_table`='sh_biohimi' and `sh_column`='".$column."';";
		
		$result=mysql_query($sql);
		$constant='';
		WHILE($Row = MYSQL_FETCH_ARRAY($result))
		{
			
			$constant=$Row['min1'].'-'.$Row['max1'].' '.$Row['negj'];
		}
		return $constant;
	}
?>

<!-- Page Layout here -->
<div class="row">
	<div class="card" id="loginDiv">
    
    	<div class="card-image">
		<img src="image/r1.png">
		<span class="card-title black-text" style="font-size:34px; padding-left:30px;">Биохимийн шинжилгээ</span>
		</div>
        
        <div class="row">
        <div class="col 12">
		<div class="divTable">
        <?php
		$sql="SELECT * FROM `sh_biohimi` where `ubchtun_id`='".$id."';";		
		$result=mysql_query($sql);
		WHILE($Row = MYSQL_FETCH_ARRAY($result))
		{
			echo '<a href="javascript:loadBiohimiShowForm('.$Row['id'].');">';
			echo '<div class="divTableDet">';
			echo '<div class="divTableImg"><i class="mdi-action-settings"></i></div>';
			echo '<span>'.$Row['date'].'</span>';
			echo '</div></a>';
		}
		?>
		</div>
        </div>
        </div>
        
        
        <div class="card-action">
		<a class="grey-text" href="javascript:loadBiohimiAddForm();"><i class="mdi-content-add-circle-outline"></i> Биохимийн шинжилгээ оруулах</a>
        </div>

    </div> <!--END CARD-->   
      
</div><!--END ROW-->


<!-- Biohimi Form -->
<div id="biohimiForm">

</div>


<script>
function loadBiohimiAddForm()
   {
	   $('#modalWait').openModal();
	   //var formData = $("#loginForm").serializeArray();
	   //var dataString = 'reserv='+ reserv +'&comment='+ comment; 
    	$.ajax({
		  type: "POST",
		  url: "biohimiAddForm.php",
		  data: "",
		  cache: false,
		  success: function(html){
			 // alert(html);
			  $('#biohimiForm').html(html);
			 // toast(html, 4000);
			 // if(html=='success') window.location.href = 'index.php';
		  }
		});
		$('#modalWait').closeModal();
   }
   
function loadBiohimiShowForm(bID)
   {
	   
	   $('#modalWait').openModal();
	   //var formData = $("#loginForm").serializeArray();
	   var dataString = 'biohimiID='+ bID; 
	  // alert(dataString);
    	$.ajax({
		  type: "POST",
		  url: "biohimiShowForm.php",
		  data: dataString,
		  cache: false,
		  success: function(html){
			 //alert(html);
			  $('#biohimiForm').html(html);
			 // toast(html, 4000);
			 // if(html=='success') window.location.href = 'index.php';
		  }
		});
		$('#modalWait').closeModal();
}
   </script>