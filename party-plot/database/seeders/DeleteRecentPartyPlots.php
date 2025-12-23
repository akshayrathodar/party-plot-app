<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PartyPlot;
use Illuminate\Support\Facades\DB;

class DeleteRecentPartyPlots extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * This seeder deletes party plots created after a specific date
     * or the most recent N records.
     */
    public function run()
    {
        // Option 1: Delete records created after a specific date
        // Uncomment and set the date as needed
        // $date = '2025-01-21 00:00:00';
        // $deleted = PartyPlot::where('created_at', '>=', $date)->delete();
        
        // Option 2: Delete the most recent N records
        // Uncomment and set the number as needed
        // $limit = 119; // Number of recent records to delete
        // $recentIds = PartyPlot::orderBy('created_at', 'desc')->limit($limit)->pluck('id');
        // $deleted = PartyPlot::whereIn('id', $recentIds)->delete();
        
        // Option 3: Delete all party plots (use with caution!)
        // $deleted = PartyPlot::truncate();
        
        // For now, let's delete records created today
        $today = date('Y-m-d') . ' 00:00:00';
        $deleted = PartyPlot::where('created_at', '>=', $today)->delete();
        
        echo "Deleted {$deleted} party plot(s).\n";
    }
}









