
<form action="{{ route('lead.store') }}" method="POST">
    @csrf
    @method('PUT')

    <label for="name">Name</label>

    <input id="name"
           name="name"
           type="text"
           value="{{ old('name') }}"
           class="@error('name') is-invalid @else is-valid @enderror">

    <label for="email">Email address</label>

    <input id="email"
           name="email"
           type="text"
           value="{{ old('email') }}"
           class="@error('email') is-invalid @else is-valid @enderror">

    <label for="phone">Phone</label>

    <input id="phone"
           type="text"
           name="phone"
           value="{{ old('phone') }}"
           class="@error('phone') is-invalid @else is-valid @enderror">

    <input type="submit" value="Store" />

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

</form>
