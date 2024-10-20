@extends('front.main')

@section('title', 'Profile')

@section('content')

@include('front.partials._nav', ['rounded' => 0])

<div id="page-header" class="py-5">
    <div class="container d-flex">
        <div>
            <img src="{{ asset('front/imgs/group-of-books.png') }}" height="120">
        </div>
        <div class="d-flex flex-column align-items-start justify-content-evenly ps-5">
            <span class="badge text-dark fw-bold">{{ $website_settings->site_title }}</span>
            <h2>{{ ucfirst(Auth::user()->first_name) }}' Profile</h2>
        </div>
    </div>
</div>

<div class="profile-body p-5">
    <div class="container">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active border-0" aria-current="page" data-bs-toggle="list" href="#general_info">General Info</a>
            </li>
            <li class="nav-item">
                <a class="nav-link border-0" data-bs-toggle="list" href="#password">Password</a>
            </li>
        </ul>
        <div class="card border-0">
            <div class="card-body p-0">
                <div class="tab-content p-3">
                    <div class="tab-pane fade show active" id="general_info" role="tabpanel">
                        <form id="general_info_form">
                            @csrf
                            <div class="input-group image-upload mb-2">
                                <label for="image" role="button" class="d-flex flex-column align-items-center">
                                    <div class="image-holder d-flex justify-content-center align-items-center">
                                        <img src="{{ Auth::user()->display_image }}" class="border rounded-2">
                                    </div>
                                    <span class="text-danger">*Only .jpeg .jpg .png images file</span>
                                </label>
                                <input type="file" id="image" name="image" accept=".jpg,.png,.jpeg">
                                <x-input-error :messages="$errors->get('image')" class="mt-2" /> 
                            </div>
                            <div class="d-flex gap-2 mb-2">
                                <div class="input-group d-flex flex-column">
                                    <label for="first_name" class="fw-bold">First Name:</label>
                                    <input type="text" value="{{ Auth::user()->first_name }}" id="first_name" name="first_name" class="form-control w-100">
                                    <x-input-error :messages="$errors->get('first_name')" class="mt-2" /> 
                                </div>
                                <div class="input-group d-flex flex-column">
                                    <label for="last_name" class="fw-bold">Last Name:</label>
                                    <input type="text" value="{{ Auth::user()->last_name }}" id="last_name" name="last_name" class="form-control w-100">
                                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" /> 
                                </div>
                            </div>
                            <div class="input-group d-flex flex-column">
                                <label for="email" class="fw-bold">Email:</label>
                                <input type="email" value="{{ Auth::user()->email }}" id="email" name="email" class="form-control w-100">
                                <x-input-error :messages="$errors->get('email')" class="mt-2" /> 
                            </div>
                            <div class="input-group d-flex flex-column">
                                <label for="phone" class="fw-bold">phone:</label>
                                <input type="phone" value="{{ Auth::user()->phone }}" id="phone" name="phone" class="form-control w-100">
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" /> 
                            </div>
                            <div class="mt-4">
                                <button class="btn btn-primary w-100" type="submit">Save</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="password" role="tabpanel">
                        <form id="password_form">
                            @csrf
                            <div class="input-group d-flex flex-column mb-3">
                                <label for="password" class="fw-bold">Password:</label>
                                <div class="input-holder position-relative d-flex justify-content-end">
                                    <i class="fa-solid fa-eye me-2"></i>
                                    <input id="password" name="password" class="form-control" type="password" placeholder="Enter your password">
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            <div class="input-group d-flex flex-column mb-3">
                                <label for="password_confirmation" class="fw-bold">Password Confirmation:</label>
                                <div class="input-holder position-relative d-flex justify-content-end">
                                    <input id="password_confirmation" name="password_confirmation" class="form-control" type="password" placeholder="Confirm your password">
                                </div>
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                            <div class="mt-4">
                                <button class="btn btn-primary w-100" type="submit">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection