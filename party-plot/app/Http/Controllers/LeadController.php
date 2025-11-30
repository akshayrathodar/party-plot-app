<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\PartyPlot;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    /**
     * Store a newly created lead (public route)
     */
    public function store(Request $request)
    {
        // Normalize phone number before validation
        $phone = $request->phone;
        if ($phone) {
            // Remove spaces, dashes, and other non-digit characters except +
            $phone = preg_replace('/[\s\-\(\)]/', '', $phone);
            
            // If starts with +91, remove it
            if (strpos($phone, '+91') === 0) {
                $phone = substr($phone, 3);
            }
            
            // Update request with normalized phone
            $request->merge(['phone' => $phone]);
        }

        $request->validate([
            'party_plot_id' => 'required|exists:party_plots,id',
            'name' => 'required|string|max:255',
            'phone' => [
                'required',
                'string',
                'regex:/^[6-9]\d{9}$/', // Indian mobile number: starts with 6-9 and 10 digits
                'size:10'
            ],
            'event_date' => 'nullable|date',
            'message' => 'nullable|string|max:1000',
        ], [
            'phone.required' => 'Mobile number is required.',
            'phone.regex' => 'Please enter a valid 10-digit mobile number starting with 6, 7, 8, or 9.',
            'phone.size' => 'Mobile number must be exactly 10 digits.',
        ]);

        try {
            $partyPlot = PartyPlot::findOrFail($request->party_plot_id);
            
            // Get vendor_id from party plot (creator or claimed_by)
            $vendorId = $partyPlot->claimed_by_user_id ?? $partyPlot->creator_user_id;
            
            if (!$vendorId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Party plot owner not found.'
                ], 400);
            }

            $lead = Lead::create([
                'party_plot_id' => $request->party_plot_id,
                'vendor_id' => $vendorId,
                'user_id' => auth()->id(), // null if guest
                'name' => $request->name,
                'email' => null, // Email not required
                'phone' => $phone, // Use normalized phone
                'function_date' => $request->event_date,
                'message' => $request->message,
                'status' => 'new',
                'source' => 'free',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Thank you! Your enquiry has been submitted successfully. We will contact you soon.',
                'lead_id' => $lead->id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error submitting enquiry: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display a listing of leads
     */
    public function index(Request $request)
    {
        $query = Lead::with(['partyPlot', 'vendor', 'user']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhereHas('partyPlot', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        if ($request->filled('party_plot_id')) {
            $query->where('party_plot_id', $request->party_plot_id);
        }

        if ($request->filled('vendor_id')) {
            $query->where('vendor_id', $request->vendor_id);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $leads = $query->paginate(20);

        // Get party plots for filter
        $partyPlots = PartyPlot::orderBy('name')->pluck('name', 'id');

        return view('leads.index', compact('leads', 'partyPlots'));
    }

    /**
     * Display the specified lead
     */
    public function show($id)
    {
        $lead = Lead::with(['partyPlot', 'vendor', 'user'])->findOrFail($id);
        return view('leads.show', compact('lead'));
    }

    /**
     * Update the lead status
     */
    public function updateStatus(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);

        $request->validate([
            'status' => 'required|in:new,contacted,converted,lost',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $lead->status = $request->status;
        if ($request->filled('admin_notes')) {
            $lead->admin_notes = $request->admin_notes;
        }
        $lead->save();

        return redirect()->back()->with('success', 'Lead status updated successfully.');
    }

    /**
     * Remove the specified lead
     */
    public function destroy($id)
    {
        $lead = Lead::findOrFail($id);
        $lead->delete();

        return redirect()->route('admin.leads.index')
            ->with('success', 'Lead deleted successfully.');
    }
}

