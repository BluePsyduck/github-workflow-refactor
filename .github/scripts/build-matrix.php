<?php

declare(strict_types=1);

$versions = explode(' ', '8.1 8.0 7.4');
$suites = [];

//if (file_exists('vendor/bin/phpunit')) {
//    $output = shell_exec('vendor/bin/phpunit --list-suites');

    $output = <<<EOT
PHPUnit 9.5.10 by Sebastian Bergmann and contributors.

Available test suite(s):
 - unit-test
 - serializer-test
EOT;

    if (preg_match_all('#^ - (.*)$#m', $output, $matches)) {
        $suites = array_map('trim', $matches[1]);
    }
//}

$matrix = [];
if (count($versions) > 0 && count($suites) > 0) {
    foreach ($versions as $version) {
        foreach ($suites as $suite) {
            $matrix[] = [
                'version' => $version,
                'suite' => $suite,
                'cover' => $suite === 'unit-test',
            ];
        }
    }
}
echo json_encode($matrix);
