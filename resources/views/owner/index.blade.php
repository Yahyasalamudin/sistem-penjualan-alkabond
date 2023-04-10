<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    owner
    @if (Session::get('success'))
        <div class="alert alert-danger" style="color: white">
            <strong>{{ $message }}</strong>
        </div>
    @endif

    <form action="{{ route('actionlogout') }}" method="post">
        @csrf
        <button type="submit"></button>
    </form>
</body>

</html>
