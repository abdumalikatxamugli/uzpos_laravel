@include("partials.validation_errors")
<form action="{{route('login_interface')}}" method="POST">
    @csrf
    <input type="text" name="username">
    <input type="password" name="password">
    <button>Login</button>
</form>
