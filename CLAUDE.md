# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview
This is a Laravel 12 application for a car export business with comprehensive settings management and media handling capabilities.

## Development Commands

### Essential Commands
- **Start development**: `composer run dev` - Runs Laravel server, queue worker, and Vite dev server concurrently
- **Frontend build**: `npm run build` - Build frontend assets for production
- **Frontend dev**: `npm run dev` - Run Vite development server only
- **Run tests**: `php artisan test` - Run all Pest tests
- **Run specific test**: `php artisan test --filter=testName`
- **Run tests in file**: `php artisan test tests/Feature/ExampleTest.php`
- **Code formatting**: `vendor/bin/pint --dirty` - Format code using Laravel Pint

### Database Commands
- **Fresh migration**: `php artisan migrate:fresh --seed` - Reset database with fresh migrations and seeders
- **Run migrations**: `php artisan migrate`
- **Run seeders**: `php artisan db:seed`

### Settings Management Commands
- **Sync settings**: `php artisan settings:sync` - Sync settings from config to database
- **Force sync**: `php artisan settings:sync --force` - Sync without confirmation
- **Reset settings**: `php artisan settings:sync --reset` - Reset to config defaults

### Keys UI Assets
- **Build assets**: `cmd //c "php artisan keys:build"`
- **Watch mode**: `cmd //c "php artisan keys:build --watch"`
- **Dev build**: `cmd //c "php artisan keys:build --dev --publish"`

## Architecture

### Core Business Models
```
Car (main entity)
├── Make (manufacturer)
├── CarModel (specific model)
├── CarAttribute (dynamic attributes)
│   ├── Attribute (definition)
│   └── AttributeValue (possible values)
├── Review (customer reviews)
└── Lead (inquiries)
```

### Settings System Architecture
The application features a comprehensive settings management system with multiple access layers:

**Database Structure:**
- Settings table with key-value pairs, types, groups, and media support
- Integration with Spatie Media Library for file/image settings
- Spatie Translatable for multi-language descriptions

**Access Patterns:**
```php
// Service/Controller
Settings::get('site_name', 'default');
Settings::set('site_name', 'New Name', SettingType::Text);
Settings::getFile('site_logo', 'thumb');

// Blade Templates
@setting('site_name')
@settingFile('site_logo', 'preview')
@hasSetting('feature_enabled')...@endHasSetting

// Helper Functions
settings('site_name');
setting_file('logo');
public_settings(); // Returns public settings collection
```

**Settings Configuration** (`config/settings.php`):
- Defines all available settings with types, defaults, validation
- Groups: site, contact, social, seo, email, maintenance, theme
- Caching configuration with TTL and key management

### Enums (Type Safety)
- `SettingType`: 18 types (Text, Boolean, Image, etc.) with validation rules
- `CarStatus`: Draft, Published, Sold, Reserved
- `AttributeType`: Text, Number, Boolean, Select, Date
- `LeadStatus` & `LeadType`: Lead management states

### Media Handling
All models implementing `HasMedia` use Spatie Media Library:
- Automatic conversions (thumb, preview)
- Collections for different media types
- Integration with settings for file/image types

### Frontend Components (Keys UI)
The application uses Keys UI component library with 50+ components. Key components include:
- Form inputs with built-in actions (copyable, clearable, show-password)
- Advanced select with search and multiple selection
- File upload with drag & drop
- Modals, alerts, cards, tables with empty states
- Avatar stacks, badges, breadcrumbs

Always check KEYS_UI_COMPONENTS.md before creating custom UI components.

### Livewire Components
- `Admin\SettingsManager`: Complete settings CRUD with file uploads
- Layout attribute: `#[layout('components.layouts.admin')]`
- File upload handling with `WithFileUploads` trait

## Database Configuration
- **Engine**: SQLite (`database/database.sqlite`)
- **Testing**: In-memory SQLite with `RefreshDatabase` trait
- **Media disk**: Public disk for file storage

## Testing Strategy
All tests use Pest 4 with Laravel plugin:
- Feature tests must use `uses(RefreshDatabase::class)`
- Test helpers: `settings()`, `setting()`, `has_setting()`
- Mock file uploads with `Storage::fake('public')`
- Test structure: Feature tests in `tests/Feature/`, Unit in `tests/Unit/`

## Key Dependencies
- **Laravel Framework**: v12.30.1 (streamlined structure)
- **Livewire**: v3.6.4 (reactive components)
- **Tailwind CSS**: v4.1.13 (uses `@import 'tailwindcss'` syntax)
- **Pest**: v4.1.0 (with browser testing capabilities)
- **Spatie Media Library**: v11.15 (file management)
- **Spatie Translatable**: v6.11 (multi-language support)
- **Keys UI**: v1.0 (comprehensive UI components)

## Laravel 12 Structure Notes
- **No middleware directory**: Register in `bootstrap/app.php`
- **No Console Kernel**: Commands auto-register from `app/Console/Commands/`
- **Service providers**: Listed in `bootstrap/providers.php`
- **Helpers**: Auto-loaded via composer from `app/helpers.php`