<?php

/**
 * Returns the importmap for this application.
 *
 * - "path" is a path inside the asset mapper system. Use the
 *     "debug:asset-map" command to see the full list of paths.
 *
 * - "entrypoint" (JavaScript only) set to true for any module that will
 *     be used as an "entrypoint" (and passed to the importmap() Twig function).
 *
 * The "importmap:require" command can be used to add new entries to this file.
 */
return [
    'app' => [
        'path' => './assets/app.js',
        'entrypoint' => true,
    ],
    'codebook' => [
        'path' => './assets/app-codebook.js',
        'entrypoint' => true,
    ],
    '@hotwired/stimulus' => [
        'version' => '3.2.2',
    ],
    '@symfony/stimulus-bundle' => [
        'path' => './vendor/symfony/stimulus-bundle/assets/dist/loader.js',
    ],
    '@alpinejs/focus' => [
        'version' => '3.14.8',
    ],
    '@alpine-collective/toolkit-scroll' => [
        'version' => '1.0.2',
    ],
    'alpinejs' => [
        'version' => '3.14.8',
    ],
    'list.js' => [
        'version' => '2.3.1',
    ],
    'string-natural-compare' => [
        'version' => '2.0.3',
    ],
    'datatables.net' => [
        'version' => '2.2.1',
    ],
    'jquery' => [
        'version' => '3.7.1',
    ],
    'datatables.net-dt' => [
        'version' => '2.2.1',
    ],
    'datatables.net-dt/css/dataTables.dataTables.min.css' => [
        'version' => '2.2.1',
        'type' => 'css',
    ],
    'tippy.js' => [
        'version' => '6.3.7',
    ],
    'tippy.js/dist/tippy.css' => [
        'version' => '6.3.7',
        'type' => 'css',
    ],
    'tippy.js/themes/light-border.css' => [
        'version' => '6.3.7',
        'type' => 'css',
    ],
    '@popperjs/core' => [
        'version' => '2.11.8',
    ],
    '@ryangjchandler/alpine-tooltip' => [
        'version' => '2.0.1',
    ],
    'axios' => [
        'version' => '1.7.9',
    ],
    'dropzone' => [
        'version' => '6.0.0-beta.1',
    ],
    'just-extend' => [
        'version' => '5.1.0',
    ],
    'dropzone/dist/dropzone.css' => [
        'version' => '6.0.0-beta.1',
        'type' => 'css',
    ],
];
