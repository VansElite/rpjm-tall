<?php

use App\Models\Bidang;
use App\Models\Program;
use App\Models\Dusun;
use App\Models\Kegiatan;
use Livewire\Volt\Component;

new class extends Component {

    //init Data dari DB
    public $bidangs;
    public $programs;
    public $kegiatans;
    public $dusuns;

    //init data yang akan di proses
    public $selectedBidang;
    public $users;
    public $statuses = [
        [
            'id' => 1,
            'value' => 'selesai',
            'nama' => 'Selesai',
        ],
        [
            'id' => 2,
            'value' => 'sedangBerjalan',
            'nama' => 'Sedang Berjalan',
        ],
        [
            'id' => 3,
            'value' => 'direncanakan',
            'nama' => 'Direncanakan',
        ],
        [
            'id' => 4,
            'value' => 'ditunda',
            'nama' => 'Ditunda',
        ],
    ];

    public $headers = [
        ['key' => 'id', 'label' => 'No'],
        ['key' => 'nama', 'label' => 'Nama Kegiatan'],
        ['key' => 'status', 'label' => 'Status'],      # <-- nested attributes
        ['key' => 'progres', 'label' => 'Progres'] # <-- this column does not exists
    ];



    public function mount()
    {
        $this->selectedBidang = null;

        $this->bidangs = Bidang::all();

        $this->kegiatans = Kegiatan::all();

        //where('id_bidang')
        $this->programs = Program::all();

        $this->dusuns = Dusun::all();
    }
}; ?>

<div>
    <x-header title="Data RPJM Tirtomulyo" subtitle="Data Rencana Pembangunan Jangka Menengah Tirtomulyo" separator />

    <x-table :headers="$headers" :rows="$kegiatans">
    {{-- Special `actions` slot --}}
        @scope('actions', $kegiatan)
            <x-button icon="o-trash" wire:click="delete({{ $kegiatan->id }})" spinner class="btn-sm" />
        @endscope

    </x-table>

</div>
