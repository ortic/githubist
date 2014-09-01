<?php

require __DIR__ . '/../vendor/autoload.php';

$klein = new \Klein\Klein();

$klein->respond('/[:user]/[:repo]/[*:file]',  'Ortic\Githubist\Controller::displayFile');
$klein->respond('/',  'Ortic\Githubist\Controller::displayInfo');

$klein->dispatch();
