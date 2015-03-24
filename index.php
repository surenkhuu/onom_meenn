<?php
session_start();
include 'conn.php';
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

function mbm_sql_quote( $value )
{
	if( get_magic_quotes_gpc() )
	{
	$value = stripslashes( $value );
	}
	//check if this function exists
	if( function_exists( "mysql_real_escape_string" ) )
	{
	$value = mysql_real_escape_string( $value );
	}
	//for PHP version < 4.3.0 use addslashes
	else
	{
	$value = addslashes( $value );
	}
	$value=mbmCleanUpHTML($value);
	return $value;
}

function mbmCleanUpHTML($comment){
        
        $search = array ('@<script[^>]*?>.*?</script>@si', // javascript -� �����
                    '@<[\/\!]*?[^<>]*?>@si',          // HTML ��� ����� �����
                    '@([\r\n])[\s]+@',                // ������ ���� �����
                    '@&(quot|#34);@i',                // HTML �������??���� �����
                    '@&(amp|#38);@i',
                    '@&(lt|#60);@i',
                    '@&(gt|#62);@i',
                    '@&(nbsp|#160);@i',
                    '@&(iexcl|#161);@i',
                    '@&(cent|#162);@i',
                    '@&(pound|#163);@i',
                    '@&(copy|#169);@i',
                    '@&#(\d+);@e');                    
    
        $replace = array (' ',
                         ' ',
                         '\1 ',
                         '" ',
                         '& ',
                         '< ',
                         '> ',
                         '  ',
                         chr(161).' ',
                         chr(162).' ',
                         chr(163).' ',
                         chr(169).' ',
                         'chr(\1) ');
        
        $comment = preg_replace($search, $replace, $comment);
        return $comment;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN">
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Эрүүл элэг</title>
    
    <!-- CSS-->
    <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="css/css.css" type="text/css" rel="stylesheet" media="screen,projection">
    
  </head>


<?php
$bodyStyle='';
if(!isset($_SESSION['login'])) $_SESSION['login']='';

if($_SESSION['login']!='Y')
{
	$bodyStyle='background:url(image/bg.png) no-repeat center bottom;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;';
}
?>   


  <body <?php echo 'style="'.$bodyStyle.'"';?>>
    <!--   -->
    
 




 




<nav class="blue-grey darken-1" role="navigation" style="background:url(image/noise.png);">
  <div class="nav-wrapper">
    <div class="container">
      <a href="index.php" class="brand-logo"><img src="image/logo.png" / width="100" style="margin-top:5px; background:#FFF; padding:5px;"></a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="#"><i class="mdi-action-home left"></i>Нүүр хуудас</a></li>
        <li><a href="http://eleg.mn" target="_blank"><i class="mdi-social-group left"></i>Зөвөлгөө</a></li>
        <li><a href="javascript:showHelp('login');"><i class="mdi-action-help left"></i>Тусламж</a></li>
        <?php
		if($_SESSION['login']=='Y')
		{ ?>
        <li>
         <form name="form" id="form" method="post" ENCTYPE="multipart/form-data">
        <input type="submit" name="btnExit" value="Гарах" class="black-text">
		</form></li>
        <?php } ?>
       
      </ul>
    </div>
 
  
 
  </div> 
</nav>
        
        
        
        
        
        
<div class="container"  style="border: solid 0px; height:80%; padding-top:10px;"> 
    
<?php
if(isset($_GET['page']))
{
	if($_SESSION['login']!='Y')
	{
		if($_GET['page']=='login') include('loginForm.php');
		if($_GET['page']=='register') include('registerForm.php');
		if($_GET['page']=='restore') include('passRestore.php');
		
	}
	
}

if($_SESSION['login']=='Y')
{
	
	include('main.php');
	
}
else
{
	if(!isset($_GET['page']))
		include('loginForm.php');
	
}

?>
    
    
   
    
          
</div><!--END CONTINER-->
        
        
        
        
        
  
        
   
<!-- Modal Wait -->
<div id="modalWait" class="modal" style="padding: 5px 25px 0 25px; width:400px;">
		<h5>Түр хүлээнэ үү!</h5>
		<div class="progress"><div class="indeterminate"></div></div>
 		<p>Мэдээллийг шалгаж байна</p>
		<div class="modal-footer">
		<a href="#" class="waves-effect waves-green btn-flat modal-action modal-close">close</a>
		</div>
</div>      
        
       

   
        
<!-- Modal Help -->
<div id="modalHelp" class="modal"  style="padding: 5px 25px 0 25px;">

<div class="row">
<h5><i class="mdi-communication-live-help left"></i>Системийн танилцуулга.</h5>

<a class="btn-floating btn-large waves-effect waves-light  blue lighten-2 tooltipped" data-position="bottom" data-tooltip="Системд бүртгүүлэх"
href="javascript:showHelp('register',2);">
<i class="mdi-social-person-add"></i></a>

<a class="btn-floating btn-large waves-effect waves-light  blue lighten-2 tooltipped" data-position="bottom" data-tooltip="Системд нэвтрэх"
href="javascript:showHelp('login',2);">
<i class="mdi-action-verified-user"></i></a>

<a class="btn-floating btn-large waves-effect waves-light  blue lighten-2 tooltipped" data-position="bottom" data-tooltip="Нууц үг мартсан"
href="javascript:showHelp('register',2);">
<i class="mdi-communication-vpn-key"></i></a>  


        
<div id="helpMain"></div></div>
<div class="modal-footer"><a href="#" class="waves-effect waves-green btn-flat modal-action modal-close">close</a></div>
</div><!-- END Modal Help -->    
        
        
        
        
        
     
  

    <!--  Scripts
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>-->
	<script src="js/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
     <script src="js/ajaxupload.3.5.js"></script> 
    
    
    <script type="text/javascript" src="camera2/photobooth_min.js"></script>
	<link rel="stylesheet" type="text/css" href="camera2/camera_css.css" />
	<script src="js/jquery.inputmask.bundle.min.js"></script>

    
    
    <script>
	 $(".button-collapse").sideNav({edge: 'right'});
	//$("#birthday").inputmask('Regex', { regex: "[0-9]{4}-[0-9]{2}-[0-9]{2}" });


$("#rd").change(function(){ 
var uRD=   $("#rd").val();    
	f_rd = /[А-Яа-яӨөҮү]{2}[0-9]{8}/;
	if(checkFilter(f_rd,'#rd'))
	{
		if(uRD.substring(8,9) % 2) { $("#er").prop("checked", true);}
		else $("#em").prop("checked", true);
		
		if(uRD.substring(2,4)>19) 
		{
			var $input = $('#birthday').pickadate();
			var picker = $input.pickadate('picker');
			picker.set('select', '19'+uRD.substring(2,4)+'-'+uRD.substring(4,6)+'-'+uRD.substring(6,8));
		}
	}
	else
	{
		//toast('<span style=" background:#fff;">Регистерийн дугаар буруу</span>', 3000, 'rounded');
	}
	
});


	
$(document).ready(function(){
	$('.datepicker').pickadate({
	monthsFull:  ['1-р сар', '2-р сар', '3-р сар', '4-р сар', '5-р сар', '6-р сар', '7-р сар', '8-р сар', '9-р сар', '10-р сар', '11-р сар', '12-р сар'],
	monthsShort: ['1-р сар', '2-р сар', '3-р сар', '4-р сар', '5-р сар', '6-р сар', '7-р сар', '8-р сар', '9-р сар', '10-р сар', '11-р сар', '12-р сар'],
 	weekdaysShort: ['Ням', 'Дав', 'Мяг', 'Лха', 'Пүр', 'Баа', 'Бям'],
	weekdaysFull: ['Няz', 'Даваа', 'Мягмар', 'Лхагва', 'Пүрэв', 'Баасан', 'Бямба'],
 showWeekdaysShort: true,
 
   format: 'yyyy-mm-dd',
  formatSubmit: 'yyyy-mm-dd',
  hiddenName: true,
    selectYears: 80,
	max: ['today'],
	closeOnSelect: true,
  closeOnClear: true ,
  today: 'Өнөөдөр',
clear: 'Арилгах',
close: 'Хаах',
// Creates a dropdown of 15 years to control year
  }); 
//$(".dropdown-button").dropdown();
//$('select').material_select();
$('.modal-trigger').leanModal();

//toast('I am a toast!', 3000, 'rounded','left');

});



function showHelp(page,s)
	{
				   if(s!=2) $('#modalHelp').openModal();
				   $('#helpMain').html('<div class="progress"><div class="indeterminate"></div></div>');
				   var formData = $("#restoreFormPhone").serializeArray();
				   // alert(formData);
					$.ajax({
					  type: "GET",
					  url: "help/"+page+".html",
					  data: "",
					  cache: false,
					  success: function(html){ //alert(html);
						 $('#helpMain').html(html);
					  }
					});
					//$('#modalWait').closeModal();
				}
	</script>

  </body>
</html>