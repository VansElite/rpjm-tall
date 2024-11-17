<?php

use App\Models\Bidang;
use App\Models\Program;
use App\Models\Dusun;
use Livewire\Volt\Component;

new class extends Component {
    public $selectedBidang;
    public $selectedDusun;

    public $bidangs;
    public $dusuns;

    public function mount()
    {
        $this->bidangs = Bidang::all();
        $this->dusuns = Dusun::all();
    }

    public function selectBidang($bidang)
    {
        $this->selectedBidang = $bidang;
        $this->dispatch('filter-updated', [
            'selectedBidang' => $this->selectedBidang,
        ]);
    }

    public function selectDusun($dusun)
    {
        $this->selectedDusun = $dusun;
        $this->dispatch('filter-updated', [
            'selectedDusun' => $this->selectedDusun,
        ]);
    }


}; ?>

<nav class="flex items-center gap-2 p-2 border border-base-300">
    <a href="/" wire:navigate class="mx-4 text-2xl font-bold">RPJM</a>

    <x-dropdown label="Bidang" class="btn-ghost" wire:model="selectedBidang">
        @foreach ($bidangs as $bidang)
        <x-menu-item
            title="{{ $bidang->nama }}"
            wire:click="selectBidang({{ $bidang->id }})"
        />
    @endforeach
    </x-dropdown>
    <x-dropdown label="Dusun" class="btn-ghost" wire:model="selectedDusun">
        @foreach ($dusuns as $dusun)
        <x-menu-item
            title="{{ $dusun->nama }}"
            wire:click="selectDusun({{ $dusun->id }})"
        />
    @endforeach
    </x-dropdown>
    <x-dropdown label="Status" class="btn-ghost" no-x-anchor responsive>
        <x-menu-item title="Selesai" />
        <x-menu-item title="Sedang Berjalan" />
        <x-menu-item title="Direncanakan" />
    </x-dropdown>

    <div id="space" class="flex-grow"></div>

    <details class="dropdown w-fit">
        <summary class="m-1 btn btn-ghost">
            <x-icon name="o-plus" />
            <span>Tambah</span>
        </summary>
        <ul class="menu dropdown-content bg-base-100 rounded-box z-[1] w-full p-2 shadow">
            <li><a wire:navigate href="{{ route('add-bidang') }}">Bidang</a></li>
            <li><a wire:navigate href="{{ route('add-kegiatan') }}">Kegiatan</a></li>
            <li><a wire:navigate href="{{ route('add-laporan') }}">Laporan</a></li>
        </ul>
    </details>

    <details class="dropdown w-fit">
        <summary class="m-1 btn btn-ghost">
            <x-icon name="o-clipboard-document-list" />
            <span>Direktori</span>
        </summary>
        <ul class="menu dropdown-content bg-base-100 rounded-box z-[1] w-full p-2 shadow">
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
