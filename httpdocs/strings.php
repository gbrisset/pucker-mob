<?php /*
$my_string = "This is a string to look into";
$reverse = "";
for($i = strlen($my_string)-1; $i >= 0; $i-- ){
	$reverse.= $my_string[$i];
}
//echo $reverse;

strrev($my_string);

$name = "flor guzman";
strpos($name, 'G'); //Return the position index on 'G' inside the string.
substr($name, 0, 4); //Substract a portion on postion index 0 length 4. 
substr_replace($name, 'Replace', 0, 3);//Replace A word from position 0 - 3.
strrev($name); //Reverse String

ucfirst($name); //Capitaliza First Letter
ucwords($name); //Capitaliza First Letter of each word
strtolower($name); //Lower Case
strtoupper($name); //UpperCase
trim($name); //Removed Spaces.
ltrim($name); //REmoved Left Spaces
rtrim($name); //Removed Right Spaces.
explode(' ', $name); //Separate the string by spaces. Return an array with the words [ 'Flor', 'Guzman']
implode(' ', $name); //Return an String with the elements of the array in one string separate by ' '
echo wordwrap($name, $limit); //wrap string into one line until the limit specify , default is 75

//NUMBERS

echo number_format(1232434, 2, ':', ',');

//ARRAYS */


$file = fopen ("https://www.agorafy.com/sitemap", "r");
if (!$file) {
    echo "<p>Unable to open remote file.\n";
    exit;
}
while (!feof ($file)) {
    $line = fgets ($file, 1024);
    /* This only works if the title and its tags are on one line */
    if (preg_match ("@\<title\>(.*)\</title\>@i", $line, $out)) {
        $title = $out[1];
        break;
    }
}
fclose($file);
?>
