<!DOCTYPE html>
<html>

<head>
	
<?php

  include ("../assets/php/config.php"); 


$dev_status = ($local)? "<span style=\"color: #000099;\">LOCAL</span>" : "<span style=\"color: #990000;\">LOCAL</span>" ;


?>

</head>

<body style=" ">

<h1 style="color: #009900; ">PUCKER MOB&nbsp;&mdash;&nbsp;<?php echo $dev_status?>&nbsp;&mdash;&nbsp;TEST PAGE</h1>





<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

<?php


// $smf_adManager = new smf_adManager;
// $article_id = 11237; //will come from the page


// echo $smf_adManager->display_tags("dsk_banner", $article_id);


$mystring = '123456_tall.jpg';
$findme   = '.jpg';
$pos = strpos($mystring, $findme);

if ($pos === false) {
    echo "The string '$findme' was not found in the string '$mystring'";
} else {
    echo "The string '$findme' was found in the string '$mystring'";
    echo " and exists at position $pos";
}
echo("<br/>POS = $pos <br/><br/>");
$mystring = 'undertone_Flex.php';
$findme   = '.php';
$pos = strpos($mystring, $findme);

// Note our use of ===.  Simply == would not work as expected
// because the position of 'a' was the 0th (first) character.
if ($pos === false) {
    echo "The string '$findme' was not found in the string '$mystring'";
} else {
    echo "The string '$findme' was found in the string '$mystring'";
    echo " and exists at position $pos";
}

echo("<br/>POS = $pos <br/><br/>");

$mystring = '';
$findme   = '.php';
$pos = strpos($mystring, $findme);

// Note our use of ===.  Simply == would not work as expected
// because the position of 'a' was the 0th (first) character.
if ($pos === false) {
    echo "The string '$findme' was not found in the string '$mystring'";
} else {
    echo "The string '$findme' was found in the string '$mystring'";
    echo " and exists at position $pos";
}

echo("<br/>POS = $pos <br/><br/>");

?>



<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>


<p>Please check out our <b>sister site</b></p>
<p><a href="http://www.puckermom.com/">Pucker MOM</a> It's not just about the kids</p>

</body>
</html>