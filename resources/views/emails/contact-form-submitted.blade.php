@extends('emails.layouts.base')

@section('title', 'New Contact Form Submission')
@section('emailTitle', 'New Contact Form Submission')
@section('emailSubtitle', 'Someone has reached out through your website contact form')
@section('headerTagline', 'Professional Car Export Services')

@section('content')
    <!-- Lead Type Badge -->
    <div style="text-align: center; margin-bottom: 32px;">
        <span class="status-badge">{{ $lead->type->value }}</span>
    </div>

    <!-- Contact Information Section -->
    <div class="content-section">
        <h3>📋 Contact Details</h3>

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

        @if($lead->source)
        <div class="field">
            <div class="field-label">Source</div>
            <div class="field-value">{{ ucfirst(str_replace('_', ' ', $lead->source)) }}</div>
        </div>
        @endif
    </div>

    <!-- Message Section -->
    <div class="content-section">
        <h3>💬 Customer Message</h3>
        <div class="field">
            <div class="field-value large">{{ $lead->message }}</div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div style="text-align: center; margin: 32px 0;">
        <a href="mailto:{{ $lead->email }}?subject=Re: Your inquiry to {{ setting('site_name', 'Elite Car Export') }}"
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
    <p><strong>Submitted:</strong> {{ $lead->created_at->format('F j, Y \a\t g:i A') }}</p>
    <p><strong>Status:</strong> {{ $lead->status->value }} | <strong>Lead ID:</strong> #{{ $lead->id }}</p>
    <p>This inquiry was submitted through the contact form on {{ setting('site_name', 'Elite Car Export') }}</p>
@endsection