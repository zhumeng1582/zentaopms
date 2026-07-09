<?php include $app->getModuleRoot() . 'common/view/header.lite.html.php';?>
<form method='post' target='hiddenwin' class='form-ajax'>
  <table class='table table-form'>
    <tr>
      <th class='w-100px'><?php echo $lang->feedback->closedReason;?></th>
      <td><?php echo html::select('closedReason', $lang->feedback->closedReasonList, 'done', "class='form-control chosen'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->feedback->comment;?></th>
      <td><?php echo html::textarea('comment', '', "rows='4' class='form-control'");?></td>
    </tr>
    <tr>
      <td colspan='2' class='text-center form-actions'><?php echo html::submitButton($lang->feedback->close) . html::commonButton($lang->close, "data-dismiss='modal'");?></td>
    </tr>
  </table>
</form>
<?php include $app->getModuleRoot() . 'common/view/footer.lite.html.php';?>
