<?php
require_once("./vendor/autoload.php");

use Zend\Dom\Document\Query;
use Zend\Dom\Document;

//file_put_contents('filename.txt','');

$rang = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$dom = new Query();
$content = file_get_contents("./source/autohome.html");
$document = new Document($content);

//$results = $dom->execute('.foo .bar a');
//$results = $dom->execute('#htmlA',$document,'TYPE_CSS');
$results = $dom->execute('#htmlA dl dt div a',$document,'TYPE_CSS');

$count = count($results); 
echo $count;
foreach ($results as $result) {
    var_dump($result->nodeValue);
    // $result is a DOMElement
}
