<form method="POST" action="{{ url('admin/login') }}">
    @csrf
    <input name="email" placeholder="Email" required>
    <input name="password" type="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>