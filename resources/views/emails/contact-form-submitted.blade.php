<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
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
            background-color: #3b82f6;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 8px 8px;
        }
        .field {
            margin-bottom: 20px;
        }
        .field-label {
            font-weight: bold;
            color: #4b5563;
            margin-bottom: 5px;
        }
        .field-value {
            background-color: white;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #e5e7eb;
        }
        .message-content {
            white-space: pre-wrap;
            min-height: 60px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            font-size: 14px;
            color: #6b7280;
        }
        .badge {
            display: inline-block;
            background-color: #10b981;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>New Contact Form Submission</h1>
        <span class="badge">{{ $lead->type->value }}</span>
    </div>

    <div class="content">
        <div class="field">
            <div class="field-label">Name:</div>
            <div class="field-value">{{ $lead->name }}</div>
        </div>

        <div class="field">
            <div class="field-label">Email:</div>
            <div class="field-value">
                <a href="mailto:{{ $lead->email }}">{{ $lead->email }}</a>
            </div>
        </div>

        @if($lead->phone)
        <div class="field">
            <div class="field-label">Phone:</div>
            <div class="field-value">
                <a href="tel:{{ $lead->phone }}">{{ $lead->phone }}</a>
            </div>
        </div>
        @endif

        <div class="field">
            <div class="field-label">Message:</div>
            <div class="field-value message-content">{{ $lead->message }}</div>
        </div>

        @if($lead->source)
        <div class="field">
            <div class="field-label">Source:</div>
            <div class="field-value">{{ $lead->source }}</div>
        </div>
        @endif

        <div class="footer">
            <p><strong>Submitted:</strong> {{ $lead->created_at->format('F j, Y \a\t g:i A') }}</p>
            <p><strong>Status:</strong> {{ $lead->status->value }}</p>
            <p><strong>Lead ID:</strong> #{{ $lead->id }}</p>
        </div>
    </div>
</body>
</html>