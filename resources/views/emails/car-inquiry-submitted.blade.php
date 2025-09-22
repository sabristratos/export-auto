<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Car Inquiry</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: #1f2937;
            color: white;
            padding: 20px;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background: #f9fafb;
            padding: 30px;
            border-radius: 0 0 8px 8px;
        }
        .car-details {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #3b82f6;
        }
        .customer-info {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .message-box {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            margin: 20px 0;
        }
        .label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 5px;
        }
        .value {
            color: #6b7280;
            margin-bottom: 15px;
        }
        .price {
            font-size: 24px;
            font-weight: bold;
            color: #059669;
        }
        .footer {
            text-align: center;
            color: #6b7280;
            font-size: 14px;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="margin: 0;">New Car Inquiry Received</h1>
        <p style="margin: 10px 0 0 0; opacity: 0.9;">
            Someone is interested in one of your vehicles
        </p>
    </div>

    <div class="content">
        <!-- Car Details -->
        <div class="car-details">
            <h2 style="margin-top: 0; color: #1f2937;">🚗 Vehicle Details</h2>

            <div class="label">Make & Model:</div>
            <div class="value">
                <strong>{{ $car->make->name }} {{ $car->model->name }}</strong>
                @php
                    $year = $car->attributes->where('attribute.slug', 'year')->first()?->value;
                    $mileage = $car->attributes->where('attribute.slug', 'mileage')->first()?->value;
                    $fuelType = $car->attributes->where('attribute.slug', 'fuel_type')->first()?->value;
                @endphp
                @if($year)
                    ({{ $year }})
                @endif
            </div>

            @if($mileage)
                <div class="label">Mileage:</div>
                <div class="value">{{ number_format($mileage) }} km</div>
            @endif

            @if($fuelType)
                <div class="label">Fuel Type:</div>
                <div class="value">{{ $fuelType }}</div>
            @endif

            <div class="label">Price:</div>
            <div class="price">€{{ number_format($car->price) }}</div>

            @if($car->description)
                <div class="label">Description:</div>
                <div class="value">{{ Str::limit($car->description, 200) }}</div>
            @endif
        </div>

        <!-- Customer Information -->
        <div class="customer-info">
            <h2 style="margin-top: 0; color: #1f2937;">👤 Customer Information</h2>

            <div class="label">Name:</div>
            <div class="value"><strong>{{ $lead->name }}</strong></div>

            <div class="label">Email:</div>
            <div class="value">
                <a href="mailto:{{ $lead->email }}" style="color: #3b82f6;">{{ $lead->email }}</a>
            </div>

            @if($lead->phone)
                <div class="label">Phone:</div>
                <div class="value">
                    <a href="tel:{{ $lead->phone }}" style="color: #3b82f6;">{{ $lead->phone }}</a>
                </div>
            @endif

            <div class="label">Inquiry Date:</div>
            <div class="value">{{ $lead->created_at->format('F j, Y \a\t g:i A') }}</div>

            <div class="label">Source:</div>
            <div class="value">{{ ucfirst(str_replace('_', ' ', $lead->source)) }}</div>
        </div>

        <!-- Customer Message -->
        <div class="message-box">
            <h3 style="margin-top: 0; color: #1f2937;">💬 Customer Message</h3>
            <p style="margin: 0; white-space: pre-line;">{{ $lead->message }}</p>
        </div>

        <!-- Quick Actions -->
        <div style="text-align: center; margin: 30px 0;">
            <a href="mailto:{{ $lead->email }}?subject=Re: Your inquiry about {{ $car->make->name }} {{ $car->model->name }}"
               style="background: #3b82f6; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin-right: 10px; display: inline-block;">
                Reply via Email
            </a>
            @if($lead->phone)
                <a href="tel:{{ $lead->phone }}"
                   style="background: #059669; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; display: inline-block;">
                    Call Customer
                </a>
            @endif
        </div>

        <div class="footer">
            <p>This inquiry was submitted through the car details page on {{ config('app.name') }}</p>
            <p>Lead ID: #{{ $lead->id }} | Car ID: #{{ $car->id }}</p>
        </div>
    </div>
</body>
</html>