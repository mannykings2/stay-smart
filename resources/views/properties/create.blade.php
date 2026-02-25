@extends('layouts.app', ['activePage' => 'Add Apartment'])

@section('content')
    <main class="page-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 mt-5">
                    <h1 class="text-center mb-5">Add New Apartment</h1>
                    <div class="card rounded-4 p-4">
                        <form action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="name">Apartment Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Enter apartment name"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label for="max_guests">Max Guests</label>
                                    <input type="number" name="max_guests" class="form-control" value="2" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="city">City</label>
                                    <input type="text" name="city" class="form-control" placeholder="Enter city" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="country">Country</label>
                                    <input type="text" name="country" class="form-control" placeholder="Enter country"
                                        required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="address">Address</label>
                                <textarea name="address" class="form-control" rows="2" placeholder="Enter full address"
                                    required></textarea>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="price_per_night">Price per Night</label>
                                    <input type="number" name="price_per_night" class="form-control" step="0.01" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="Pending">Pending</option>
                                        <option value="Available">Available</option>
                                        <option value="Booked">Booked</option>
                                        <option value="Under Maintenance">Under Maintenance</option>
                                    </select>
                                </div>
                            </div>

                            @if(auth()->user()->hasRole('Super Admin'))
                                <div class="mb-3">
                                    <label for="owner_id">Assign Owner (Optional)</label>
                                    <select name="owner_id" class="form-control">
                                        <option value="">- Select Owner (Admin) -</option>
                                        @foreach($admins as $admin)
                                            <option value="{{ $admin->id }}">{{ $admin->first_name }} {{ $admin->last_name }}
                                                ({{ $admin->email }})</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">If left blank, you will be the owner.</small>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control" rows="3"
                                    placeholder="Enter description"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="images" class="form-label">Upload Images (first image will be the cover)</label>
                                <input type="file" name="images[]" id="images" class="form-control" multiple
                                    accept="image/jpeg,image/png,image/jpg" onchange="previewImages(event)">
                                <div id="imagePreviewContainer" class="d-flex flex-wrap gap-2 mt-2"></div>
                            </div>

                            <script>
                                function previewImages(event) {
                                    const container = document.getElementById('imagePreviewContainer');
                                    container.innerHTML = '';
                                    const files = event.target.files;

                                    if (files) {
                                        Array.from(files).forEach(file => {
                                            if (file.type.match('image.*')) {
                                                const reader = new FileReader();
                                                reader.onload = function (e) {
                                                    const imgBuilder = document.createElement('div');
                                                    imgBuilder.className = 'position-relative';
                                                    imgBuilder.innerHTML = `<img src="${e.target.result}" style="height: 80px; width: 80px; object-fit: cover; border-radius: 5px; border: 1px solid #ddd;">`;
                                                    container.appendChild(imgBuilder);
                                                }
                                                reader.readAsDataURL(file);
                                            }
                                        });
                                    }
                                }
                            </script>

                            <button type="submit" class="btn btn-primary w-100">Add Apartment</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection