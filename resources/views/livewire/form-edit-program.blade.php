<?php

use App\Models\Program;
use App\Models\Bidang;
use Livewire\Volt\Component;

new class extends Component {
    public Program $program;

    public $bidangs;
    public $tempId;

    //init variable program
    public $nama;
    public $selectedBidang;
    public $cangkupan;

    public function mount()
    {
        $this->bidangs = Bidang::all();
        $this->tempId = $this->program->id_bidang;
    }

    public function holderBidang($id)
    {

    }

    public function update()
    {
        Program::update([
            // Isi dengan data yang akan diupdate
            'nama' => $this->nama,
            'id_bidang' => $this->selectedBidang,
            'cangkupan_program' => $this->cangkupan,
        ]);

        session()->flash('message', 'Data Bidang berhasil diupdate.');
        // Kembali ke halaman daftar kegiatan atau halaman lain yang sesuai
        return redirect()->route('direktori-program');
    }
}; ?>

<div>
    <x-card title="Edit Program {{ $program->nama }}" class="flex mx-3 my-3 bg-base-200 rounded-xl" separator>
        <x-form wire:submit.prevent="update" class="m-4">
            <div class="grid grid-rows-2 gap-1">
                <div class="grid row-span-1 gap-4 md:grid-cols-10">
                    <div class="col-span-5">
                        <x-input label="Nama Program" placeholder="{{ $program->nama }}" wire:model="nama" />
                    </div>
                    <div class="col-span-5">
                        {{-- Masih ada Bug Selected Bidang --}}
                        <x-select label="Pilih Bidang" :options="$bidangs" option-value="id" option-label="nama" placeholder="{{ dd($program->id_bidang) }}"
                            wire:model.live="selectedBidang" />
                    </div>
                </div>
                <div class="grid row-span-1 gap-4 md:grid-cols-10">
                    <div class="col-span-8">
                        <x-input label="Cangkupan Program" wire:model="cangkupan" placeholder="{{ $program->cangkupan_program }}" />
                    </div>
                    <div class="justify-center col-span-2 mx-5 pt-7 ">
                        <x-slot:actions>
                            <x-button label="Simpan" type="submit" class="btn-primary" />
                        </x-slot:actions>
                    </div>
                </div>
            </div>
        </x-form>
    </x-card>
</div>