<?php

namespace App\Livewire\Role;

use App\Models\Role;
use App\Models\User;
use App\Traits\HandlesFlashMessages;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use function Pest\Laravel\delete;

class Index extends Component
{
    use WithPagination, HandlesFlashMessages;

    public $search = '';

    public function createRole(){
        return redirect()->route('role-permissions.create');
    }

    public function editRole($roleId){
        return redirect()->route('role-permissions.edit', $roleId);
    }
    public function deleteRole($roleId)
    {
        if (!auth()->user()->hasPermissionTo('delete', 'Role')) {
            $this->flashInfo('You are not authorized to delete role.');
        } else {
            try {
                $role = Role::findOrFail($roleId);

                if ($role->users()->exists()) {
                    $this->flashWarning('Cannot delete role: It is currently assigned to one or more users.');
                    return;
                }

                DB::transaction(function () use ($role) {
                    $role->permissions()->detach();
                    $role->delete();
                });

                $this->flashSuccess('Role deleted successfully.');
            } catch (ModelNotFoundException $e) {
                $this->flashError('Role not found.');
            } catch (\Exception $e) {
                $this->flashError('Error deleting role: ' . $e->getMessage());
            }
        }
    }

    public function render()
    {
        $roles = Role::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        return view('livewire.role.index', compact('roles'));
    }
}
