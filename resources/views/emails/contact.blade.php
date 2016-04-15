<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <p>
        Email de la: {{ $email }}
    </p>
    <p>
        Nume: {{ $name }}
    </p>
    <p>
        Mesaj:
    </p>
    <p>
        {{ strip_tags($body) }}
    </p>
</body>
</html>