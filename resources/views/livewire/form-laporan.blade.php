<?php

use App\Models\Bidang;
use App\Models\Program;
use App\Models\Kegiatan;
use App\Models\Laporan;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component {
    public $bidangs;
    public $selectedBidang;
    public $programs;
    public $selectedProgram;
    public $kegiatans;
     #[Validate('required', message: 'Tolong Pilih Salah Satu Kegiatan')]
    public $selectedKegiatan;
    #[Validate('required', message: 'Jangan Kosongkan Judul Laporan')]
    public $judul;
    #[Validate('required', message: 'Berikan Persentase Progress Minimal 5%')]
    public int $progres = 30;
    #[Validate('required', message: 'Jangan Kosongkan Deskripsi Laporan')]
    public $deskripsi;

    public function mount(){
        $this->selectedBidang = null;
        $this->bidangs = Bidang::all();
        $this->selectedProgram = null;
        $this->programs = Program::all();
        $this->kegiatans = Kegiatan::all();
    }

    //Update Selected Bidang
    public function updatedSelectedBidang($bidangId)
    {
        // Filter data berdasarkan bidang yang dipilih
        $this->programs = Program::where('id_bidang', $bidangId)->get();
    }

    //Update Selected Program
    public function updatedSelectedProgram($programId)
    {
        // Filter data berdasarkan Program yang dipilih
        $this->kegiatans = Kegiatan::where('id_program', $programId)->get();
    }

    public function store()
    {
        $validated = $this->validate();

        Laporan::create([
        'id_kegiatan' => $this->selectedKegiatan,
        'judul' => $this->judul,
        'progres' => $this->progres,
        'deskripsi' => $this->deskripsi,
    ]);

    session()->flash('message', 'Data berhasil disimpan.');
    }
}; ?>

<div>
<x-card title="Form Tambah Laporan Kegiatan" class="flex mx-3 my-3 bg-base-200 rounded-xl">
    <x-form wire:submit.prevent="store">
        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <x-select label="Bidang" :options="$bidangs" option-value="id" option-label="nama" wire:model.live="selectedBidang" />
            </div>
            <div>
                <x-select label="Program" :options="$programs" option-value="id" option-label="nama"
                    wire:model.live="selectedProgram" />
            </div>
        </div>
        <x-select label="Kegiatan" :options="$kegiatans" option-value="id" option-label="nama"
            wire:model.live="selectedKegiatan" />
        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <x-input label="Judul Laporan" wire:model="judul" />
            </div>
            <div>
                <x-range wire:model.live.debounce="progres" min="5" max="100" step="5" label="Progres Kegiatan"
                    hint="Greater than 30." class="range-accent" />
            </div>
        </div>

        <x-textarea label="Detail Laporan" wire:model="deskripsi" placeholder="Tuliskan Deskripsi Laporan ..."
            hint="Max 1000 chars" rows="5" inline />

        <x-slot:actions>
            <x-button label="Cancel" />
            <x-button label="Simpan" class="btn-primary" type="submit" spinner="save" />
        </x-slot:actions>
    </x-form>
</x-card>

</div>
