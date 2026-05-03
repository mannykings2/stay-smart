@extends('layouts.app', ['activePage' => 'Apartments'])

@section('content')
<main class="page-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-5">
                <h1 class="text-center mb-5">Edit Apartment</h1>
                <div class="card rounded-4 p-4">
                    <form action="{{ route('properties.update', $property->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name">Apartment Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $property->name }}" required 
                                    {{ (auth()->user()->hasRole('Admin') && !auth()->user()->hasRole('Super Admin')) ? 'readonly' : '' }}>
                            </div>
                            <div class="col-md-6">
                                <label for="max_guests">Max Guests</label>
                                <input type="number" name="max_guests" class="form-control" value="{{ $property->max_guests }}" required
                                    {{ (auth()->user()->hasRole('Admin') && !auth()->user()->hasRole('Super Admin')) ? 'readonly' : '' }}>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="city">City</label>
                                <input type="text" name="city" class="form-control" value="{{ $property->city }}" required
                                    {{ (auth()->user()->hasRole('Admin') && !auth()->user()->hasRole('Super Admin')) ? 'readonly' : '' }}>
                            </div>
                            <div class="col-md-6">
                                <label for="country">Country</label>
                                <input type="text" name="country" class="form-control" value="{{ $property->country }}" required
                                    {{ (auth()->user()->hasRole('Admin') && !auth()->user()->hasRole('Super Admin')) ? 'readonly' : '' }}>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address">Address</label>
                            <textarea name="address" class="form-control" rows="2" required
                                {{ (auth()->user()->hasRole('Admin') && !auth()->user()->hasRole('Super Admin')) ? 'readonly' : '' }}>{{ $property->address }}</textarea>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="price_per_night">Price per Night</label>
                                <input type="number" name="price_per_night" class="form-control" step="0.01" value="{{ $property->price_per_night }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="status">Status</label>
                                <select name="status" class="form-control">
                                    <option value="Pending" {{ $property->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Available" {{ $property->status == 'Available' ? 'selected' : '' }}>Available</option>
                                    <option value="Booked" {{ $property->status == 'Booked' ? 'selected' : '' }}>Booked</option>
                                    <option value="Under Maintenance" {{ $property->status == 'Under Maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                                </select>
                            </div>
                        </div>

                        @if(auth()->user()->hasRole('Super Admin'))
                            <div class="mb-3">
                                <label for="owner_id">Assign Owner (Admin)</label>
                                <select name="owner_id" class="form-control">
                                    <option value="">- Select Admin -</option>
                                    @foreach($admins as $admin)
                                        <option value="{{ $admin->id }}" {{ $property->user_id == $admin->id ? 'selected' : '' }}>
                                            {{ $admin->first_name }} {{ $admin->last_name }} ({{ $admin->email }})
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Currently owned by: {{ $property->user->first_name ?? 'Unknown' }} {{ $property->user->last_name ?? '' }}</small>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ $property->description }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Amenities</label>
                            <div class="row">
                                @foreach($amenities as $amenity)
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="amenities[]" value="{{ $amenity->id }}" id="amenity_{{ $amenity->id }}"
                                                {{ $property->amenities->contains($amenity->id) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="amenity_{{ $amenity->id }}">
                                                {{ $amenity->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="images" class="form-label">Add More Images</label>
                            <input type="file" name="images[]" id="images" class="form-control" multiple accept="image/jpeg,image/png,image/jpg" onchange="previewImages(event)">
                            <div id="imagePreviewContainer" class="d-flex flex-wrap gap-2 mt-2"></div>
                            
                            @if($property->images->count() > 0 || $property->image_path)
                                <div class="mt-4">
                                    <label class="form-label text-muted small">Existing Gallery</label>
                                    <div class="d-flex flex-wrap gap-2">
                                        <!-- Main Image -->
                                        @if($property->image_path)
                                        <div class="position-relative">
                                            <img src="{{ asset('storage/' . $property->image_path) }}" class="rounded border" style="height: 80px; width: 80px; object-fit: cover;">
                                            <span class="position-absolute top-0 start-0 badge bg-primary" style="font-size: 0.6rem;">Main</span>
                                            
                                            {{-- Find the PropertyImage model for this path if possible, or handle deletion of main --}}
                                            @php
                                                $mainImgModel = $property->images->where('image_path', $property->image_path)->first();
                                            @endphp
                                            @if($mainImgModel)
                                            <button type="button" class="btn btn-danger btn-sm p-0 rounded-circle position-absolute top-0 end-0" 
                                                style="width: 18px; height: 18px; line-height: 1; font-size: 10px;"
                                                onclick="submitDeleteImage('{{ route('properties.images.destroy', [$property->id, $mainImgModel->id]) }}')">
                                                &times;
                                            </button>
                                            @endif
                                        </div>
                                        @endif
                                        
                                        <!-- Other Images -->
                                        @foreach($property->images as $img)
                                            @if($img->image_path !== $property->image_path)
                                            <div class="position-relative">
                                                 <img src="{{ asset('storage/' . $img->image_path) }}" class="rounded border" style="height: 80px; width: 80px; object-fit: cover;">
                                                 <button type="button" class="btn btn-danger btn-sm p-0 rounded-circle position-absolute top-0 end-0" 
                                                     style="width: 18px; height: 18px; line-height: 1; font-size: 10px;"
                                                     onclick="submitDeleteImage('{{ route('properties.images.destroy', [$property->id, $img->id]) }}')">
                                                     &times;
                                                 </button>
                                            </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="mb-3 bg-light p-3 rounded">
                            <label for="image" class="form-label small text-muted">Replace Main Cover Image (Optional)</label>
                            <input type="file" name="image" class="form-control form-control-sm">
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
                                        reader.onload = function(e) {
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

                        function submitDeleteImage(url) {
                            Swal.fire({
                                title: 'Delete Image?',
                                text: 'Are you sure you want to delete this image? This action cannot be undone.',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Yes, delete it!',
                                cancelButtonText: 'Cancel',
                                buttonsStyling: false,
                                customClass: {
                                    confirmButton: 'btn btn-primary px-4 me-2',
                                    cancelButton: 'btn btn-danger px-4',
                                    popup: 'rounded-4 border-0 shadow'
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    const form = document.getElementById('deleteImageForm');
                                    form.action = url;
                                    form.submit();
                                }
                            });
                        }
                        </script>

                        <button type="submit" class="btn btn-primary w-100">Update Apartment</button>
                    </form>
                </div>

                {{-- Hidden form for image deletion to avoid nested forms --}}
                <form id="deleteImageForm" action="" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
