@extends('layouts.app', ['activePage' => 'Add Driver'])

@section('content')
    <main class="page-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 mt-5">
                    <h1 class="text-center mb-5">Add New Driver</h1>
                    <div class="card rounded-4 p-4">
                        <form action="{{ route('drivers.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="first_name">First Name</label>
                                    <input type="text" name="first_name" class="form-control" placeholder="Enter first name"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" name="last_name" class="form-control" placeholder="Enter last name"
                                        required>
                                </div>
                            </div>

                            {{-- <div class="mb-3">
                                <label for="specialty">Specialty</label>
                                <input type="text" name="specialty" class="form-control"
                                    placeholder="E.g. City Driving, Highway, Airport Transfers">
                            </div> --}}

                            <div class="mb-3">
                                <label for="phone_number">Phone Number</label>
                                <input type="text" name="phone_number" class="form-control" placeholder="Enter phone number"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="vehicle_details">Vehicle Details</label>
                                <input type="text" name="vehicle_details" class="form-control"
                                    placeholder="E.g. Toyota Camry 2020 - White" required>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="max_occupants">Max Passengers</label>
                                    <input type="number" name="max_occupants" class="form-control" value="4" min="1"
                                        required>
                                </div>
                                <div class="col-md-4">
                                    <label for="hourly_rate">Hourly Rate (₦)</label>
                                    <input type="number" name="hourly_rate" class="form-control" placeholder="E.g. 5000"
                                        min="0" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="extra_person_charge">Extra Person (₦)</label>
                                    <input type="number" name="extra_person_charge" class="form-control"
                                        placeholder="E.g. 1000" min="0" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="license_number">License Number</label>
                                <input type="text" name="license_number" class="form-control"
                                    placeholder="Enter license number" required>
                            </div>

                            <div class="mb-3">
                                <label for="availability_status">Availability Status</label>
                                <select name="availability_status" class="form-control">
                                    <option value="Available">Available</option>
                                    <option value="Busy">Busy</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Upload Image</label>
                                <input type="file" name="image" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Add Driver</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection