<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DefaultSetting;
use App\Models\MailSetting;
use App\Models\SmsSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class SettingController extends Controller
{
    // Update Env Function
    public function updateEnv($envKey, $envValue)
    {
        $envFilePath = app()->environmentFilePath();
        $strEnv = file_get_contents($envFilePath);
        $strEnv.="\n";
        $keyStartPosition = strpos($strEnv, "{$envKey}=");
        $keyEndPosition = strpos($strEnv, "\n",$keyStartPosition);
        $oldLine = substr($strEnv, $keyStartPosition, $keyEndPosition-$keyStartPosition);

        if(!$keyStartPosition || !$keyEndPosition || !$oldLine){
            $strEnv.="{$envKey}={$envValue}\n";
        }else{
            $strEnv=str_replace($oldLine, "{$envKey}={$envValue}",$strEnv);
        }
        $strEnv=substr($strEnv, 0, -1);
        file_put_contents($envFilePath, $strEnv);
    }

    public function defaultSetting(){
        $default_setting = DefaultSetting::first();
        return view('admin.setting.default', compact('default_setting'));
    }

    public function defaultSettingUpdate(Request $request, $id){
        $request->validate([
            'favicon' => 'nullable|image|mimes:png,jpg,jpeg',
            'logo_photo' => 'nullable|image|mimes:png,jpg,jpeg',
            'app_name' => 'required',
            'app_url' => 'required',
            'time_zone' => 'required',
        ]);
        $this->updateEnv("APP_NAME", "'$request->app_name'");
        $this->updateEnv("APP_URL", "'$request->app_url'");
        $this->updateEnv("TIME_ZONE", "'$request->time_zone'");
        $default_setting = DefaultSetting::where('id', $id)->first();
        DefaultSetting::where('id', $id)->update([
            'app_name' => $request->app_name,
            'app_url' => $request->app_url,
            'time_zone' => $request->time_zone,
            'main_phone' => $request->main_phone,
            'support_phone' => $request->support_phone,
            'main_email' => $request->main_email,
            'support_email' => $request->support_email,
            'address' => $request->address,
            'facebook_link' => $request->facebook_link,
            'twitter_link' => $request->twitter_link,
            'instagram_link' => $request->instagram_link,
            'linkedin_link' => $request->linkedin_link,
            'youtube_link' => $request->youtube_link,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),
        ]);

       // Logo Photo Upload
       if($request->hasFile('logo_photo')){
        if($default_setting->logo_photo != NULL){
            unlink(base_path("public/uploads/default_photo/").$default_setting->logo_photo);
        }
        $logo_photo_name = "Logo-Photo".".". $request->file('logo_photo')->getClientOriginalExtension();
        $upload_link = base_path("public/uploads/default_photo/").$logo_photo_name;
        Image::make($request->file('logo_photo'))->resize(192, 40)->save($upload_link);
        DefaultSetting::where('id', $id)->update([
            'logo_photo' => $logo_photo_name
        ]);
    }

    // Favicon Upload
    if($request->hasFile('favicon')){
        if($default_setting->favicon != NULL){
            unlink(base_path("public/uploads/default_photo/").$default_setting->favicon);
        }
        $favicon_name = "Favicon".".". $request->file('favicon')->getClientOriginalExtension();
        $upload_link = base_path("public/uploads/default_photo/").$favicon_name;
        Image::make($request->file('favicon'))->resize(70, 70)->save($upload_link);
        DefaultSetting::where('id', $id)->update([
            'favicon' => $favicon_name
        ]);
    }

        $notification = array(
            'message' => 'Default setting details updated successfully.',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }

    public function mailSetting(){
        $mail_setting = MailSetting::first();
        return view('admin.setting.mail', compact('mail_setting'));
    }

    public function mailSettingUpdate(Request $request, $id){
        $request->validate([
            'mailer' => 'required',
            'host' => 'required',
            'port' => 'required',
            'username' => 'required',
            'password' => 'required',
            'encryption' => 'required',
            'from_address' => 'required',
        ]);
        $this->updateEnv("MAIL_MAILER", "'$request->mailer'");
        $this->updateEnv("MAIL_HOST", "'$request->host'");
        $this->updateEnv("MAIL_PORT", "'$request->port'");
        $this->updateEnv("MAIL_USERNAME", "'$request->username'");
        $this->updateEnv("MAIL_PASSWORD", "'$request->password'");
        $this->updateEnv("MAIL_ENCRYPTION", "'$request->encryption'");
        $this->updateEnv("MAIL_FROM_ADDRESS", "'$request->from_address'");
        MailSetting::where('id', $id)->update([
            'mailer' => $request->mailer,
            'host' => $request->host,
            'port' => $request->port,
            'username' => $request->username,
            'password' => $request->password,
            'encryption' => $request->encryption,
            'from_address' => $request->from_address,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Mail details updated successfully.',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }

    public function smsSetting(){
        $sms_setting = SmsSetting::first();
        return view('admin.setting.sms', compact('sms_setting'));
    }

    public function smsSettingUpdate(Request $request, $id){
        $request->validate([
            'api_key' => 'required',
            'sender_id' => 'required',
        ]);
        $this->updateEnv("SMS_API_KEY", "'$request->api_key'");
        $this->updateEnv("SMS_SENDER_ID", "'$request->sender_id'");
        SmsSetting::where('id', $id)->update([
            'api_key' => $request->api_key,
            'sender_id' => $request->sender_id,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Sms details updated successfully.',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }
}
