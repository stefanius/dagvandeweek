<?php

$row = 1;
$output = '';
if (($handle = fopen('content.csv', 'r')) !== false) {
    while (($data = fgetcsv($handle, 1000, ',')) !== false) {
        if ($data[4] === 'nieuws') {
            $localItem = '  hist-' . $row . ":\n";
            $localItem = $localItem . '    ' . 'id: ' . $data[0] . "\n";
            $localItem = $localItem . '    ' . 'title: ' . $data[1] . "\n";
            $localItem = $localItem . '    ' . 'description: ' . $data[2] . "\n";
            $localItem = $localItem . '    ' . 'body: ' . $data[3] . "\n";
            $localItem = $localItem . '    ' . 'slug: ' . $data[6] . "\n";
            $localItem = $localItem . '    ' . "created: <dateTimeBetween('$data[9]', '$data[9]')>" . "\n";

            $output = $output . $localItem;
            $row++;
        }
    }
    fclose($handle);
}

file_put_contents('result.yml', $output);
