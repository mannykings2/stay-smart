@extends('layouts.app', [$activePage = 'Profile'])

@section('content')
<!--start content-->
<main class="page-content" style="background: ">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 mt-5">
                <div class="card rounded-4 p-4 d-flex justify-content-between">
                    <h6 class="text-center" >Update your Profile</h6>
                    <form action="{{route('update.profile')}}" method="POST">
                        @csrf
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <div class="input-area">
                                    <label class="d-lg-none mt-3" for="first_name">First Name</label>
                                    <input type="text" name="first_name" value="{{auth()->user()->first_name}}" placeholder="First Name">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-area">
                                    <label class="d-lg-none mt-3" for="last_name">Last Name</label>
                                    <input type="text" name="last_name" value="{{auth()->user()->last_name}}" placeholder="Last Name">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="input-area">
                                    <label class="d-lg-none mt-3" for="Email">Email</label>
                                    <input type="email" name="Email" placeholder="Email" value="{{auth()->user()->email}}" readonly>
                                </div>
                            </div>
                        </div>
                        <button type="submit" href="{{route('apartments.index')}}" role="button" class="btn btn-primary rounded-3 px-3">Update</button>
                    </form>
                </div>
                <div class="card rounded-4 p-4 d-flex justify-content-between mt-5">
                    <h6 class="text-center" >Change Password</h6>
                    <form action="{{route('update.password')}}" method="POST">
                        @csrf
                        <div class="row mb-4">
                            <div class="col-md-12 mb-3">
                                <div class="input-area">
                                    <label class="d-lg-none mt-3" for="current_password">Current Password</label>
                                    <input type="password" name="current_password" placeholder="Enter Current Password">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-area">
                                    <label class="d-lg-none mt-3" for="new_password">New Password</label>
                                    <input type="password" name="new_password" placeholder="Enter New Password">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-area">
                                    <label class="d-lg-none mt-3" for="confirm_password">Confirm Password</label>
                                    <input type="password" name="confirm_password" placeholder="Confirm Password">
                                </div>
                            </div>

                        </div>
                        <button type="submit" href="{{route('apartments.index')}}" role="button" class="btn btn-primary rounded-3 px-3">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
