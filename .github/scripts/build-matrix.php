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
    foreach ($versions as $version) {
        foreach ($suites as $suite) {
            $matrix[] = [
                'suite' => $suite,
                'version' => $version,
                'cover' => $suite === 'unit-test',
            ];
        }
    }
}
echo json_encode($matrix);
