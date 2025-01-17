<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude('var')
;

$config = new PhpCsFixer\Config();
return $config->setRules([
    '@PhpCsFixer' => true,
    'yoda_style' => ['equal' => false, 'identical' => false, 'less_and_greater' => false],
    'blank_line_before_statement' => false,
    'multiline_whitespace_before_semicolons' => false,
])
    ->setFinder($finder)
;
