<?php
include('ajaxAPI.php');

if($_SESSION['login']=='Y')
{
	$tablename='ubchtun_main';
	$id=$_SESSION['userid'];
		$systemcode='';
		$userimg='';
		$lastname='';
		$firstname='';
		$rd='';
		$gender='';
		$birthday='';
		$phone='';
		$mobile='';
		$email='';
		$cityid=0;
		$districtid=0;
		$address='';
		$description='';
		$reguser='';
		$regdate=date("Y-m-d H:i:s");
		

	$sqlD="SELECT t1.*, t2.title as city, t3.title as district, t4.avator
		FROM ubchtun_main t1 
		LEFT JOIN city t2 ON t1.cityid = t2.id 
		LEFT JOIN district t3 ON t1.districtid = t3.id 
		LEFT JOIN ubchtun_main_avator t4 ON t1.id = t4.uid 
		where t1.id='".$id."'";
		
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
	}


//$cityid=0;
?>


<!-- Page Layout here -->
<div class="row">
	<div class="card" id="loginDiv">
		<div class="card-image">
		<img src="image/r1.png">
		<span class="card-title black-text" style="font-size:34px; padding-left:30px;">Өвчтөний дэлгэрэнгүй мэдээлэл
        <?php
		
				echo '<a title="Засах"
				href="javascript:testFormEditor(\''.$tablename.'\','.$id.');">';
				echo '<i class="mdi-action-settings" style="color:#43b4fb;font-size:18px;"></i>';
				echo '</a>';
				
		?>
        
        </span>
		</div>
        
        
        
        <div class="row" style="padding-left:20px; padding-right:20px; padding-top:0px;">
       
       	<div class="col s3">
       		<div><label>Овог/нэр:</label><br /><?php echo $lastname.'/'.$firstname;?></div>
        	<div><label>Төрсөн огноо:</label><br /><?php echo $birthday;?></div>
        	<div><label>Гар утас:</label><br /><?php echo $mobile;?></div>
        </div>
        
        <div class="col s3">
       	<div><label>Регистерийн дугаар:</label><br /><?php echo $rd;?></div>
        <div><label>Хүйс:</label><br /><?php echo $gender;?></div>
        <div><label>И-майл:</label><br /><?php echo $email;?></div>
        </div>
        
        <div class="col s4">
       	<img class="circle responsive-img" src="image/avator.png" id="imgAvator" width="100">
        </div>
        
        <div class="col s12">
        <div><label>Хаяг:</label><br /><?php echo $city.'/'.$district.' '.$address;?></div>
        </div>
        
        
        </div>
        
  		
	</div> <!--END CARD-->   
     
  
  
  
  <div class="card" id="loginDiv" style="background:#FFF;">
		<div class="card-image">
		<img src="image/r1.png">
		<span class="card-title black-text" style="font-size:34px; padding-left:30px;">Шинжилгээ эмчилгээний явц</span>
		</div>
  
 <?php
 $usergroupid=4;
