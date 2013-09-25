<?php 

error_reporting(E_ERROR);

/* example of Previmeteo weather API use with a weather widget creation

Place pictograms in the images/weather directory

Previmeteo.com - 2013

*/

//define size of final widget
$width = 150;

//fill your api key you have pickup from http://api.previmeteo.com
$API_KEY="YOUR_API_KEY";

//language and unit of data (en = english and imperial units, fr = french and metric units, de, es,…)
$hl="en";

//place where you want the weather
$Place=Array("name"=>"Marmande,FR");//name of the weather you would like to show

//we collect weather iformation from Previmeto API
$Weather_data=Array();

//we lorad the data from the API
$data_tmp=simplexml_load_file("http://api.previmeteo.com/".$API_KEY."/ig/api?weather=".$Place["name"]."&hl=".$hl);
foreach ($data_tmp->weather->forecast_conditions AS $forecast_day) {
	//we populate the $Weather_data to have one single array for all the cities $Weather_data[$city][$Day]=Array("icon"=>.. , "tmin"=>.. , "tmax"=> ..)
	$Weather_data[$Place["name"]][]=Array("icon"=>(string)$forecast_day->icon["data"],"tmin"=>(integer)$forecast_day->low["data"],"tmax"=>(integer)$forecast_day->high["data"],"day_of_week"=>(string)$forecast_day->day_of_week["data"]);
}


echo "<div style='margin: auto;border:1px solid #CCCCCC;width:".$width."px;font-size:16px;font-family:tahoma;'>";
echo "<span style='margin: auto;display:block; text-align:center;border:1px solid #EEEEEE; width:".$width."px;'>".$Place["name"]."</span>";
for ($day_forecast=0;$day_forecast<4;$day_forecast++) {
	echo "<span style='display:block; text-align:center; margin: auto;border:1px solid #EEEEEE;width:".$width."px;'>";
	//pick the right icon minimum temperature and maximum temperature
	$icon = $Weather_data[$Place["name"]][$day_forecast]["icon"];
	$tmin = $Weather_data[$Place["name"]][$day_forecast]["tmin"];
	$tmax = $Weather_data[$Place["name"]][$day_forecast]["tmax"];
	$day_of_week = $Weather_data[$Place["name"]][$day_forecast]["day_of_week"];
	
	echo "<b>".$day_of_week."</b><br /><img src='.".$icon."' style='margin: 5 5 5 5px;'><BR /><font color='blue'>".$tmin."</font> / <font color='red'>".$tmax."</font><br /></span>";

}
echo "</div>";

?>