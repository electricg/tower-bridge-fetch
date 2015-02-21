<?php
date_default_timezone_set('Europe/London');
// ini_set('display_errors', 1);

$url = 'http://www.towerbridge.org.uk/lift-times/';
// $url = 'test.html';
$output = 'data.json';

$input = file_get_contents($url);
$data = array();

function td($xpath, $dom, $index) {
  $items = $xpath->query('./td['.$index.']', $dom);
  foreach ($items as $item) {
    return $item->nodeValue;
  }
}

if ($input != false) {
  $doc = new DOMDocument();
  $res = $doc->loadHTML($input);

  if ($res != false) {
    $xpath = new DOMXpath($doc);
    $trs = $xpath->query('//*/table[@class="lined"]/tbody/tr');

    if (!is_null($trs)) {
      foreach ($trs as $tr) {
        $tds = $xpath->query('./td', $tr);
        if (!is_null($tds)) {
          $entry = array();
          
          $date = new DateTime(td($xpath, $tr, 2).'T'.td($xpath, $tr, 3));
          $month = $date->format('n');
          $this_month = date('n');
          if ($month < $this_month) {
            $year = date('Y') + 1;
            $date = new DateTime(td($xpath, $tr, 2).' '.$year.'T'.td($xpath, $tr, 3));
          }
          $entry['date'] = $date->format('c');

          $entry['vessel'] = td($xpath, $tr, 4);

          $direction = td($xpath, $tr, 5);
          if (stripos($direction, 'down') != false) {
            $direction = 'down';
          }
          else {
            $direction = 'up';
          }
          $entry['direction'] = $direction;

          array_push($data, $entry);
        }
      }
    }

    $json = json_encode($data);
    file_put_contents($output, $json);
    echo "ok";
  }
}

?>