<?php

$row    = 1;
$output = '';
if (($handle = fopen('history.csv', 'r')) !== false) {
    while (($data = fgetcsv($handle, 1000, ',')) !== false) {
        if ($data[1] !== '00') {
            $localItem = '  hist-' . $row . ":\n";
            $localItem = $localItem . '    ' . 'id: ' . $data[0] . "\n";
            $localItem = $localItem . '    ' . 'day: ' . $data[1] . "\n";
            $localItem = $localItem . '    ' . 'month: ' . $data[2] . "\n";
            $localItem = $localItem . '    ' . 'year: ' . $data[3] . "\n";
            $localItem = $localItem . '    ' . 'slug: ' . $data[4] . "\n";
            $localItem = $localItem . '    ' . 'title: ' . $data[5] . "\n";
            $localItem = $localItem . '    ' . 'body: ' . $data[6] . "\n";

            $output = $output . $localItem;
        }

        $row++;
    }
    fclose($handle);
}

file_put_contents('result.yml', $output);
