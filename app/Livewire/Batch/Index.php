<?php

namespace App\Livewire\Batch;

use App\Models\Batch;
use App\Models\RadUserGroup;
use App\Traits\HandlesFlashMessages;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, HandlesFlashMessages;

    public string $search = '';

    protected $queryString = ['search'];

    public function deleteAccount(int $batchId)
    {
        try {
            DB::transaction(function () use ($batchId) {

                $batch = Batch::with('radcheckAccounts.radusergroup', 'radcheckAccounts.radreply')
                    ->findOrFail($batchId);

                foreach ($batch->radcheckAccounts as $account) {

                    RadUserGroup::where('username', $account->username)->delete();

                    if ($account->radusergroup) {
                        $account->radusergroup->delete();
                    }


                    if ($account->radreply) {
                        $account->radreply->delete();
                    }


                    $account->delete();
                }

                $batch->delete();
            });

            $this->flashSuccess('Batch and all related accounts deleted successfully.');

        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Failed to delete batch: ' . $e->getMessage()
            ]);
        }
    }

    public function render()
    {
        $batches = Batch::query()
            ->withCount('radcheckAccounts')
            ->when($this->search, fn($q) => $q->where('batch_name', 'like', "%{$this->search}%"))
            ->latest()
            ->paginate(10);

        return view('livewire.batch.index', compact('batches'));
    }
}
