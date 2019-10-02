    <!--<script src="lib/jquery/js/jquery.js"></script>-->
    <script src="lib/popper.js/js/popper.js"></script>
    <script src="lib/bootstrap/js/bootstrap.js"></script>
    <script src="js/slim.js"></script>
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