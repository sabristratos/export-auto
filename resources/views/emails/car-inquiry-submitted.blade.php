@extends('emails.layouts.base')

@section('title', 'New Car Inquiry')
@section('emailTitle', 'New Car Inquiry Received')
@section('emailSubtitle', 'A potential customer is interested in one of your vehicles')
@section('headerTagline', 'Premium European Car Export')

@section('content')
    @php
        $year = $car->attributes->where('attribute.slug', 'year')->first()?->value;
        $mileage = $car->attributes->where('attribute.slug', 'mileage')->first()?->value;
        $fuelType = $car->attributes->where('attribute.slug', 'fuel_type')->first()?->value;
        $transmission = $car->attributes->where('attribute.slug', 'transmission')->first()?->value;
        $bodyType = $car->attributes->where('attribute.slug', 'body_type')->first()?->value;
    @endphp

    <!-- Vehicle Details Section -->
    <div class="content-section">
        <h3>🚗 Vehicle Information</h3>

        <div class="field">
            <div class="field-label">Make & Model</div>
            <div class="field-value">
                <strong>{{ $car->make->name }} {{ $car->model->name }}</strong>
                @if($year)
                    ({{ $year }})
                @endif
            </div>
        </div>

        @if($mileage)
        <div class="field">
            <div class="field-label">Mileage</div>
            <div class="field-value">{{ number_format($mileage) }} km</div>
        </div>
        @endif

        @if($fuelType)
        <div class="field">
            <div class="field-label">Fuel Type</div>
            <div class="field-value">{{ $fuelType }}</div>
        </div>
        @endif

        @if($transmission)
        <div class="field">
            <div class="field-label">Transmission</div>
            <div class="field-value">{{ $transmission }}</div>
        </div>
        @endif

        @if($bodyType)
        <div class="field">
            <div class="field-label">Body Type</div>
            <div class="field-value">{{ $bodyType }}</div>
        </div>
        @endif

        <div class="field">
            <div class="field-label">Price</div>
            <div class="price">€{{ number_format($car->price) }}</div>
        </div>

        @if($car->description)
        <div class="field">
            <div class="field-label">Description</div>
            <div class="field-value">{{ Str::limit($car->description, 250) }}</div>
        </div>
        @endif
    </div>

    <!-- Customer Information Section -->
    <div class="content-section">
        <h3>👤 Customer Information</h3>

        <div class="field">
            <div class="field-label">Full Name</div>
            <div class="field-value">{{ $lead->name }}</div>
        </div>

        <div class="field">
            <div class="field-label">Email Address</div>
            <div class="field-value">
                <a href="mailto:{{ $lead->email }}" class="email-link">{{ $lead->email }}</a>
            </div>
        </div>

        @if($lead->phone)
        <div class="field">
            <div class="field-label">Phone Number</div>
            <div class="field-value">
                <a href="tel:{{ $lead->phone }}" class="email-link">{{ $lead->phone }}</a>
            </div>
        </div>
        @endif

        <div class="field">
            <div class="field-label">Inquiry Date</div>
            <div class="field-value">{{ $lead->created_at->format('F j, Y \a\t g:i A') }}</div>
        </div>

        <div class="field">
            <div class="field-label">Source</div>
            <div class="field-value">{{ ucfirst(str_replace('_', ' ', $lead->source)) }}</div>
        </div>
    </div>

    <!-- Customer Message Section -->
    <div class="content-section">
        <h3>💬 Customer Message</h3>
        <div class="field">
            <div class="field-value large">{{ $lead->message }}</div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div style="text-align: center; margin: 32px 0;">
        <a href="mailto:{{ $lead->email }}?subject=Re: Your inquiry about {{ $car->make->name }} {{ $car->model->name }}"
           class="email-button">
            Reply via Email
        </a>

        @if($lead->phone)
        <a href="tel:{{ $lead->phone }}"
           class="email-button secondary">
            Call Customer
        </a>
        @endif
    </div>
@endsection

@section('footerMeta')
    <p><strong>Inquiry Date:</strong> {{ $lead->created_at->format('F j, Y \a\t g:i A') }}</p>
    <p><strong>Lead ID:</strong> #{{ $lead->id }} | <strong>Car ID:</strong> #{{ $car->id }}</p>
    <p>This inquiry was submitted through the car details page on {{ setting('site_name', 'Elite Car Export') }}</p>
@endsection