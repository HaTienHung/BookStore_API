<?php

namespace App\Http\Middleware;

use App\Enums\Constant;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware extends Controller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, $role, $permission = null)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], Constant::UNAUTHENTICATED_CODE);
        }

        // Nếu đã load quan hệ role trong user, thì tránh gọi lại query
        // Hoặc ít nhất nên dùng firstOrFail để rõ ràng hơn
        $roleName = $user->role?->name;

        if ($roleName !== $role) {
            return response()->json(['message' => 'Unauthorized'], Constant::FORBIDDEN_CODE);
        }

        return $next($request);
    }
}
