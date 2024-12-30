<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\CIAuth;
use App\Libraries\Hash;
use App\Models\User;
use App\Models\AdminUser;
use App\Models\PasswordResetToken;
use Carbon\Carbon;

class AuthController extends BaseController
{
    protected $helpers = ['url','form','CIMail', 'CIFunctions'];
    public function loginform(){
        $data = [
            'pageTitle' => 'Login',
            'validation' => null,
        ];

        return view('backend/pages/auth/login', $data);
    }
     
    public function superAdmin(){
        $adminUser = new AdminUser();
        $userInfo = $adminUser->where('admin_id', $this->request->getVar('loginId'))->first();
        $check_password = Hash::check($this->request->getVar('loginPw'), $userInfo['password']);
        if(!$check_password){
            return redirect()->route('admin.login.form')->with('fail','Wrong password')->withInput();
        }else{
            CIAuth::setCIAuth($userInfo);
            return redirect()->route('admin.home');
        }
    }

    public function superAdminChangePW(){
        $adminUser = new AdminUser();
        $adminUser->where('admin_id', $this->request->getVar('loginId') )->set(['password' => Hash::make($this->request->getVar('loginPw') )])->update();
    }

    public function loginHandler(){
        $fieldType = filter_var($this->request->getVar('login_id'), FILTER_VALIDATE_EMAIL)  ? 'email': 'admin_id';
        if($fieldType == 'email'){
            log_message('error',json_encode($this->request->getVar('login_id')));
            $isValid = $this->validate([
                'login_id' => [
                    'rules' => 'required|valid_email|is_not_unique[admin_user.email]',
                    'errors' => [
                        'required' => 'Email is required',
                        'valid_email' => 'Please, check the email field. It does not appears to be valid.',
                        'is_not_unique'=> 'Email is not exists in our system.',
                    ],
                ],
                'password'=>[
                    'rules'=> 'required|min_length[5]|max_length[45]',
                    'errors'=> [
                        'required'      => 'Password is required',
                        'min_length'    => 'Password must have atleast 5 characters in length',
                        'max_length'    => 'Password must not have characters more than 45 in length',
                    ],
                ]
            ]);
        }else{
            $isValid = $this->validate([
                'login_id' => [
                    'rules' => 'required|is_not_unique[admin_user.admin_id]',
                    'errors' => [
                        'required' => 'Admin ID is required',
                        'is_not_unique'=> 'Admin ID is not exists in our system.',
                    ],
                ],
                'password'=>[
                    'rules'=> 'required|min_length[5]|max_length[45]',
                    'errors'=> [
                        'required'      => 'Password is required',
                        'min_length'    => 'Password must have atleast 5 characters in length',
                        'max_length'    => 'Password must not have characters more than 45 in length',
                    ],
                ]
            ]);
        }

        if(!$isValid){
            return view('backend/pages/auth/login',[
                'pageTitle' => 'Login',
                'validation'=> $this->validator,
            ]);
        }else{
            $adminUser = new AdminUser();
            $userInfo = $adminUser->where($fieldType, $this->request->getVar('login_id'))->first();
            $check_password = Hash::check($this->request->getVar('password'), $userInfo['password']);
            if(!$check_password){
                return redirect()->route('admin.login.form')->with('fail','Wrong password')->withInput();
            }else{
                CIAuth::setCIAuth($userInfo);
                return redirect()->route('admin.home');
            }
        }
    }
    public function forgotForm(){
        $data = [
            'pageTitle'=> 'Forgot password',
            'validation'=> null,
        ];
        return view('backend/pages/auth/forgot', $data);
    }

