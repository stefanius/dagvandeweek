<?php
$row = 1;
$output = "";
if (($handle = fopen("weekhero.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {


        $localItem = "  hero-" . $row . ":\n";
        $localItem = $localItem . "    " . "id: " . $data[0] . "\n";
        $localItem = $localItem . "    " . "year: " . $data[1] . "\n";
        $localItem = $localItem . "    " . "week: " . $data[2] . "\n";
        $localItem = $localItem . "    " . "slug: " . slug($data[3]) . "\n";
        $localItem = $localItem . "    " . "title: " . $data[3] . "\n";
        $localItem = $localItem . "    " . "description: " . $data[4] . "\n";
        $localItem = $localItem . "    " . "body: " . $data[5] . "\n";

        $output = $output . $localItem;

        $row++;
    }
    fclose($handle);
}

file_put_contents ( "result.yml" , $output );

function slug($string)
{
    $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
    $string = trim($string);
    $string = preg_replace("/[^a-zA-Z0-9_| -]/", ' ', $string);
    $string = preg_replace("/[| -]+/", '-', $string);
    $string = strtolower(trim($string, '-'));
    $string = preg_replace('/-{2,}/', ' ', $string);

    return $string;
}
?>