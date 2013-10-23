<?php

$isLimit = !empty($scriptProperties['limit']);
$isCombo = !empty($scriptProperties['combo']);
$start = $modx->getOption('start', $scriptProperties, 0);
$limit = $modx->getOption('limit', $scriptProperties, 10);
$query = $modx->getOption('query', $scriptProperties, '');
$sort = 'pagetitle';
$dir = 'ASC';

$classname = 'modResource';

$c = $modx->newQuery($classname);
$c->select($modx->getSelectColumns($classname, $classname));
$c->where(array('pagetitle:LIKE' => '%' . $query . '%'));

$count = $modx->getCount($classname,$c);

$c->limit($limit, $start);

$c->sortby($sort, $dir);
$stmt = $c->prepare();
//echo $c->toSql();
$stmt->execute();
$result = $stmt->fetchAll();

$rows = array();
foreach ($result as $row){
    $row['value'] = $row['id'];
    $row['text'] = $row['pagetitle'];
    $row['display'] = '<strong>'.$row['text'].'</strong><br />' . $row['value'] . '<hr />';
    $rows[] = $row;
}


return $this->outputArray($rows, $count);
