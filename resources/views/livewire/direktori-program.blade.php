<?php

use App\Models\Program;
use Livewire\WithPagination;
use Livewire\Volt\Component;
use App\Models\Bidang;

new class extends Component {
    use WithPagination;

    public array $activeFilters = []; //properti untuk menyimpan filter yang aktif
    public $selectedBidang;

    protected $listeners = [
        'filter-updated' => 'applyFilter'
    ];

    public function applyFilter($filters)
    {
        $this->selectedBidang = $filters['selectedBidang'] ?? null;

        // Perbarui activeFilters
        $this->activeFilters = [];

        if ($this->selectedBidang) {
            $bidangName = Bidang::find($this->selectedBidang)->nama ?? 'Unknown';
            $this->activeFilters[] = "Bidang: {$bidangName}";
        }

        $this->resetPage();
    }

    public function removeFilter($filterString)
    {
        [$type, $value] = explode(': ', $filterString);

        if ($type === 'Bidang') {
            $this->selectedBidang = null;
        }

        $this->activeFilters = array_filter($this->activeFilters, fn($filter) => $filter !== $filterString);

        $this->resetPage();
    }

    public $headers = [
        ['key' => 'id', 'label' => 'No', 'class' => 'w-1'],
        ['key' => 'nama', 'label' => 'Nama Program'],
        ['key' => 'cangkupan_program', 'label' => 'Cangkupan Program'],
    ];



    public function render(): mixed
    {
        $query = Program::with('bidang');

        // Filter berdasarkan Bidang
        if ($this->selectedBidang) {
            $query->whereHas('bidang', function ($q) {
                $q->where('id', $this->selectedBidang);
            });
        }

        $programs = $query->paginate(10); // Menggunakan paginate

        return view('livewire.direktori-program', [
            'programs' => $programs,
        ]);
    }
    // public function updatedperPage($pageValue)
    // {
    //     $this->programs=Program::paginate($this->$pageValue)->get();
    // }

    public function edit($id)
    {
        return to_route('edit-program', $id);
    }

    public function delete($id)
    {
        Program::destroy($id);
        return to_route('direktori-program');
    }
}; ?>

<div>
    <x-card title="Data Program RPJM Tirtomulyo" class="flex mx-3 my-3 bg-base-200 rounded-xl" subtitle="Data Rencana Pembangunan Jangka Menengah Tirtomulyo"
        separator>
        <div class="flex items-center mb-5">
            <div class="flex flex-wrap gap-2">
                @foreach ($activeFilters as $filter)
                    <span class="inline-flex items-center px-3 py-1 text-sm text-blue-800 bg-blue-100 rounded-full">
                        {{ $filter }}
                        <button
                            wire:click="removeFilter('{{ $filter }}')"
                            class="ml-2 text-red-500 hover:text-red-700"
                        >
                            &times;
                        </button>
                    </span>
                @endforeach
            </div>
        </div>
        <x-table :headers="$headers" :rows="$programs" with-pagination>
            {{-- Special `actions` slot --}}
            @scope('actions', $program)
            <div class="flex gap-2">
                {{-- <x-button icon="o-folder-open" wire:click="#" spinner class="btn-sm" /> --}}
                <x-button icon="o-pencil-square" wire:click="edit({{ $program->id }})" spinner class="btn-sm" />
                <x-button icon="o-trash" wire:click="delete({{ $program->id }})" spinner class="btn-sm" />
            </div>
            @endscope
        </x-table>
    </x-card>
</div>
