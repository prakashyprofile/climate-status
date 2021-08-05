<?php

/**
* @file providing the service which returns weather data provided a city name.
*
*/

namespace  Drupal\material;

/**
 * Class weatherService
 * @package Drupal\material
 */
class weatherService {

  public function  getWeatherDataViaApi($city) {
    // $url = "https://community-open-weather-map.p.rapidapi.com/weather?q=" . $city . "&id=2172797&lang=null&units=%22metric%22%20or%20%22imperial%22&mode=xml%2C%20html";
    // try {
    //   $data = (string) \Drupal::httpClient()
    //     ->get($url)
    //     ->getBody();

    // }
    // catch (RequestException $exception) {
    //   watchdog_exception('weather_widget', $exception);
    // }

    // TODO: fix exeption invalid API KEY when trying to use Guzzle
    $curl = curl_init();

    curl_setopt_array($curl, [
      CURLOPT_URL => "https://community-open-weather-map.p.rapidapi.com/weather?q=" . $city . "&id=2172797&lang=null&units=%22metric%22%20or%20%22imperial%22&mode=xml%2C%20html",
      CURLOPT_RETURNTRANSFER => TRUE,
      CURLOPT_FOLLOWLOCATION => TRUE,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => [
        "x-rapidapi-host: community-open-weather-map.p.rapidapi.com",
        "x-rapidapi-key: 3208ca1202msh6795eb0f7ebf38ep1d8ab3jsn9814e467a86e",
      ],
    ]);

    $result = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    }
    else {
      // Echo $result;.
    }
    $decoded_result = json_decode($result);
    $data = [
              'city'      => $decoded_result->name,
              'longitude' => $decoded_result->coord->lon,
              'latitude'  => $decoded_result->coord->lon,
              'weather'   => $decoded_result->weather[0]->main,
              'temp'      => $decoded_result->main->temp,
              'min_temp'  => $decoded_result->main->temp_min,
              'max_temp'  => $decoded_result->main->temp_max
            ];
    return $data;
  }

}
