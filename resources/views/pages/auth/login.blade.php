<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Website Kelas PPLG</title>
</head>
<body>
    <div style="max-width: 400px; margin: 50px auto; font-family: sans-serif;">
        <h2>Login Member Area</h2>

        @if ($errors->any())
            <div style="color: red; margin-bottom: 15px;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div style="margin-bottom: 15px;">
                <label>Username atau Email:</label><br>
                <input type="text" name="login" value="{{ old('login') }}" required style="width: 100%; padding: 8px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label>Password:</label><br>
                <input type="password" name="password" required style="width: 100%; padding: 8px;">
            </div>

            <button type="submit" style="padding: 10px 15px;">Login</button>
        </form>
    </div>
</body>
</html>