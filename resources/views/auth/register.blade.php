<form method="POST" action="/auth/register">
    {!! csrf_field() !!}

    <div>
        Name
        <input type="text" name="name" value="{{ old('name') }}">
    </div>

    <div>
        Email
        <input type="email" name="email" value="{{ old('email') }}">
    </div>

    <div>
        Password
        <input type="password" name="password">
    </div>

    <div>
        Confirm Password
        <input type="password" name="password_confirmation">
    </div>

    <div>
        Telefon
        <input type="text" name="telefon">
    </div>

    <div>
        Drzava
        <input type="text" name="drzava">
    </div>

    <div>
        Grad
        <input type="text" name="grad">
    </div>

    <div>
        <button type="submit">Register</button>
    </div>
</form>