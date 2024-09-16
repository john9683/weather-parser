## Парсер прогноза погоды
Парсит прогноз погоды одного известного сайта для городов: Москва, Санкт-Петербург, Новосибирск

### Tребования
PHP 8.2

### Установка
composer require john9683/weather-parser

### Использование
1. Метод getForecast класса WeatherParser принимает название города (выбирается из enum класса Cities) и возвращает массив прогноза погоды на 31 день, начиная со вчерашнего для. Вид массива: 
['city' => 'название города в именительном падеже', 'forecast' => ['вчера/сегодня/день недели', 'дата', 'данные по облачности', 'температура днём', 'температура ночью']]
2. В случае ошибки getForecast() вернёт false

