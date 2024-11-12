<?php
use App\Models\Bidang;
use Livewire\Volt\Component;

new class extends Component {
    public Bidang $bidang;
    public $nama;

    public function mount()
    {
        $this->nama = $this->bidang->nama;
    }

    public function update()
    {
        $this->bidang->update([
            // Isi dengan data yang akan diupdate
            'nama' => $this->nama,
        ]);

        session()->flash('message', 'Data Bidang berhasil diupdate.');
        // Kembali ke halaman daftar kegiatan atau halaman lain yang sesuai
        return redirect()->route('direktori-bidang');
    }

}; ?>

<div>
    <x-card title="Edit Bidang {{ $bidang->nama }}" class="flex mx-3 my-3 bg-base-200 rounded-xl" separator>
        <x-form wire:submit.prevent="update" class="m-4">
            <x-input label="Nama Bidang" placeholder="{{ $bidang->nama }}" wire:model="nama"/>
            <x-slot:actions>
                <x-button label="Simpan" type="submit" class="btn-primary" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>
