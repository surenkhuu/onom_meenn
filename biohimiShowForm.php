<?php
session_start();

include 'conn.php';
?>

<?php
	$biohimiID=0;
    if(ISSET($_POST['biohimiID'])) {$biohimiID=$_POST['biohimiID'];}

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
	
	
	
	
	$date='';
	$address='';
	
	  $b1=''; /*niit bilirubin*/
	  $b2=''; /*mes zasal*/
	  $b3=''; /*hepatit A*/
	  $b4=''; /*hepatit B*/
	  $b5=''; /*hepatit C*/
	  $b6=''; /*bambai bulchirhai*/
	  $b7=''; /*zurhnii uvchin*/
	  $b8=''; /*zurhnii bagtraa*/
	  $b9=''; /*guursan hooloin bargtraa*/
	  $b10=''; /*suriee*/
	  $b11=''; /*tsusnii daralt*/
	  $b12=''; /*chihriin shijin*/
	  $b13=''; /*emfizema/cord*/
	  $b14=''; /*boornii ovchin*/
	  $b15=''; /*DOX*/
	  $reguser='';
	  $regdate=date("Y-m-d H:i:s");
	  
	  
	  $sqlD="SELECT * FROM sh_biohimi t1 where id='".$biohimiID."'";
	$resultD=mysql_query($sqlD);
	
	WHILE($RowD = MYSQL_FETCH_ARRAY($resultD))
	{
		  $b1=$RowD['niiit_bilirubin']; /*niit bilirubin*/
		  $b2=$RowD['shuud_bilirubin']; /*mes zasal*/
		  $b3=$RowD['holestrin']; /*hepatit A*/
		  $b4=$RowD['shultleg_fosfotaz']; /*hepatit B*/
		  $b5=$RowD['niit_uurag']; /*hepatit C*/
		  $b6=$RowD['alibumin']; /*bambai bulchirhai*/
		  $b7=$RowD['AST']; /*zurhnii uvchin*/
		  $b8=$RowD['ALT']; /*zurhnii bagtraa*/
		  $b9=$RowD['GGT']; /*guursan hooloin bargtraa*/
		  $b10=$RowD['glukoz']; /*suriee*/
		  $b11=$RowD['kreatinin']; /*tsusnii daralt*/
		  $b12=$RowD['sheesnii_huchil']; /*chihriin shijin*/
		  $b13=$RowD['fosfor']; /*emfizema/cord*/
		  $b14=$RowD['kaltsi']; /*boornii ovchin*/
		  $b15=$RowD['tumur']; /*DOX*/
		  $address=$RowD['title'];
		  $regdate=$RowD['date'];
	}
?>



<!-- Page Layout here -->
<div class="row">
	<div class="card" id="loginDiv">
    
    	<div class="card-content">
        
        <span class="card-title black-text">Биохимийн шинжилгээ [<?php echo $regdate;?>]</span>
        
        
        
<div class="row">
<div class="col s12" style="">

	<div class="col s3">
    <label><i class="mdi-action-event prefix"></i>Огноо:</label><br />
	<?php echo $regdate;?>
	</div>
    
    <div class="icol s9">
	<label for="address"><i class="mdi-communication-business prefix"></i>Шинжилгээ хийлгэсэн газар</label><br />
    <?php echo $address;?>
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
            <td><?php echo $b1;?></td>
          </tr>
          
          <tr>
            <td>Шууд билирубин</td>
            <td><?php echo getConstant_Biohimi('shuud_bilirubin');?></td>
            <td><?php echo $b2;?></td>
          </tr>
          
          <tr>
            <td>Холестерин</td>
            <td><?php echo getConstant_Biohimi('holestrin');?></td>
            <td><?php echo $b3;?></td>
          </tr>
          
          <tr>
            <td>Шүлтлэг фосфотаза</td>
            <td><?php echo getConstant_Biohimi('shultleg_fosfotaz');?></td>
            <td><?php echo $b4;?></td>
          </tr>
          
          <tr>
            <td>Нийт уураг</td>
            <td><?php echo getConstant_Biohimi('niit_uurag');?></td>
            <td><?php echo $b5;?></td>
          </tr>
          
          <tr>
            <td>альбумин</td>
            <td><?php echo getConstant_Biohimi('alibumin');?></td>
            <td><?php echo $b6;?></td>
          </tr>
          
          <tr>
            <td>AST (GOT)</td>
            <td><?php echo getConstant_Biohimi('AST');?></td>
            <td><?php echo $b7;?></td>
          </tr>
          
          <tr>
            <td>ALT (GPT)</td>
            <td><?php echo getConstant_Biohimi('ALT');?></td>
            <td><?php echo $b8;?></td>
          </tr>
          
          <tr>
            <td>GGT</td>
            <td><?php echo getConstant_Biohimi('GGT');?></td>
            <td><?php echo $b9;?></td>
          </tr>
          
          <tr>
            <td>Глюкоз</td>
            <td><?php echo getConstant_Biohimi('glukoz');?></td>
            <td><?php echo $b10;?></td>
          </tr>
          
          <tr>
            <td>Креатинин</td>
            <td><?php echo getConstant_Biohimi('kreatinin');?></td>
            <td><?php echo $b11;?></td>
          </tr>
          
          <tr>
            <td>Шээсний хүчил</td>
            <td><?php echo getConstant_Biohimi('sheesnii_huchil');?></td>
            <td><?php echo $b12;?></td>
          </tr>
          
          <tr>
            <td>Фосфор</td>
            <td><?php echo getConstant_Biohimi('fosfor');?></td>
            <td><?php echo $b13;?></td>
          </tr>
          
          <tr>
            <td>Кальци</td>
            <td><?php echo getConstant_Biohimi('kaltsi');?></td>
            <td><?php echo $b14;?></td>
          </tr>
          
          <tr>
            <td>Төмөр</td>
            <td><?php echo getConstant_Biohimi('tumur');?></td>
            <td><?php echo $b15;?></td>
          </tr>
          
        </tbody>
      </table></div>
    
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
			  alert(html);
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