<?php
session_start();
error_reporting(0);
$change="";
$errors=0;

define ("MAX_SIZE","5000");

function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
}
 
if($_SESSION['login']=='Y')
{
	
	$errors=0;
	$uploadedfile = $_FILES['uploadfile']['tmp_name'];      
   	$filename = stripslashes($_FILES['uploadfile']['name']);
 	
 	$extension = getExtension($filename);
	
	
 	$extension = strtolower($extension);
 	$size=filesize($_FILES['uploadfile']['tmp_name']);
	
	if ($size > MAX_SIZE*1024)
	{   $errors=1;
	}
	
		         
    if($extension=="jpg" || $extension=="jpeg" || $extension=="JPG")
	{
		$uploadedfile = $_FILES['uploadfile']['tmp_name'];
		$src = imagecreatefromjpeg($uploadedfile);
	}
	else if($extension=="png")
	{
		$uploadedfile = $_FILES['uploadfile']['tmp_name'];
		$src = imagecreatefrompng($uploadedfile);
		
			
		
	}
	else 
	{   $errors=2;
		//$src = imagecreatefromgif($uploadedfile);
	}
	
	
	if($errors==0)
	{
			
		list($width,$height)=getimagesize($uploadedfile);
		//echo 'rrr'.$image_data; 
		$image_data=file_get_contents($_FILES['uploadfile']['tmp_name']);
		//echo 'rrr'.$image_data; 
		$encoded_image=base64_encode($image_data);
		//echo 'data:image/'.$extension.';base64,'.$encoded_image;
		echo $encoded_image;
	}
	else
	{
		echo $errors;
	}
}
?>
