<?php $pgname = "login";
include 'login-header.php';
?>
    <div class="signin-wrapper">
      <div class="signin-box">        
        <h2 class="signin-title-primary">Login</h2>
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Enter email">
        </div>
        <div class="form-group position-relative">
          <input type="password" class="form-control" placeholder="Enter password">
          <i class="fa fa-eye password-icon" aria-hidden="true"></i>
        </div>
        <div class="form-group mg-b-50 d-flex">
            <input type="text" class="form-control captcha-control" required="" id="captcha" value="2 + 2" readonly="">
            <input type="number" class="form-control" required="" id="captcha_number">
        </div>
        <a href="#!" class="btn btn-primary btn-block btn-signin btn-oblong">Sign In</a>
        <div class="text-right mb-3">
            <a href="forgot.php">Forgot Password ?</a>
        </div>
        <p class="mg-b-0">Don't have an account? <a href="page-signup.html">Click here</a></p>
      </div>
    </div>
<?php include 'login-footer.php'; ?>