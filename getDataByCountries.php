<?php
function getDataByCountries($from, $to) {
    $allData = getAllData();
    $dataForPeiod = getDataByDayForPeriod($from, $to); 

    $arrPopulation = getPopulation();
    
    $resData = []; 
    foreach($arrPopulation as $key => $item) {
        $resData[] = [
            "country" => $key,
            "popData2019" => $item,
            "cases" => 0,
            "deaths" => 0,
            "allCases" => 0,
            "allDeaths" => 0,
            "casesPer1000" => 0,
            "deathsPer1000" => 0,
            "averageCasesPerDay" => 0,
            "averageDeathsPerDay" => 0,
            "maxCasesPerDay" => 0,
            "maxDeathsPerDay" => 0
        ];
    }


    foreach($allData as $item) {
        $index = array_search($item['country'], array_column($resData, 'country'));
        if($index !== false) {
            $resData[$index]['allCases'] += $item['cases'];
            $resData[$index]['allDeaths'] += $item['deaths'];
        if($item['population'] > 0 && $resData[$index]['popData2019'] === 0) {
            $resData[$index]['popData2019'] = $item['population'];
        }  
        }
    }

    foreach($dataForPeiod as $item) {
        $index = array_search($item['country'], array_column($resData, 'country'));
        if($index !== false) {
            $resData[$index]['cases'] += $item['cases'];
            $resData[$index]['deaths'] += $item['deaths'];

            if($item['cases'] > $resData[$index]['maxCasesPerDay']){
                $resData[$index]['maxCasesPerDay'] = $item['cases'];
            }

            if($item['deaths'] > $resData[$index]['maxDeathsPerDay']){
                $resData[$index]['maxDeathsPerDay'] = $item['deaths'];
            }
        }
    }

    $days_diff = round((strtotime($to) - strtotime($from)) / (60 * 60 * 24));

    function getMaxNumPerDay($dataForPeiod, $item, $arg){

        $arrDaysCurrentCountry = array_filter($dataForPeiod, function($value) use ($item) {
            return $item['country'] === $value['country'];
        });

        $arrCasesPerDays = array_map(function($value) use($arg) {
            return $value[$arg];
        }, $arrDaysCurrentCountry);
        if(count($arrDaysCurrentCountry) > 0){
            $res = max($arrCasesPerDays);
        } else {
            $res = 0;
        }
        return $res;
    }

    foreach($resData as &$item) {
        if($item['allCases'] && $item['popData2019']){
            $res = $item['allCases'] / ($item['popData2019'] / 1000);
            $res = round($res, 5);
            $item['casesPer1000'] = $res;   
        }
        if($item['allDeaths'] && $item['popData2019']){
            $res = $item['allDeaths'] / ($item['popData2019'] / 1000);
            $res = round($res, 5);
            $item['deathsPer1000'] = $res;   
        }

        $item['averageCasesPerDay'] = round( $item['cases'] / $days_diff);
        $item['averageDeathsPerDay'] = round( $item['deaths'] / $days_diff);

        // $item['maxCasesPerDay'] = getMaxNumPerDay($dataForPeiod, $item, 'cases');
        // $item['maxDeathsPerDay'] = getMaxNumPerDay($dataForPeiod, $item, 'deaths');
    }

    
    return $resData;
}