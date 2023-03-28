<?php

['name' => $name, 'version' => $ver] = $cfg = json_decode(
    file_get_contents(__DIR__ . '/composer.json'),
    true,
);

fprintf(
    STDOUT,
    "%s v%s%s",
    explode('/', $name)[1],
    $ver,
    PHP_EOL
);


$home = rtrim(`composer -n --no-ansi config home`, "\r\n");
$dir = rtrim(`composer -n --no-ansi config --global bin-dir`, "\r\n");
$dir = $home . DIRECTORY_SEPARATOR . $dir;
$display = $dir;
if (($home = getenv('HOME')) && 0 === strpos($display, $home)) {
    $display = '~'  . substr($dir, strlen($home));
}

$result = ($real = realpath($dir))
    && is_dir($real)
    && array_intersect([$dir, "$dir/", $real, "$real/"], explode(PATH_SEPARATOR, getenv('PATH')))
;
fprintf(
    STDOUT,
    'PATH: composer home-bin-dir "%s" [%s]%s',
    addcslashes($display, "\0..\37\\\"\177..\377"),
    $result ? "OK" : "FAIL",
    PHP_EOL,
);
