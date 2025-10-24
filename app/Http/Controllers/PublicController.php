<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Display the home page.
     */
    public function home()
    {
        return view('public.home');
    }

    /**
     * Display news page.
     */
    public function news()
    {
        return view('public.news');
    }

    /**
     * Display agenda page.
     */
    public function agenda()
    {
        return view('public.agenda');
    }

    /**
     * Display documents page.
     */
    public function documents()
    {
        return view('public.documents');
    }

    /**
     * Display gallery page.
     */
    public function gallery()
    {
        return view('public.gallery');
    }

    /**
     * Display contact page.
     */
    public function contact()
    {
        return view('public.contact');
    }

    /**
     * Display vision & mission page.
     */
    public function visionMission()
    {
        return view('public.vision-mission');
    }

    /**
     * Display organization structure page.
     */
    public function organizationStructure()
    {
        return view('public.organization-structure');
    }

    /**
     * Display programs page.
     */
    public function programs()
    {
        return view('public.programs');
    }
}
