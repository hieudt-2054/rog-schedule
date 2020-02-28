<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PasswordSecurity;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FAQRCode\Google2FA as Google2FAQR;

class PasswordSecurityController extends Controller
{
    private $google2fa;
    
    private $googleqrcode;

    public function __construct(Google2FA $google2fa, Google2FAQR $googleqrcode)
    {
        $this->google2fa = $google2fa;
        $this->googleqrcode = $googleqrcode;
    }

    public function show2fa(Request $request){
        $user = Auth::user();
        $google2fa_url = '';
        if($user->passwordSecurity != null){
            $google2fa_url = $this->googleqrcode->getQRCodeInline(
                'RogScheduleApplication',
                $user->email,
                $user->passwordSecurity->google2fa_secret
            );
        }

        $data = [
            'google2fa_enable' => $user->passwordSecurity ? $user->passwordSecurity->google2fa_enable : 0,
            'google2fa_url' => $google2fa_url,
            'passwordSecurity' => $user->passwordSecurity ? $user->passwordSecurity->count() : 0,
        ];
        
        return response()->json($data, 200);
    }

    public function generate2faSecret(Request $request){
        $user = Auth::user();
        // Initialise the 2FA class
        $google2fa = app('pragmarx.google2fa');
    
        // Add the secret key to the registration data
        PasswordSecurity::create([
            'user_id' => $user->id,
            'google2fa_enable' => 0,
            'google2fa_secret' => $google2fa->generateSecretKey(),
        ]);
    
        return response()->json(['success' => 'Secret Key is generated, Please verify Code to Enable 2FA']);
    }

    public function enable2fa(Request $request){
        $user = Auth::user();
        $google2fa = app('pragmarx.google2fa');
        $secret = $request->input('verifyCode');
        $valid = $google2fa->verifyKey($user->passwordSecurity->google2fa_secret, $secret);
        if($valid){
            $user->passwordSecurity->google2fa_enable = 1;
            $user->passwordSecurity->save();
            return response()->json(['success' => '2FA is Enabled Successfully']);
        }else{
            return response()->json(['error' => 'Invalid Verification Code, Please try again.'], 500);
        }
    }

    public function disable2fa(Request $request){
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your  password does not matches with your account password. Please try again.");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
        ]);
        $user = Auth::user();
        $user->passwordSecurity->google2fa_enable = 0;
        $user->passwordSecurity->save();
        return redirect('/2fa')->with('success',"2FA is now Disabled.");
    }
}
