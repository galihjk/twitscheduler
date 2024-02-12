<?php
function data__save($name, $data){
    $GLOBALS['data'][$name] = $data;
    $filename="data/$name.json";
	return file_put_contents($filename, json_encode($data)); 
}