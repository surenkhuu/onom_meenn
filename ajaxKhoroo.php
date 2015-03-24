<?PHP
session_start();
global $PHP_SELF;
include 'conn.php';

	if(ISSET($_GET['cityid']) && ISSET($_GET['districtid']))
	{
				
    $sqlCombo="SELECT * FROM khoroo where city_id=".$_GET['cityid']." and district_id=".$_GET['districtid'];
	
	//echo $sqlCombo;
    $resultCombo=mysql_query($sqlCombo);
    echo '<select id="khorooid" name="khorooid" class="browser-default">'; 
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