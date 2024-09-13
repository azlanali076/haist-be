@if(session()->has('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if(session()->has('error') || $errors->any())
    <div class="alert alert-danger">
        {{ session('error') }}
        @foreach($errors->all() as $error)
            {{ $error }}
        @endforeach
    </div>
@endif
