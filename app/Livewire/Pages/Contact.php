<?php

namespace App\Livewire\Pages;

use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Contact')]
class Contact extends Component
{
    #[Validate('required', message: 'Email is required.')]
    #[Validate('email', message: 'Email must be in a valid format: john.doe@gmail.com')]
    public $email;

    #[Validate('required', message: 'This is required.')]
    public $feedback;

    public function send()
    {
        $this->validate();

        session()->flash('success', 'Message sent!');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.pages.contact')
            ->extends('layouts.app', ['layoutType' => 'user']);
    }
}
