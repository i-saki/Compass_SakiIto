<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;//（Laravel標準で使える日付ライブラリ）
use App\Models\Users\Subjects;
use App\Models\Users\User;
use App\Http\Requests\StoreUserRequest;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $subjects = Subjects::all();
        return view('auth.register.register', compact('subjects'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
   public function store(StoreUserRequest $request)
{
    DB::beginTransaction();

    try {
        $subjects = $request->subject;
        $user_get = User::create([
            'over_name' => $request->over_name,
            'under_name' => $request->under_name,
            'over_name_kana' => $request->over_name_kana,
            'under_name_kana' => $request->under_name_kana,
            'mail_address' => $request->mail_address,
            'sex' => $request->sex,
            'birth_day' => $request->birth_day,
            'role' => $request->role,
            'password' => bcrypt($request->password)
        ]);

         if ($request->role == 4) {
            $user_get->subjects()->attach($subjects);
        }

        DB::commit();
        return view('auth.login.login');

        } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->route('registerView')
            ->withErrors(['error' => '登録に失敗しました。']);
    }
}
}
