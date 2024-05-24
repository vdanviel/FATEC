<?php

namespace App\Model;

class Calculator {

    public function sum(float $n1, float $n2): float
    {

        return $n1 + $n2;

    }

    public function multiple(float $n1, float $n2): float
    {

        return $n1 * $n2;

    }

    public function minus(float $n1, float $n2): float
    {

        return $n1 - $n2;

    }

    public function divide(float $n1, float $n2): float
    {

        return $n1 / $n2;

    }

}