<!DOCTYPE html>
<html>
<head>
    <title>Notification</title>
</head>
<body>
    <h1>Nouvelle Notification</h1>
    <p>{{ $notification->message }}</p>
    <p>Date: {{ $notification->created_at->format('d-m-Y H:i:s') }}</p>
</body>
</html>
