@extends('layouts.userdashboard')
@section('content')
<section id="tabs">
    <div class="">		
        <div class="row">
            <div class="col-xs-12 col-lg-12 ">
                <nav>
                    <div class="container pd0 position-relative">
                        <div class="nav nav-tabs " id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Activity </a>
                        </div>
                        <div class="search-top">
                            <select class="form-control">
                                <option selected="">Email Address</option>
                                <option>Transaction ID</option>
                                <option>First Name</option>
                                <option>Last Name</option>
                            </select>
                            <div class="form-group">
                                <input type="text" class="form-control" id="email" placeholder="Search for Transaction">
                            </div>
                        </div>
                    </div>
                </nav>
                <div class="tab-content py-3 px-3 px-sm-0 container" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="block-item shadow-block">
                                    <div class="filter-sec">
                                        <div class="select-boxes">
                                            <form class="common-form">
                                                <select class="form-control">
                                                    <option selected="">Active</option>
                                                    <option>Archieved</option>
                                                    <option>All</option>
                                                </select>
                                                <select class="form-control">
                                                    <option selected="">All Transaction</option>
                                                    <option>Payments Received</option>
                                                    <option>Payments sent</option>
                                                </select>
                                                <select class="form-control">
                                                    <option selected="">All Currencies</option>
                                                    <option>USD</option>
                                                    <option>AUD</option>
                                                    <option>GBP</option>
                                                </select>
                                                <select class="form-control">
                                                    <option selected="">Past 30 Days</option>
                                                    <option>Past 90 Days</option>
                                                    <option>All</option>
                                                </select>
                                            </form>
                                        </div>
                                        <div class="download-text">
                                            <i class="fas fa-arrow-down"></i>Download
                                        </div>
                                    </div>
                                    <table class="table table-bordered my-table">
                                        <thead>
                                            <tr>
                                                <th width="50px"></th>
                                                <th width="55px"></th>
                                                <th>Date</th>
                                                <th width="120px">Type</th>
                                                <th>Name</th>
                                                <th>payment</th>
                                                <th>Gross</th>
                                                <th>Free</th>
                                                <th>Net</th>
                                                <th>Balance</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="11">First 30 transactions</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="position-relative">
                                                        <label class="l-checkbox">       
                                                            <input type="checkbox">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="ico-down">
                                                        <a href="#!" id="show-down"><i class="fas fa-angle-down"></i></a>
                                                    </div>
                                                </td>
                                                <td>16-Nov-2018</td>
                                                <td>Purchase from</td>
                                                <td>Envato</td>
                                                <td>Completed</td>
                                                <td>-$ 12.00USD</td>
                                                <td>$ 0.00</td>
                                                <td class="dark">-$ 12.00</td>
                                                <td>$ 0.00 USD</td>
                                                <td ><a class="btn btn-archive">Archieve</a></td>
                                            </tr>
                                            <tr class="show1" style="display: none">
                                                <td class=""></td>
                                                <td class="secondaryAction"></td>
                                                <td>16-Nov-2018</td>
                                                <td>Withdraw from</td>
                                                <td>Credit Card</td>
                                                <td>Completed            </td>
                                                <td>-$ 12.00USD</td>
                                                <td>$ 0.00</td>
                                                <td class="dark">-$ 12.00</td>
                                                <td>$ 0.00 USD</td>
                                                <td><a class="btn btn-archive">Archieve</a></td>
                                            </tr>
                                            <tr class="show1" style="display: none">
                                                <td class=""></td>
                                                <td class="secondaryAction"></td>
                                                <td>16-Nov-2018</td>
                                                <td>Purchase from</td>
                                                <td>Paypal</td>
                                                <td>Completed</td>
                                                <td>-$ 12.00USD</td>
                                                <td>$ 0.00</td>
                                                <td class="dark">-$ 12.00</td>
                                                <td>$ 0.00 USD</td>
                                                <td ><a class="btn btn-archive">Archieve</a></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="position-relative">
                                                        <label class="l-checkbox">       
                                                            <input type="checkbox">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="ico-down">
                                                        <a href="#!" ><i class="fas fa-angle-down"></i></a>
                                                    </div>
                                                </td>
                                                <td>16-Nov-2018</td>
                                                <td>Purchase from</td>
                                                <td>Paypal</td>
                                                <td>Completed</td>
                                                <td>-$ 12.00USD</td>
                                                <td>$ 0.00</td>
                                                <td class="dark">-$ 12.00</td>
                                                <td>$ 0.00 USD</td>
                                                <td ><a class="btn btn-archive">Archieve</a></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="position-relative">
                                                        <label class="l-checkbox">       
                                                            <input type="checkbox">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="ico-down">
                                                        <a href="#!" ><i class="fas fa-angle-down"></i></a>
                                                    </div>
                                                </td>
                                                <td>16-Nov-2018</td>
                                                <td>Purchase from</td>
                                                <td>abc.com</td>
                                                <td>Completed</td>
                                                <td>-$ 12.00USD</td>
                                                <td>$ 0.00</td>
                                                <td class="dark">-$ 12.00</td>
                                                <td>$ 0.00 USD</td>
                                                <td ><a class="btn btn-archive">Archieve</a></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="position-relative">
                                                        <label class="l-checkbox">       
                                                            <input type="checkbox">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="ico-down">
                                                        <a href="#!" ><i class="fas fa-angle-down"></i></a>
                                                    </div>
                                                </td>
                                                <td>16-Nov-2018</td>
                                                <td>Purchase from</td>
                                                <td>abc.com</td>
                                                <td>Completed</td>
                                                <td>-$ 12.00USD</td>
                                                <td>$ 0.00</td>
                                                <td class="dark">-$ 12.00</td>
                                                <td>$ 0.00 USD</td>
                                                <td ><a class="btn btn-archive">Archieve</a></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="position-relative">
                                                        <label class="l-checkbox">       
                                                            <input type="checkbox">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="ico-down">
                                                        <a href="#!" ><i class="fas fa-angle-down"></i></a>
                                                    </div>
                                                </td>
                                                <td>16-Nov-2018</td>
                                                <td>Purchase from</td>
                                                <td>abc.com</td>
                                                <td>Completed</td>
                                                <td>-$ 12.00USD</td>
                                                <td>$ 0.00</td>
                                                <td class="dark">-$ 12.00</td>
                                                <td>$ 0.00 USD</td>
                                                <td ><a class="btn btn-archive">Archieve</a></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="position-relative">
                                                        <label class="l-checkbox">       
                                                            <input type="checkbox">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="ico-down">
                                                        <a href="#!" ><i class="fas fa-angle-down"></i></a>
                                                    </div>
                                                </td>
                                                <td>16-Nov-2018</td>
                                                <td>Purchase from</td>
                                                <td>abc.com</td>
                                                <td>Completed</td>
                                                <td>-$ 12.00USD</td>
                                                <td>$ 0.00</td>
                                                <td class="dark">-$ 12.00</td>
                                                <td>$ 0.00 USD</td>
                                                <td ><a class="btn btn-archive">Archieve</a></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="position-relative">
                                                        <label class="l-checkbox">       
                                                            <input type="checkbox">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="ico-down">
                                                        <a href="#!" ><i class="fas fa-angle-down"></i></a>
                                                    </div>
                                                </td>
                                                <td>16-Nov-2018</td>
                                                <td>Purchase from</td>
                                                <td>abc.com</td>
                                                <td>Completed</td>
                                                <td>-$ 12.00USD</td>
                                                <td>$ 0.00</td>
                                                <td class="dark">-$ 12.00</td>
                                                <td>$ 0.00 USD</td>
                                                <td ><a class="btn btn-archive">Archieve</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ./Tabs -->
<script>
    window.FontAwesomeConfig = {
        searchPseudoElements: true
    }
</script>
<script>
    $(document).ready(function () {
        $("#show-down").click(function () {
            $(".show1").fadeToggle();
            $(this).parent().parent().parent().toggleClass('bg-lightblue');
            $(this).parent().toggleClass('bg-darkblue');
            $(".show1").toggleClass('bg-lightblue');
            $(this).find('i').toggleClass('fa-angle-down fa-angle-up');
            ;
        });
    });
</script>
@endsection