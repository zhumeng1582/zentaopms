<?php
$lang->feedback = new stdclass();

$lang->feedback->common       = '反馈';
$lang->feedback->browse       = '反馈列表';
$lang->feedback->admin        = '反馈管理';
$lang->feedback->create       = '创建反馈';
$lang->feedback->edit         = '编辑反馈';
$lang->feedback->view         = '反馈详情';
$lang->feedback->delete       = '删除反馈';
$lang->feedback->assignTo     = '指派';
$lang->feedback->close        = '关闭';
$lang->feedback->comment      = '备注';
$lang->feedback->basicInfo    = '基本信息';
$lang->feedback->history      = '历史记录';
$lang->feedback->aiAnalyze    = 'AI 分析';
$lang->feedback->notFound     = '反馈不存在或已删除。';
$lang->feedback->noData       = '暂无反馈';

$lang->feedback->id           = 'ID';
$lang->feedback->product      = '所属产品';
$lang->feedback->module       = '所属模块';
$lang->feedback->title        = '反馈名称';
$lang->feedback->type         = '类型';
$lang->feedback->solution     = '处理方案';
$lang->feedback->desc         = '描述';
$lang->feedback->pri          = '优先级';
$lang->feedback->status       = '状态';
$lang->feedback->public       = '公开';
$lang->feedback->notify       = '接收邮件通知';
$lang->feedback->notifyEmail  = '通知邮箱';
$lang->feedback->source       = '来源公司';
$lang->feedback->openedBy     = '创建者';
$lang->feedback->openedDate   = '创建时间';
$lang->feedback->reviewedBy   = '评审者';
$lang->feedback->reviewedDate = '评审时间';
$lang->feedback->processedBy  = '处理者';
$lang->feedback->processedDate= '处理时间';
$lang->feedback->closedBy     = '关闭者';
$lang->feedback->closedDate   = '关闭时间';
$lang->feedback->closedReason = '关闭原因';
$lang->feedback->assignedTo   = '指派给';
$lang->feedback->assignedDate = '指派时间';
$lang->feedback->feedbackBy   = '反馈者';
$lang->feedback->mailto       = '抄送给';
$lang->feedback->keywords     = '关键词';
$lang->feedback->files        = '附件';
$lang->feedback->actions      = '操作';
$lang->feedback->allProduct   = '全部产品';

$lang->feedback->menu = new stdclass();
$lang->feedback->menu->browse = array('link' => '反馈|feedback|browse', 'alias' => 'admin,view,create,edit');

$lang->feedback->browseTypeList = array();
$lang->feedback->browseTypeList['all']        = '全部';
$lang->feedback->browseTypeList['wait']       = '待处理';
$lang->feedback->browseTypeList['doing']      = '处理中';
$lang->feedback->browseTypeList['toclosed']   = '待关闭';
$lang->feedback->browseTypeList['review']     = '待评审';
$lang->feedback->browseTypeList['assigntome'] = '指派给我';
$lang->feedback->browseTypeList['openedbyme'] = '由我反馈';
$lang->feedback->browseTypeList['public']     = '公开';

$lang->feedback->featureBar = array();
$lang->feedback->featureBar['browse'] = $lang->feedback->browseTypeList;
$lang->feedback->featureBar['admin']  = $lang->feedback->browseTypeList;

$lang->feedback->typeList = array();
$lang->feedback->typeList['requirement'] = '需求';
$lang->feedback->typeList['bug']         = 'Bug';
$lang->feedback->typeList['task']        = '任务';
$lang->feedback->typeList['question']    = '问题';
$lang->feedback->typeList['advice']      = '建议';
$lang->feedback->typeList['other']       = '其他';

$lang->feedback->solutionList = array();
$lang->feedback->solutionList['']        = '';
$lang->feedback->solutionList['tobug']   = '转 Bug';
$lang->feedback->solutionList['tostory'] = '转需求';
$lang->feedback->solutionList['totask']  = '转任务';
$lang->feedback->solutionList['comment'] = '备注处理';
$lang->feedback->solutionList['closed']  = '直接关闭';

$lang->feedback->statusList = array();
$lang->feedback->statusList['wait']     = '待处理';
$lang->feedback->statusList['doing']    = '处理中';
$lang->feedback->statusList['toclosed'] = '待关闭';
$lang->feedback->statusList['review']   = '待评审';
$lang->feedback->statusList['closed']   = '已关闭';

$lang->feedback->priList = array();
$lang->feedback->priList[1] = '1';
$lang->feedback->priList[2] = '2';
$lang->feedback->priList[3] = '3';
$lang->feedback->priList[4] = '4';

$lang->feedback->closedReasonList = array();
$lang->feedback->closedReasonList['done']      = '已处理';
$lang->feedback->closedReasonList['duplicate'] = '重复';
$lang->feedback->closedReasonList['refuse']    = '不予处理';
$lang->feedback->closedReasonList['external']  = '外部原因';
