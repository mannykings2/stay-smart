@extends('layouts.app', [$activePage = 'Check In'])

@section('content')
<!--start content-->
<main class="page-content" style="background: ">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 mt-5">
                <h1 class="text-center mb-5">Welcome to <span style="font-weight: 600;">StaySmart</span> </h1>
                <div class="card rounded-4 p-4 d-flex justify-content-between">
                    <h6 class="text-center" >Enter your booking information</h6>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <div class="input-area">
                                <label class="d-lg-none mt-3" for="last_name">Last Name</label>
                                <input type="text" name="last_name" placeholder="Last Name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-area">
                                <label class="d-lg-none mt-3" for="booking_reference">Booking Reference</label>
                                <input type="text" name="booking_reference" placeholder="Booking Reference">
                            </div>
                        </div>
                    </div>
                    <a href="{{route('apartments.index')}}" role="button" class="btn btn-primary rounded-3 px-3">Access Booking</a>
                    <h6 class="text-center mt-4" style="font-size:13px">Our Smart homes are operated fully digital. Click <a href="/">here</a> to learn more.</h6>

                </div>
            </div>
        </div>
    </div>
</main>
@endsection
