<?php
use App\Models\Laporan;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public $headers = [
        ['key' => 'id', 'label' => 'No'],
        ['key' => 'judul', 'label' => 'Judul Laporan'],
        ['key' => 'progres', 'label' => 'Progres Laporan'],
        ['key' => 'deskripsi', 'label' => 'Deskripsi'], // Masih ada kekurangan, progres ambil dari laporan
    ];

    public function render(): mixed
    {
        return view('livewire.direktori-laporan', [
            'laporans' => Laporan::paginate(10), // Menggunakan paginate
        ]);
    }

    public function edit($id)
    {
        return to_route('edit-laporan', $id);
    }

    public function delete($id)
    {
        Laporan::destroy($id);
        return to_route('direktori-laporan');
    }
}; ?>

<div>
    <x-card title="Data Laporan RPJM Tirtomulyo" class="flex mx-3 my-3 bg-base-200 rounded-xl" subtitle="Data Rencana Pembangunan Jangka Menengah Tirtomulyo" separator>
        <x-table :headers="$headers" :rows="$laporans" with-pagination>
            {{-- Special `actions` slot --}}
                @scope('actions', $laporan)
                <div class="flex gap-2">
                    {{-- <x-button icon="o-folder-open" wire:click="#" spinner class="btn-sm" /> --}}
                    <x-button icon="o-pencil-square" wire:click="edit({{ $laporan->id }})" spinner class="btn-sm" />
                    <x-button icon="o-trash" wire:click="delete({{ $laporan->id }})" spinner class="btn-sm" />
                </div>
                @endscope
            </x-table>
            <div class="mt-4">
                {{ $laporans->links('pagination::tailwind') }}
            </div>
    </x-card>
</div>
