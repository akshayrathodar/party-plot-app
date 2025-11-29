<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Handle contact form submission
     */
    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
            'terms' => 'required|accepted',
        ]);

        if ($validator->fails()) {
            return redirect()->route('contact')
                ->withErrors($validator)
                ->withInput();
        }

        // TODO: Save to database
        // Contact::create($request->all());

        // TODO: Send email notification
        // Mail::to(config('mail.admin_email'))->send(new ContactFormMail($request->all()));

        return redirect()->route('contact')
            ->with('success', 'Thank you for contacting us! We will get back to you soon.');
    }
}



