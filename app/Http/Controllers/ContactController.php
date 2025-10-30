<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Message;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display the contact page.
     */
    public function index()
    {
        $contact = Contact::first();

        // Generate simple math captcha
        $num1 = rand(1, 10);
        $num2 = rand(1, 10);
        session(['captcha_answer' => $num1 + $num2]);

        return view('public.contact', compact('contact', 'num1', 'num2'));
    }

    /**
     * Store a new message from contact form.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'captcha' => 'required|numeric',
        ]);

        // Verify captcha
        if ($request->captcha != session('captcha_answer')) {
            return back()
                ->withInput()
                ->withErrors(['captcha' => 'Jawaban captcha salah! Silakan coba lagi.']);
        }

        // Store message
        Message::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
        ]);

        // Clear captcha from session
        session()->forget('captcha_answer');

        return redirect()
            ->route('kontak')
            ->with('success', 'Pesan Anda berhasil dikirim! Kami akan segera menghubungi Anda.');
    }
}
