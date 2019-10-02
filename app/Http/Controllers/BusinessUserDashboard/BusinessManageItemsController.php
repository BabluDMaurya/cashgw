<?php

namespace App\Http\Controllers\BusinessUserDashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\QueryException;
use Exception;
use App\InvoiceCategory;
use App\TaxInformations;
use App\ManageItem;

class BusinessManageItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Auth::logout();
        return redirect('/login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Auth::logout();
        return redirect('/login');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $mes = 'No record added';

        $this->validate($request, [
            'item_name' => 'required',
            'description' => 'required',
            'price' => 'required',
//            'tax_name' => 'required',
//            'rate' => 'required',
            'category' => 'required',
                ], [
            'item_name.required' => 'Item Name Required',
            'description.required' => 'Description Required',
            'price.required' => 'Price Required',
//            'tax_name.required' => 'Tax Name Required',
//            'rate.required' => 'Tax Rate Required',
            'category.required' => 'Category Required',
        ]);

        ManageItem::create([
            'user_id' => $user->id,
            'item_name' => $request->item_name,
            'description' => $request->description,
            'price' => $request->price,
            'tax_name' => $request->tax_name,
            'rate' => $request->rate,
            'invoice_cat_id' => $request->category,
        ]);
        $mes = 'Item Added Successfully';

        session()->flash('status', $mes);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $user = Auth::user();
            $decrypted = Crypt::decrypt($id);
            if ($user->id != $decrypted) {
                throw new Exception(config('constants.DecryptionError'));
            }
        } catch (DecryptException $e) {
            $errormes = config('constants.DecryptException');
        } catch (QueryException $qe) {
            $errormes = config('constants.QueryException');
        } catch (Exception $ee) {
            $errormes = config('constants.Exception');
        } finally {
            if (empty($errormes)) {
                $ItemList = ManageItem::where('status', 0)->where('user_id', $user->id)->get();
                $allCategory = InvoiceCategory::where('status', 0)->get();
                $taxInfoList = TaxInformations::where('user_id', $user->id)->where('status', 0)->get();
                return view('pages.business.manage-item', ['user_id' => $id, 'allCategory' => $allCategory, 'taxInfoList' => $taxInfoList, 'ItemList' => $ItemList]);
            } else {
                Auth::logout();
                session()->flash('status', $errormes);
                return redirect('/login');
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Auth::logout();
        return redirect('/login');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $this->validate($request, [
            'item_name' => 'required',
            'description' => 'required',
            'price' => 'required',
//            'tax_name' => 'required',
//            'rate' => 'required',
            'category' => 'required',
                ], [
            'item_name.required' => 'Item Name Required',
            'description.required' => 'Description Required',
            'price.required' => 'Price Required',
//            'tax_name.required' => 'Tax Name Required',
//            'rate.required' => 'Tax Rate Required',
            'category.required' => 'Category Required',
        ]);
        $id = $request->id;
        $ManageItemupdated = ManageItem::find($id);
        $ManageItemupdated->item_name = $request->item_name;
        $ManageItemupdated->description = $request->description;
        $ManageItemupdated->price = $request->price;
        $ManageItemupdated->tax_name = $request->tax_name;
        $ManageItemupdated->rate = $request->rate;
        $ManageItemupdated->invoice_cat_id = $request->category;
        $ManageItemupdated->save();

        $mes = 'Item Updated Successfully';

        session()->flash('status', $mes);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Auth::logout();
        return redirect('/login');
    }
    
    public function DeleteItem(Request $request) {
        $id = $request->id;
        $deleteupdated = ManageItem::find(decrypt($id));
        $deleteupdated->delete();
    }

    public function EditView(Request $request) {
        $id = decrypt($request->id);
        $singleItemInfoDetails = ManageItem::where('id', $id)->first();
        if (!empty($singleItemInfoDetails)) {
            foreach ($singleItemInfoDetails->toArray() as $key => $value) {
                try {
                    $singleItemInfoDetailsArr[$key] = Crypt::decrypt($value);
                } catch (DecryptException $e) {
                    $singleItemInfoDetailsArr[$key] = $value;
                }
            }
        }
        echo json_encode($singleItemInfoDetailsArr);
    }
    
    public function GetTaxRateOnChange(Request $request) {
        $user = Auth::user();
        $tax_name = $request->tax_name;
        $taxrate = TaxInformations::where('user_id',$user->id)->where('tax_name',$tax_name)->where('status',0)->first(); 
        echo $taxrate->tax_rate;
}

}
