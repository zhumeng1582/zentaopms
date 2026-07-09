<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<?php
$browseLink = $this->createLink('feedback', 'browse', "browseType={browseType}&productID=$productID&orderBy=$orderBy");
$sortLink   = function(string $field) use($browseType, $productID, $orderBy)
{
    $sort = strpos($orderBy, "{$field}_") === 0 && substr($orderBy, -5) === '_desc' ? "{$field}_asc" : "{$field}_desc";
    return $this->createLink('feedback', 'browse', "browseType=$browseType&productID=$productID&orderBy=$sort");
};
?>
<style>
.feedback-side-list a{display:block;padding:7px 14px;color:#313c52}
.feedback-side-list a.active{background:#e8f1ff;color:#0b74de;font-weight:600}
.feedback-title-cell{max-width:560px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.feedback-toolbar-tabs .btn{border-radius:0}
.feedback-status-wait{color:#0b74de}.feedback-status-doing{color:#f56c6c}.feedback-status-closed{color:#8c99ad}
</style>
<div id='mainMenu' class='clearfix'>
  <div class='btn-toolbar pull-left feedback-toolbar-tabs'>
    <?php foreach($lang->feedback->browseTypeList as $type => $label):?>
    <?php echo html::a(str_replace('{browseType}', $type, $browseLink), $label . ($type == 'all' ? " <span class='label label-badge'>{$pager->recTotal}</span>" : ''), '', "class='btn btn-link " . ($browseType == $type ? 'btn-active-text' : '') . "'");?>
    <?php endforeach;?>
  </div>
  <div class='btn-toolbar pull-right'>
    <?php echo html::a($this->createLink('feedback', 'create'), "<i class='icon icon-plus'></i> {$lang->feedback->create}", '', "class='btn btn-primary'");?>
  </div>
</div>

<div id='mainContent' class='main-row'>
  <div class='side-col' id='sidebar'>
    <div class='cell'>
      <div class='panel panel-sm'>
        <div class='panel-heading'><strong><?php echo $lang->feedback->allProduct;?></strong></div>
        <div class='feedback-side-list'>
          <?php echo html::a($this->createLink('feedback', 'browse', "browseType=$browseType&productID=0&orderBy=$orderBy"), $lang->feedback->allProduct, '', $productID == 0 ? "class='active'" : '');?>
          <?php foreach($products as $id => $name):?>
          <?php if(!$id) continue;?>
          <?php echo html::a($this->createLink('feedback', 'browse', "browseType=$browseType&productID=$id&orderBy=$orderBy"), $name, '', $productID == $id ? "class='active'" : '');?>
          <?php endforeach;?>
        </div>
      </div>
    </div>
  </div>
  <div class='main-col'>
    <div class='cell'>
      <form method='post' id='feedbackForm'>
        <table class='table has-sort-head table-fixed'>
          <thead>
            <tr>
              <th class='w-id'><?php echo html::a($sortLink('id'), $lang->feedback->id);?></th>
              <th><?php echo html::a($sortLink('title'), $lang->feedback->title);?></th>
              <th class='w-60px'>P</th>
              <th class='w-90px'><?php echo $lang->feedback->status;?></th>
              <th class='w-90px'><?php echo $lang->feedback->type;?></th>
              <th class='w-110px'><?php echo $lang->feedback->assignedTo;?></th>
              <th class='w-110px'><?php echo $lang->feedback->solution;?></th>
              <th class='w-110px'><?php echo $lang->feedback->openedBy;?></th>
              <th class='w-140px'><?php echo html::a($sortLink('openedDate'), $lang->feedback->openedDate);?></th>
              <th class='w-160px text-center'><?php echo $lang->feedback->actions;?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($feedbacks as $feedback):?>
            <tr>
              <td><?php echo $feedback->id;?></td>
              <td class='feedback-title-cell' title='<?php echo $feedback->title;?>'><?php echo html::a($this->createLink('feedback', 'view', "feedbackID={$feedback->id}"), $feedback->public ? "<span class='label label-info'>{$lang->feedback->public}</span> " . $feedback->title : $feedback->title);?></td>
              <td><span class='label label-pri label-pri-<?php echo $feedback->pri;?>'><?php echo zget($lang->feedback->priList, $feedback->pri, $feedback->pri);?></span></td>
              <td class='feedback-status-<?php echo $feedback->status;?>'><?php echo zget($lang->feedback->statusList, $feedback->status, $feedback->status);?></td>
              <td><?php echo zget($lang->feedback->typeList, $feedback->type, $feedback->type);?></td>
              <td><?php echo zget($users, $feedback->assignedTo, $feedback->assignedTo);?></td>
              <td><?php echo zget($lang->feedback->solutionList, $feedback->solution, $feedback->solution);?></td>
              <td><?php echo zget($users, $feedback->openedBy, $feedback->openedBy);?></td>
              <td><?php echo $feedback->openedDate;?></td>
              <td class='text-center'>
                <?php echo html::a($this->createLink('feedback', 'view', "feedbackID={$feedback->id}"), "<i class='icon icon-eye'></i>", '', "class='btn btn-link' title='{$lang->feedback->view}'");?>
                <?php echo html::a($this->createLink('feedback', 'assignTo', "feedbackID={$feedback->id}", '', true), "<i class='icon icon-hand-right'></i>", '', "class='iframe btn btn-link' data-width='520' title='{$lang->feedback->assignTo}'");?>
                <?php echo html::a($this->createLink('feedback', 'edit', "feedbackID={$feedback->id}"), "<i class='icon icon-edit'></i>", '', "class='btn btn-link' title='{$lang->feedback->edit}'");?>
                <?php echo html::a($this->createLink('feedback', 'close', "feedbackID={$feedback->id}", '', true), "<i class='icon icon-off'></i>", '', "class='iframe btn btn-link' data-width='520' title='{$lang->feedback->close}'");?>
                <?php echo html::a($this->createLink('feedback', 'delete', "feedbackID={$feedback->id}"), "<i class='icon icon-trash'></i>", 'hiddenwin', "class='btn btn-link' title='{$lang->feedback->delete}' onclick='return confirm(\"{$lang->confirmDelete}\")'");?>
              </td>
            </tr>
            <?php endforeach;?>
          </tbody>
        </table>
        <div class='table-footer'><?php $pager->show('right', 'pagerjs');?></div>
      </form>
    </div>
  </div>
</div>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
