<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->exclude(['var', 'vendor', 'node_modules'])
    ->notPath('config/bundles.php')
    ->notName('bundles.php')
    ->in(__DIR__)
;

$config = new Config();
return $config->setRules([
    '@PhpCsFixer' => true,
    'yoda_style' => ['equal' => false, 'identical' => false, 'less_and_greater' => false],
    'blank_line_before_statement' => false,
    'multiline_whitespace_before_semicolons' => false,
])
    ->setFinder($finder)
;
