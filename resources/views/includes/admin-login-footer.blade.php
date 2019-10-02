  <script src="/public/js/jquery.js"></script>
<script src="/public/js/popper.js"></script>
    <script src="/public/js/bootstrap.js"></script>
    <script src="/public/js/slim.js"></script>
    <script type="text/javascript">
        $('.password-icon').each(function () {
            var eye = $(this);
            eye.on('click', function() {
                eye.toggleClass("fa-eye-slash fa-eye");
                eye.siblings("input").each(function () {
                    if (eye.hasClass('fa-eye-slash')) {
                        $(this).attr('type', 'text');
                    }
                    else if (eye.hasClass('fa-eye')) {
                        $(this).attr('type', 'password');
                    }
                });
            });
        });
    </script>
  </body>
</html>