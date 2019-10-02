@extends('layouts.businessdashboard')
@section('content')   
<section class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                    <div class="block-item shadow-block">
                        <div class="balance-new-title mb-30">
                            <span>Bank List (Select your nearest Bank and Deposite the {{$request->balance}} on bank. Use reference code on deposit the amount)</span>                           
                        </div>
                    <form action="{{URL('/business-summary')}}" class="myform" method="post"> 
                        {{ csrf_field() }}
                        <input name="balance_request" type="hidden" value="{{$request->balance_request}}"/>
                        <input name="balance" type="hidden" value="{{$request->balance}}"/>
                        <table class="table table-bordered my-table">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Bank Name</th>
                                    <th>Bank Code</th>
                                    <th>Bank Branch</th>
                                    <th>IFSC Code</th>
                                    <th>Address</th>
                                    <th>Name</th>
                                    <th>A/C No.</th>
                                    <th>Reference Code</th>
                                    <th>Check</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($bankaccs) > 0)
                                    @php 
                                        $i = 1;
                                    @endphp
                                @foreach($bankaccs as $bankacc)                                
                                <tr>     
                                    <td>
                                        @php 
                                            echo $i;
                                        @endphp
                                    </td>
                                    <td>{{$bankacc->bank}}</td>
                                    <td>{{$bankacc->bankcode}}</td>
                                    <td>{{$bankacc->branch}}</td>
                                    <td>{{$bankacc->ifsc}}</td>
                                    <td>{{$bankacc->address}}</td>
                                    <td>{{$bankacc->name}}</td>
                                    <td>{{$bankacc->acno}}</td>
                                    <td>
                                        {{substr($bankacc->bank,0,2)}}{{__('_')}}{{$bankacc->ifsc}}{{__('_')}}{{decrypt($user_id)}}
                                    </td>
                                    <td>
                                        <input type="radio" name="bankid" value="{{$bankacc->id}}"/>
                                    </td>
                                </tr>
                                    @php 
                                        $i++;
                                    @endphp
                                @endforeach
                                @endif
                            </tbody>
                            </table>     
                        <button type="submit" class="btn btn-dark btn-block round-btn mt-20 mb-20 busi-sum-btn" id="addbankbutton">Send Request</button>
                    </form>
                    </div>
                </div>
        </div>
    </div>
</section>
<script>
    $(document).on('click','#addbankbutton',function(){
            $('#addbankbutton').hide();
            $('.loader').show();
        });
</script>
@endsection

