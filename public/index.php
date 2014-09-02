<?php

require __DIR__ . '/../vendor/autoload.php';

$klein = new \Klein\Klein();

$klein->respond('/js/[:user]/[:repo]/[*:file]',  'Ortic\Githubist\Controller::displayFileJs');
$klein->respond('/[:user]/[:repo]/[*:file]',  'Ortic\Githubist\Controller::displayFileStatic');
$klein->respond('/',  'Ortic\Githubist\Controller::displayInfo');

$klein->dispatch();
