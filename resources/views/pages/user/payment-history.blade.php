@extends('layouts.userdashboard')
@section('content')   
<section class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                    <div class="block-item shadow-block">
                        <div class="balance-new-title mb-30">
                            <span>Payment History</span>  
                            <select class="text-right main_select_change float-right" name="archieveView" id="archieveView">
                                <option disabled="" selected="">Select Option</option>
                                <option value="1">Archieve</option>
                                <option value="2">Unarchieve</option>
                            </select>
                        </div>
                        @if(count($paymenthistory) > 0)
                        <table class="table table-bordered my-table">
                            <thead>
                                <tr>
                                    <th class="width_145">Trnasaction ID</th>
                                    <th class="width_95">Name</th>
                                    <th class="width_91">Amount </th>
                                    <th class="width_91">Date</th>
                                    <th class="width_160">Email</th>
                                    <th class="width_220">Details</th>
                                    <th class="width_95">Status</th>
                                    <th class="width_130">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="bodydata">                              
                                @foreach($paymenthistory as $value)
                                    <tr class="">
                                        <td>{{$value->transactionid}}</td>
                                         <td>{{ucfirst($value->name)}}</td>
                                         <td>{{$value->amount}}</td>
                                         <td>{{$value->updated_at}}</td>
                                         <td>{{$value->email}}</td>
                                         <td><p class="truncl">{{$value->details}}</p></td>
                                         <td class="
                                                @if($value->tstatus == 1)
                                                {{__('green-text')}}
                                                @else {{__('red-text')}}
                                                @endif
                                             ">
                                                @if($value->tstatus == 1)
                                                {{__('Creadited')}}
                                                @else
                                                {{__('Debited')}}
                                                @endif
                                         </td>
                                         <td ><a class="btn btn-archive clickarchive" id="{{$value->id}}" data-archivetype="@if($value->archieve == 1){{__('2')}}@else{{__('1')}}@endif">@if($value->archieve == 1){{__('Archieve')}} @else {{__('Unarchieve')}} @endif</a></td>
                                     </tr>                                
                                @endforeach   
                            </tbody>
                            </table>          
                        @else
                            <p> No Transaction Done</p>
                        @endif
                    </div>
                </div>
        </div>
    </div>
</section>
<script>
    $(document).on('change','#archieveView',function(){
        var id = "{{$user_id}}";
        var archieve = $(this).val();        
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                url :'{{URL("individual-payment-history-archieve-view")}}',
                type :'POST',
                data: {id:id,status:archieve},
                success: function(response){
                    $('#bodydata').html(response);
                }
        });
    });
    $(document).on('click','.clickarchive',function(){
        var id = $(this).attr('id');
        var archieve = $(this).attr('data-archivetype');        
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                url :'{{URL("individual-payment-history-archieve")}}',
                type :'POST',
                data: {rowid:id,status:archieve},
                success: function(response){
                    if(response == 'updated'){
                        location.reload();
                    }
                }
        }); 
    });
</script>
@endsection

