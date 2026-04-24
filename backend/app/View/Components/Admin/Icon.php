<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class Icon extends Component
{
    public function __construct(public string $name, public string $class = 'w-5 h-5 shrink-0') {}

    public function render()
    {
        return view('components.admin.icon');
    }
}