$sqlMenugroup="SELECT * FROM `menugroup` where 
`menutype`='".$tablename."' 
ORDER BY `sortid` ASC;";
	$resultMenugroup=mysql_query($sqlMenugroup);
	$tabContent='';
	echo '<div class="row">';
	echo '<div class="col s12">';
    echo '<ul class="tabs">';
	WHILE($rowMenugroup = MYSQL_FETCH_ARRAY($resultMenugroup))
	{
		//$tabContent='';
		echo '<li class="tab col s3" id="tabli'.$rowMenugroup['id'].'"><a href="#tab'.$rowMenugroup['id'].'">'.$rowMenugroup['title'].'</a></li>';
		$js='';
		$tabContent.='<div id="tab'.$rowMenugroup['id'].'" class="col s12">';
		$ss="SELECT * FROM `menu` where 
		`menugroupid`=".$rowMenugroup['id'].";";
		$rr=mysql_query($ss);
		
		WHILE($rowTab = MYSQL_FETCH_ARRAY($rr))
		{
			$tabContent.='<div class="card-content black-text" id="ubSection">';
			$tabContent.='<div class="ubSectionTitle">'.$rowTab['title'].' ';
			
			
			if(substr($rowTab['tname'],0,3)=='sh_')
			{
			$tabContent.=' <button class="waves-effect waves-green btn-flat modal-action" type="button" id="btnAddForm" 
			onclick="javascript:testFormChart(\''.$rowTab['tname'].'\','.$id.');"><i class="mdi-editor-insert-chart left"></i>Chart</button>';
			
			$tabContent.='<button class="waves-effect waves-green btn-flat modal-action" type="button"  
			onclick="javascript:addSh_Table(\''.$rowTab['tname'].'\','.$id.');">Нэмэх<i class="mdi-content-add left"></i></button>';
			}
			
			
			
			
			$tabContent.='</div>';
			
			$sql="SELECT * FROM `".$rowTab['tname']."` where `ubchtunid`='".$id."';";		
			
			
			$fieldArrayDDD = array();
			$sqlDDD="SELECT * FROM sh_table where `shtablename`='".$rowTab['tname']."' ORDER BY `sortid` ASC;";
			$resultDDD=mysql_query($sqlDDD);
			WHILE($rowDDD = MYSQL_FETCH_ARRAY($resultDDD))
			{
				$fieldArrayDDD[] = $rowDDD;
			}
			$arrlengthDDD=0;
			$arrlengthDDD=count($fieldArrayDDD);
			
			
			
			
			
			//echo $sql;
			$result=mysql_query($sql);
			$tabContent.='<div class="divTable">';
			$iif=0;
			WHILE($Row = MYSQL_FETCH_ARRAY($result))
			{
				//$tabContent.= '<div style="width:100px; display:inline-table;border:solid 1px;">';
				
			    //substr($f,0,2)
				if(substr($rowTab['tname'],0,3)=='sh_')
				{
					$tabContent.= '<div class="divTableDet">';
					$tabContent.='<a href="javascript:testFormVisitorSH(\''.$rowTab['tname'].'\','.$Row['id'].');">';
					$tabContent.= '<div class="divTableImg"><i class="mdi-action-invert-colors"></i></div>';
					$tabContent.= '<div class="divTableText">'.$Row['date'].'</div>';
					$tabContent.= '</a>';
					
					$tabContent.= '</div>';
				}
				
				
				if(substr($rowTab['tname'],0,3)=='em_')
				{
					$tabContent.= '<div class="divTableDetEm">';
					$tabContent.= '<table width="100%" class="bordered" id="bioTable">';
					$tabContent.= '<thead class="grey lighten-5">'; 
					$tabContent.= '<tr><th colspan="2">['.$Row['regdate'].'] '.$Row['title'];
					
					$tabContent.= '<th></tr>';
					$tabContent.= '</thead>'; 
					
					for($x=0;$x<$arrlengthDDD;$x++)
					{
						if ($fieldArrayDDD[$x]['listvisit']=='Y')
						{
							$tabContent.= '<tr>'; $tabContent.= '<td style="width:150px;">'.$fieldArrayDDD[$x]['title'].'</td>';
							$tabContent.= '<td>'.$Row[$fieldArrayDDD[$x]['field']].'</td>';
							$tabContent.= '</tr>';
						}
						
					}
				
					$tabContent.= '</table><br>';
					
					
					$tabContent.= '</div>';
				}
					
			
				$iif++;
			}
			if($iif==0) $tabContent.= '<label>Одоогоор '.$rowTab['title'].' хэсэгт мэдээлэл байхгүй байна.</label>';
			
			$tabContent.='</div>';
			$tabContent.='</div>';
		
		
			
			
			
		}
		$tabContent.='</div>';
	}
	echo '</ul></div>';

	echo $tabContent;

echo '</div>';

?> 
  	</div> <!--END CARD-->   
  
   

</div><!--END ROW-->  
  




        

 <!-- Modal Edito -->
	<div id="modalEditor" class="modal"> 
    </div><!--END MODAL -->

  
	<div id="modalChart" class="modal" style="width: 940px; padding:20px 20px 15px 20px;"> 
    </div><!--END MODAL -->
    
    
  
  
  
<div id="divCamera" title="camera" class="modal">
</div>
  

    
<script> 
$('ul.tabs').tabs();   

function addSh_Table(tablename, ubchtunid)
{
	$.ajax({
		  type: "POST",
		  url: "testFormAddSH.php",
		  data: "tablename="+tablename+"&ubchtunid="+ubchtunid,
		  cache: false,
		  success: function(html){
			 $('#modalWait').closeModal();
			 $('#modalEditor').openModal();
			$('#modalEditor').html(html);	 	  	
		  }
		});
}


function addEM_Table(tablename, ubchtunid)
{
	$.ajax({
		  type: "POST",
		  url: "testFormAddEM.php",
		  data: "tablename="+tablename+"&ubchtunid="+ubchtunid,
		  cache: false,
		  success: function(html){
			 $('#modalWait').closeModal();
			 $('#modalEditor').openModal();
			$('#modalEditor').html(html);	
			
			
			 	  	
		  }
		});
}

function testFormVisitorSH(tablename,id)
{
	//$('#modalWait').openModal();
	
	//$('#modalEditor').openModal();
//	$('#modalEditor').html('<h4>Modal Header</h4><div class="progress"><div class="indeterminate"></div></div><p>A bunch of text</p>')
	
	$.ajax({
		  type: "POST",
		  url: "testFormVisitorSH.php",
		  data: "tablename="+tablename+"&id="+id,
		  cache: false,
		  success: function(html){
			// $('#modalWait').closeModal();
			 $('#modalEditor').openModal();
			 $('#modalEditor').html(html)
			
			   	
		  }
		});
}

function testFormChart(tablename,ubchtunid)
{
	//$('#modalWait').openModal();
	
	//$('#modalEditor').openModal();
//	$('#modalEditor').html('<h4>Modal Header</h4><div class="progress"><div class="indeterminate"></div></div><p>A bunch of text</p>')
	
	$.ajax({
		  type: "POST",
		  url: "testFormChart.php",
		  data: "tablename="+tablename+"&ubchtunid="+ubchtunid,
		  cache: false,
		  success: function(html){
			// $('#modalWait').closeModal();
			 $('#modalChart').openModal();
			 $('#modalChart').html(html)
			
			   	
		  }
		});
}


</script>

<?php
}
?>