<?php
namespace App\Traits;

trait HandlesFlashMessages
{
    public function flashSuccess(string $message): void
    {
        session()->flash('message', $message);
        session()->flash('message_type', 'success');
    }

    public function flashError(string $message): void
    {
        session()->flash('message', $message);
        session()->flash('message_type', 'error');
    }

    public function flashInfo(string $message): void
    {
        session()->flash('message', $message);
        session()->flash('message_type', 'info');
    }

    public function flashWarning(string $message): void
    {
        session()->flash('message', $message);
        session()->flash('message_type', 'warning');
    }
}
