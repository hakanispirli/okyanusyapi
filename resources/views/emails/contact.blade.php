<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İletişim Formu Mesajı</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .content {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #e9ecef;
            border-radius: 8px;
        }
        .field {
            margin-bottom: 15px;
        }
        .label {
            font-weight: bold;
            color: #495057;
            margin-bottom: 5px;
        }
        .value {
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 4px;
            border-left: 4px solid #007bff;
        }
        .message-field {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            border-left: 4px solid #28a745;
            white-space: pre-wrap;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Yeni İletişim Formu Mesajı</h1>
        <p>Web sitenizden yeni bir iletişim formu mesajı alındı.</p>
    </div>

    <div class="content">
        <div class="field">
            <div class="label">Ad Soyad:</div>
            <div class="value">{{ $contactData['name'] }}</div>
        </div>

        <div class="field">
            <div class="label">E-posta:</div>
            <div class="value">{{ $contactData['email'] }}</div>
        </div>

        @if(!empty($contactData['phone']))
        <div class="field">
            <div class="label">Telefon:</div>
            <div class="value">{{ $contactData['phone'] }}</div>
        </div>
        @endif

        <div class="field">
            <div class="label">Konu:</div>
            <div class="value">{{ $contactData['subject'] }}</div>
        </div>

        <div class="field">
            <div class="label">Mesaj:</div>
            <div class="message-field">{{ $contactData['message'] }}</div>
        </div>

        <div class="field">
            <div class="label">Gönderim Tarihi:</div>
            <div class="value">{{ now()->format('d.m.Y H:i') }}</div>
        </div>
    </div>
</body>
</html>
