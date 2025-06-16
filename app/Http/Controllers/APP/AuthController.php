<?php

namespace App\Http\Controllers\APP;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use App\Enums\Constant;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\User\AuthRequest;
use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Mail;
use App\Notifications\VerifyCodeEmail;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private AuthService $authService;
    private User $user;

    public function __construct(
        AuthService $authService,
        User $user,
    ) {
        $this->authService = $authService;
        $this->user = $user;
    }
    /**
     * @author Hungha
     * @OA\Post (
     *     path="/api/auth/login",
     *     tags={"Tài khoản"},
     *     summary="Đăng nhập User",
     *     operationId="user_login",
     *     @OA\Parameter(
     *          in="header",
     *          name="X-localication",
     *          required=false,
     *          description="Ngôn ngữ",
     *          @OA\Schema(
     *            type="string",
     *            example="vi",
     *          )
     *     ),
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="email", type="string"),
     *              @OA\Property(property="password", type="string"),
     *          @OA\Examples(
     *              summary="Examples",
     *              example = "Examples",
     *              value = {
     *                  "email": "hungtmt1102@gmail.com",
     *                  "password": "123123",
     *                  },
     *              ),
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *             @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Success."),
     *          )
     *     ),
     * )
     */
    public function login(Request $request): JsonResponse
    {
        try {
            // Log::debug('test', [User::$publisher, User::$user]);
            $user = $this->user->ofEmail($request->email)
                ->ofRole([User::$user])
                ->first();

            if (!$user) {
                return response()->json([
                    'status' => Response::HTTP_BAD_REQUEST,
                    'errorCode' => 'E_UC2_1',
                    'message' => trans('messages.errors.users.email_not_found'),
                    'data' => []
                ], Response::HTTP_BAD_REQUEST);
            }

            if ($user->inactive_at !== null) {
                return response()->json([
                    'status' => Response::HTTP_BAD_REQUEST,
                    'errorCode' => 'E_UC2_2',
                    'message' => trans('messages.errors.users.account_not_active'),
                    'data' => []
                ], Response::HTTP_BAD_REQUEST);
            }

            $credentials = $request->only('email', 'password');

            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'status' => Response::HTTP_BAD_REQUEST,
                    'errorCode' => 'E_UC2_3',
                    'message' => trans('messages.errors.users.password_not_correct'),
                    'data' => []
                ], Response::HTTP_BAD_REQUEST);
            }

            // xoa token cu
            $user->tokens()->delete();

            // $user->update([
            //     'device_token' => $request->device_token
            // ]);

            Log::debug($request);
            $data = [
                'token' => $user->createToken('API Token')->plainTextToken,
                'user' => $user
            ];

            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => trans('messages.success.users.login_success'),
                'data' => $data
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                // 'status' => Constant::FALSE_CODE,
                'message' => $th->getMessage(),
                'data' => []
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    /**
     * @author Hungha
     * @OA\Get (
     *     path="/api/auth/me",
     *     tags={"Tài khoản"},
     *     security={{"bearerAuth":{}}},
     *     summary="Thông tin người dùng",
     *     operationId="user_me",
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *             @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Success."),
     *          )
     *     ),
     * )
     */
    public function me()
    {
        return response()->json(Auth::user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * @author Nampx
     * @OA\Get (
     *     path="/api/auth/logout",
     *     tags={"Tài khoản"},
     *     summary="Đăng xuất",
     *     security={{"bearerAuth":{}}},
     *     operationId="user_logout",
     *     @OA\Parameter(
     *          in="header",
     *          name="language",
     *          required=false,
     *          description="Ngôn ngữ",
     *          @OA\Schema(
     *            type="string",
     *            example="vi",
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *             @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Success."),
     *          )
     *     ),
     * )
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $user = Auth::user();

            Log::debug('User ID:', [$user?->id]); // đúng cách để log object


            if ($user) {
                $user->tokens()->delete();
            } else {
                // abort(Constant::UNAUTHORIZED_CODE);
            }

            DB::commit();

            return response()->json([
                // 'status' => Constant::SUCCESS_CODE,
                'message' => 'Log out successfully!',
                'data' => $user
            ],);
        } catch (\Throwable $th) {
            return response()->json([
                // 'status' => Constant::FALSE_CODE,
                'message' => $th->getMessage(),
                'data' => []
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @author Nampx
     * @OA\Post (
     *     path="/api/auth/change-password",
     *     tags={"Tài khoản"},
     *     summary="Đổi mật khẩu",
     *     security={{"bearerAuth":{}}},
     *     operationId="user_change-password",
     *     @OA\Parameter(
     *          in="header",
     *          name="language",
     *          required=false,
     *          description="Ngôn ngữ",
     *          @OA\Schema(
     *            type="string",
     *            example="vi",
     *          )
     *     ),
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="old_password", type="string"),
     *              @OA\Property(property="new_password", type="string"),
     *              @OA\Property(property="confirm_password", type="string"),
     *          @OA\Examples(
     *              summary="Examples",
     *              example = "Examples",
     *              value = {
     *                  "old_password": "123123",
     *                  "new_password": "123456",
     *                  "confirm_password": "123456",
     *                  "code_verify":"123456"
     *                  },
     *              ),
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *             @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Success."),
     *          )
     *     ),
     * )
     */
    public function changePassword(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $user = Auth::user();
            $old_password = $request->old_password;
            $new_password = $request->new_password;
            $confirm_password = $request->confirm_password;

            $user = User::find($user->id);
            if ($confirm_password !== $new_password) return response()->json([
                'message' => 'Xác nhận mật khẩu sai. Vui lòng thử lại.'
            ]);
            if (!Hash::check($old_password, $user->password)) {
                DB::rollBack();
                return response()->json([
                    'status' => Response::HTTP_BAD_REQUEST,
                    'message' => trans('messages.errors.users.password_not_correct'),
                    'data' => []
                ], Response::HTTP_BAD_REQUEST);
            }

            $record = PasswordReset::where('email', $user->email)
                ->where('code', $request->code_verify)
                ->where('expires_at', '>', now())
                ->first();

            if (!$record) {
                return response()->json(['message' => 'Mã xác nhận không hợp lệ hoặc đã hết hạn.'], 400);
            }

            $user->update(['password' => Hash::make($new_password)]);

            $record->delete();

            DB::commit();
            return response()->json([
                'status' => Constant::SUCCESS_CODE,
                'message' => trans('messages.success.success'),
                'data' => User::find($user->id)
            ], Constant::SUCCESS_CODE);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => Constant::FALSE_CODE,
                'message' => $th->getMessage(),
                'data' => []
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @OA\Post(
     *     path="/api/auth/send-verify-code",
     *     tags={"Tài khoản"},
     *     summary="Gửi mã xác nhận để reset mật khẩu",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email"},
     *             @OA\Property(property="email", type="string", example="user@example.com")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Mã xác nhận đã được gửi"),
     *     @OA\Response(response=400, description="Lỗi validation")
     * )
     */
    public function sendVerifyCode(Request $request)
    {
        // throw new \Exception('Đã vào function sendVerifyCode');
        Log::info('Hello');
        return $this->authService->sendVerifyCode($request);
    }

    //     /**
    //      * Refresh a token.
    //      *
    //      * @return \Illuminate\Http\JsonResponse
    //      */
    //     public function refresh()
    //     {
    //         return $this->respondWithToken(auth()->refresh());
    //     }
    // 
    //     /**
    //      * Get the token array structure.
    //      *
    //      * @param  string $token
    //      *
    //      * @return \Illuminate\Http\JsonResponse
    //      */
    //     protected function respondWithToken($token)
    //     {
    //         return response()->json([
    //             'access_token' => $token,
    //             'token_type' => 'bearer',
    //             'expires_in' => config('jwt.ttl') * 60
    //         ]);
    //     }
}
