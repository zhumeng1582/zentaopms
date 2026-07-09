<?php
declare(strict_types=1);

namespace zin;

foreach($feedbacks as $feedback)
{
    $feedback->productName = zget($products, $feedback->product, '');
}

$actionList = array();
$actionList['assignTo']['icon']        = 'hand-right';
$actionList['assignTo']['text']        = $lang->feedback->assignTo;
$actionList['assignTo']['hint']        = $lang->feedback->assignTo;
$actionList['assignTo']['url']         = array('module' => 'feedback', 'method' => 'assignTo', 'params' => 'feedbackID={id}');
$actionList['assignTo']['data-toggle'] = 'modal';
$actionList['assignTo']['data-size']   = 'sm';

$actionList['edit']['icon'] = 'edit';
$actionList['edit']['text'] = $lang->feedback->edit;
$actionList['edit']['hint'] = $lang->feedback->edit;
$actionList['edit']['url']  = array('module' => 'feedback', 'method' => 'edit', 'params' => 'feedbackID={id}');

$actionList['close']['icon']        = 'off';
$actionList['close']['text']        = $lang->feedback->close;
$actionList['close']['hint']        = $lang->feedback->close;
$actionList['close']['url']         = array('module' => 'feedback', 'method' => 'close', 'params' => 'feedbackID={id}');
$actionList['close']['data-toggle'] = 'modal';
$actionList['close']['data-size']   = 'sm';

$actionList['delete']['icon']         = 'trash';
$actionList['delete']['text']         = $lang->feedback->delete;
$actionList['delete']['hint']         = $lang->feedback->delete;
$actionList['delete']['url']          = array('module' => 'feedback', 'method' => 'delete', 'params' => 'feedbackID={id}');
$actionList['delete']['className']    = 'ajax-submit';
$actionList['delete']['data-confirm'] = array('message' => $lang->confirmDelete, 'icon' => 'icon-exclamation-sign', 'iconClass' => 'warning-pale rounded-full icon-2x');
$actionList['delete']['notInModal']   = true;

$cols = array();
$cols['id']          = array('name' => 'id',          'title' => $lang->idAB,                 'type' => 'id',       'fixed' => 'left',  'width' => '70',  'sortType' => true);
$cols['title']       = array('name' => 'title',       'title' => $lang->feedback->title,      'type' => 'title',    'fixed' => 'left',  'flex' => 1,      'sortType' => true, 'link' => array('module' => 'feedback', 'method' => 'view', 'params' => 'feedbackID={id}'));
$cols['pri']         = array('name' => 'pri',         'title' => $lang->feedback->pri,        'type' => 'pri',      'width' => '80',  'sortType' => true, 'priList' => $lang->feedback->priList);
$cols['status']      = array('name' => 'status',      'title' => $lang->feedback->status,     'type' => 'status',   'width' => '100', 'sortType' => true, 'statusMap' => $lang->feedback->statusList);
$cols['type']        = array('name' => 'type',        'title' => $lang->feedback->type,       'type' => 'category', 'width' => '100', 'sortType' => true, 'map' => $lang->feedback->typeList);
$cols['productName'] = array('name' => 'productName', 'title' => $lang->feedback->product,    'type' => 'text',     'width' => '140');
$cols['assignedTo']  = array('name' => 'assignedTo',  'title' => $lang->feedback->assignedTo, 'type' => 'assign',   'width' => '110', 'sortType' => true, 'assignLink' => array('module' => 'feedback', 'method' => 'assignTo', 'params' => 'feedbackID={id}'));
$cols['openedBy']    = array('name' => 'openedBy',    'title' => $lang->feedback->openedBy,   'type' => 'user',     'width' => '110', 'sortType' => true);
$cols['openedDate']  = array('name' => 'openedDate',  'title' => $lang->feedback->openedDate, 'type' => 'date',     'width' => '160', 'sortType' => true);
$cols['actions']     = array('name' => 'actions',     'title' => $lang->actions,              'type' => 'actions',  'width' => '130', 'fixed' => 'right', 'sortType' => false, 'list' => $actionList, 'menu' => array('assignTo', 'edit', 'close', 'delete'));

$tableData = initTableData($feedbacks, $cols, $this->feedback);

featureBar
(
    set::current($browseType),
    set::linkParams("browseType={key}&productID={$productID}&orderBy={$orderBy}")
);

toolbar
(
    item(set(array
    (
        'text'  => $lang->feedback->create,
        'icon'  => 'plus',
        'class' => 'primary',
        'url'   => helper::createLink('feedback', 'create')
    )))
);

dtable
(
    set::cols($cols),
    set::data($tableData),
    set::userMap($users),
    set::customCols(true),
    set::orderBy($orderBy),
    set::sortLink(helper::createLink('feedback', 'browse', "browseType={$browseType}&productID={$productID}&orderBy={name}_{sortType}&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}&pageID={$pager->pageID}")),
    set::footPager(usePager()),
    set::emptyTip($lang->feedback->noData)
);

render();
