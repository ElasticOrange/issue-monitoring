<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
<p>Hello, @if($user->name){{ $user->name }}@else{{ $user->email }}@endif!</p>

<p>Ai o noua alerta de tip raport.</p><br />
{!! $alert->alertable->title !!} <br />
{!! $alert->alertable->description !!} <br />

</body>
</html>