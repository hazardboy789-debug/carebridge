<?php
$f = __DIR__ . '/../resources/views/livewire/patient/pharmacy.blade.php';
$s = file_get_contents($f);
$t = preg_replace('/@\w+(?:[^\n\r]*)/','', $s);
$t = preg_replace('/{{\s*[^}]*\s*}}/','', $t);
$t = preg_replace('/{!!\s*[^}]*\s*!!}/','', $t);
libxml_use_internal_errors(true);
$d = new DOMDocument();
$d->loadHTML('<?xml encoding="utf-8"?>' . $t);
$body = $d->getElementsByTagName('body')->item(0);
$cnt=0;
foreach ($body->childNodes as $n) {
    if ($n->nodeType===1) {
        $cnt++;
        $html = $d->saveHTML($n);
        echo "--- node $cnt (" . $n->nodeName . ") ---\n";
        echo substr(trim($html),0,200) . "\n\n";
    }
}
echo "TOTAL=" . $cnt . "\n";
