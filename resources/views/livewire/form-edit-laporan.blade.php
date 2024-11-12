<?php

use App\Models\Laporan;
use Livewire\Volt\Component;

new class extends Component {
    public Laporan $laporan;
    public $nama;

    public function update()
    {
        Laporan::update([
            // Isi dengan data yang akan diupdate
            'id_kegiatan' => $this->selectedKegiatan,
        'judul' => $this->judul,
        'progres' => $this->progres,
        'deskripsi' => $this->deskripsi,
        ]);

        session()->flash('message', 'Data laporan berhasil diupdate.');
        // Kembali ke halaman daftar kegiatan atau halaman lain yang sesuai
        return redirect()->route('direktori-laporan');
    }
}; ?>

<div>
    <x-card title="Edit laporan {{ $laporan->judul }}" class="flex mx-3 my-3 bg-base-200 rounded-xl" separator>
        <x-form wire:submit.prevent="update" class="m-4">
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
