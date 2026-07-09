<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<?php
$browseLink = $this->session->feedbackList ? $this->session->feedbackList : $this->createLink('feedback', 'browse');
$statusName = zget($lang->feedback->statusList, $feedback->status, $feedback->status);
$typeName   = zget($lang->feedback->typeList, $feedback->type, $feedback->type);
$priName    = zget($lang->feedback->priList, $feedback->pri, $feedback->pri);
?>
<style>
.feedback-view-title{display:flex;align-items:center;gap:10px;font-size:16px;font-weight:700}
.feedback-label{display:inline-block;padding:2px 6px;border-radius:3px;background:#e8f1ff;color:#0b74de;font-size:12px}
.feedback-layout{display:flex;gap:12px}
.feedback-main{flex:1;min-width:0}
.feedback-side{width:320px}
.feedback-desc{min-height:360px;line-height:1.7}
.feedback-desc img{max-width:100%;height:auto}
.feedback-files img{max-width:260px;max-height:160px;margin:8px 12px 8px 0;border:1px solid #ddd}
.feedback-actions{position:sticky;bottom:0;padding:12px;text-align:center;background:rgba(45,52,64,.95);z-index:10}
.feedback-actions .btn{margin:0 4px}
.feedback-basic th{width:90px;color:#667085;font-weight:400}
.feedback-history{margin-top:12px}
.feedback-history li{margin:8px 0}
</style>

<div id='mainMenu' class='clearfix'>
  <div class='btn-toolbar pull-left'>
    <?php echo html::a($browseLink, "<i class='icon icon-back'></i> {$lang->goback}", '', "class='btn btn-link'");?>
    <span class='feedback-label'><?php echo $feedback->id;?></span>
    <?php if($feedback->public):?><span class='feedback-label'><?php echo $lang->feedback->public;?></span><?php endif;?>
    <span class='feedback-view-title'><?php echo $feedback->title;?></span>
    <span class='label label-info'><?php echo $statusName;?></span>
    <span class='label label-info'><?php echo $typeName;?></span>
  </div>
</div>

<div id='mainContent' class='feedback-layout'>
  <div class='feedback-main'>
    <div class='cell'>
      <div class='detail'>
        <div class='detail-title'><?php echo $lang->feedback->desc;?></div>
        <div class='detail-content feedback-desc'><?php echo $feedback->desc;?></div>
        <?php if(!empty($feedback->files)):?>
        <div class='feedback-files'>
          <?php foreach($feedback->files as $file):?>
          <?php $isImage = in_array(strtolower($file->extension), array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'));?>
          <?php if($isImage):?>
          <a href='<?php echo $this->createLink('file', 'download', "fileID={$file->id}&mouse=left");?>' target='_blank'><img src='<?php echo $this->createLink('file', 'read', "fileID={$file->id}");?>' title='<?php echo $file->title;?>' /></a>
          <?php else:?>
          <div><?php echo html::a($this->createLink('file', 'download', "fileID={$file->id}"), "<i class='icon icon-paper-clip'></i> " . $file->title);?></div>
          <?php endif;?>
          <?php endforeach;?>
        </div>
        <?php endif;?>
      </div>
    </div>

    <div class='cell feedback-history'>
      <div class='detail'>
        <div class='detail-title'><?php echo $lang->feedback->history;?></div>
        <div class='detail-content'>
          <?php if(empty($actions)):?>
          <div class='text-muted'><?php echo $lang->noData;?></div>
          <?php else:?>
          <ol>
            <?php foreach($actions as $action):?>
            <li>
              <?php echo $action->date;?>，
              <?php echo zget($users, $action->actor, $action->actor);?>
              <?php echo zget($lang->action->label, $action->action, $action->action);?>
              <?php if(!empty($action->comment)):?><div class='text-muted'><?php echo $action->comment;?></div><?php endif;?>
            </li>
            <?php endforeach;?>
          </ol>
          <?php endif;?>
        </div>
      </div>
    </div>
  </div>

  <div class='feedback-side'>
    <div class='cell'>
      <div class='panel'>
        <div class='panel-heading'><strong><?php echo $lang->feedback->basicInfo;?></strong></div>
        <table class='table table-data feedback-basic'>
          <tr><th><?php echo $lang->feedback->product;?></th><td><?php echo zget($products, $feedback->product, '');?></td></tr>
          <tr><th><?php echo $lang->feedback->module;?></th><td><?php echo zget($modules, $feedback->module, '/');?></td></tr>
          <tr><th><?php echo $lang->feedback->status;?></th><td><?php echo $statusName;?></td></tr>
          <tr><th><?php echo $lang->feedback->type;?></th><td><?php echo $typeName;?></td></tr>
          <tr><th><?php echo $lang->feedback->pri;?></th><td><?php echo $priName;?></td></tr>
          <tr><th><?php echo $lang->feedback->solution;?></th><td><?php echo zget($lang->feedback->solutionList, $feedback->solution, $feedback->solution);?></td></tr>
          <tr><th><?php echo $lang->feedback->openedBy;?></th><td><?php echo zget($users, $feedback->openedBy, $feedback->openedBy) . ' ' . $feedback->openedDate;?></td></tr>
          <tr><th><?php echo $lang->feedback->assignedTo;?></th><td><?php echo zget($users, $feedback->assignedTo, $feedback->assignedTo);?></td></tr>
          <tr><th><?php echo $lang->feedback->feedbackBy;?></th><td><?php echo $feedback->feedbackBy;?></td></tr>
          <tr><th><?php echo $lang->feedback->source;?></th><td><?php echo $feedback->source;?></td></tr>
          <tr><th><?php echo $lang->feedback->notifyEmail;?></th><td><?php echo $feedback->notifyEmail;?></td></tr>
          <tr><th><?php echo $lang->feedback->mailto;?></th><td><?php echo $feedback->mailto;?></td></tr>
          <tr><th><?php echo $lang->feedback->keywords;?></th><td><?php echo $feedback->keywords;?></td></tr>
          <tr><th><?php echo $lang->feedback->closedReason;?></th><td><?php echo zget($lang->feedback->closedReasonList, $feedback->closedReason, $feedback->closedReason);?></td></tr>
        </table>
      </div>
    </div>
  </div>
</div>

<div class='feedback-actions'>
  <?php echo html::a($browseLink, "<i class='icon icon-back'></i> {$lang->goback}", '', "class='btn btn-default'");?>
  <?php echo html::a($this->createLink('feedback', 'assignTo', "feedbackID={$feedback->id}", '', true), "<i class='icon icon-hand-right'></i> {$lang->feedback->assignTo}", '', "class='iframe btn btn-primary' data-width='520'");?>
  <?php echo html::a($this->createLink('feedback', 'edit', "feedbackID={$feedback->id}"), "<i class='icon icon-edit'></i> {$lang->feedback->edit}", '', "class='btn btn-primary'");?>
  <?php echo html::a($this->createLink('feedback', 'close', "feedbackID={$feedback->id}", '', true), "<i class='icon icon-off'></i> {$lang->feedback->close}", '', "class='iframe btn btn-primary' data-width='520'");?>
  <?php echo html::a($this->createLink('feedback', 'delete', "feedbackID={$feedback->id}"), "<i class='icon icon-trash'></i> {$lang->feedback->delete}", 'hiddenwin', "class='btn btn-danger' onclick='return confirm(\"{$lang->confirmDelete}\")'");?>
</div>

<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
