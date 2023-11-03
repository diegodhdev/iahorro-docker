<form action="{{ route('lead.update') }}" method="POST">
    @csrf
    @method('PATCH')

    <input id="id"
           name="id"
           type="hidden"
           class="@error('id') is-invalid @else is-valid @enderror" value="{{ $lead['id']  }}">


    <input id="name"
           name="name"
           type="text"
           class="@error('name') is-invalid @else is-valid @enderror" value="{{ $lead['name']  }}">

    <label for="email">Email address</label>

    <input id="email"
           name="email"
           type="text"
           class="@error('email') is-invalid @else is-valid @enderror" value="{{ $lead['email']  }}">


    <label for="phone">Phone</label>

    <input id="phone"
           type="text"
           name="phone"
           class="@error('phone') is-invalid @else is-valid @enderror" value="{{ $lead['phone']  }}">

    <input type="submit" value="Store"/>

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
