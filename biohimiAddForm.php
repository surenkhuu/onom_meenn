<?php
session_start();
include 'conn.php';
?>

<?php
//if(ISSET($_GET['id']))

	$id=13;
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
    
    	<div class="card-content">
        
        <span class="card-title black-text">Биохимийн шинжилгээ оруулах</span>
        
        
        
<div class="row">
<div class="col s12" style="">
<form name="formBiohimi" id="formBiohimi" method="post" ENCTYPE="multipart/form-data">

	<div class="input-field col s1" style="text-align:right">
	<label>Огноо:</label>
	</div>

	<div class="input-field col s4">
    <i class="mdi-action-event prefix"></i>
	<input id="date" type="date" class="datepicker"  name="date">
	</div>
    
    <div class="input-field col s7">
		<i class="mdi-communication-business prefix"></i>
		<input id="address" type="text" class="validate" name="address">
		<label for="address">Шинжилгээ хийлгэсэн газар</label>
	</div>
    
    <div class="input-field col s12">
    <a class="waves-effect waves-light btn blue-grey lighten-3 black-text right" href="javascript:ajaxAddBiohimi();">
    <i class="mdi-content-add-circle-outline left"></i>Нэмэх</a>
    </div>
  
        
        
	<div class="col s12">            
      <table class="bordered" id="bioTable">
        <thead class="blue-grey lighten-3">
          <tr>
              <th data-field="id">Биохимийн шинжилгээ</th>
              <th data-field="name">Хэвийн хэмжээ</th>
              <th data-field="price">Таны шинжилгээ</th>
          </tr>
        </thead>

        <tbody>
          <tr>
            <td>Нийт билирубин</td>
            <td><?php echo getConstant_Biohimi('niiit_bilirubin');?></td>
            <td><input type="text" name="b1" class="defInput"/></td>
          </tr>
          
          <tr>
            <td>Шууд билирубин</td>
            <td><?php echo getConstant_Biohimi('shuud_bilirubin');?></td>
            <td><input type="text" name="b2"/></td>
          </tr>
          
          <tr>
            <td>Холестерин</td>
            <td><?php echo getConstant_Biohimi('holestrin');?></td>
            <td><input type="text" name="b3"/></td>
          </tr>
          
          <tr>
            <td>Шүлтлэг фосфотаза</td>
            <td><?php echo getConstant_Biohimi('shultleg_fosfotaz');?></td>
            <td><input type="text" name="b4"/></td>
          </tr>
          
          <tr>
            <td>Нийт уураг</td>
            <td><?php echo getConstant_Biohimi('niit_uurag');?></td>
            <td><input type="text" name="b5"/></td>
          </tr>
          
          <tr>
            <td>альбумин</td>
            <td><?php echo getConstant_Biohimi('alibumin');?></td>
            <td><input type="text" name="b6"/></td>
          </tr>
          
          <tr>
            <td>AST (GOT)</td>
            <td><?php echo getConstant_Biohimi('AST');?></td>
            <td><input type="text" name="b7"/></td>
          </tr>
          
          <tr>
            <td>ALT (GPT)</td>
            <td><?php echo getConstant_Biohimi('ALT');?></td>
            <td><input type="text" name="b8"/></td>
          </tr>
          
          <tr>
            <td>GGT</td>
            <td><?php echo getConstant_Biohimi('GGT');?></td>
            <td><input type="text" name="b9"/></td>
          </tr>
          
          <tr>
            <td>Глюкоз</td>
            <td><?php echo getConstant_Biohimi('glukoz');?></td>
            <td><input type="text" name="b10"/></td>
          </tr>
          
          <tr>
            <td>Креатинин</td>
            <td><?php echo getConstant_Biohimi('kreatinin');?></td>
            <td><input type="text" name="b11"/></td>
          </tr>
          
          <tr>
            <td>Шээсний хүчил</td>
            <td><?php echo getConstant_Biohimi('sheesnii_huchil');?></td>
            <td><input type="text" name="b12"/></td>
          </tr>
          
          <tr>
            <td>Фосфор</td>
            <td><?php echo getConstant_Biohimi('fosfor');?></td>
            <td><input type="text" name="b13"/></td>
          </tr>
          
          <tr>
            <td>Кальци</td>
            <td><?php echo getConstant_Biohimi('kaltsi');?></td>
            <td><input type="text" name="b14"/></td>
          </tr>
          
          <tr>
            <td>Төмөр</td>
            <td><?php echo getConstant_Biohimi('tumur');?></td>
            <td><input type="text" name="b15"/></td>
          </tr>
          
        </tbody>
      </table></div>
      </form>
 </div></div>         

</div>




    </div> <!--END CARD-->   
</div><!--END ROW-->



<script>

function ajaxAddBiohimi()
{   
	//$("#loadGif").css('display','block');
	$('#modal1').openModal();
	
	var formData = $("#formBiohimi").serializeArray();
	// alert(formData);
    $.ajax({
		  type: "POST",
		  url: "ajaxBiohimiAdd.php",
		  data: formData,
		  cache: false,
		  success: function(html){
			 // alert(html);
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
					toast(element.msg, 1000);
				}
				if(element.type=='success')
				{
					toast(element.msg, 10000);
					loadInfo('biohimi');
					//$('#modalSuccess').openModal();
				}
				
			  });
			 
		  	$('#modal1').closeModal();  
		  }
		});
}


  $('.datepicker').pickadate('yyyy-mm-dd');
        
		</script>