<?php

namespace App\Http\Middleware;

use App\Models\Seminar;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LogicException;
use Symfony\Component\HttpFoundation\Response;

class EventAuthAttendActionsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check())
        {
            $request->validate([
                'event_id' => ['required', 'exists:seminars,id']
            ]);
            $event = Seminar::where('id', $request->event_id)->first();
            if($event->date > now())
            {
                
                return $next($request);
            }    
        }

        return response()->json(['errors' => ['invalid' => [__('custom-errors.invalid-request')]]], 422);
    }
}
