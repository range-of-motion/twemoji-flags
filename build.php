<?php

require_once __DIR__ . '/vendor/autoload.php';

function characterToUnicode(string $character): string
{
    $dictionary = [
        'a' => '1F1E6',
        'b' => '1F1E7',
        'c' => '1F1E8',
        'd' => '1F1E9',
        'e' => '1F1EA',
        'f' => '1F1EB',
        'g' => '1F1EC',
        'h' => '1F1ED',
        'i' => '1F1EE',
        'j' => '1F1EF',
        'k' => '1F1F0',
        'l' => '1F1F1',
        'm' => '1F1F2',
        'n' => '1F1F3',
        'o' => '1F1F4',
        'p' => '1F1F5',
        'q' => '1F1F6',
        'r' => '1F1F7',
        's' => '1F1F8',
        't' => '1F1F9',
        'u' => '1F1FA',
        'v' => '1F1FB',
        'w' => '1F1FC',
        'x' => '1F1FD',
        'y' => '1F1FE',
        'z' => '1F1FF',
    ];

    $character = strtolower($character);

    if (array_key_exists($character, $dictionary)) {
        return strtolower($dictionary[$character]);
    }

    throw new Exception('Could not find character ' . $character);
}

$client = new GuzzleHttp\Client();
$request = $client->request('GET', 'https://gist.githubusercontent.com/almost/7748738/raw/ef1825a0ed94af095f0a1f58a92d2110916c20fb/countries.json');
$countries = json_decode($request->getBody());

$output = '';

foreach ($countries as $country) {
    $countryCode = strtolower($country->code);
    $unicode = characterToUnicode($countryCode[0]) . '-' . characterToUnicode($countryCode[1]);

    $output .= '.twf-' . $countryCode . ' {' . PHP_EOL;
    $output .= '  background-image: url("https://twemoji.maxcdn.com/v/13.0.0/svg/' . $unicode . '.svg");' . PHP_EOL;
    $output .= '}' . PHP_EOL;
    $output .= PHP_EOL;
}

echo $output;