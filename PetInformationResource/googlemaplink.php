<?php
function addressLink($streetAddress, $city, $zip, $state) {
    $output = 'https://www.google.com/maps/place/';
    for($index = 0; $index < strlen($streetAddress); $index++) {
        if($streetAddress[$index] == ' ') {
            $streetAddress[$index] = '+';
        }
    }
    for($index = 0; $index < strlen($city); $index++) {
        if($city[$index] == ' ') {
            $city = substr($city,0,$index) . '%20' . substr($city,$index + 1,strlen($city) - $index - 1);
        }
    }
    $output = $output . $streetAddress . ',+' . $city . ',+' . $state . '+' . $zip . '/';
    return $output;
}
echo addressLink('2093 123rd Ln NW','Coon Rapids','MN','55448');
?>