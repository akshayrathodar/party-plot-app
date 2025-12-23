<?php

namespace App\Http\Controllers;

use App\Models\VenueRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VenueRequestController extends Controller
{
    /**
     * Store a newly created venue request.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $venueRequest = VenueRequest::create([
            'name' => $request->name,
            'city' => $request->city,
            'phone' => $request->phone,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thank you! Your request has been submitted successfully. We will contact you soon.',
            'data' => $venueRequest,
        ]);
    }

    /**
     * Display a listing of venue requests (Admin).
     */
    public function index(Request $request)
    {
        $query = VenueRequest::query();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $venueRequests = $query->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.venue-requests.index', compact('venueRequests'));
    }

    /**
     * Update the status of a venue request (Admin).
     */
    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,contacted,completed,rejected',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $venueRequest = VenueRequest::findOrFail($id);
        $venueRequest->update([
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return back()->with('success', 'Venue request status updated successfully.');
    }
}

