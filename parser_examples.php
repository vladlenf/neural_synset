<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');



// Открываем файл label_interpretation_example.csv для чтения
$handle = fopen('../data/label_interpretation_example.csv', 'r');
$new_rows = [];
$prev_row = null;

// Открываем файл parsed_label_interpretation_examples.csv для записи
$handle_new = fopen('../data/parsed_label_interpretation_examples.csv', 'w');

while (($row = fgetcsv($handle, 1000, '$')) !== false) {
    if ($prev_row !== null && count($prev_row) >= 3 && count($row) >= 3 && array_slice($prev_row, 0, 3) === array_slice($row, 0, 3)) {
        $prev_row[3] .= $row[3];
    } else {
        if ($prev_row !== null) {
            fputcsv($handle_new, $prev_row, '$');
        }
        $prev_row = $row;
    }
}

// Добавляем последнюю строку
if ($prev_row !== null) {
    fputcsv($handle_new, $prev_row, '$');
}

fclose($handle);
fclose($handle_new);

echo "Обработка файла завершена. Результат сохранен в parsed_label_interpretation_examples.csv.csv\n";




