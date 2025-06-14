<?php

namespace App\Livewire\Report;

use App\Models\RadAcct;
use Livewire\Component;
use Livewire\WithPagination;

class RadiusLog extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'acctstarttime';
    public $sortDirection = 'desc';
    public $statusFilter = 'all';

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage',
        'sortField',
        'sortDirection',
        'statusFilter'
    ];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'desc';
        }

        $this->sortField = $field;
    }

    public function render()
    {
        $logs = RadAcct::query()
            ->when($this->search, function ($query) {
                $query->where('username', 'like', '%'.$this->search.'%')
                    ->orWhere('nasipaddress', 'like', '%'.$this->search.'%');
            })
            ->when($this->statusFilter !== 'all', function ($query) {
                if ($this->statusFilter === 'completed') {
                    $query->whereNotNull('acctstoptime');
                } elseif ($this->statusFilter === 'active') {
                    // "Active" sessions are those with a NULL acctstoptime
                    $query->whereNull('acctstoptime');
                } elseif ($this->statusFilter === 'abnormal_termination') {
                    // "Abnormal termination" could be non-NULL acctstoptime but with specific error causes
                    $query->whereNotNull('acctstoptime')
                        ->whereNotIn('acctterminatecause', ['User-Request', 'Session-Timeout', 'Idle-Timeout']);
                }
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
        return view('livewire.report.radius-log', [
            'logs' => $logs
        ]);
    }
}
