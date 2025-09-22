<?php

namespace App\Livewire;

use App\Enums\LeadStatus;
use App\Enums\LeadType;
use App\Facades\Settings;
use App\Mail\ContactFormSubmitted;
use App\Models\Lead;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ContactForm extends Component
{
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $message = '';
    public string $inquiry_type = 'general';
    public bool $showSuccess = false;

    // Prepared data properties
    public array $inquiryOptions;
    public array $successContent;
    public array $formLabels;
    public array $placeholders;
    public int $maxCharacters = 1000;

    public function mount(): void
    {
        $this->prepareFormData();
    }

    private function prepareFormData(): void
    {
        $this->inquiryOptions = [
            'general' => __('General Inquiry'),
            'car_inquiry' => __('Car Purchase Inquiry'),
            'quote' => __('Request Quote'),
            'support' => __('Customer Support'),
        ];

        $this->successContent = [
            'title' => __('Thank You!'),
            'message' => __('Your message has been sent successfully. We\'ll get back to you soon!'),
            'button_text' => __('Send Another Message'),
        ];

        $this->formLabels = [
            'name' => __('Full Name'),
            'email' => __('Email Address'),
            'phone' => __('Phone Number'),
            'inquiry_type' => __('Inquiry Type'),
            'message' => __('Message'),
        ];

        $this->placeholders = [
            'name' => __('Enter your full name'),
            'email' => __('Enter your email address'),
            'phone' => __('Enter your phone number'),
            'inquiry_type' => __('Select inquiry type'),
            'message' => __('Tell us about your car export needs or any questions you have...'),
        ];
    }

    protected array $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:50',
        'message' => 'required|string|min:10|max:1000',
        'inquiry_type' => 'required|string|in:general,car_inquiry,quote,support',
    ];

    protected function getMessages(): array
    {
        return [
            'name.required' => __('Please enter your name.'),
            'name.max' => __('Name must not exceed 255 characters.'),
            'email.required' => __('Please enter your email address.'),
            'email.email' => __('Please enter a valid email address.'),
            'email.max' => __('Email must not exceed 255 characters.'),
            'phone.max' => __('Phone number must not exceed 50 characters.'),
            'message.required' => __('Please enter your message.'),
            'message.min' => __('Message must be at least 10 characters.'),
            'message.max' => __('Message must not exceed 1000 characters.'),
            'inquiry_type.required' => __('Please select an inquiry type.'),
            'inquiry_type.in' => __('Please select a valid inquiry type.'),
        ];
    }

    public function submitForm()
    {
        $this->validate();

        // Create the lead
        $lead = Lead::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone ?: null,
            'message' => $this->message,
            'type' => $this->inquiry_type === 'car_inquiry' ? LeadType::CarInquiry :
                     ($this->inquiry_type === 'general' ? LeadType::General : LeadType::Contact),
            'status' => LeadStatus::New,
            'source' => 'contact_form',
        ]);

        // Send email notification to admin
        $contactEmail = Settings::get('contact_email');
        if ($contactEmail) {
            Mail::to($contactEmail)->send(new ContactFormSubmitted($lead));
        }

        // Show success message
        $this->showSuccess = true;

        // Reset form after 3 seconds
        $this->js('setTimeout(() => { $wire.resetForm() }, 3000)');
    }

    public function resetForm()
    {
        $this->reset(['name', 'email', 'phone', 'message', 'inquiry_type', 'showSuccess']);
        $this->inquiry_type = 'general';
        $this->resetErrorBag();
    }

    public function getCharacterCountProperty()
    {
        return $this->maxCharacters - strlen($this->message);
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}