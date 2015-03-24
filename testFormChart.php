<?php
include('ajaxAPI.php');

echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
// include("pChart/class/pData.class.php");
// include("pChart/class/pDraw.class.php");
// include("pChart/class/pImage.class.php"); 
 
 
  include("pChart/class/pData.class.php");
 include("pChart/class/pDraw.class.php");
 include("pChart/class/pImage.class.php"); 

if($_SESSION['login']=='Y')
{

$cityid=0;
$fieldArray = array(); $rowArray = array();


if(isset($_POST['tablename']) && isset($_POST['ubchtunid']))
{
	$tablename=$_POST['tablename']; $ubchtunid=$_POST['ubchtunid']; 
	$userimg='';
	

	$sql="SELECT * FROM sh_table where `shtablename`='".$tablename."';";
	//Field 	Type 	Null 	Key 	Default 	Extra 
	//id 	   int(11)	NO 	    PRI 	NULL	    auto_increment
	$result=mysql_query($sql);
	
	WHILE($row = MYSQL_FETCH_ARRAY($result))
	{
		$fieldArray[] = $row;
	}
	$arrlength=count($fieldArray);
	
	
	
	
	
	

	$s2="SELECT * FROM `".$tablename."` where `ubchtunid`=".$ubchtunid.";";
	$r2=mysql_query($s2);
	WHILE($row2 = MYSQL_FETCH_ARRAY($r2))
	{
		$rowArray[] = $row2;
	}
	 $arrRowlength=count($rowArray);
	 
	 
	 
if($arrRowlength>0)
	{
		
	$MyData = new pData();  	
		
		$a2 = array();
	for($y=0;$y<$arrlength;$y++)
	{	
		if($fieldArray[$y]['chartvisit']=='Y')
		{
			$a1 = array(); $a2 = array();
			for($x=0;$x<$arrRowlength;$x++)
			{
				$a1[]=$rowArray[$x][$fieldArray[$y]['field']];
				$a2[]=$rowArray[$x]['date'];
			}
			if(count($a1)>0)
			$MyData->addPoints($a1,$fieldArray[$y]['title']); 
		}
	}
	

 
 $MyData->setSerieWeight("Probe 1",2);
 $MyData->setSerieTicks("Probe 2",4);
 $MyData->setAxisName(0,"Үзүүлэлт");
 $MyData->addPoints($a2,"Labels");
 $MyData->setSerieDescription("Labels","Months");
 $MyData->setAbscissa("Labels");

 /* Create the pChart object */
 $myPicture = new pImage(700,400,$MyData);

 /* Turn of Antialiasing */
 $myPicture->Antialias = FALSE;

 /* Draw the background */
 $Settings = array("R"=>170, "G"=>183, "B"=>87, "Dash"=>1, "DashR"=>190, "DashG"=>203, "DashB"=>107);
 $myPicture->drawFilledRectangle(0,0,700,400,$Settings);

 /* Overlay with a gradient */
 $Settings = array("StartR"=>219, "StartG"=>231, "StartB"=>139, "EndR"=>1, "EndG"=>138, "EndB"=>68, "Alpha"=>50);
 $myPicture->drawGradientArea(0,0,700,400,DIRECTION_VERTICAL,$Settings);


 /* Set the default font */
 $myPicture->setFontProperties(array("FontName"=>"pChart/fonts/verdana.ttf","FontSize"=>8,"R"=>0,"G"=>0,"B"=>0));

 /* Define the chart area */
 $myPicture->setGraphArea(200,40,650,360);
// $myPicture->setGraphArea(111,50,536,190);

 /* Draw the scale */
 $scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
 $myPicture->drawScale($scaleSettings);


 /* Draw the line chart */
 $myPicture->drawLineChart();
 $myPicture->drawPlotChart(array("DisplayValues"=>TRUE,"PlotBorder"=>TRUE,"BorderSize"=>2,"Surrounding"=>-60,"BorderAlpha"=>80));

 /* Write the chart legend */
$Config = array("FontR"=>0, "FontG"=>0, "FontB"=>0, "FontName"=>"pChart/fonts/verdana.ttf", "FontSize"=>8, "Margin"=>10, "Alpha"=>30, "BoxSize"=>7, "Style"=>LEGEND_ROUND
, "Mode"=>LEGEND_VERTICAL
);
$myPicture->drawLegend(20,30,$Config);
$myPicture->Render("pictures/1.png");
  
  
  
	$sql="SELECT * FROM `menu` where 
		`tname`='".$tablename."';";
	if($result=mysql_query($sql))
	{
		WHILE($row = MYSQL_FETCH_ARRAY($result))
		{
			//echo '<div class="card-image"><img src="image/r1.png">';
			echo '<div>'.$row['title'].' </div>';
			//echo '</div>';
		}
	}
	
	?>
    
   <table width="100%">
   <tr>
   <td style="vertical-align:top;">
   <?php
   echo '<ul class="leftMenu" style="width:200px">';
   for($y=0;$y<$arrlength;$y++)
	{	
	
		if($fieldArray[$y]['chartvisit']=='Y')
		{
			
			echo '<li><a href="">';
			echo '<div><i class="mdi-action-account-box left"></i>'.$fieldArray[$y]['title'].'</div></a>';
			echo '</li>';
			
		}
	}
	echo '</ul>';
	
   ?>
   </td>
    
   <td style="vertical-align:top;">
    <?php
		
	  echo '<img src="pictures/1.png?'.time().'" />'; 
	?>
    </td>
    </tr></table>








<?php



		}//end if array count



}//end if post
}//end if login
?>