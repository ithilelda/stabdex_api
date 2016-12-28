<?php
  namespace StabDex\Utils;
  
  
  class Stats {
    public function summarize($name, $raw) {
      sort($raw);
      $count = count($raw);
      $min = $raw[0];
      $max = $raw[$count-1];
      $median = $count & 1 ? $raw[intdiv($count,2)] : ($raw[intdiv($count,2)] + $raw[intdiv($count,2)-1]) / 2;
      $mean = array_sum($raw) / $count;
      $ssr = array_reduce($raw, function ($carry, $item) use($mean) {
        $carry += ($item - $mean) ** 2;
        return $carry;
      });
      $var = $ssr / $count;
      $stdev = sqrt($var);
      $output = [
        "name" => $name,
        "count" => $count,
        "min" => intval($min),
        "max" => intval($max),
        "median" => intval($median),
        "mean" => $mean,
        "sum_of_squares" => $ssr,
        "variance" => $var,
        "standard_deviation" => $stdev,
      ];
      return $output;
    }
  }