<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use DB;
use Carbon\Carbon;//（Laravel標準で使える日付ライブラリ）
use App\Models\Users\Subjects;
use App\Models\Users\User;

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
    public function store(Request $request)
    {
        $birth_day = Carbon::createFromDate(//Carbon（Laravel標準で使える日付ライブラリ）
        $request->input('old_year'),
        $request->input('old_month'),
        $request->input('old_day')
        )->format('Y-m-d');

        $request->merge(['birth_day' => $birth_day]);

         $request->validate([ // 🔹 バリデーション
                'over_name' => ['required', 'string', 'max:10'],
                'under_name' => ['required', 'string', 'max:10'],
                'over_name_kana' => ['required', 'string', 'max:30','regex:/^[ァ-ヶー]+$/u'],
                'under_name_kana' => ['required', 'string', 'max:30','regex:/^[ァ-ヶー]+$/u'],
                'mail_address' => ['required', 'email', 'unique:users,mail_address','max:100'],
                'sex' => ['required', 'in:1,2,3'], // 1:男性, 2:女性, 3:その他 など
                'old_year' => ['required','numeric'],
                'old_month' => ['required','numeric'],
                'old_day' => ['required','numeric'],
                'birth_day' => ['date','after_or_equal:2000-01-01','before_or_equal:today'],
                'role' => ['required', 'in:1,2,3,4'], // 例：1=管理者, 4=学生 など
                'password' => ['required', 'max:30', 'min:8', 'confirmed'],
                // password_confirmation もフォームに必要
            ]);

        DB::beginTransaction();
        try{

             // 🔹 生年月日をまとめる
            $old_year = $request->old_year;
            $old_month = $request->old_month;
            $old_day = $request->old_day;
            $data = $old_year . '-' . $old_month . '-' . $old_day;
            $birth_day = date('Y-m-d', strtotime($data));
            $subjects = $request->subject;

            // 🔹 ユーザー登録
            $user_get = User::create([
                'over_name' => $request->over_name,
                'under_name' => $request->under_name,
                'over_name_kana' => $request->over_name_kana,
                'under_name_kana' => $request->under_name_kana,
                'mail_address' => $request->mail_address,
                'sex' => $request->sex,
                'birth_day' => $birth_day,
                'role' => $request->role,
                'password' => bcrypt($request->password)
                ]);

                if($request->role == 4){
                    $user = User::findOrFail($user_get->id);
                    $user->subjects()->attach($subjects);
                 }
               DB::commit();
    return view('auth.login.login');

} catch (\Exception $e) {
    DB::rollback();
    return redirect()->route('registerView')->withErrors(['error' => '登録に失敗しました。']);
}
        }
    }
