<?php

use App\Models\Bidang;
use App\Models\Program;
use App\Models\Dusun;
use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<nav class="p-2 flex gap-2 items-center border border-base-300">
    <a href="/" wire:navigate class="mx-4 text-2xl font-bold">RPJM</a>

    <x-dropdown label="Bidang" class="btn-ghost" no-x-anchor responsive>
        <x-menu-item title="Pendidikan" />
        <x-menu-item title="Kesehatan" />
        <x-menu-item title="Pekerjaan Umum & Penataan Ruang" />
        <x-menu-item title="Kawasan Pemukiman" />
        <x-menu-item title="Kehutanan dan Lingkungan Hidup" />
        <x-menu-item title="Perhub dan Infokom" />
        <x-menu-item title="Pariwisata" />
    </x-dropdown>
    <x-dropdown label="Dusun" class="btn-ghost" no-x-anchor responsive>
        <x-menu-item title="Plesan" />
        <x-menu-item title="Paliyan" />
        <x-menu-item title="Karen" />
        <x-menu-item title="Gondangan" />
        <x-menu-item title="Kergan" />
        <x-menu-item title="Bracan" />
        <x-menu-item title="Tokolan" />
    </x-dropdown>
    <x-dropdown label="Status" class="btn-ghost" no-x-anchor responsive>
        <x-menu-item title="Selesai" />
        <x-menu-item title="Sedang Berjalan" />
        <x-menu-item title="Direncanakan" />
    </x-dropdown>

    <div id="space" class="flex-grow"></div>

    <details class="dropdown">
        <summary class="btn btn-ghost m-1">
            <x-icon name="o-plus" />
            <span>Tambah</span>
        </summary>
        <ul class="menu dropdown-content bg-base-100 rounded-box z-[1] w-52 p-2 shadow">
            <li><a wire:navigate href="/form">Program</a></li>
            <li><a wire:navigate href="/form">Kegiatan</a></li>
        </ul>
    </details>

    <x-button label="Dashboard" icon="s-book-open" link="###" class="btn-ghost" responsive />

    <x-button label="User Management" icon="o-user-group" link="###" class="btn-ghost" responsive />

    <button data-toggle-theme="dark,light" class="mr-2">
        <x-icon name="o-moon" />
    </button>

    <x-dropdown>
        <x-slot:trigger>
            <x-button label="Guest" icon="o-user" class="btn-outline" responsive />
        </x-slot:trigger>
        <x-menu-item title="log in" icon="o-arrow-left-end-on-rectangle" />
        <x-menu-item title="log out" icon="o-arrow-right-start-on-rectangle" />
    </x-dropdown>
</nav>
