<?php

// install composer require php-console/php-console

// require autoload
require './vendor/autoload.php';

// Call debug from global PC class-helper (most short & easy way)
PhpConsole\Helper::register(); // required to register PC class in global namespace, must be called only once

// Debug some mixed variable

PhpConsole\Connector::getInstance()->getDebugDispatcher()->setDumper(
    new PhpConsole\Dumper(4, 10, 400) // set new dumper with levelLimit=2, itemsCountLimit=10, itemSizeLimit=10
);


class DebugExample {

    private $privateProperty = 1;
    protected $protectedProperty = 2;
    public $publicProperty = 3;
    public $selfProperty;

    public function __construct() {
        $this->selfProperty = $this;
    }

    public function someMethod() {
    }
}
$s = new stdClass();
$s->asd = array(array(123));
PC::debug('11111111112222222222333333333344444444445');
PC::debug(array(
    'null' => null,
    'boolean' => true,
    'longString' => '11111111112222222222333333333344444444445',
    'someObject' => new DebugExample(),
    'someCallback' => array(new DebugExample(), 'someMethod'),
    'someClosure' => function () {
    },
    'someResource' => fopen(__FILE__, 'r'),
    'manyItemsArray' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11),
    'deepLevelArray' => array(1 => array(2 => array(3))),
));

// Trace debug call

PC::getConnector()->getDebugDispatcher()->detectTraceAndSource = true;

function a() {
    b();
}

function b() {
    PC::debug('Message with source & trace detection');
}

a();

echo 'See debug messages in JavaScript Console(Ctrl+Shift+J) and in Notification popups. Click on PHP Console icon in address bar to see configuration options.';
