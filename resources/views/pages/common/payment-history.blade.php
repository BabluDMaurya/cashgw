@extends('layouts.businessdashboard')
@section('content')   
<section class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                    <div class="block-item shadow-block">
                        <div class="balance-new-title mb-30">
                            <span>Payment History</span>                           
                        </div>
                        <table class="table table-bordered my-table">
                            <thead>
                                <tr>
                                    <th width="100px">T. ID</th>
                                    <th>Name</th>
                                    <th>Amount </th>
                                    <th>Date</th>
                                    <th>Email</th>
                                    <th>Details</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                              @if(!empty($paymenthistory))  
                                @foreach($paymenthistory as $value)
                                    <tr class="">
                                        <td>{{$value->transactionid}}</td>
                                         <td>{{ucfirst($value->name)}}</td>
                                         <td>{{$value->amount}}</td>
                                         <td>{{$value->updated_at}}</td>
                                         <td>{{$value->email}}</td>
                                         <td>{{$value->details}}</td>
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
                                         <td>
                                             <select class="form-control">
                                                 <option>Archieve</option>
                                             </select>

                                         </td>
                                     </tr>                                
                                @endforeach                                
                                @endif
                            </tbody>
                            </table>                      
                    </div>
                </div>
        </div>
    </div>
</section>
@endsection

