<?php

$row = 1;
$output = '';
if (($handle = fopen('history.csv', 'r')) !== false) {
    while (($data = fgetcsv($handle, 1000, ',')) !== false) {
        if ($data[1] === '00') {
            $localItem = '  hist-' . $row . ":\n";
            $localItem = $localItem . '    ' . 'id: ' . $data[0] . "\n";
            $localItem = $localItem . '    ' . 'year: ' . $data[3] . "\n";
            $localItem = $localItem . '    ' . 'slug: ' . $data[3] . "\n";
            $localItem = $localItem . '    ' . 'title: ' . $data[3] . "\n";
            $localItem = $localItem . '    ' . 'body: ' . $data[6] . "\n";

            $output = $output . $localItem;
        }

        $row++;
    }
    fclose($handle);
}

file_put_contents('result.yml', $output);
