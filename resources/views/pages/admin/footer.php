    <div class="slim-footer">
        <div class="container-fluid text-center">
            <p class="w-100">Copyright 2019 &copy; All Rights Reserved.</p>
        </div>
    </div>
    <!-- Add Category Modal -->
    <div id="add-modal" class="modal fade">
      <div class="modal-dialog modal-dialog-vertical-center custom-modal" role="document">
        <div class="modal-content modal-sm bd-0 tx-14">
            <div class="modal-header">
                <h5 class="mg-b-0 tx-uppercase tx-inverse">Add Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pd-25">
                <div class="row">
                    <div class="col">
                        <input class="form-control" placeholder="Enter Category Name" type="text">
                    </div>
                </div>
                <div class="text-right mt-3">
                    <a href="#!" class="btn btn-primary btn-oblong" data-dismiss="modal" aria-label="Close">Save</a>
                </div>
            </div>
        </div>
      </div><!-- modal-dialog -->
    </div>
    <!-- Category Edit Modal -->
    <div id="edit-modal" class="modal fade">
      <div class="modal-dialog modal-dialog-vertical-center custom-modal" role="document">
        <div class="modal-content modal-sm bd-0 tx-14">
            <div class="modal-header">
                <h5 class="mg-b-0 tx-uppercase tx-inverse">Edit Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pd-25">
                <div class="row">
                    <div class="col">
                        <input class="form-control" value="Category 1" type="text">
                    </div>
                </div>
                <div class="text-right mt-3">
                    <a href="#!" class="btn btn-primary btn-oblong">Save</a>
                </div>
            </div>
        </div>
      </div><!-- modal-dialog -->
    </div>

    <script src="lib/jquery/js/jquery.js"></script>
    <script src="lib/popper.js/js/popper.js"></script>
    <script src="lib/bootstrap/js/bootstrap.js"></script>
    <script src="lib/datatables/js/jquery.dataTables.js"></script>
    <script src="lib/datatables-responsive/js/dataTables.responsive.js"></script>
    <script src="lib/select2/js/select2.min.js"></script>
    <script src="lib/jquery.cookie/js/jquery.cookie.js"></script>
    <script src="lib/chartist/js/chartist.js"></script>
    <script src="lib/d3/js/d3.js"></script>
    <script src="lib/rickshaw/js/rickshaw.min.js"></script>
    <script src="lib/jquery.sparkline.bower/js/jquery.sparkline.min.js"></script>

    <script src="js/ResizeSensor.js"></script>
<!--    <script src="js/dashboard.js"></script>-->
    <script src="js/slim.js"></script>
    <script type="text/javascript">
        // Initialize tooltip
        $('[data-toggle="tooltip"]').tooltip();
        $(function(){
            // showing modal with effect
            $('.modal-effect').on('click', function(e){
              e.preventDefault();
              var effect = $(this).attr('data-effect');
              $('#modaldemo8').addClass(effect);
            });
            // hide modal with effect
            $('#modaldemo8').on('hidden.bs.modal', function (e) {
              $(this).removeClass (function (index, className) {
                  return (className.match (/(^|\s)effect-\S+/g) || []).join(' ');
              });
            });
        });
        
        $(function(){
        'use strict';

        $('#datatable1').DataTable({
          responsive: true,
          language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
          }
        });

        $('#datatable2').DataTable({
          bLengthChange: false,
          searching: false,
          responsive: true
        });

        // Select2
        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

      });
    </script>
  </body>
</html>