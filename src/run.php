<?php
$demoPath = dirname(__DIR__) . '/demo';
$exosPath = dirname(__DIR__) . '/exos';

if ($argc !== 2) {
    die("php src/run.php <demo|exo_(1|2|3|4|5|6)>\n");
}

$command = strtolower($argv[1]);
$path    = null;

if ($command === 'demo') {
    $path = $demoPath;
} else {
    if ((preg_match('/^(?<exo>exo_\d)$/', $command, $matches)) && is_dir($exosPath . '/' . $matches['exo'])) {
        $path = $exosPath . '/' . $matches['exo'];
    } else {
        die("Impossible de trouver l'exercice\n");
    }
}

foreach (scandir($path . '/data') as $filename) {
    if ((preg_match('/^input(?<id>\d+)\.txt$/', $filename, $matches)) && file_exists($path . '/data/output' . $matches['id'] . '.txt')) {
        $inputFile    = $path . '/data/input'  . $matches['id'] . '.txt';
        $outputFile   = $path . '/data/output' . $matches['id'] . '.txt';

        $inputHandle  = fopen($inputFile,  'r');
        $outputHandle = fopen($outputFile, 'r');

        $input        = [];
        $output       = trim(fgets($outputHandle));

        while ($line = fgets($inputHandle)) {
            $input[] = $line;
        }

        ob_start();
        require $path . '/index.php';
        $result = trim(ob_get_clean());

        printf(
            "%sIO %d\t%sRésultat attendu: %s%s\t%sResultat obtenu: %s%s\t%s%s%s\n",
            "\033[1;33m",
            $matches['id'],
            "\033[1;36m",
            "\033[1;35m",
            $output,
            "\033[1;36m",
            "\033[1;35m",
            $result,
            "\033[1;" . ($output === $result ? 92 : 91) . "m",
            $output === $result ? 'Ok' : 'Pas Ok',
            "\033[0m"
        );
    }
}
