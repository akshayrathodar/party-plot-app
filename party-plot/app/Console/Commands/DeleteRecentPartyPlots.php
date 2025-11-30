<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DeleteRecentPartyPlots extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'party-plots:delete-recent {--date= : Delete records created after this date (YYYY-MM-DD)} {--count= : Delete the most recent N records}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete recently uploaded party plots (created today by default)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Deleting recent party plots...');
        
        $deleted = 0;
        
        if ($this->option('date')) {
            // Delete records created after a specific date
            $date = $this->option('date') . ' 00:00:00';
            $deleted = \App\Models\PartyPlot::where('created_at', '>=', $date)->delete();
            $this->info("Deleted {$deleted} party plot(s) created after {$this->option('date')}.");
        } elseif ($this->option('count')) {
            // Delete the most recent N records
            $count = (int) $this->option('count');
            $recentIds = \App\Models\PartyPlot::orderBy('created_at', 'desc')->limit($count)->pluck('id');
            $deleted = \App\Models\PartyPlot::whereIn('id', $recentIds)->delete();
            $this->info("Deleted {$deleted} most recent party plot(s).");
        } else {
            // Delete records created today (default)
            $today = date('Y-m-d') . ' 00:00:00';
            $deleted = \App\Models\PartyPlot::where('created_at', '>=', $today)->delete();
            $this->info("Deleted {$deleted} party plot(s) created today.");
        }
        
        return 0;
    }
}
