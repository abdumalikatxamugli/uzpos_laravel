@include("partials.validation_errors")
<form action="{{route('dashboard.login')}}" method="POST">
    @csrf
    <input type="text" name="username">
    <input type="password" name="password">
    <button>Login</button>
</form>
