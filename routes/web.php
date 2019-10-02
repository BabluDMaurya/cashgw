<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/logout','Auth\LoginController@logout');
Route::get('/', 'FrontendController@index');
Route::get('/about', 'FrontendController@viewAboutPage');
Route::get('/works', 'FrontendController@viewHowItWorksPage');
Route::get('/faq', 'FrontendController@viewFaqPage');
Route::get('/terms', 'FrontendController@viewTermsPage');
Route::get('/privacy', 'FrontendController@viewPrivacyPage');
Route::get('/sitemap', 'FrontendController@viewSitemapPage');
Route::get('/security', 'FrontendController@viewSecurityPage');
Route::post('/cformsubmit', 'ContactController@formsubmit');
Route::get('/contact', 'ContactController@index');

Route::get('/pay-invoice-id/{id}', 'UserDashboard\IndividualCreateInvoiceController@setPayInvoiceId');
Route::get('/pay-invoice/{id}', 'UserDashboard\IndividualCreateInvoiceController@viewInvoicePreview');
Route::get('/confirm-pay-invoice/{id}', 'UserDashboard\IndividualCreateInvoiceController@sendInvoiceOpt');
Route::get('/confirm-pay-invoice-otp/{id}', 'UserDashboard\IndividualCreateInvoiceController@viewConfirmInvoicePayment');
Route::post('/check-invoice-otp', 'UserDashboard\IndividualCreateInvoiceController@checkInvoiceOtp');

//business invoice 
Route::get('/business-pay-invoice/{id}', 'BusinessUserDashboard\BusinessCreateInvoiceController@viewInvoicePreview');
Route::get('/business-confirm-pay-invoice/{id}', 'BusinessUserDashboard\BusinessCreateInvoiceController@sendInvoiceOpt');
Route::get('/business-confirm-pay-invoice-otp/{id}', 'BusinessUserDashboard\BusinessCreateInvoiceController@viewConfirmInvoicePayment');
Route::post('/business-check-invoice-otp', 'BusinessUserDashboard\BusinessCreateInvoiceController@checkInvoiceOtp');

Route::group(['middleware' => ['web']], function () {
    Route::get('/login/admin', 'Auth\LoginController@showAdminLoginForm');
    Route::post('/login/admin', 'Auth\LoginController@adminLogin');
});
Route::group(['middleware' => ['auth:admin']], function() {
    Route::post('admin-ajax-request-fees','Admin\AjaxRequest@fees');
    Route::post('admin-ajax-request-feesedit','Admin\AjaxRequest@feesedit');
    Route::post('feeedit','Admin\AjaxRequest@feeEdit');
    Route::resource('/bank','Admin\BankManagementController');
    Route::resource('/defaultfees','Admin\TransactionDefaultFees');
    
    Route::get('/admin', 'Admin\AdminDashboardController@index');
    Route::get('/contact-management', 'Admin\AdminContactManagementController@index');
    Route::post('/contact-delete', 'Admin\AdminContactManagementController@contactDelete');

    Route::post('/contact_admin', 'Admin\AdminContactManagementController@adminContact');

    Route::resource('manage-accounts','Admin\AdminManageAccountsController');
    Route::resource('/manage-payment-request', 'Admin\ManagePaymentRequestController');
    Route::post('/payment-request-admin', 'Admin\AdminUserController@PaymentRequestAdmin'); 
    
    Route::get('/individual-user-verification', 'Admin\KYCIndividualApprovalController@index');
    Route::post('/IndividualVerifyUserByAdmin', 'Admin\KYCIndividualApprovalController@VerifyUserByAdmin');
    
    Route::get('/business-user-verification', 'Admin\KYCBusinessApprovalController@index');
    Route::post('/BusinessVerifyUserByAdmin', 'Admin\KYCBusinessApprovalController@VerifyBusinessByAdmin');
    
    Route::get('/primary-address-approval', 'Admin\PrimaryAddressApprovalController@index');
    Route::post('/viewaddressforapproval', 'Admin\PrimaryAddressApprovalController@ViewPrimaryAddressApproval');
    Route::post('/AppOrRejectAddressByAdmin', 'Admin\PrimaryAddressApprovalController@AppOrRejectAddressByAdmin');
    
    Route::resource('/category','Admin\AdminCategory');
    Route::post('/DeleteCat', 'Admin\AdminCategory@DeleteCategory');
});
Route::post('/signupsubmit', 'Auth\SignupController@formsubmit');
Route::get('/sign-up', 'Auth\SignupController@index');

