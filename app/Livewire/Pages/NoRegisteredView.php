<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class NoRegisteredView extends Component
{

    public $isConnexionOpens = false;



    public function openConnexion()
    {
        $this->isConnexionOpens = true;
    }

    public function closeConnexion()
    {
        $this->isConnexionOpens = false;
    }

    public function redirectToProvider($provider)
    {
        return redirect()->route('socialite.redirect', ['provider' => $provider]);
    }

    public function render()
    {
        return view('livewire.pages.no-registered-view');
    }
}
