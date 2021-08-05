<?php

namespace Drupal\material\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;
use Drupal\Component\Serialization\Json;

class showWeather extends ControllerBase {
  public function getWeather() {
    $curl = curl_init();

    curl_setopt_array($curl, [
      CURLOPT_URL => "https://community-open-weather-map.p.rapidapi.com/weather?q=London%2Cuk&lat=0&lon=0&id=2172797&lang=null&units=%22metric%22%20or%20%22imperial%22&mode=xml%2C%20html",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => [
        "x-rapidapi-host: community-open-weather-map.p.rapidapi.com",
        "x-rapidapi-key: 3208ca1202msh6795eb0f7ebf38ep1d8ab3jsn9814e467a86e"
      ],
    ]);

    $result = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      //echo '<pre>';print_r($result);die();
    }
    $decoded_result = json_decode($result);
    $prepare_array = [];
    $data = [
              'city'      => $decoded_result->name,
              'longitude' => $decoded_result->coord->lon,
              'latitude'  => $decoded_result->coord->lon,
              'weather'   => $decoded_result->weather[0]->main,
              'temp'      => $decoded_result->main->temp,
              'min_temp'  => $decoded_result->main->temp_min,
              'max_temp'  => $decoded_result->main->temp_max,
            ];
 
      
    echo '<pre>';print_r($data);die();
    $build = [
      '#theme' => 'custom_rss',
      '#items' => $items,
      '#links' => $links,
      '#cache' => ['max-age' => (60 * 60)], // 1 Hour
    ];
    return [
      '#theme' => 'weather_widget',      
      '#result' => $result,
    ];
  }
}