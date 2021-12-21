<?php

/* Задание 1. Реализовать на PHP пример Декоратора, позволяющий отправлять уведомления 
несколькими различными способами (описан в этой методичке).*/

interface Messeging 
{
    public function messege();
}

class ConcreteMesseging implements Messeging
{
    public function messege()
    {
        return "Messege";
    }
}

class DecoratorMesseging implements Messeging 
{
    protected $messege;

    public function __construct($messege)
    {
        $this->messege = $messege;
    }

    public function messege()
    {
        return $this->messege->messege();
    }
}

class EmailDecoratorMesseging extends DecoratorMesseging
{
    public function sendEmail()
    {
        /* operation */
        return "Sending Email(" . parent::messege() . ")";
    }
}

class TelegramDecoratorMesseging extends DecoratorMesseging
{
    public function sendTelegram()
    {
        /* operation */
        return "Sending Telegram(" . parent::messege() . ")";
    }
}

$msg = new ConcreteMesseging();
echo $msg->messege() . "<br>";

$emailMsg = new EmailDecoratorMesseging($msg);
echo $emailMsg->sendEmail();
$telegramMsg = new TelegramDecoratorMesseging($msg);
echo $telegramMsg->sendTelegram();


/* Задание 2. Реализовать паттерн Адаптер для связи внешней библиотеки 
(классы SquareAreaLib и CircleAreaLib) вычисления площади квадрата (getSquareArea) и 
площади круга (getCircleArea) с интерфейсами ISquare и ICircle имеющегося кода. 
Примеры классов даны ниже. Причём во внешней библиотеке используются для расчётов 
формулы нахождения через диагонали фигур, а в интерфейсах квадрата и круга — формулы, 
принимающие значения одной стороны и длины окружности соответственно. */

/* внешняя библиотека */

class CircleAreaLib
{
   public function getCircleArea(float $diagonal)
   {
       $area = (M_PI * $diagonal**2)/4;

       return $area;
   }
}

class SquareAreaLib
{
   public function getSquareArea(float $diagonal)
   {
       $area = ($diagonal**2)/2;

       return $area;
   }
}

/* Имеющиеся интерфейсы: */

interface ISquare
{
function squareArea(int $sideSquare);
}

interface ICircle
{
function circleArea(int $circumference);
}

/* Адаптеры */

class CircleAreaAdapter implements ICircle 
{
    private $circleArea = null;

    public function __construct()
    {
        $this-> circleArea = new CircleAreaLib();
    }

    public function circleArea(int $circumference)
    {
        $circumference = $circumference / M_PI;
        return $this->circleArea->getCircleArea($circumference);
    }
}

class SquareAreaAdapter implements ISquare
{
    private $squareArea = null;

    public function __construct()
    {
        $this-> squareArea = new squareAreaLib();
    }

    public function squareArea(int $sideLong)
    {
        $diagonal = $sideLong * sqrt(2);
        return $this->squareArea->getSquareArea($diagonal);
    }
}

$сircleAreaAdapter = new CircleAreaAdapter();
echo "<br>Площадь круга с длинной окружности 10 см: " . $сircleAreaAdapter->circleArea(10);

$squareAreaAdapter = new SquareAreaAdapter();
echo "<br>Площадь квадрата со стороной 4 см: " . $squareAreaAdapter->squareArea(4);