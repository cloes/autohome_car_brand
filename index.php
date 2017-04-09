<?php
require_once("./vendor/autoload.php");

use Zend\Dom\Document\Query;
use Zend\Dom\Document;

$mysqli = new mysqli("localhost", "root", "", "test");

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$mysqli->query('SET NAMES UTF8');

$rang = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$dom = new Query();
$content = file_get_contents("./source/autohome.html");
$document = new Document($content);

for($i = 0; $i < 26; $i++){
    $html = '#html'.$rang[$i];
    $brandResults = $dom->execute("$html dl dt div a",$document,'TYPE_CSS');
    $brandWithModelResults = $dom->execute("$html dl dt div a, $html dl dd ul h4 a,$html dl dt a img",$document,'TYPE_CSS');

    $brandLength = count($brandResults);
    $brandWithModelLength = count($brandWithModelResults);
    for($j = 0; $j < $brandLength; $j++){
        echo "<hr/>";
        echo $brandResults[$j]->nodeValue,"<br/>";
        //插入brand
        $mysqli->query("INSERT INTO `car_brand` VALUES (null, "."'".$brandResults[$j]->nodeValue."',"."'".$rang[$i]."',null)");
        $brandID = $mysqli->insert_id;


        for($k = 0; $k < $brandWithModelLength; $k++){
            //添加一个判断，就是左边栏目的nodeValue才匹配
            if($brandResults[$j]->nodeValue == $brandWithModelResults[$k]->nodeValue
               && $brandWithModelResults[$k]->parentNode->parentNode->nodeName == 'dt'
            ){
                $start = $k;
            }

            if(isset($brandResults[$j+1])){
                if($brandResults[$j+1]->nodeValue == $brandWithModelResults[$k]->nodeValue){
                    $end = $k;
                }
            }else{
                $end = $brandWithModelLength;
            }
        }
        
        //提取img
        $imgPath = $brandWithModelResults[$start - 1]->getAttribute('src');

        $pathinfo = pathinfo($imgPath);

        //rename(getcwd()."\\source\\autohome_files\\".$pathinfo['basename'], getcwd().'\\logo\\'.$brandID.".".$pathinfo['extension']);
        copy(getcwd()."\\source\\autohome_files\\".$pathinfo['basename'], getcwd().'\\logo\\'.$brandID.".".$pathinfo['extension']);
        $mysqli->query("UPDATE `car_brand` SET `img_path` = " . "'" . $brandID.".".$pathinfo['extension'] . "' WHERE `id` = " . $brandID);

        for($l = $start + 1; $l < $end; $l++){
            if($brandWithModelResults[$l]->nodeName == 'a'){
                echo ">>>",$brandWithModelResults[$l]->nodeValue,"<br/>";
                $mysqli->query("INSERT INTO `car_model` VALUES (null, " . $brandID . ",'" . $brandWithModelResults[$l]->nodeValue . "')");
            }
        }
    }
}