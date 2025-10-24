<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Hero;

class HeroSlider extends Component
{
    public $heroes;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($limit = null)
    {
        // Get active heroes ordered by position
        $query = Hero::active()->ordered();

        if ($limit) {
            $query->limit($limit);
        }

        $this->heroes = $query->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.hero-slider');
    }
}
