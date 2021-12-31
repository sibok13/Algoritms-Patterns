<?php

// 1. Создать массив на миллион элементов и отсортировать его различными способами. Сравнить скорости.

$my_arr = [];

for ($i=0; $i <= 1000; $i++) { 
    array_push($my_arr, random_int(0, 1000));
}

function bubbleSort($array){
    for($i=0; $i<count($array); $i++){
        $count = count($array);
            for($j=$i+1; $j<$count; $j++){
                if($array[$i]>$array[$j]){
                    $temp = $array[$j];
                    $array[$j] = $array[$i];
                    $array[$i] = $temp;
                }
            }         
        }
    return $array;
}

function shakerSort ($array) {
    $n = count($array);
    $left = 0;
    $right = $n - 1;
    do {
        for ($i = $left; $i < $right; $i++) {
        if ($array[$i] > $array[$i + 1]) {
        list($array[$i], $array[$i + 1]) = array($array[$i + 1], $array[$i]);
    }
    }
    $right -= 1;
    for ($i = $right; $i > $left; $i--) {
        if ($array[$i] < $array[$i - 1]) {
            list($array[$i], $array[$i - 1]) = array($array[$i - 1], $array[$i]);
        }
    }
    $left += 1;
    } while ($left <= $right);
    }

function quickSort(&$arr, $low = null, $high = null) {
    if($low !== null && $high !== null){
        $i = $low;                
        $j = $high;
    } else {
        $i = $low = 0;                
        $j = $high = count($arr) - 1;
    }
    $middle = $arr[($low + $high) / 2];
    do {
        while($arr[$i] < $middle) ++$i;
        while($arr[$j] > $middle) --$j;
            if($i <= $j){          
                $temp = $arr[$i];
                $arr[$i] = $arr[$j];
                $arr[$j] = $temp;
                $i++; $j--;
            }
    } 
    while($i < $j);
    if($low < $j){
        quickSort($arr, $low, $j);
    }

    if($i < $high){
        quickSort($arr, $i, $high);
    }
}

$start_time = microtime(true);
bubbleSort($my_arr);
$end_time = microtime(true);
echo "Time: " . ($end_time - $start_time);
echo PHP_EOL;
// Time: 0.15223097801208

$start_time = microtime(true);
shakerSort($my_arr);
$end_time = microtime(true);
echo "Time: " . ($end_time - $start_time);
echo PHP_EOL;
// Time: 0.16954898834229

$start_time = microtime(true);
quickSort($my_arr);
$end_time = microtime(true);
echo "Time: " . ($end_time - $start_time);
echo PHP_EOL;
// Time: 0.0041801929473877

echo "-------------------------------------" . PHP_EOL;


// 3. Подсчитать практически количество шагов при поиске описанными в методичке алгоритмами.

$my_arr2 = [];
for ($i=1; $i <= 100; $i++) { 
    array_push($my_arr2, $i);
}

// shuffle($my_arr2);

function LinearSearch ($myArray, $num) {
    $iter_num = 0;
    $count = count($myArray);
    for ($i=0; $i < $count; $i++) {
        $iter_num++;
        if ($myArray[$i] == $num) {
        echo "элемпент номер: " . $i . PHP_EOL;
        echo "количество шагов: " . $iter_num . PHP_EOL;
        return $i;
    } 
    }
    echo "не найдено" . PHP_EOL;
    echo "количество шагов: " . $iter_num . PHP_EOL;
    return null;
    }

    function binarySearch ($myArray, $num) {
        $left = 0;
        $right = count($myArray) - 1;
        $iter_num = 0;
        
        while ($left <= $right) {
        $iter_num++;
        
        $middle = floor(($right + $left)/2);
        if ($myArray[$middle] == $num) {
           echo "элемпент номер: " . $middle . PHP_EOL;
           echo "количество шагов: " . $iter_num . PHP_EOL;
           return $middle;
        }
        elseif ($myArray[$middle] > $num) {
            $right = $middle - 1;
        }
        elseif ($myArray[$middle] < $num) {
            $left = $middle + 1;
        }
        }
        echo "не найдено" . PHP_EOL;
        echo "количество шагов: " . $iter_num . PHP_EOL;
        return null;
    }
        

function InterpolationSearch($myArray, $num)
    {
    $start = 0;
    $last = count($myArray) - 1;
    $iter_num = 0;

    while (($start <= $last) && ($num >= $myArray[$start]) 
    && ($num <= $myArray[$last])) {
        $iter_num++;

        $pos = floor($start + (
        (($last - $start) / ($myArray[$last] - $myArray[$start]))
        * ($num - $myArray[$start])
        ));

        if ($myArray[$pos] == $num) {
            echo "элемпент номер: " . $pos . PHP_EOL;
            echo "количество шагов: " . $iter_num . PHP_EOL;
            return $pos;
        }

        if ($myArray[$pos] < $num) {
            $start = $pos + 1;
        }

        else {
            $last = $pos - 1;
        }
    }
    echo "не найдено" . PHP_EOL;
    echo "количество шагов: " . $iter_num . PHP_EOL;
    return null;
}
 
    
    LinearSearch($my_arr2, 89); // 89 шагов
    binarySearch($my_arr2, 89); // 6 шагов
    InterpolationSearch($my_arr2, 89); // 1 шаг

echo "-------------------------------------" . PHP_EOL;

// 2. Реализовать удаление элемента массива по его значению. Обратите внимание на возможные дубликаты!

function del_num (&$arr, $num){
    quickSort($arr);

    while(true) {
        $pos = InterpolationSearch($arr, $num);
        if ($pos !== null){
            unset($arr[$pos]);
        } else {
            return false;
        }
    }
}

$my_arr3 = [1, 676, 45, 34, 676, 3, 2, 8, 9, 676];
del_num($my_arr3, 676);
print_r($my_arr3);