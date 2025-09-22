<?php

namespace App\Enums;

enum SettingType: string
{
    case Text = 'text';
    case Textarea = 'textarea';
    case Number = 'number';
    case Integer = 'integer';
    case Float = 'float';
    case Boolean = 'boolean';
    case Select = 'select';
    case MultiSelect = 'multi_select';
    case Email = 'email';
    case Url = 'url';
    case Color = 'color';
    case Date = 'date';
    case DateTime = 'datetime';
    case Time = 'time';
    case File = 'file';
    case Image = 'image';
    case Json = 'json';
    case Array = 'array';
    case Html = 'html';

    public function label(): string
    {
        return match ($this) {
            self::Text => 'Text',
            self::Textarea => 'Textarea',
            self::Number => 'Number',
            self::Integer => 'Integer',
            self::Float => 'Float',
            self::Boolean => 'Boolean',
            self::Select => 'Select',
            self::MultiSelect => 'Multi Select',
            self::Email => 'Email',
            self::Url => 'URL',
            self::Color => 'Color',
            self::Date => 'Date',
            self::DateTime => 'Date & Time',
            self::Time => 'Time',
            self::File => 'File',
            self::Image => 'Image',
            self::Json => 'JSON',
            self::Array => 'Array',
            self::Html => 'HTML',
        };
    }

    public function isFileType(): bool
    {
        return in_array($this, [self::File, self::Image]);
    }

    public function getValidationRules(): array
    {
        return match ($this) {
            self::Text, self::Textarea => ['string', 'max:65535'],
            self::Number, self::Integer => ['numeric'],
            self::Float => ['numeric'],
            self::Boolean => ['boolean'],
            self::Email => ['email'],
            self::Url => ['url'],
            self::Color => ['string', 'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],
            self::Date => ['date'],
            self::DateTime => ['date'],
            self::Time => ['date_format:H:i'],
            self::File => ['file'],
            self::Image => ['image'],
            self::Json => ['json'],
            self::Array => ['array'],
            self::Html => ['string'],
            default => ['string'],
        };
    }
}