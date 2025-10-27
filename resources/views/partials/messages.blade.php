@if (session()->has('success'))
    <div class="alert alert-success message-alert" role="alert">
        <i class="fa fa-check-circle"></i>
        <span class="pr-20 pl-20">{{session('success')}}</span>
    </div>
@endif

@if (session()->has('error'))
    <div class="alert alert-danger message-alert" role="alert">
        <i class="fa fa-times-circle"></i>
        @if (is_array(session('error')))
            @foreach (session('error') as $error)
                <span class="pr-20 pl-20">{{ $error[0] }}</span>
            @endforeach
        @else
            <span class="pr-20 pl-20">{{ session('error') }}</span>
        @endif
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger message-alert" role="alert">
        <i class="fa fa-times-circle"></i>
        @foreach ($errors->all() as $error)
            <span class="pr-20 pl-20">{{ $error }}</span>
        @endforeach
    </div>
@endif
