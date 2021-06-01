<?php

// Method: POST, PUT, GET etc
// Data: array("param" => "value") ==> index.php?param=value

class PARestAPITax
{
  function CallAPI($method, $route, $data = false)
  {
    $baseURL = get_option('PA_Taxonomy_Host') . '/wp-json/wp/v2/';
    $curl = curl_init();

    switch ($method) {
      case "POST":
        curl_setopt($curl, CURLOPT_POST, 1);

        if ($data)
          curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        break;
      case "PUT":
        curl_setopt($curl, CURLOPT_PUT, 1);
        break;
      default:
        if ($data) {
          $url = sprintf("%s?%s", $baseURL . $route, http_build_query($data));
        } else {
          $url = $baseURL . $route;
        }
    }

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return json_decode($result);
  }
}
