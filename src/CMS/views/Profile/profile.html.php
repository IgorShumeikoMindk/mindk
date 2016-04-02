<?php if (!isset($errors)) {
    $errors = array();
}

$getValidationClass = function ($field) use ($errors) {
    return isset($errors[$field])?'has-error has-feedback':'';
};

$getErrorBody = function ($field) use ($errors){
  if (isset($errors[$field])){
      return '<span class="glyphicon glyphicon-remove form-control-feedback"></span><span class="pull-right small form-error">'.$errors[$field].'</span>';
  }
    return '';
};

?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">User Profile</h3>
    </div>
    <div class="panel-body">

        <?php if (isset($error) && !is_array($error)) { ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <strong>Error!</strong> <?php echo $error ?>
            </div>
        <?php } ?>

        <form class="form-horizontal" role="form" method="post" id="post-form" action="<?php echo $action; ?>">
            <div class="form-group <?php echo $getValidationClass('email') ?>">
                <label class="col-sm-2 control-label">Email</label>

                <div class="col-sm-10">
                    <input type="text" class="form-control" name="Email" placeholder="Email" value="<?php echo @$user->email ?>">
                    <?php echo $getErrorBody('email')?>
                </div>
            </div>

            <div class="form-group <?php echo $getValidationClass('password') ?>">
                <label class="col-sm-2 control-label">Password</label>

                <div class="col-sm-10">
                    <input type="text" class="form-control" name="Password" placeholder="Password" value="<?php echo @$user->password ?>">
                    <?php echo $getErrorBody('password')?>
                </div>
            </div>

            <?php $generateToken() ?>

            <div class="btn-group pull-right">
                <button type="submit" class="btn btn-success mr-5">Save</button>
                <a href="/" class="btn btn-danger">Cancel</a>
            </div>
        </form>
    </div>
</div>
