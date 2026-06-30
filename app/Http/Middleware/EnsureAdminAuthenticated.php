<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminAuthenticated
{
    /**
     * @param Closure(Request): Response $next
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        if (! Auth::check()) {
            return redirect()->route('admin.login');
        }

        $user = Auth::user();
        $roles = [
            'super-admin',
            'admin',
            'content-manager',
            'order-manager',
            'product-manager',
        ];

        if (! method_exists($user, 'hasAnyRole') || ! $user->hasAnyRole($roles)) {
            abort(403);
        }

        return $next($request);
    }
}
