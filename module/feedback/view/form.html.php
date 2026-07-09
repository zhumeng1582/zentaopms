<?php
$isEdit = isset($feedback);
if(!$isEdit)
{
    $feedback = new stdclass();
    $feedback->product = 0;
    $feedback->module = 0;
    $feedback->type = 'requirement';
    $feedback->title = '';
    $feedback->public = 1;
    $feedback->pri = 3;
    $feedback->desc = '';
    $feedback->feedbackBy = '';
    $feedback->source = '';
    $feedback->notifyEmail = '';
    $feedback->mailto = '';
    $feedback->keywords = '';
    $feedback->notify = 1;
    $feedback->assignedTo = '';
}
?>
<table class='table table-form'>
  <tr>
    <th class='w-120px required'><?php echo $lang->feedback->product;?></th>
    <td class='w-500px'><?php echo html::select('product', $products, $feedback->product, "class='form-control chosen' onchange='loadFeedbackModules(this.value)'");?></td>
  </tr>
  <tr>
    <th><?php echo $lang->feedback->module;?></th>
    <td id='moduleBox'><?php echo html::select('module', $modules, $feedback->module, "class='form-control chosen'");?></td>
  </tr>
  <tr>
    <th><?php echo $lang->feedback->type;?></th>
    <td><?php echo html::select('type', $lang->feedback->typeList, $feedback->type, "class='form-control chosen'");?></td>
  </tr>
  <tr>
    <th class='required'><?php echo $lang->feedback->title;?></th>
    <td colspan='3'>
      <div class='input-group'>
        <?php echo html::input('title', $feedback->title, "class='form-control'");?>
        <span class='input-group-addon'><?php echo html::checkbox('public', array('on' => $lang->feedback->public), $feedback->public ? 'on' : '');?></span>
        <span class='input-group-addon'><?php echo $lang->feedback->pri;?></span>
        <?php echo html::select('pri', $lang->feedback->priList, $feedback->pri, "class='form-control' style='width:80px'");?>
      </div>
    </td>
  </tr>
  <tr>
    <th><?php echo $lang->feedback->desc;?></th>
    <td colspan='3'><?php echo html::textarea('desc', $feedback->desc, "rows='12' class='form-control' placeholder='可以在这里粘贴文字、错误信息和截图说明。'");?></td>
  </tr>
  <tr>
    <th><?php echo $lang->feedback->assignedTo;?></th>
    <td><?php echo html::select('assignedTo', array('' => '') + $users, $feedback->assignedTo, "class='form-control chosen'");?></td>
  </tr>
  <tr>
    <th><?php echo $lang->feedback->feedbackBy;?></th>
    <td><?php echo html::input('feedbackBy', $feedback->feedbackBy, "class='form-control'");?></td>
  </tr>
  <tr>
    <th><?php echo $lang->feedback->source;?></th>
    <td><?php echo html::input('source', $feedback->source, "class='form-control'");?></td>
  </tr>
  <tr>
    <th><?php echo $lang->feedback->notifyEmail;?></th>
    <td><?php echo html::input('notifyEmail', $feedback->notifyEmail, "class='form-control'");?></td>
  </tr>
  <tr>
    <th><?php echo $lang->feedback->mailto;?></th>
    <td><?php echo html::select('mailto[]', $users, explode(',', (string)$feedback->mailto), "class='form-control chosen' multiple");?></td>
  </tr>
  <tr>
    <th><?php echo $lang->feedback->keywords;?></th>
    <td><?php echo html::input('keywords', $feedback->keywords, "class='form-control'");?></td>
  </tr>
  <tr>
    <th><?php echo $lang->feedback->files;?></th>
    <td colspan='3'><input type='file' name='files[]' multiple class='form-control' /></td>
  </tr>
  <tr>
    <th><?php echo $lang->feedback->notify;?></th>
    <td><?php echo html::checkbox('notify', array('on' => $lang->feedback->notify), $feedback->notify ? 'on' : '');?></td>
  </tr>
  <?php if($isEdit):?>
  <tr>
    <th><?php echo $lang->feedback->comment;?></th>
    <td colspan='3'><?php echo html::textarea('comment', '', "rows='3' class='form-control'");?></td>
  </tr>
  <?php endif;?>
  <tr>
    <td colspan='4' class='text-center form-actions'><?php echo html::submitButton() . html::backButton();?></td>
  </tr>
</table>
<script>
function loadFeedbackModules(productID)
{
    $('#moduleBox').load(createLink('feedback', 'ajaxGetModules', 'productID=' + productID), function(){ $('#moduleBox .chosen').chosen(); });
}
</script>
