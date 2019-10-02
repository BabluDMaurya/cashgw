@if(count($ItemDetails)>0)
@foreach($ItemDetails as $items)
<tr>
    <td class="edit-table">
        <input type="text" class="form-control" value="{{$items->item_name}}" name="item_name[]" placeholder="Item Name">        
    </td>
    <td class=""><input name="item_quantity[]" type="number" min="1" value="1" class="form-control input-custom mr-15 itemQuantity"></td>
    <td class=""><input name="item_price[]" type="number" min="0" value="{{$items->price}}" class="form-control input-custom mr-15 itemPrice"></td>
    <td>
        <select class="form-control border-none itemTax" id="optax" name="item_tax_id[]">
            <option value="0" tax_rate="0">No Tax</option>            
        </select>
    </td>    
    <td class="gre-bg-td"><input name="item_amount[]" type="text" value="" class="form-control input-custom mr-15 itemAmount" readonly></td>
    <td class="text-center delete-tbody"><i class="far fa-trash-alt"></i></td>
</tr>
<tr>
    <td colspan="4" class="edit-table">        
        <input type="text" class="form-control" value="{{$items->description}}" name="item_desc[]" placeholder="Enter Description">    
    </td>
    <td class="gre-bg-td">&nbsp;</td>
    <td>&nbsp;</td>
</tr>
@endforeach
@else
<h4 >No Record Found</h4>
@endif