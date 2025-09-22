<?php

namespace App\Console\Commands;

use App\Services\SettingsService;
use Illuminate\Console\Command;

class SyncSettingsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'settings:sync
                            {--force : Force sync without confirmation}
                            {--reset : Reset existing settings to config defaults}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync settings configuration with database';

    /**
     * Execute the console command.
     */
    public function handle(SettingsService $settingsService): int
    {
        $this->info('Syncing settings from configuration to database...');

        if ($this->option('reset') && !$this->option('force')) {
            if (!$this->confirm('This will reset existing settings to their config defaults. Continue?')) {
                $this->info('Sync cancelled.');
                return Command::SUCCESS;
            }
        }

        try {
            $synced = $settingsService->syncFromConfig();

            if (empty($synced)) {
                $this->info('✅ All settings are already in sync.');
                return Command::SUCCESS;
            }

            $this->info("✅ Successfully synced " . count($synced) . " settings:");

            foreach ($synced as $key) {
                $this->line("  • {$key}");
            }

            if ($this->option('reset')) {
                $this->warn('⚠️  Settings have been reset to config defaults.');
            }

        } catch (\Exception $e) {
            $this->error("❌ Error syncing settings: {$e->getMessage()}");
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
