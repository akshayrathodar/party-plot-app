<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TruncatePartyPlots extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'party-plots:truncate {--force : Force truncation without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all party plots and reset auto-increment ID to start from 1';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->option('force')) {
            if (!$this->confirm('Are you sure you want to delete ALL party plots? This cannot be undone!')) {
                $this->info('Operation cancelled.');
                return 0;
            }
        }

        $this->info('Deleting all party plots...');
        
        // Get count before deletion
        $count = \App\Models\PartyPlot::count();
        
        // Truncate table (this also resets auto-increment)
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\PartyPlot::truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // Reset auto-increment to 1
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE party_plots AUTO_INCREMENT = 1;');
        
        $this->info("Successfully deleted {$count} party plot(s).");
        $this->info('Auto-increment ID reset to start from 1.');
        
        return 0;
    }
}
