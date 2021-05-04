<?php

function checkIncomingData($incoming_data) {
    $check_hash = $incoming_data['hash'];
    unset($incoming_data['hash']);
    $data_check_arr = [];
    foreach ($incoming_data as $key => $value) {
      $data_check_arr[] = $key . '=' . $value;
    }
    sort($data_check_arr);
    $data_check_string = implode("\n", $data_check_arr);
    $secret_key = hash('sha256', API_KEY, true); // API_KEY - is your API key
    $hash = hash_hmac('sha256', $data_check_string, $secret_key);
    if (strcmp($hash, $check_hash) !== 0) {
      throw new Exception('Data is NOT from PaywithTerra');
    }
    return $incoming_data;
}

$incoming_data = checkIncomingData($_POST);