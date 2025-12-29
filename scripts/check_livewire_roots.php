<?php
$dir = __DIR__ . '/../resources/views/livewire';
$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
$files = [];
foreach ($rii as $file) {
    if ($file->isDir()) continue;
    if (substr($file->getFilename(), -10) === '.blade.php') {
        $files[] = $file->getPathname();
    }
}

libxml_use_internal_errors(true);
foreach ($files as $f) {
    $s = file_get_contents($f);
    // Remove Blade directives roughly
    $t = preg_replace('/@\w+(?:[^\n\r]*)/','', $s);
    $t = preg_replace('/{{\s*[^}]*\s*}}/','', $t);
    $t = preg_replace('/{!!\s*[^}]*\s*!!}/','', $t);
    $t = preg_replace('/<\?php[\s\S]*?\?>/','', $t);
    $d = new DOMDocument();
    // wrap in html
    $ok = $d->loadHTML('<?xml encoding="utf-8"?>' . $t);
    if (!$ok) {
        echo "ERR parse: $f\n";
        continue;
    }
    $body = $d->getElementsByTagName('body')->item(0);
    $cnt = 0;
    foreach ($body->childNodes as $n) {
        if ($n->nodeType === 1) $cnt++;
    }
    echo "count=$cnt \t $f\n";
}
