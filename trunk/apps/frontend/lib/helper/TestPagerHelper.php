<?php
function test_pager($pager, $sort, $type)
{
	$navigation = '';
	$currentModule = sfContext::getInstance()->getModuleName();

  $uri = url_for($currentModule."/index?sort=$sort&type=$type&page=");

  // First and previous page
  if ($pager->getPage() != 1) {
    $navigation .= link_to('Primero', $uri.'1', array('class' => 'flecha l_all'));
    $navigation .= link_to('Atras', $uri.$pager->getPreviousPage(), array('class' => 'flecha l')).' ';
  }

  // Pages one by one
  $links = array();
  foreach ($pager->getLinks() as $page)
  {
    $links[] = link_to_unless($page == $pager->getPage(), $page, $uri.$page);
  }
  $navigation .= join('  ', $links);

  // Next and last page
  if ($pager->getPage() != $pager->getLastPage()) {
    $navigation .= ' '.link_to('Siguiente', $uri.$pager->getNextPage(), array('class' => 'flecha r'));
    $navigation .= link_to('Ultimo', $uri.$pager->getLastPage(), array('class' => 'flecha r_all'));
  }

  return $navigation;
}