    public function sendPasswordResetLink(){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $isValid = $this->validate([
            'email'=> [
                'rules' =>'required|valid_email|is_not_unique[users.email]',
                'errors' => [
                    'required' => 'Email is required',

                    'valid_email' => 'Please check email field. It does not appears to be valid',
                    'is_not_unique'=>'Email not exists in system',
                ],
            ]
        ]);
        if(!$isValid){
            return view('backend/pages/auth/forgot',[
                'pageTitle' => 'Forgot password',
                'validation' => $this->validator,
            ]);
        }else{
            //유저(어드민) 정보 가져오기
            $user = new User();
            $user_info = $user->asObject()->where('email', $this->request->getVar('email'))->first();

            //토큰 생성
            $token = bin2hex(openssl_random_pseudo_bytes(65));

            //리셋 패스워드 토큰 가져오기
            $password_reset_token = new PasswordResetToken();
            $isOldTokenExists = $password_reset_token->asObject()->where('email',$user_info->email)->first();

            if(!$isOldTokenExists){
                $password_reset_token->where('email', $user_info->email)
                ->set(['token'=> $token, 'create_at' => Carbon::now()])
                ->update();
            }else{
                $password_reset_token->insert([
                    'email'=> $user_info->email,
                    'token'=> $token,
                    'create_at' => Carbon::now(),
                ]);
            }

            //create action link
            // $actionLink = route_to('admin.reset-password',$token);
            $actionLink = base_url(route_to('admin.reset-password',$token));

            $mail_data = array(
                'actionLink' => $actionLink,
                'user' => $user_info,
            );

            $view = \Config\Services::renderer();
            $mail_body = $view->setVar('mail_data', $mail_data)->render('email-templates/forgot-email-template');
            $mailConfig = array(
                'mail_from_email' => env('EMAIL_FROM_ADDRESS'),
                'mail_from_name' => env('EMAIL_FROM_NAME'),
                'mail_recipient_email' => $user_info->email,
                'mail_recipient_name' => $user_info->username,
                'mail_subject' => 'Reset Password',
                'mail_body' => $mail_body,
            );
            //메일 발송
            if( sendEmail($mailConfig) ){
                return redirect()->route('admin.forgot.form')->with('success', 'We have E-mailed your password reset link');
            }else{
                return redirect()->route('admin.forgot.form')->with('fail','Something went wrong');
            }

        }
    }

    public function resetPassword($token){
        $passwordResetPassword = new PasswordResetToken();
        $check_token = $passwordResetPassword->asObject()->where('token', $token)->first();

        if(!$check_token){
            return redirect()->route('admin.forgot.form')->with('fail','Invalid token. Request another reset password link.');
        }else{
            //사용한 토큰인지 확인(15분보다 길지 않게)
            $diffMins = Carbon::createFromFormat('Y-m-d H:i:s', $check_token->create_at)->diffInMinutes(Carbon::now());

            if($diffMins >15){
                return redirect()->route('admin.forgot.form')->with('fail', 'Token expired. Request another reset password link');
            }else{
                return view('backend/pages/auth/reset', array(
                    'pageTitle' => 'Reset password',
                    'validation'=> null,
                    'token'     => $token,
                ));
            }
        }
    }

    public function resetPasswordHandler($token){
        $isValid = $this->validate([
            'new_password'  => [
                'rules'     => 'required|min_length[5]|max_length[20]|is_password_strong',
                'errors'    => [
                    'required'  =>  'Enter new password',
                    'min_length'    =>'New password must have atleast minimum of 5 characters',
                    'max_length'    =>'New password must have maximum of 20 characters',
                    'is_password_strong'    => 'New password must contains atleast 1 upppercase, 1 lowercase, 1 number and 1 special character.',
                ],
            ],
            'confirm_new_password'  =>[
                'rules'  => 'required|matches[new_password]',
                'errors' => [
                    'required' => 'Confirm new password',
                    'matches'   => 'Passwords not matches.'
                ],
            ],
        ]);

        if(!$isValid){
            return view('backend/pages/auth/reset', [
                'pageTitle' => 'Reset password',
                'validation'=>  null,
                'token'     => $token,
            ]);
        }else{
            //Get token details
            $passwordResetPassword = new PasswordResetToken();
            $get_token = $passwordResetPassword->asObject()->where('token', $token)->first();

            //Get user (admin) details
            $user = new AdminUser();
            $user_info = $user->asObject()->where('email', $get_token->email)->first();
            
            if(!$get_token){
                return redirect()->back()->with('fail', 'Invalid token!')->withInput();
            }else{
                $user->where('email', $user_info->email)
                ->set(['password'=> Hash::make($this->request->getVar('new_password') )])
                ->update();

                //Send notification to user (admin) email address
                $mail_data = array(
                    'user' => $user_info,
                    'new_password' => $this->request->getVar('new_password'),
                );

                $view = \Config\Services::renderer();
                $mail_body = $view->setVar('mail_data',$mail_data)->render('email-templates/password-changed-email-template');

                $mailConfig = array(
                    'mail_from_email' =>env('EMAIL_FROM_ADDRESS'),
                    'mail_from_name'    =>env('EMAIL_FROM_NAME'),
                    'mail_recipient_email'  => $user_info->email,
                    'mail_recipient_name'   => $user_info->name,
                    'mail_subject'          => 'Password Changed',
                    'mail_body'             => $mail_body,
                );
                $sendmail = sendEmail($mailConfig);
                if($sendmail){
                    //Delete token
                    $passwordResetPassword->where('email', $get_token->email)->delete();

                    //Redirect and display message on Login page
                    return redirect()->route('admin.home')->with('success', 'Done!, Your password has been changed. Use new password to login into system.');
                }else{
                    return redirect()->back()->with('fail' , 'Something went wrong')->withInput();
                }
            }
            
        }
    }
}
