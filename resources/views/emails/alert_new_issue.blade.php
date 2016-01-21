<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
<p>Hello, @if($user->name){{ $user->name }}@else{{ $user->email }}@endif!</p>

Ai o noua alerta de tip <strong>{{ $alert_type }}</strong>

</body>
</html>