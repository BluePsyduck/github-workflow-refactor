<?php

declare(strict_types=1);

$versions = explode(' ', getenv('PHP_VERSIONS'));
$suites = [];

if (file_exists('vendor/bin/phpunit')) {
    $output = shell_exec('vendor/bin/phpunit --list-suites');
    if (preg_match_all('#^ - (.*)$#m', $output, $matches)) {
        $suites = array_map('trim', $matches[1]);
    }
}

$matrix = [];
if (count($versions) > 0 && count($suites) > 0) {
    foreach ($suites as $suite) {
        foreach ($versions as $version) {
            $matrix[] = [
                'suite' => $suite,
                'version' => $version,
            ];
        }
    }
}
echo json_encode($matrix);
