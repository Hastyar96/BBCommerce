<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebSocket Test</title>
</head>
<body>
    {{ Auth::user()->first_name }}
    @foreach ($data['data'] as $item)
        <h1>{{ $item['name'] }}</h1>
    @endforeach
</body>
</html>
