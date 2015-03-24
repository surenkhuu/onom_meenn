<?PHP
session_start();
global $PHP_SELF;
include 'conn.php';

	if(ISSET($_GET['cityid']))
	{
				
    $sqlCombo="SELECT * FROM district where city_id=".$_GET['cityid'];
    $resultCombo=mysql_query($sqlCombo);
   // echo '<select id="selectDistrict" name="districtid" class="browser-default">'; 
	echo '<select id="selectDistrict" name="districtid" onchange="javascript:setKhoroo('.$_GET['cityid'].',this.value)" class="browser-default">'; 
 
    echo '<option value=""></option>';	
    WHILE($RowCombo = MYSQL_FETCH_ARRAY($resultCombo))
    {
    $vv='';
   // if($RowCombo['id']==$city) $vv='selected=selected';
    echo '<option value="'.$RowCombo['id'].'" '.$vv.'>'.$RowCombo['title'].'</option>';	
    }
    echo ' </select>';
   
					
					
					
					
							
	}
?>