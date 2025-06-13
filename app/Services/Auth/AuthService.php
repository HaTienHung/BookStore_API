<?php

namespace App\Services\Auth;

use App\Enums\Constant;
use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class AuthService
{
  protected $user;
  protected $passwordReset;
  public function __construct(
    PasswordReset $passwordReset,
    User $user,
  ) {
    $this->passwordReset = $passwordReset;
    $this->user = $user;
  }
  /**
   * check code record
   * @param Request $request
   * @param string $type
   * @return object $code
   * @author Nampx
   */
//   public function getCode(Request $request, string $type)
//   {
//     return $this->passwordReset->where('email', $request->email)
//       ->where('code', $request->code)
//       ->where('created_at', '>=', now()->subMinutes(2))
//       ->where('type', $type)
//       ->first();
//   }
// 
//   /**
//    * check code record
//    * @param Request $request
//    * @param string $type
//    * @author Nampx
//    */
//   public function deleteCode(Request $request, string $type)
//   {
//     $deleteCode = $this->passwordReset->where('email', $request->email)
//       ->where('code', $request->code)
//       ->where('type', $type)
//       ->delete();
// 
//     Log::debug('Xóa mã code cũ: ' . $deleteCode);
//   }
// 
//   /**
//    * save code record
//    * @param string $email
//    * @param string $code
//    * @param string $type
//    * @author Nampx
//    */
//   public function saveCode(string $email, string $code, string $type)
//   {
//     return $this->passwordReset->updateOrInsert(
//       [
//         'email' => $email,
//         'type' => $type
//       ],
//       [
//         'code' => $code,
//         'created_at' => Carbon::now(),
//       ]
//     );
//   }
// 
//   /**
//    * set new password
//    * @param string $email
//    * @param string $password
//    * @author Nampx
//    */
//   public function newPassword(string $email, string $password)
//   {
//     $newPassword = $this->user->where('email', $email)->update([
//       'password' => Hash::make($password)
//     ]);
// 
//     Log::debug('Mật khẩu mới: ' . $newPassword);
//   }
// 
//   /**
//    * edit profile
//    * @param object $user
//    * @param array $req
//    * @author Nampx
//    */
//   public function editProfile(object $user, array $req)
//   {
//     $user->update($req);
//   }
// 
//   /**
//    * active account
//    * @param object $user
//    * @author Nampx
//    */
//   public function activeAccount(object $user)
//   {
//     $activeAccount = $user->update(['verify' => User::$verify]);
// 
//     Log::debug('Kích hoạt tài khoản: ' . $activeAccount);
//   }
// 
//   /**
//    * del account
//    * @param object $user
//    * @author Nampx
//    */
//   public function deleteAccount(object $user)
//   {
//     $this->deleteAvatar($user->avatar);
// 
//     $deleteAccount = $user->delete();
// 
//     Log::debug('Xóa tài khoản: ' . $deleteAccount);
// 
//     return response()->json([
//       'status' => Constant::SUCCESS_CODE,
//       'message' => trans('messages.success.users.delete'),
//       'data' => $user
//     ], Constant::SUCCESS_CODE);
//   }
// 
//   /**
//    * del avatar
//    * @param string $path
//    * @author Nampx
//    */
//   public function deleteAvatar(string $path)
//   {
//     $deleteAvatar = Storage::delete('public/' . $path);
// 
//     Log::debug('Xóa ảnh đại diện: ' . $deleteAvatar);
//   }
// 
//   public function getUserNotVerify(string $email)
//   {
//     return User::where('email', $email)
//       ->OfVerify(User::$not_verify)
//       ->first();
//   }

  public function sendVerifyCode(Request $request)
  {
    $request->validate([
      'email' => 'required|email|exists:users,email',
    ]);
    $code = mt_rand(100000, 999999); // 6 số ngẫu nhiên

    PasswordReset::updateOrCreate(
      ['email' => $request->email],
      ['code' => $code, 'expires_at' => now()->addMinutes(1), 'created_at' => now()]
    );

    Mail::raw("Mã xác nhận đổi mật khẩu của bạn là: $code", function ($message) use ($request) {
      $message->to($request->email)
        ->subject('Verify Code');
    });

    return response()->json([
      'message' => 'Mã xác nhận đã được gửi đến email.',
    ]);
  }
}
