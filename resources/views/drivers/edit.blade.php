@extends('layouts.app', ['activePage' => 'Edit Driver'])

@section('content')
    <main class="page-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 mt-5">
                    <h1 class="text-center mb-5">Edit Driver: {{ $driver->first_name }}</h1>
                    <div class="card rounded-4 p-4">
                        <form action="{{ route('drivers.update', $driver->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="first_name">First Name</label>
                                    <input type="text" name="first_name" class="form-control"
                                        value="{{ $driver->first_name }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" name="last_name" class="form-control"
                                        value="{{ $driver->last_name }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="phone_number">Phone Number</label>
                                <input type="text" name="phone_number" class="form-control"
                                    value="{{ $driver->phone_number }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="vehicle_details">Vehicle Details</label>
                                <input type="text" name="vehicle_details" class="form-control"
                                    value="{{ $driver->vehicle_details }}" required>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="max_occupants">Max Passengers</label>
                                    <input type="number" name="max_occupants" class="form-control"
                                        value="{{ $driver->max_occupants }}" min="1" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="hourly_rate">Hourly Rate (₦)</label>
                                    <input type="number" name="hourly_rate" class="form-control"
                                        value="{{ $driver->hourly_rate }}" min="0" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="extra_person_charge">Extra Person (₦)</label>
                                    <input type="number" name="extra_person_charge" class="form-control"
                                        value="{{ $driver->extra_person_charge }}" min="0" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="license_number">License Number</label>
                                <input type="text" name="license_number" class="form-control"
                                    value="{{ $driver->license_number }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="availability_status">Availability Status</label>
                                <select name="availability_status" class="form-control">
                                    <option value="Available" {{ $driver->availability_status == 'Available' ? 'selected' : '' }}>Available</option>
                                    <option value="Busy" {{ $driver->availability_status == 'Busy' ? 'selected' : '' }}>Busy
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Update Image (Leave blank to keep current)</label>
                                @if($driver->image)
                                    <div class="mb-2">
                                        <img src="{{ asset($driver->image) }}" width="60" class="rounded shadow-sm">
                                    </div>
                                @endif
                                <input type="file" name="image" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Update Driver</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection