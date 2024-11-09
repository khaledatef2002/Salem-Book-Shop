<div class="d-flex justify-content-between align-items-center">
    <h2>@lang('custom.events.attendance')</h2>
    {{-- Auth Attend Actions --}}
    @if ($event->date > now())
        {{-- Show Actions If Logged In --}}
        @if (Auth::check())
            <form id="unattend-form" style="display: {{ $event->authAttendants->count() ? 'block' : 'none' }}" onsubmit="unattend_event(event, this, {{ $event->id }})">
                @csrf
                <button class="btn btn-danger" type="submit">@lang('custom.events.unattend')</button>
            </form>    
            <form id="attend-form" style="display: {{ $event->authAttendants->count() ? 'none' : 'block' }}" onsubmit="attend_event(event, this, {{ $event->id }})">
                @csrf
                <button class="btn btn-primary" type="submit">@lang('custom.events.attend')</button>
            </form> 
        {{-- If not -> tell him to login to take action --}}
        @else
            <a href="{{ route('login') }}" class="text-decoration-none">@lang('custom.events.login-to-attend')</a>
        @endif
    @endif
</div>
{{-- If user logged in -> show him his attendance if exists --}}
<div id="auth-attendance">
    @if (Auth::check() && $event->authAttendants->count())
            @include('front.parts.events-auth-attendance', ['attendance' => $event->authAttendants->first()])
    @endif
</div>
@foreach ($attendance as $user)
    @if (!(auth()->check() && $user->id == auth()->user()->id))
        <div class="attendance-item">
            <hr>
            <div class="user-info d-flex align-items-center gap-3 mb-1">
                <div class="user_image d-flex justify-content-center align-items-center">
                    <img src="{{ $user->display_image }}" alt="{{ $user->full_name }} @lang('dashboard.person.image')" title="{{ $user->full_name }} @lang('dashboard.person.image')">
                </div>
                <div>
                    <p class="mb-0 fw-bold">{{ $user->full_name }}</p>
                    <p class="mb-0" id="auth-attend-date">{{ $user->created_at->format('Y/m/d h:i:sa') }}</p>
                </div>
            </div>
        </div>
    @endif
@endforeach
<p id="no-attendance-message" class="mx-auto mt-2" style="display: {{ $attendance->count() ? 'none' : 'block' }}">@lang('custom.events.no-attendance')</p>

{{ $attendance->appends(['reviews_page' => request('reviews_page')])->links('pagination::bootstrap-4') }}