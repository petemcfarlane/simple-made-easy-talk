<?php

class Distance
{
    private $km;

    private function __construct() {}

    public static function fromKm($km)
    {
        $d = new static;
        $d->km = $km;
        return $d;
    }

    public function getKm()
    {
        return $this->km;
    }
}

class Time
{
    private $seconds;

    private function __construct() {}

    public static function fromSeconds($seconds)
    {
        $t = new static;
        $t->seconds = $seconds;
        return $t;
    }

    public function getHours()
    {
        return $this->seconds / 3600;
    }
}

class Speed
{
    private $kmph;

    private function __construct() {}

    public static function fromDistanceAndTime(Distance $d, Time $t)
    {
        $s = new static;
        $s->kmph = $d->getKm() / $t->getHours();
        return $s;
    }

    public function asMph()
    {
        return $this->kmph * 1.6093;
    }
}


$d = Distance::fromKm(10);

$t = Time::fromSeconds(3600);

$s = Speed::fromDistanceAndTime($d, $t);

echo $s->asMph();
