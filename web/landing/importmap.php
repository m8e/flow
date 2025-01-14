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
 *
 * This file has been auto-generated by the importmap commands.
 */
return [
    'app' => [
        'path' => 'app.js',
        'entrypoint' => true,
    ],
    '@symfony/stimulus-bundle' => [
        'path' => '@symfony/stimulus-bundle/loader.js',
    ],
    '@hotwired/stimulus' => [
        'version' => '3.2.1',
    ],
    'highlight.js/lib/core' => [
        'version' => '11.9.0',
    ],
    'highlight.js/lib/languages/php' => [
        'version' => '11.9.0',
    ],
    'highlight.js/styles/github-dark.min.css' => [
        'version' => '11.9.0',
        'type' => 'css',
    ],
    '@fontsource-variable/cabin/index.min.css' => [
        'version' => '5.0.17',
        'type' => 'css',
    ],
    'htmx.org' => [
        'version' => '1.9.10',
    ],
    'clipboard' => [
        'version' => '2.0.11',
    ],
    '@oddbird/popover-polyfill' => [
        'version' => '0.3.8',
    ],
    'highlight.js/lib/languages/shell' => [
        'version' => '11.9.0',
    ],
    'highlight.js/lib/languages/json' => [
        'version' => '11.9.0',
    ],
];
