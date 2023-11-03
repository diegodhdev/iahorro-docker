<form action="{{ route('lead.store') }}" method="POST">
    @csrf
    @method('PUT')

    <label for="name">Name</label>

    <input id="name"
           name="name"
           type="text"
           class="@error('name') is-invalid @else is-valid @enderror">

    <label for="email">Email address</label>

    <input id="email"
           name="email"
           type="text"
           class="@error('email') is-invalid @else is-valid @enderror">


    <label for="phone">Phone</label>

    <input id="phone"
           type="text"
           name="phone"
           class="@error('phone') is-invalid @else is-valid @enderror">

    <input type="submit" value="Store" />

</form>
