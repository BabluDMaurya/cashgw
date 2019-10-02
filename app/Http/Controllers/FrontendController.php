<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ManageCms;
use App\ManageFaq;
use App\Testimonials;
use App\PartnersImages;

class FrontendController extends Controller
{

    public function __construct(){
      $footerData = ManageCms::where('page_id', 6)->get()->toArray();
      \View::share('footerData',$footerData);
    }

        public function index(){
        $data['pageData'] = ManageCms::where('page_id', 1)->get()->toArray();
        $data['partnersImages'] = PartnersImages::where('is_deleted', 0)->get()->toArray();
        return view('pages.index')->with($data);
    }
    
    public function viewAboutPage(){
        $data['pageData'] = ManageCms::where('page_id', 2)->get()->toArray();
        $data['testimonials'] = Testimonials::where('is_deleted', 0)->get()->toArray();
        $data['partnersImages'] = PartnersImages::where('is_deleted', 0)->get()->toArray();
        return view('pages.about')->with($data);
    }
    
    public function viewHowItWorksPage(){
        $data['pageData'] = ManageCms::where('page_id', 3)->get()->toArray();
        return view('pages.works')->with($data);
    }
    
    public function viewFaqPage(){
        $data['faq'] = ManageFaq::where('is_deleted', 0)->get()->toArray();
        return view('pages.faq')->with($data);
    }
    
    public function viewTermsPage(){
        $data['pageData'] = ManageCms::where('page_id', 4)->get()->toArray();
        return view('pages.terms')->with($data);
    }
    
    public function viewPrivacyPage(){
        $data['pageData'] = ManageCms::where('page_id', 5)->get()->toArray();
        return view('pages.privacy')->with($data);
    }
    
    public function viewSitemapPage(){
        return view('pages.sitemap');
    }
    
    public function viewSecurityPage(){
        return view('security');
    }
}
