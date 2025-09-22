<?php

namespace App\Livewire;

use App\Enums\LeadStatus;
use App\Enums\LeadType;
use App\Facades\Settings;
use App\Mail\CarInquirySubmitted;
use App\Models\Car;
use App\Models\Lead;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class CarInquiryForm extends Component
{
    public Car $car;

    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $message = '';
    public bool $showSuccess = false;

    // Prepared data properties
    public array $successContent;
    public array $formLabels;
    public array $placeholders;
    public int $maxCharacters = 500;

    public function mount(Car $car): void
    {
        $this->car = $car;
        $this->prepareFormData();
        $this->generateCarSpecificMessage();
    }

    private function prepareFormData(): void
    {
        $this->successContent = [
            'title' => __('Inquiry Sent Successfully!'),
            'message' => __('Thank you for your interest in this :make :model. Our team will contact you within 24 hours with detailed information about this vehicle.', [
                'make' => $this->car->make->name,
                'model' => $this->car->model->name
            ]),
            'button_text' => __('Send Another Inquiry'),
        ];

        $this->formLabels = [
            'name' => __('Full Name'),
            'email' => __('Email Address'),
            'phone' => __('Phone Number'),
            'message' => __('Your Message'),
        ];

        $this->placeholders = [
            'name' => __('Enter your full name'),
            'email' => __('Enter your email address'),
            'phone' => __('Enter your phone number (optional)'),
            'message' => __('Tell us about your interest in this vehicle...'),
        ];
    }

    private function generateCarSpecificMessage(): void
    {
        $year = $this->car->attributes->where('attribute.slug', 'year')->first()?->value;
        $carDescription = $this->car->make->name . ' ' . $this->car->model->name . ($year ? ' ' . $year : '');

        $this->message = __("I'm interested in this :car. Please provide more information about pricing, condition, and the export process.", [
            'car' => $carDescription
        ]);
    }

    protected array $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:50',
        'message' => 'required|string|min:10|max:500',
    ];

    protected array $messages = [
        'name.required' => 'Please enter your name.',
        'name.max' => 'Name must not exceed 255 characters.',
        'email.required' => 'Please enter your email address.',
        'email.email' => 'Please enter a valid email address.',
        'email.max' => 'Email must not exceed 255 characters.',
        'phone.max' => 'Phone number must not exceed 50 characters.',
        'message.required' => 'Please enter your message.',
        'message.min' => 'Message must be at least 10 characters.',
        'message.max' => 'Message must not exceed 500 characters.',
    ];

    public function submitInquiry()
    {
        $this->validate();

        // Create the lead with car relationship
        $lead = Lead::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone ?: null,
            'message' => $this->message,
            'type' => LeadType::CarInquiry,
            'status' => LeadStatus::New,
            'source' => 'car_details_page',
            'car_id' => $this->car->id,
        ]);

        // Send email notification to admin
        $contactEmail = Settings::get('contact_email');
        if ($contactEmail) {
            Mail::to($contactEmail)->send(new CarInquirySubmitted($lead, $this->car));
        }

        // Show success message
        $this->showSuccess = true;

        // Reset form after 5 seconds
        $this->js('setTimeout(() => { $wire.resetForm() }, 5000)');
    }

    public function resetForm()
    {
        $this->reset(['name', 'email', 'phone', 'showSuccess']);
        $this->generateCarSpecificMessage();
        $this->resetErrorBag();
    }

    public function getCharacterCountProperty()
    {
        return $this->maxCharacters - strlen($this->message);
    }

    public function render()
    {
        return view('livewire.car-inquiry-form');
    }
}