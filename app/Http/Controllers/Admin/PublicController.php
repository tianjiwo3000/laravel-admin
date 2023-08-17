<?php
/**
 * Created by PhpStorm.
 * User: lea
 * Date: 2018/1/18
 * Time: 14:51
 */

namespace app\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\Y;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\Fluent\Concerns\Has;

class PublicController extends Controller
{
    /**
     * 登录
     * @param Request $request
     * @return mixed
     */
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $params = $request->input();
            $validator = Validator::make($params, [
                'account' => 'required',
                'password' => 'required',
                'captcha'  => 'required|captcha'
            ], [
                'account.*' => '账号不能为空',
                'password.*' => '密码不能为空',
                'captcha.*' => '验证码错误'
            ]);
            if ($validator->fails()) {
                return Y::error($validator->errors()->first());
            }
            if (Auth::guard('admin')->attempt(['account' => $params['account'], 'password' => $params['password']])) {
                return Y::success('登录成功', [], route('admin.index'));
            }
            return Y::error('用户验证失败');
        } else {
            /*if (Auth::guard('admin')->check()) {
                return redirect(route('admin.index'));
            }*/
            return view('admin.public.login');
        }
    }

    /**
     * 退出登录
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirectorsd
     */
    public function logout(Request $request)
    {
        auth()->logout();
        if ($request->isMethod('post')) {
            return Y::success('登出成功', [], route('admin.login'));
        } else {
            return redirect(route('admin.login'));
        }
    }

    public function icon(Request $request)
    {
        return view('admin.icon.index');
    }

}