Route::get('/user/verify/{token}', 'Auth\RegisterController@verify');
Route::get('/user/kycverify/{token}', 'UserDashboard\InfoindividualController@verifyKYC');
Route::get('/user/bukycverify/{token}', 'BusinessUserDashboard\InfobusinessController@verifyKYC');
Route::get('/admin/userverify/{id}', 'Admin\UserVerifyController@verifyUser');

Route::group(['middleware' => ['auth', 'emailverify']], function() {
    Route::get('/info-individual', 'UserDashboard\InfoindividualController@index');
    Route::post('/individualkyc', 'UserDashboard\InfoindividualController@KycFormSubmit');
    Route::post('/kycaddprofilepic', 'UserDashboard\InfoindividualController@KYCAddProfilePic');
    
    Route::get('/info-business', 'BusinessUserDashboard\InfobusinessController@index');
    Route::post('/businesskyc', 'BusinessUserDashboard\InfobusinessController@KycFormSubmit');
});
Route::group(['middleware' => ['auth', 'emailverify', 'kycauth', 'adminverify', 'accountactive']], function() {
    //Business Dashboard
    Route::resource('/business-recieved-invoice', 'BusinessUserDashboard\BusinessRecievedInvoiceController');
    Route::resource('/business-account', 'BusinessUserDashboard\BusinessAccountSettingController');
    Route::post('/businessaddprofilepic', 'BusinessUserDashboard\BusinessAccountSettingController@BusiAddProfilePic');
    Route::resource('/business-security', 'BusinessUserDashboard\BusinessSecurityController');
    Route::resource('/business-summary', 'BusinessUserDashboard\BusinessSummaryController');
    Route::get('/business-recived-money/{id}', 'BusinessUserDashboard\BusinessRecivedMoneyController@index');
    Route::get('/business-payment-history/{id}', 'BusinessUserDashboard\PaymentHistoryController@index');
    Route::post('/business-payment-history-archieve', 'BusinessUserDashboard\PaymentHistoryController@updateArchieve');
    Route::post('business-payment-history-archieve-view','BusinessUserDashboard\PaymentHistoryController@archieveView');
    Route::get('/business-send-request-money/{id}', 'BusinessUserDashboard\BusinessSendRequestMoneyController@index');
    Route::resource('/business-recived-request', 'BusinessUserDashboard\BusinessRecivedRequestMoneyController');
    Route::resource('/business-send-money', 'BusinessUserDashboard\BusinessSendMoneyController');
    Route::resource('/business-sent-request', 'BusinessUserDashboard\BusinessSentRequestMoneyController');
    Route::resource('/business-request-payment', 'BusinessUserDashboard\BusinessRequestPaymentController');
    Route::resource('/business-balance', 'BusinessUserDashboard\BusinessBalanceController');
    Route::get('/searchajax', array('as' => 'searchajax', 'uses' => 'BusinessUserDashboard\BusinessAjaxController@autoComplete'));
    Route::get('/backurl', array('as' => 'backurl', 'uses' => 'BusinessUserDashboard\BusinessAjaxController@setSessionBackUrl'));
    Route::get('/business-payment-history/{id}', 'BusinessUserDashboard\PaymentHistoryController@index');
    Route::get('/sendMoney/{id}', 'RequestFormController@sendMoneyForm');

    Route::resource('business-activity','BusinessUserDashboard\ActivityController');
    Route::get('business-activity-details/{id}','BusinessUserDashboard\AcivityDetailsController@index');
    Route::get('business-invoice-details/{id}','BusinessUserDashboard\InvoiceDetailsController@index');
    
    Route::get('/business-create-invoice/{id}', 'BusinessUserDashboard\BusinessCreateInvoiceController@index');
    Route::get('/business-manage-invoice/{id}', 'BusinessUserDashboard\BusinessManageInvoiceController@index');
    Route::post('/business-get-all-users-email', 'BusinessUserDashboard\BusinessCreateInvoiceController@getAllUsersEmail');
    
    Route::post('/business-info-on-change-invoice-category', 'BusinessUserDashboard\BusinessCreateInvoiceController@BusinessInfoOnChangeInvoiceCategory');
    Route::post('/business-get-items-on-change-invoice-category', 'BusinessUserDashboard\BusinessCreateInvoiceController@GetItemsOnChangeInvoiceCategory');
    Route::post('/business-insert-invoice-data', 'BusinessUserDashboard\BusinessCreateInvoiceController@CreateInvoiceList');
    Route::post('/business-update-invoice-data', 'BusinessUserDashboard\BusinessCreateInvoiceController@updateInvoiceList');
    Route::post('/business-get-invoice-preview', 'BusinessUserDashboard\BusinessCreateInvoiceController@GetInvoicePreview');
    
    Route::post('/business-manage-invoice-pdfdownload', 'BusinessUserDashboard\BusinessManageInvoiceController@dowonloadPDF');    
    Route::post('/business-invoice-status-ajax', 'BusinessUserDashboard\BusinessManageInvoiceController@InvoiceStatusAjax');    
    Route::post('/business-change-batch-action', 'BusinessUserDashboard\BusinessManageInvoiceController@ChangeBatchAction');     
    Route::get('/business-edit-invoice/{id}', 'BusinessUserDashboard\BusinessManageInvoiceController@EditInvoice');
    Route::get('/business-copy-invoice/{id}', 'BusinessUserDashboard\BusinessManageInvoiceController@CopyInvoice');
    Route::post('/business-Print-invoiceView', 'BusinessUserDashboard\BusinessManageInvoiceController@PrintInvoiceView'); 
    Route::get('/business-generate-pdf/{id}','BusinessUserDashboard\BusinessManageInvoiceController@generatePDF');
    Route::post('/business-delete-cancel-invoice', 'BusinessUserDashboard\BusinessManageInvoiceController@DeleteDraftOrCancelInvoice');     
    
    
    Route::resource('/business-address-book', 'BusinessUserDashboard\BusinessAddressBookController');
    Route::post('business_check_addressbook_email', 'BusinessUserDashboard\BusinessAddressBookController@checkAddressBookEmail');
    Route::post('/BusinessGetSingleContactDetails', 'BusinessUserDashboard\BusinessAddressBookController@GetSingleContactDetails');
    Route::post('/BusinessDeleteAddressContact', 'BusinessUserDashboard\BusinessAddressBookController@DeleteAddressBookContact');
    Route::resource('/business-information-details', 'BusinessUserDashboard\BusinessInformationDetailsController');
    Route::post('/businessGetSingleBusinessInfo', 'BusinessUserDashboard\BusinessInformationDetailsController@GetSingleBusinessInfo'); 
    Route::resource('/business-tax-information', 'BusinessUserDashboard\BusinessTaxInformationController');    
    Route::post('/BusinessDeleteTaxInfo', 'BusinessUserDashboard\BusinessTaxInformationController@DeleteTaxInfo');
    Route::resource('/business-manage-item', 'BusinessUserDashboard\BusinessManageItemsController');
    Route::post('/business-edit-view-item', 'BusinessUserDashboard\BusinessManageItemsController@EditView');
    Route::post('/BusinessDeleteItem', 'BusinessUserDashboard\BusinessManageItemsController@DeleteItem');
    
    //UserDashboard
    Route::resource('/individual-recieved-invoice', 'UserDashboard\IndividualRecievedInvoiceController');
    Route::resource('individual-activity','UserDashboard\ActivityController');
    Route::get('activity-pdf/{id}','UserDashboard\ActivityController@exportPdf');
    Route::get('individual-activity-details/{id}','UserDashboard\AcivityDetailsController@index');
    Route::get('individual-invoice-details/{id}','UserDashboard\InvoiceDetailsController@index');
    
    Route::get('/individual-recived-money/{id}', 'UserDashboard\IndividualRecivedMoneyController@index');
    Route::get('/individual-payment-history/{id}', 'UserDashboard\PaymentHistoryController@index');
    Route::post('/individual-payment-history-archieve', 'UserDashboard\PaymentHistoryController@updateArchieve');
    Route::post('individual-payment-history-archieve-view','UserDashboard\PaymentHistoryController@archieveView');
    Route::resource('/individual-account', 'UserDashboard\IndividualAccountSettingController');
    Route::post('/addprofilepic', 'UserDashboard\IndividualAccountSettingController@AddProfilePic');
    Route::resource('/individual-security', 'UserDashboard\IndividualSecurityController');
    Route::resource('/individual-summary', 'UserDashboard\IndividualSummaryController');
    Route::resource('/individual-balance', 'UserDashboard\IndividualBalanceController');
    Route::get('/individual-send-request-money/{id}', 'UserDashboard\IndividualSendRequestMoneyController@index');
    Route::resource('/individual-request-payment', 'UserDashboard\IndividualRequestPaymentController');
    Route::resource('/individual-recived-request', 'UserDashboard\IndividualRecivedRequestMoneyController');
    Route::resource('/individual-sent-request', 'UserDashboard\IndividualSentRequestMoneyController');
    Route::resource('/individual-send-money', 'UserDashboard\IndividualSendMoneyController');
    
    Route::get('/create-invoice/{id}', 'UserDashboard\IndividualCreateInvoiceController@index');
    Route::post('/get-all-users-email', 'UserDashboard\IndividualCreateInvoiceController@getAllUsersEmail');
    Route::post('/BusinessInfoOnChangeInvoiceCategory', 'UserDashboard\IndividualCreateInvoiceController@BusinessInfoOnChangeInvoiceCategory');
    Route::post('/GetItemsOnChangeInvoiceCategory', 'UserDashboard\IndividualCreateInvoiceController@GetItemsOnChangeInvoiceCategory');
    Route::post('/InsertInvoiceData', 'UserDashboard\IndividualCreateInvoiceController@CreateInvoiceList');
    Route::post('/UpdateInvoiceData', 'UserDashboard\IndividualCreateInvoiceController@updateInvoiceList');
    Route::post('/GetInvoicePreview', 'UserDashboard\IndividualCreateInvoiceController@GetInvoicePreview');
    Route::get('/manage-invoice/{id}', 'UserDashboard\IndividualManageInvoiceController@index');
    
    Route::post('/manage-invoice-pdfdownload', 'UserDashboard\IndividualManageInvoiceController@dowonloadPDF');    
    
    Route::post('/InvoiceStatusAjax', 'UserDashboard\IndividualManageInvoiceController@InvoiceStatusAjax');    
    
    Route::post('/ChangeBatchAction', 'UserDashboard\IndividualManageInvoiceController@ChangeBatchAction');     
    Route::get('/edit-invoice/{id}', 'UserDashboard\IndividualManageInvoiceController@EditInvoice');
    Route::get('/copy-invoice/{id}', 'UserDashboard\IndividualManageInvoiceController@CopyInvoice');
    Route::post('/PrintInvoiceView', 'UserDashboard\IndividualManageInvoiceController@PrintInvoiceView'); 
    Route::get('/generate-pdf/{id}','UserDashboard\IndividualManageInvoiceController@generatePDF');
    Route::post('/delete-cancel-invoice', 'UserDashboard\IndividualManageInvoiceController@DeleteDraftOrCancelInvoice');     
    
    Route::resource('/address-book', 'UserDashboard\AddressBookController');
    Route::post('/check_addressbook_email', 'UserDashboard\AddressBookController@checkAddressBookEmail');
    Route::post('/GetSingleContactDetails', 'UserDashboard\AddressBookController@GetSingleContactDetails');
    Route::post('/DeleteAddressContact', 'UserDashboard\AddressBookController@DeleteAddressBookContact');
    Route::resource('/business-information', 'UserDashboard\BusinessInformationController');
    Route::post('/GetSingleBusinessInfo', 'UserDashboard\BusinessInformationController@GetSingleBusinessInfo');    
//    Route::post('/DeleteBusinessInfo', 'UserDashboard\BusinessInformationController@DeleteBusinessInfo');
    Route::resource('/tax-information', 'UserDashboard\TaxInformationController');
    Route::post('/DeleteTaxInfo', 'UserDashboard\TaxInformationController@DeleteTaxInfo');
    Route::resource('/manage-item', 'UserDashboard\ManageItemsController');
    Route::post('/edit-view-item', 'UserDashboard\ManageItemsController@EditView');
    Route::post('/DeleteItem', 'UserDashboard\ManageItemsController@DeleteItem');
    Route::post('/getTaxRateOnChange', 'UserDashboard\ManageItemsController@GetTaxRateOnChange');  
});
Route::group(['middleware' => ['auth', 'emailverify', 'kycauth', 'adminverify', 'accountactive']], function() {
    Route::get('/dashboard', 'MyDashboard@redirectUserDashboardBaseOnRole');
});

// Route::get('/home', 'HomeController@index')->name('home');
// Route::get('/rates', 'ExampleController@rates');
// Route::get('/convert/single', 'ExampleController@single');
// Route::get('/convert/multiple', 'ExampleController@multiple');