<hr>
<div class="user-info d-flex align-items-center gap-3 mb-1">
    <div class="user_image d-flex justify-content-center align-items-center">
        <img src="{{ auth()->user()->display_image }}" alt="{{ Auth::user()->full_name }} @lang('dashboard.person.image')" title="@lang('custom.you')">
    </div>
    <div>
        <p class="mb-0 fw-bold">{{ auth()->user()->full_name }}</p>
        <p class="mb-0" id="auth-attend-date">{{  $attendance->created_at->format('Y/m/d h:i:sa') }}</p>
    </div>
</div>