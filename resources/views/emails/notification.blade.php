<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333333;
        }
        .container {
            width: 80%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #007BFF;
        }
        .content p {
            line-height: 1.6;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #e0e0e0;
            color: #777777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>
                @if($notification->type === 'danger')
                    Notification d'Annulation
                @else
                    Notification de Confirmation
                @endif
            </h1>
        </div>
        <div class="content">
            <p>{{ $notification->message }}</p>
            <p>Cette action a été effectuée le: {{ $notification->created_at->format('d-m-Y H:i:s') }}</p>
        </div>
        <div class="footer">
            <p>Merci de votre attention.</p>
            <p><strong>M2M Group</strong></p>
        </div>
    </div>
</body>
</html>
