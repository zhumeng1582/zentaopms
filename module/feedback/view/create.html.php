<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<div id='mainMenu' class='clearfix'>
  <div class='btn-toolbar pull-left'><div class='page-title'><span class='text'><?php echo $lang->feedback->create;?></span></div></div>
</div>
<div id='mainContent' class='main-content'>
  <form method='post' enctype='multipart/form-data' target='hiddenwin' class='form-ajax'>
    <?php include __DIR__ . '/form.html.php';?>
  </form>
</div>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
