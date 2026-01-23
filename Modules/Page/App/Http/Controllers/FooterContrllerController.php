<?php

namespace Modules\Page\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Page\App\Models\Footer;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Page\App\Models\FooterTranslation;

class FooterContrllerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $footer = Footer::first();
        
        if (!$footer) {
            // Create a default footer if it doesn't exist
            $footer = new Footer();
            $footer->save();
        }
        
        $translate = FooterTranslation::where(['footer_id' => $footer->id, 'lang_code' => $request->lang_code])->first();
        
        // If translation doesn't exist for this language, create it
        if (!$translate) {
            $translate = new FooterTranslation();
            $translate->footer_id = $footer->id;
            $translate->lang_code = $request->lang_code;
            $translate->about_us = '';
            $translate->save();
        }

        return view('page::section.footer', [
            'footer' => $footer,
            'translate' => $translate,
        ]);
    }

    public function update(Request $request)
    {

        if($request->lang_code == admin_lang()){

            $request->validate([
                'facebook' => 'required|max:250',
                'twitter' => 'required|max:250',
                'linkedin' => 'required|max:250',
                'instagram' => 'required|max:250',
                'copyright' => 'required|max:250',
                'playstore' => 'required|max:250',
                'appstore' => 'required|max:250',
                'address' => 'required|max:250',
                'email' => 'required|max:250',
                'phone' => 'required|max:250',
            ],[
                'facebook' => trans('translate.Facebook is required'),
                'twitter' => trans('translate.Twitter is required'),
                'linkedin' => trans('translate.Linkedin is required'),
                'instagram' => trans('translate.Instagram is required'),
                'copyright' => trans('translate.Copyright is required'),
                'playstore' => trans('translate.Playstore is required'),
                'appstore' => trans('translate.Appstore is required'),
                'address' => trans('translate.Address is required'),
                'email' => trans('translate.Email is required'),
                'phone' => trans('translate.Phone is required'),
            ]);

            $footer = Footer::first();
            
            if (!$footer) {
                $footer = new Footer();
            }

            $footer->facebook = $request->facebook;
            $footer->twitter = $request->twitter;
            $footer->linkedin = $request->linkedin;
            $footer->instagram = $request->instagram;
            $footer->copyright = $request->copyright;
            $footer->playstore = $request->playstore;
            $footer->appstore = $request->appstore;
            $footer->phone = $request->phone;
            $footer->email = $request->email;
            $footer->address = $request->address;
            $footer->save();

        }

        $request->validate([
            'about_us' => 'required',
        ],[
            'about_us' => trans('translate.About us is required'),
        ]);

        $footer = Footer::first();
        
        if (!$footer) {
            $footer = new Footer();
            $footer->save();
        }

        $translate = FooterTranslation::where(['footer_id' => $footer->id, 'lang_code' => $request->lang_code])->first();
        
        if (!$translate) {
            $translate = new FooterTranslation();
            $translate->footer_id = $footer->id;
            $translate->lang_code = $request->lang_code;
        }
        
        $translate->about_us = $request->about_us;
        $translate->save();


        $notify_message = trans('translate.Update successfully');
        $notify_message = array('message' => $notify_message, 'alert-type' => 'success');
        return redirect()->back()->with($notify_message);
    }

    public function setup_language($lang_code){
        $footer_translates = FooterTranslation::where('lang_code' , admin_lang())->first();
        
        if (!$footer_translates) {
            // If no translation exists, get or create footer first
            $footer = Footer::first();
            if (!$footer) {
                $footer = new Footer();
                $footer->save();
            }
            
            $footer_translates = new FooterTranslation();
            $footer_translates->footer_id = $footer->id;
            $footer_translates->lang_code = admin_lang();
            $footer_translates->about_us = '';
            $footer_translates->save();
        }

        $new_trans = new FooterTranslation();
        $new_trans->lang_code = $lang_code;
        $new_trans->footer_id = $footer_translates->footer_id;
        $new_trans->about_us = $footer_translates->about_us;
        $new_trans->save();

    }
}
