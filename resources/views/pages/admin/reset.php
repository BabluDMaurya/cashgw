<?php $pgname = "login";
include 'login-header.php';
?>
    <div class="signin-wrapper">
      <div class="signin-box">        
        <h2 class="signin-title-primary">Reset Password</h2>
        <div class="form-group position-relative">
          <input type="password" class="form-control" placeholder="New Password">
          <i class="fa fa-eye password-icon" aria-hidden="true"></i>
        </div>
        <div class="form-group position-relative">
          <input type="password" class="form-control" placeholder="Confirm New Password">
          <i class="fa fa-eye password-icon" aria-hidden="true"></i>
        </div>
        <div class="form-group mg-b-50 d-flex">
            <input type="text" class="form-control captcha-control" required="" id="captcha" value="2 + 2" readonly="">
            <input type="number" class="form-control" required="" id="captcha_number">
        </div>
        <a href="login.php" class="btn btn-primary btn-block btn-signin btn-oblong">Reset Password</a>
      </div>
    </div>
<?php include 'login-footer.php'; ?>