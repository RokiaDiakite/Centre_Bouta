<?php
 
namespace App\Http\Middleware;
 
use Closure;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Symfony\Component\HttpFoundation\Response;
 
class MaitreGuestMiddleware

{

    /**

     * Handle an incoming request.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \Closure  $next

     * @return \Symfony\Component\HttpFoundation\Response

     */

    public function handle(Request $request, Closure $next): Response

    {

        if (Auth::check()) {

            // Utilisateur déjà authentifié : on redirige vers le tableau de bord

            return redirect('maitre/dashboard');

        }
 
        // Sinon, on continue la requête

        return $next($request);

    }

}

 