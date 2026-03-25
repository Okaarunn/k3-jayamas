<?php
define('FCPATH', __DIR__ . '/');
require_once __DIR__ . '/../vendor/autoload.php';
$app = new \CodeIgniter\Boot();
\CodeIgniter\Boot::bootWeb(new \Config\Paths());
