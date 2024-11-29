<?php

use App\Models\Bidang;
use App\Models\Program;
use App\Models\Kegiatan;
use App\Models\Laporan;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component {
    public $bidangs;
    public ?int $selectedBidang;
    public $programs;
    public ?int $selectedProgram;
    public $kegiatans;

    public $tempBidangs;
    public $tempPrograms;
    public $tempKegiatans;
    public $kegiatan;

    public $selectedKegiatan;
    public $selectedProgres;
    #[Validate('required', message: 'Jangan Kosongkan Judul Laporan')]
    public $judul;
    #[Validate('required', message: 'Berikan Persentase Progress Minimal 5%')]
    public int $progres = 0;
    #[Validate('required', message: 'Jangan Kosongkan Deskripsi Laporan')]
    public $deskripsi;

    protected $queryString = [
        'selectedBidang' => ['except' => null],
        'selectedProgram' => ['except' => null],
        'selectedKegiatan' => ['except' => null],
        'progres' => ['except' => null],
    ];

    public function mount(){

        //menambah data ke array pertama pada opsi x-select
        $this->tempBidangs =  [
            'id' => null,
            'value' => null,
            'nama' => '-- Pilih Bidang --',
        ];
        $this->tempPrograms = [
            'id' => null,
            'value' => null,
            'nama' => '-- Pilih Program --',
        ];
        $this->tempKegiatans = [
            'id' => null,
            'value' => null,
            'nama' => '-- Pilih Kegiatan --',
        ];

        //init untuk Opsi x-select
        $this->bidangs = [$this->tempBidangs,
            ...Bidang::all()->toArray()
        ];
        $this->programs = [$this->tempPrograms,
            ...Program::all()->toArray()
        ];
        $this->kegiatans = [$this->tempKegiatans,
            ...Kegiatan::all()->toArray()
        ];
    }

    //Update Selected Bidang
    public function updatedSelectedBidang($bidangId)
    {
        // Filter data berdasarkan bidang yang dipilih
        $this->programs = [$this->tempPrograms,
            ...Program::where('id_bidang', $bidangId)->get()->toArray()
        ];
    }

    //Update Selected Program
    public function updatedSelectedProgram($programId)
    {
        // Filter data berdasarkan Program yang dipilih
        $this->kegiatans = [$this->tempKegiatans,
            ...Kegiatan::where('id_program', $programId)->get()];
    }


    // Update Selected Program
    public function updatedProgres($valProgres)
    {
        // Filter data berdasarkan Program yang dipilih
        // dd($valProgres);
        $this->progres = $valProgres;
    }

    public function store()
    {
        $this->kegiatan = Kegiatan::find($this->selectedKegiatan);

        $validated = $this->validate();

        Laporan::create([
        'id_kegiatan' => $this->selectedKegiatan,
        'judul' => $this->judul,
        'progres' => $this->progres,
        'deskripsi' => $this->deskripsi,
    ]);
    if ($this->progres === 0) {
        $this->kegiatan->update([
            'status' => 'direncanakan',
        ]);
        $this->kegiatan->save();
    }elseif ($this->progres === 100) {
        $this->kegiatan->update([
            'status' => 'selesai',
        ]);
        $this->kegiatan->save();
    }else {
            if ($this->kegiatan->status !== 'sedangBerjalan') {
            $this->kegiatan->update([
                'status' => 'sedangBerjalan',
            ]);
            $this->kegiatan->save();
        }
    };

    session()->flash('message', 'Data berhasil disimpan.');
    return redirect()->route('direktori-laporan');
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
                <x-input label="Judul Laporan" placeholder="Masukkan Judul Laporan" wire:model="judul" />
            </div>
            <div>
                <x-range wire:model.live.debounce="progres" min="0" max="100" step="5" label="Progres Kegiatan" class="range-accent" />
                <p>Progres: {{ $progres }}</p>
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
