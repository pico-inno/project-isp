<?php

namespace App\Livewire\User;

use App\Models\Role;
use App\Models\User;
use App\Traits\HandlesFlashMessages;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class Form extends Component
{
    use HandlesFlashMessages;

    public $roles = [];
    public $name;
    public $email;
    public $role_id;
    public $password;
    public $password_confirmation;
    public $isEdit = false;
    public ?\App\Models\User $user = null;
    public ?int $userId = null;

    public function mount($user = null)
    {
        $this->roles = Role::all();

        if ($user) {
            $this->isEdit = true;
            $this->userId = $user->id;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->role_id = $user->role_id;
        }
    }

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->userId),
            ],
            'password' => [$this->isEdit ? 'nullable' : 'required', 'confirmed', Rules\Password::defaults()],
            'role_id' => ['required', 'exists:roles,id'],
        ];
    }

    public function save()
    {
        $this->validate();

        $userData = [
            'name' => $this->name,
            'email' => $this->email,
            'role_id' => $this->role_id,
        ];

        if ($this->password) {
            $userData['password'] = Hash::make($this->password);
        }

        if ($this->isEdit) {
            User::find($this->userId)->update($userData);
        } else {
            User::create($userData);
        }

        $this->flashSuccess(  $this->isEdit ? 'User updated successfully!' : 'User created successfully!');

        return $this->redirect(route('users.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.user.form');
    }

    public function placeholder()
    {
        return view('components.form-placeholder');
    }
}
