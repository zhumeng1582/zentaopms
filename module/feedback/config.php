<?php
if(!isset($lang)) $lang = new stdclass();
if(!isset($lang->feedback)) $lang->feedback = new stdclass();
if(!isset($lang->feedback->assignTo))     $lang->feedback->assignTo     = '指派';
if(!isset($lang->feedback->edit))         $lang->feedback->edit         = '编辑反馈';
if(!isset($lang->feedback->close))        $lang->feedback->close        = '关闭';
if(!isset($lang->feedback->delete))       $lang->feedback->delete       = '删除反馈';
if(!isset($lang->feedback->priList))      $lang->feedback->priList      = array(1 => '1', 2 => '2', 3 => '3', 4 => '4');
if(!isset($lang->feedback->statusList))   $lang->feedback->statusList   = array('wait' => '待处理', 'doing' => '处理中', 'toclosed' => '待关闭', 'review' => '待评审', 'closed' => '已关闭');
if(!isset($lang->feedback->typeList))     $lang->feedback->typeList     = array('requirement' => '需求', 'bug' => 'Bug', 'task' => '任务', 'question' => '问题', 'advice' => '建议', 'other' => '其他');
if(!isset($lang->confirmDelete))          $lang->confirmDelete          = '您确定要执行删除操作吗？';

$config->feedback = new stdclass();
$config->feedback->create = new stdclass();
$config->feedback->edit   = new stdclass();

$config->feedback->create->requiredFields = 'product,title';
$config->feedback->edit->requiredFields   = 'product,title';

$config->feedback->actionList = array();
$config->feedback->actionList['assignTo']['icon']        = 'hand-right';
$config->feedback->actionList['assignTo']['text']        = $lang->feedback->assignTo;
$config->feedback->actionList['assignTo']['hint']        = $lang->feedback->assignTo;
$config->feedback->actionList['assignTo']['url']         = array('module' => 'feedback', 'method' => 'assignTo', 'params' => 'feedbackID={id}');
$config->feedback->actionList['assignTo']['data-toggle'] = 'modal';
$config->feedback->actionList['assignTo']['data-size']   = 'sm';

$config->feedback->actionList['edit']['icon'] = 'edit';
$config->feedback->actionList['edit']['text'] = $lang->feedback->edit;
$config->feedback->actionList['edit']['hint'] = $lang->feedback->edit;
$config->feedback->actionList['edit']['url']  = array('module' => 'feedback', 'method' => 'edit', 'params' => 'feedbackID={id}');

$config->feedback->actionList['close']['icon']        = 'off';
$config->feedback->actionList['close']['text']        = $lang->feedback->close;
$config->feedback->actionList['close']['hint']        = $lang->feedback->close;
$config->feedback->actionList['close']['url']         = array('module' => 'feedback', 'method' => 'close', 'params' => 'feedbackID={id}');
$config->feedback->actionList['close']['data-toggle'] = 'modal';
$config->feedback->actionList['close']['data-size']   = 'sm';

$config->feedback->actionList['delete']['icon']         = 'trash';
$config->feedback->actionList['delete']['text']         = $lang->feedback->delete;
$config->feedback->actionList['delete']['hint']         = $lang->feedback->delete;
$config->feedback->actionList['delete']['url']          = array('module' => 'feedback', 'method' => 'delete', 'params' => 'feedbackID={id}');
$config->feedback->actionList['delete']['className']    = 'ajax-submit';
$config->feedback->actionList['delete']['data-confirm'] = array('message' => $lang->confirmDelete, 'icon' => 'icon-exclamation-sign', 'iconClass' => 'warning-pale rounded-full icon-2x');
$config->feedback->actionList['delete']['notInModal']   = true;

$config->feedback->dtable = new stdclass();
$config->feedback->dtable->defaultField = array('id', 'title', 'pri', 'status', 'type', 'productName', 'assignedTo', 'openedBy', 'openedDate', 'actions');
$config->feedback->dtable->fieldList = array();
$config->feedback->dtable->fieldList['id']          = array('name' => 'id',          'title' => $lang->idAB,              'type' => 'id',       'fixed' => 'left',  'width' => '70',  'sortType' => true);
$config->feedback->dtable->fieldList['title']       = array('name' => 'title',       'title' => 'title',                 'type' => 'title',    'fixed' => 'left',  'flex' => 1,      'sortType' => true, 'link' => array('module' => 'feedback', 'method' => 'view', 'params' => 'feedbackID={id}'));
$config->feedback->dtable->fieldList['pri']         = array('name' => 'pri',         'title' => 'pri',                   'type' => 'pri',      'width' => '80',  'sortType' => true, 'priList' => $lang->feedback->priList);
$config->feedback->dtable->fieldList['status']      = array('name' => 'status',      'title' => 'status',                'type' => 'status',   'width' => '100', 'sortType' => true, 'statusMap' => $lang->feedback->statusList);
$config->feedback->dtable->fieldList['type']        = array('name' => 'type',        'title' => 'type',                  'type' => 'category', 'width' => '100', 'sortType' => true, 'map' => $lang->feedback->typeList);
$config->feedback->dtable->fieldList['productName'] = array('name' => 'productName', 'title' => 'product',               'type' => 'text',     'width' => '140');
$config->feedback->dtable->fieldList['assignedTo']  = array('name' => 'assignedTo',  'title' => 'assignedTo',            'type' => 'assign',   'width' => '110', 'sortType' => true, 'assignLink' => array('module' => 'feedback', 'method' => 'assignTo', 'params' => 'feedbackID={id}'));
$config->feedback->dtable->fieldList['openedBy']    = array('name' => 'openedBy',    'title' => 'openedBy',              'type' => 'user',     'width' => '110', 'sortType' => true);
$config->feedback->dtable->fieldList['openedDate']  = array('name' => 'openedDate',  'title' => 'openedDate',            'type' => 'date',     'width' => '160', 'sortType' => true);
$config->feedback->dtable->fieldList['actions']     = array('name' => 'actions',     'title' => $lang->actions,          'type' => 'actions',  'width' => '130', 'fixed' => 'right', 'sortType' => false, 'list' => $config->feedback->actionList, 'menu' => array('assignTo', 'edit', 'close', 'delete'));
