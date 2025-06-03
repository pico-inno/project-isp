<?php

namespace App\Livewire\Role;

use App\Models\Feature;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Traits\HandlesFlashMessages;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Form extends Component
{
    use HandlesFlashMessages;

    public $isEdit = false;
    public $role_name = '';
    public $selected_permissions = [];

    public ?\App\Models\Role $role = null;
    public ?int $roleId = null;

    protected function rules()
    {
        return [
            'role_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')->ignore($this->roleId),
            ],
            'selected_permissions' => 'sometimes|array',
        ];
    }

    public function mount($role = null)
    {
        if ($role) {
            $this->isEdit = true;
            $this->roleId = $role->id;
            $this->role_name = $role->name;
            $this->selected_permissions = $role->permissions()->pluck('permissions.id')->toArray();
        }
    }

    public function save()
    {
        $this->validate();
        try {
            DB::beginTransaction();

            if ($this->isEdit) {
                $role = Role::findOrFail($this->roleId);
                $role->update([
                    'name' => $this->role_name,
                ]);
            } else {
                $role = Role::create([
                    'name' => $this->role_name,
                ]);
            }

            if (!empty($this->selected_permissions)) {
                $role->permissions()->sync($this->selected_permissions);
            }

            DB::commit();

            $this->flashSuccess($this->isEdit ? 'Role updated successfully!' : 'Role created successfully!');
            return $this->redirect(route('role-permissions.index'), navigate: true);

        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            $this->flashError('Role not found.');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->flashError('Error saving role: ' . $e->getMessage());
        }
    }


    public function render()
    {
        $featuresWithPermissions = Feature::with('permissions')->get();
        return view('livewire.role.form', [
            'fPermissions' => $featuresWithPermissions
        ]);
    }
}
