<?php

use Livewire\Volt\Component;

new class extends Component {
    public bool $bidang = false;
    public bool $program = false;
    public bool $kegiatan = false;
    public bool $laporan = false;
}; ?>

<details class="dropdown">
    <summary class="btn btn-ghost m-1">
        <x-icon name="o-plus" />
        <span>Tambah</span>
    </summary>
    <ul class="menu dropdown-content bg-base-100 rounded-box z-[1] w-52 p-2 shadow">
        <li><a wire:navigate @click="$wire.bidang = true">Bidang</a></li>
        <li><a wire:navigate @click="$wire.program = true">Program</a></li>
        <li><a wire:navigate @click="$wire.kegiatan = true">Kegiatan</a></li>
        <li><a wire:navigate @click="$wire.laporan = true">Laporan</a></li>
    </ul>

    <x-modal wire:model="bidang" title="Tambah Bidang" subtitle="Masukkan nama bidang" separator>
        <x-input label="Nama Bidang" />

        <x-slot:actions>
            <x-button label="Cancel" @click="$wire.bidang = false" />
            <x-button label="Confirm" class="btn-primary" />
        </x-slot:actions>
    </x-modal>

    <x-modal wire:model="program" title="Tambah Program" subtitle="Masukkan nama program" separator>
        <x-input label="Nama Program" />

        <x-slot:actions>
            <x-button label="Cancel" @click="$wire.program = false" />
            <x-button label="Confirm" class="btn-primary" />
        </x-slot:actions>
    </x-modal>

    <x-modal wire:model="kegiatan" title="Tambah Kegiatan" subtitle="Masukkan nama kegiatan" separator>
        <x-input label="Nama Kegiatan" />

        <x-slot:actions>
            <x-button label="Cancel" @click="$wire.kegiatan = false" />
            <x-button label="Confirm" class="btn-primary" />
        </x-slot:actions>
    </x-modal>

    <x-modal wire:model="laporan" title="Tambah Laporan" subtitle="Masukkan nama laporan" separator>
        <x-input label="Nama Laporan" />

        <x-slot:actions>
            <x-button label="Cancel" @click="$wire.laporan = false" />
            <x-button label="Confirm" class="btn-primary" />
        </x-slot:actions>
    </x-modal>

</details>
