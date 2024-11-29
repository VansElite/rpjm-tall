<?php

use App\Models\Bidang;
use App\Models\Program;
use App\Models\Kegiatan;
use App\Models\Laporan;
use Livewire\Volt\Component;

new class extends Component {
    //init Data
    public Laporan $laporan;
    public $kegiatan;

    //init Opsi x-select
    public $bidangs;
    public $programs;
    public $kegiatans;

    //init val default x-select
    public $tempBidangs;
    public $tempPrograms;
    public $tempKegiatans;

    //init value x-select
    public $selectedBidang;
    public $selectedProgram;

    //init input data
    public $selectedKegiatan;
    public $judul;
    public $progres;
    public $deskripsi;

    public function mount()
    {
        //menambah data ke array pertama pada opsi x-select
        $this->tempBidangs = [
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
        $this->bidangs = [$this->tempBidangs, ...Bidang::all()->toArray()];
        $this->programs = [$this->tempPrograms, ...Program::all()->toArray()];
        $this->kegiatans = [$this->tempKegiatans, ...Kegiatan::all()->toArray()];

        // data untuk init value model x-select
        $this->selectedBidang = $this->laporan->kegiatan->program->id_bidang;
        $this->selectedProgram = $this->laporan->kegiatan->id_program;

        // Isi nilai properti component dengan data laporan
        $this->selectedKegiatan = $this->laporan->kegiatan->id;
        $this->judul = $this->laporan->judul;
        $this->progres = $this->laporan->progres;
        $this->deskripsi = $this->laporan->deskripsi;
    }

    public function mounted()
    {
        $this->updateSelectedBidang($this->selectedBidang);
        $this->updateSelectedProgram($this->selectedProgram);
    }

    public function updatedSelectedBidang($bidangId)
    {
        // Filter data berdasarkan bidang yang dipilih
        $this->programs = [$this->tempPrograms, ...Program::where('id_bidang', $bidangId)->get()];
    }

    //Update Selected Program
    public function updatedSelectedProgram($programId)
    {
        // Filter data berdasarkan Program yang dipilih
        $this->kegiatans = [$this->tempKegiatans, ...Kegiatan::where('id_program', $programId)->get()];
    }

    public function cancle()
    {
        return redirect()->route('direktori-laporan');
    }

    public function save()
    {
        $this->laporan->update([
            'id_kegiatan' => $this->selectedKegiatan,
            'judul' => $this->judul,
            'progres' => $this->progres,
            'deskripsi' => $this->deskripsi,
        ]);

        // dd('hehe');
        $this->progres = (int)$this->progres;
        if ($this->progres === 0) {
            $this->kegiatan = Kegiatan::find($this->selectedKegiatan);
            $this->kegiatan->update([
                'status' => 'direncanakan',
            ]);
            $this->kegiatan->save();
        } elseif ($this->progres === 100) {
            $this->kegiatan = Kegiatan::find($this->selectedKegiatan);
            $this->kegiatan->update([
                'status' => 'selesai',
            ]);
            $this->kegiatan->save();
        } else {
            $this->kegiatan = Kegiatan::find($this->selectedKegiatan);
            if ($this->kegiatan->status !== 'sedangBerjalan') {
                $this->kegiatan->update([
                    'status' => 'sedangBerjalan',
                ]);
                $this->kegiatan->save();
            }
        }

        session()->flash('message', 'Data laporan berhasil diupdate.');
        // Kembali ke halaman daftar kegiatan atau halaman lain yang sesuai
        return redirect()->route('direktori-laporan');
    }
}; ?>

<div>
    <x-card title="Edit laporan {{ $laporan->judul }}" class="flex mx-3 my-3 bg-base-200 rounded-xl" separator>
        <x-form wire:submit.prevent="save" class="m-4">
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <x-select label="Bidang" :options="$bidangs" option-value="id" option-label="nama"
                        wire:model.live="selectedBidang" />
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
                    <x-range wire:model.live.debounce="progres" min="0" max="100" step="5" label="Progres Kegiatan" class="range-accent" />
                    <p>Progres: {{ $progres }}</p>
                </div>
            </div>

            <x-textarea label="Detail Laporan" wire:model="deskripsi" placeholder="Tuliskan Deskripsi Laporan ..."
                hint="Max 1000 chars" rows="5" inline />

            <x-slot:actions>
                <x-button label="Cancel" wire:click="cancle" />
                <x-button label="Simpan" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>
