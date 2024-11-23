<?php

use App\Models\Bidang;
use App\Models\Program;
use App\Models\Dusun;
use Livewire\Volt\Component;
use Livewire\Attributes\Computed;

new class extends Component {
    public $selectedBidang;
    public $selectedStatus;
    public $selectedDusun;
    public $selectedYear;

    public $bidangs;
    public $statuses;
    public $dusuns;

    public $showFilter;

    #[Computed]
    public function isAdmin() {
        if (!auth()->user()) {
            return;
        }
        $role = auth()->user()->role->name;
        return $role === 'Admin';
    }

    #[Computed]
    public function isOfficer() {
        if (!auth()->user()) {
            return;
        }
        $role = auth()->user()->role->name;
        return $role === 'Petugas' || $role === 'Admin';
    }

    public function mount()
    {
        $this->bidangs = Bidang::all();
        $this->dusuns = Dusun::all();

        $currentRouteName = Route::currentRouteName();
        $allowedRoutes = [
            'index',
            'add-kegiatan',
            'edit-kegiatan',
            'direktori-kegiatan',
            'add-laporan',
            'edit-laporan',
            'direktori-laporan',
        ];
        $this->showFilter = in_array($currentRouteName, $allowedRoutes);
    }

    public function selectBidang($bidang)
    {
        $this->selectedBidang = $bidang;
        $this->selectedDusun = null; //reset dusun
        $this->selectedStatus = null; //reset status
        $this->selectedYear = null; //reset status
        $this->dispatch('filter-updated', [
            'selectedBidang' => $this->selectedBidang,
            'selectedDusun' => $this->selectedDusun,
            'selectedStatus' => $this->selectedStatus,
            'selectedYear' => $this->selectedYear,
        ]);
    }

    public function selectDusun($dusun)
    {
        $this->selectedDusun = $dusun;
        $this->selectedStatus = null; //reset status
        $this->selectedYear = null; //reset status
        $this->dispatch('filter-updated', [
            'selectedBidang' => $this->selectedBidang,
            'selectedDusun' => $this->selectedDusun,
            'selectedStatus' => $this->selectedStatus,
            'selectedYear' => $this->selectedYear,
        ]);
    }

    public function selectStatus($status)
    {
        $this->selectedStatus = $status;
        $this->selectedYear = null; //reset status
        $this->dispatch('filter-updated', [
            'selectedBidang' => $this->selectedBidang,
            'selectedDusun' => $this->selectedDusun,
            'selectedStatus' => $this->selectedStatus,
            'selectedYear' => $this->selectedYear,
        ]);
    }

    public function selectYear($year)
    {
        $this->selectedYear = $year;
        $this->dispatch('filter-updated', [
            'selectedBidang' => $this->selectedBidang,
            'selectedDusun' => $this->selectedDusun,
            'selectedStatus' => $this->selectedStatus,
            'selectedYear' => $this->selectedYear,
        ]);
    }


}; ?>

<nav class="flex items-center gap-2 p-2 border border-base-300">
    <a href="/" wire:navigate class="mx-4 text-2xl font-bold">RPJM</a>

    @if($showFilter)
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
    <x-dropdown label="Status" class="btn-ghost" wire:model="selectedStatus" no-x-anchor responsive>
        <x-menu-item wire:click="selectStatus('selesai')" title="Selesai" />
        <x-menu-item wire:click="selectStatus('sedangBerjalan')" title="Sedang Berjalan" />
        <x-menu-item wire:click="selectStatus('direncanakan')" title="Direncanakan" />
    </x-dropdown>
    <x-dropdown label="Tahun" class="btn-ghost" wire:model="selectedYear" no-x-anchor responsive>
        <x-menu-item wire:click="selectYear('1')" title="Tahun 1" />
        <x-menu-item wire:click="selectYear('2')" title="Tahun 2" />
        <x-menu-item wire:click="selectYear('3')" title="Tahun 3" />
        <x-menu-item wire:click="selectYear('4')" title="Tahun 4" />
        <x-menu-item wire:click="selectYear('5')" title="Tahun 5" />
        <x-menu-item wire:click="selectYear('6')" title="Tahun 6" />
    </x-dropdown>
    @endif


    <div id="space" class="flex-grow"></div>

    @auth
    <details class="dropdown w-fit">
        <summary class="m-1 btn btn-ghost">
            <x-icon name="o-plus" />
            <span>Tambah</span>
        </summary>
        <ul class="menu dropdown-content bg-base-100 rounded-box z-[1] w-full p-2 shadow">
            @if($this->isAdmin)
                <li><a wire:navigate href="{{ route('add-bidang') }}">Bidang</a></li>
                <li><a wire:navigate href="{{ route('add-kegiatan') }}">Kegiatan</a></li>
            @endif
            @if($this->isOfficer)
            <li><a wire:navigate href="{{ route('add-laporan') }}">Laporan</a></li>
            @endif
        </ul>
    </details>

    <details class="dropdown w-fit">
        <summary class="m-1 btn btn-ghost">
            <x-icon name="o-clipboard-document-list" />
            <span>Direktori</span>
        </summary>
        <ul class="menu dropdown-content bg-base-100 rounded-box z-[1] w-full p-2 shadow">
            @if($this->isAdmin)
            <li><a wire:navigate href="#">Users</a></li>
            <li><a wire:navigate href="{{ route('direktori-bidang') }}">Bidang</a></li>
            <li><a wire:navigate href="{{ route('direktori-program') }}">Program</a></li>
            <li><a wire:navigate href="{{ route('direktori-kegiatan') }}">Kegiatan</a></li>
            @endif
            @if($this->isOfficer)
            <li><a wire:navigate href="{{ route('direktori-laporan') }}">Laporan</a></li>
            @endif
        </ul>
    </details>
    @endauth

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
