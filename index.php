<?php

/* 1. Наблюдатель: есть сайт HandHunter.gb. На нем работники могут подыскать себе вакансию 
РНР-программиста. Необходимо реализовать классы искателей с их именем, почтой и стажем работы. 
Также реализовать возможность в любой момент встать на биржу вакансий (подписаться на уведомления), 
либо же, напротив, выйти из гонки за местом. Таким образом, как только появится новая вакансия 
программиста, все жаждущие автоматически получат уведомления на почту (можно реализовать условно). */

class Subject implements \SplSubject
{
    public $state;
    private $observers;

    public function __construct()
    {
        $this->observers = new \SplObjectStorage();
    }

    public function attach(\SplObserver $observer): void
    {
        echo "Вы встали на биржу.<br>";
        $this->observers->attach($observer);
    }

    public function detach(\SplObserver $observer): void
    {
        $this->observers->detach($observer);
        echo "Вы удалены с биржи.<br>";
    }

    public function notify(): void
    {
        echo "Появилась нужная вам вакансия.<br>";
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    public function someBusinessLogic(): void
    {
        echo "\nРазмещена новая вакансия Программиста.<br>";
        $this->state = ["programmist" => 1];

        $this->notify();
    }
}

/**
 * Конкретные Наблюдатели реагируют на обновления, выпущенные Издателем, к
 * которому они прикреплены.
 */
class ObserverApplicant implements \SplObserver
{
    public $email = null;
    public $name = null;

    public function __construct($email, $name)
    {
        $this -> email = $email;
        $this -> name = $name;
    }

    public function update(\SplSubject $subject): void
    {
        if ($subject->state["programmist"] > 0) {
            echo "Реакция на событие для подписчика " . $this -> name ." , отправка письма на почту " . $this -> email . "<br>";
        }
    }
}

/**
 * Клиентский код.
 */

$subject = new Subject();

$o1 = new ObserverApplicant("Nikola@mail", "Nikola");
$subject->attach($o1);
$subject->someBusinessLogic();
$subject->detach($o1);
$subject->someBusinessLogic();


/* 2. Стратегия: есть интернет-магазин по продаже носков. Необходимо реализовать возможность 
оплаты различными способами (Qiwi, Яндекс, WebMoney). Разница лишь в обработке запроса на оплату 
и получение ответа от платёжной системы. В интерфейсе функции оплаты достаточно общей суммы товара 
и номера телефона. */

class Context
{
    private $strategy;
    public $order = [89634822176, 142.30];

    public function __construct($strategy)
    {
        $this->strategy = $strategy;
    }

    public function setPayment($strategy)
    {
        $this->strategy = $strategy;
    }

    public function doPayment(): void
    {
        /* код */
        $result = $this->strategy->getPayment($this->order);
        echo $result;
    }
}

interface PaymentMethod
{
    public function getPayment($order);
}

class CreditCardPayment implements PaymentMethod
{
    public function getPayment($order)
    {
        /* код */
        return "Оплата картой клиента " . $order[0] . " на сумму " . $order[1] . "<br>";
    }
}

class PayPalPayment implements PaymentMethod
{
    public function getPayment($order)
    {
        /* код */
        return "Оплата клиента через PayPal " . $order[0] . " на сумму " . $order[1] . "<br>";
    }
}

$context = new Context(new CreditCardPayment());
$context->doPayment();

$context = new Context(new PayPalPayment());
$context->doPayment();

/* 3. Команда: вы — разработчик продукта Macrosoft World. Это текстовый редактор 
с возможностями копирования, вырезания и вставки текста (пока только это). Необходимо 
реализовать механизм по логированию этих операций и возможностью отмены и возврата 
действий. Т.е., в ходе работы программы вы открываете текстовый файл .txt, выделяете 
участок кода (два значения: начало и конец) и выбираете, что с этим кодом делать. */

interface Command
{
    public function execute(): void;
}

class ComplexCommand implements Command
{
    private $receiver;
    private $myCommand;

    public function __construct(Receiver $receiver, $myCommand)
    {
        $this->receiver = $receiver;
        $this->myCommand = $myCommand;
    }

    public function execute(): void
    {
        $this->receiver->doComand($this->myCommand);
        $this->receiver->saveHistory();
    }
}

class Receiver
{
    public function doComand($myCommand)
    {
        echo "Выполнена команда (" . $myCommand . ".)<br>";
    }

    public function saveHistory()
    {
        echo "Запись команды в ЛОГ <br>";
    }
}

class Invoker
{
    private $sendCommand;

    public function sendCommand(Command $command): void
    {
        $this->sendCommand = $command;
        $this->sendCommand->execute();
    }
}

$invoker = new Invoker();
$receiver = new Receiver();
$invoker->sendCommand(new ComplexCommand($receiver, "Вырезать"));