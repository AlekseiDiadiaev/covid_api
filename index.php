<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Content-type: json/application');

require_once 'configDb.php';
require_once 'getAllData.php';
require_once 'getDataByDayForPeriod.php';      
require_once 'getUniqueCountries.php';
require_once 'getPopulation.php';
require_once 'getDataByCountries.php';
require_once 'getMinMaxDate.php';


switch($_GET['q']) {
    case 'alldata':        
        ['minDate' => $min, 'maxDate' => $max] = getMinMaxDate();
        $data = getDataByCountries($min, $max);
        $res = json_encode($data);   
        print_r($res); 
        break;
    case 'data':     
        $data = getDataByCountries($_GET['from'], $_GET['to']);
        $res = json_encode($data);
        print_r($res);  
        break;
    case 'databyday':     
        $data = getDataByDayForPeriod($_GET['from'], $_GET['to']);
        $res = json_encode($data);
        print_r($res);  
        break;
    case 'minmax':     
        $res = json_encode(getMinMaxDate());
        print_r($res);       
        break;   
    case 'countries':     
        $res = json_encode(getUniqueCountries());
        print_r($res);       
        break;    

    default:
        http_response_code(404);
        print_r('{"status": false, "message": "Not found"}');    
}


