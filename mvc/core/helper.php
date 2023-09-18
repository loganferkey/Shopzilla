<?php

function dnd(...$val) {
    echo '<pre>';
    foreach($val as $arg) {
        echo var_dump($arg);
    }
    echo '</pre>';
    exit;
}

function route($controller, $action = null, ...$args) {
    $params = '';
    if (count($args) > 0) {
        foreach ($args as $arg) {
            if (is_array($arg)) {
                foreach ($arg as $subarg) { $params .= $subarg . '/'; }
            } else { $params .= $arg . '/'; }
        }
        $params = rtrim($params, '/');
    }
    if ($action === null) {  return PROJ_ROOT . strtolower($controller) . ($params ? '/' . $params : ''); }
    return PROJ_ROOT . strtolower($controller) . '/' . strtolower($action) . ($params ? '/' . $params : ''); 
}

function getFormattedPrice($largeDecimals, $price) {
    if ($price === 'bidding') { return 'Bidding'; }
    if ($price < 1) { return 'FREE'; }
    if ($price >= 10000) {
        $suffix = '';
        if ($price > 1000000000) { $suffix = "B"; $divisor = 1000000000; }
        else {
            $suffix = $price > 999999.99 ? "M" : "K";
            $divisor = $price > 999999.99 ? 1000000 : 1000;
        }

        return '$'.number_format(round($price/$divisor, $largeDecimals), $largeDecimals) . $suffix;
      }
      return '$'.number_format($price, 2, '.', ',');
}