<?php
// update-check.php
header('Content-Type: application/json');

$theme_data = array(
    'version' => '1.0.1', // Your theme version
    'url' => 'https://github.com/craigcallen/iprosystems/archive/master.zip', // URL to your ZIP file
);

echo json_encode($theme_data);