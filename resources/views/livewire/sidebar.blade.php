<?php

use Livewire\Volt\Component;

new class extends Component {
  public $selectedTab = 'users';
}; ?>

<div>
    <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-200">

        {{-- User --}}
        @if ($user = auth()->user())
            <x-list-item :item="$user" value="name" sub-value="email" no-separator no-hover class="pt-2">
                <x-slot:actions>
                    <x-button icon="o-power" class="btn-circle btn-ghost btn-xs" tooltip-left="logoff" no-wire-navigate
                        link="/logout" />
                </x-slot:actions>
            </x-list-item>

            <x-menu-separator />
        @endif


        {{-- Activates the menu item when a route matches the `link` property --}}
        <x-menu activate-by-route>
                    <x-menu-item title="Home" icon="o-home" link="###" />
                    <x-menu-item title="Messages" icon="o-envelope" link="###" />
                    <x-menu-sub title="Settings" icon="o-cog-6-tooth">
                        <x-menu-item title="Wifi" icon="o-wifi" link="####" />
                        <x-menu-item title="Archives" icon="o-archive-box" link="####" />
                    </x-menu-sub>
                </x-menu>
    </x-slot:sidebar>
</div>
