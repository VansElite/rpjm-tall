<?php

use App\Models\Program;
use Livewire\WithPagination;
use Livewire\Volt\Component;

new class extends Component {
    use WithPagination;
    public $programs;
    public $perPage = 3;

    public $headers = [
        ['key' => 'id', 'label' => 'No', 'class' => 'w-1'],
        ['key' => 'nama', 'label' => 'Nama Program'],
        ['key' => 'cangkupan_program', 'label' => 'Cangkupan Program'],
    ];

    public function mount()
    {
        $this->programs = Program::all();
    }

    public function delete($id)
    {
        Program::destroy($id);
        return to_route('direktori-program');
    }
}; ?>

<div>
    <x-card title="Data Program RPJM Tirtomulyo" subtitle="Data Rencana Pembangunan Jangka Menengah Tirtomulyo"
        separator>
        <x-table :headers="$headers" :rows="$programs" with-pagination>
            {{-- Special `actions` slot --}}
            @scope('actions', $program)
            <div class="flex gap-2">
                <x-button icon="o-folder-open" wire:click="#" spinner class="btn-sm" />
                <x-button icon="o-pencil-square" wire:click="#" spinner class="btn-sm" />
                <x-button icon="o-trash" wire:click="delete({{ $program->id }})" spinner class="btn-sm" />
            </div>
            @endscope
        </x-table>
    </x-card>
</div>
