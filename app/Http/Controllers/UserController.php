<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\User\UserInterface;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

/**
 * @OA\Tag(
 *     name="Users",
 * )
 */

class UserController extends Controller
{
    private $userRepository;
    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    /**
     * @OA\Get(
     *     path="/api/users",
     *     tags={"Users"},
     *     summary="Lấy danh sách người dùng",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách người dùng"
     *     )
     * )
     */

    public function index()
    {
        // Mail::raw('Nội dung test gửi mail', function ($message) {
        //     $message->to('test@example.com')
        //         ->subject('Test gửi mail');
        // });

        // return User::select('id', 'name', 'email', 'phone_number', 'address', 'inactive_at', 'role_id', 'avatar_url')->get();
        return $this->userRepository->all(['id', 'name', 'email', 'phone_number', 'address', 'inactive_at', 'role_id', 'avatar_url']);
    }
}
