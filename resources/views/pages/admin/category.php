<?php $pgname = "category";
include 'header.php';
?>
    <div class="slim-mainpanel">
        <div class="container-fluid">
            <div class="slim-pageheader">
                <ol class="breadcrumb slim-breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Category</li>
                </ol>
                <h6 class="slim-pagetitle">Category</h6>
            </div>
            <div class="section-wrapper">
                <div class="table-wrapper">
                    <a id="add-cate" class="btn btn-primary btn-signin btn-oblong">Add Category</a>
                    <table id="category-table" class="table responsive table-hover mg-b-0 table-primary text-center border-0">
                        <thead>
                            <tr>
                                <th style="width: 10%;" class="text-center">Sr. No.</th>
                                <th>Category Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="text-center" scope="row">01</th>
                                <td>Category 1</td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">02</th>
                                <td>Category 2</td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">03</th>
                                <td>Category 3</td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">04</th>
                                <td>Category 4</td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">05</th>
                                <td>Category 5</td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">06</th>
                                <td>Category 6</td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">07</th>
                                <td>Category 7</td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">08</th>
                                <td>Category 8</td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">09</th>
                                <td>Category 9</td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">10</th>
                                <td>Category 10</td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">11</th>
                                <td>Category 11</td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">12</th>
                                <td>Category 12</td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">13</th>
                                <td>Category 3</td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">14</th>
                                <td>Category 14</td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">15</th>
                                <td>Category 15</td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">16</th>
                                <td>Category 16</td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">17</th>
                                <td>Category 17</td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">18</th>
                                <td>Category 18</td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">19</th>
                                <td>Category 19</td>
                            </tr>
                            <tr>
                                <th class="text-center" scope="row">20</th>
                                <td>Category 20</td>
                            </tr>
                        </tbody>
                    </table>
                </div><!-- table-wrapper -->                
            </div>
        </div><!-- container -->
    </div><!-- slim-mainpanel -->

<?php include 'footer.php'; ?>
   <script src="js/jquery.tabledit.js"></script>
    <script>
        $(function(){
            'use strict';
            $('#category-table').DataTable({
                responsive: true,
                ordering: false,
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_ items/page',
                }
            });
            $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
        });
        
//         $(document).ready(function() {
//            $("#add-cate").click(function() {
//              $('#category-table tbody>tr:last').clone(true).insertAfter('#category-table tbody>tr:last');
//              return false;
//            });
//        });
        
        $("#add-cate").click(function() { 
                var tableditTableName = '#category-table';  // Identifier of table
                var newID = parseInt($(tableditTableName + " tr:last").attr("id")) + 1; 
                var clone = $("table tr:last").clone(); 
                $(".tabledit-span", clone).text(""); 
                $(".tabledit-input", clone).val(""); 
                clone.prependTo("table"); 
                $(tableditTableName + " tbody tr:first").attr("id", newID); 
                $(tableditTableName + " tbody tr:first td .tabledit-span.tabledit-identifier").text(newID); 
                $(tableditTableName + " tbody tr:first td .tabledit-input.tabledit-identifier").val(newID); 
                $(tableditTableName + " tbody tr:first td:last .tabledit-edit-button").trigger("click"); 
        });
        
        $('#category-table').Tabledit({
            columns: {
              identifier: [0, ''],                    
              editable: [[0, 'Sr. No.'], [1, 'Category Name']]
            }

        });       
       
    </script>