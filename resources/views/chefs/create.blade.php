@extends('layouts.app', ['activePage' => 'Add Chef'])

@section('content')
<main class="page-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 mt-5">
                <h1 class="text-center mb-5">Add New Chef</h1>
                <div class="card rounded-4 p-4">
                    <form action="{{ route('chefs.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="first_name">First Name</label>
                                <input type="text" name="first_name" class="form-control" placeholder="Enter first name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="last_name">Last Name</label>
                                <input type="text" name="last_name" class="form-control" placeholder="Enter last name" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="specialty">Specialty</label>
                            <input type="text" name="specialty" class="form-control" placeholder="E.g. Italian, Pastry, Grill">
                        </div>

                        <div class="mb-3">
                            <label for="phone_number">Phone Number</label>
                            <input type="text" name="phone_number" class="form-control" placeholder="Enter phone number" required>
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

                        <button type="submit" class="btn btn-primary w-100">Add Chef</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
