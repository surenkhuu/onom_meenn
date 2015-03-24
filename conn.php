<?PHP
	
	/* Сервэр машин дээрх баазын тохиргоо */
	//$mysql_link=mysql_connect("localhost", "elegmxgg", "6^6DlPlCbDgS") or die("not connceted BD");
	//mysql_query("SET NAMES 'utf8'");
	//mysql_select_db("elegmxgg_hepatitis") or die("not connected ITZ baaz");

	/* Локал машин дээрх баазын тохиргоо */
	error_reporting(E_ALL ^ E_DEPRECATED);
	//error_reporting = E_ALL ^ E_DEPRECATED
	mysql_connect('localhost','root','root');
	mysql_query("SET NAMES 'utf8'");
	mysql_select_db("onomcom_meenn");
?>