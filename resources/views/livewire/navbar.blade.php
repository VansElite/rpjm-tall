<?php

use App\Models\Bidang;
use App\Models\Program;
use App\Models\Dusun;
use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<nav class="flex items-center gap-2 p-2 border border-base-300">
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
        <summary class="m-1 btn btn-ghost">
            <x-icon name="o-plus" />
            <span>Tambah</span>
        </summary>
        <ul class="menu dropdown-content bg-base-100 rounded-box z-[1] w-52 p-2 shadow">
            <li><a wire:navigate href="{{ route('add-bidang') }}">Bidang</a></li>
            <li><a wire:navigate href="/kegiatan/add">Kegiatan</a></li>
            <li><a wire:navigate href="/laporan/add">Laporan</a></li>
        </ul>
    </details>

    <details class="dropdown">
        <summary class="m-1 btn btn-ghost">
            <x-icon name="o-clipboard-document-list" />
            <span>Direktori</span>
        </summary>
        <ul class="menu dropdown-content bg-base-100 rounded-box z-[1] w-52 p-2 shadow">
            <li><a wire:navigate href="{{ route('direktori-bidang') }}">Bidang</a></li>
            <li><a wire:navigate href="{{ route('direktori-program') }}">Program</a></li>
            <li><a wire:navigate href="{{ route('direktori-kegiatan') }}">Kegiatan</a></li>
            <li><a wire:navigate href="{{ route('direktori-laporan') }}">Laporan</a></li>
            <li><a wire:navigate href="#">Users</a></li>
        </ul>
    </details>

    <x-theme-toggle />

    @guest
        <x-button label="Login" link="/login" icon="o-user" class="btn-outline" />
    @endguest

    @auth
        <x-dropdown>
            <x-slot:trigger>
                <x-button icon="o-user" class="btn-outline">
                    <div class="text-left">
                        <p class="font-bold">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-400">{{ auth()->user()->role->name }}</p>
                    </div>
                </x-button>
            </x-slot:trigger>
            <x-menu-item title="Logout" link="/logout" icon="o-arrow-right-start-on-rectangle" />
        </x-dropdown>
    @endauth
</nav>
