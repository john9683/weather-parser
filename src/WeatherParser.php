<?php

declare(strict_types=1);

namespace John9683\WeatherParser;

class WeatherParser
{
  /**
   * @var string
   */
  private static string $URL = 'https://yandex.ru/pogoda/';

  /**
   * @var string
   */
  private static string $PATTERN = '/aria-label=[\S|\s][^\"]+\"/';

  /**
   * @var string[]
   */
  private static array $KEYS = [
    'вчера', 'сегодня', 'понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота', 'воскресенье'
  ];

  /**
   * @var string
   */
  private static string $SEPARATOR = ', ';

  /**
   * length of <aria-label=">
   * @var int
   */
  private static int $OFFSET = 12;

  /**
   * @var string[]
   */
  private array $weatherData = [];

  /**
   * @param string $city
   * @return array|false
   */
  public function getForecast(string $city): array|false
  {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, self::$URL . $this->getCityParameters($city)['slug']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $layout = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    curl_close($ch);

    if ($status !== 200) return false;

    $this->weatherData['city'] = $this->getCityParameters($city)['title'];

    preg_match_all (self::$PATTERN, $layout, $data);

    foreach ($data[0] as $aria) {
      foreach (self::$KEYS as $key) {
        if (strpos($aria, $key)) {
          $string = substr(substr($aria, self::$OFFSET), 0, -1);
          $this->weatherData['forecast'][] = explode(self::$SEPARATOR, $string);
        }
      }
    }

   return $this->weatherData;
  }

  /**
   * @param string $city
   * @return string[]
   */
  private function getCityParameters(string $city): array
  {
    $parametersArray = explode('][',$city);

    return [
      'title' => $parametersArray[0], 'slug' => $parametersArray[1]
    ];
  }
}
