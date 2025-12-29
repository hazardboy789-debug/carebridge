<?php
$s = file_get_contents(__DIR__ . '/../resources/views/livewire/patient/appointments.blade.php');
// Remove Blade directives roughly
$t = preg_replace('/@\w+(?:[^\n\r]*)/','', $s);
$t = preg_replace('/{{[^}]*}}/','', $t);
libxml_use_internal_errors(true);
$d = new DOMDocument();
$d->loadHTML('<?xml encoding="utf-8"?>'. $t);
$body = $d->getElementsByTagName('body')->item(0);
$cnt=0;
$nodes = [];
foreach ($body->childNodes as $n) {
    if ($n->nodeType===1) {
        $cnt++;
        $nodes[] = $d->saveHTML($n);
    }
}
echo "count=" . $cnt . PHP_EOL;
foreach ($nodes as $i => $n) {
    echo "--- node " . ($i+1) . " ---\n";
    echo $n . "\n";
}
