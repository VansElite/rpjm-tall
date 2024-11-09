<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div class="h-dvh w-140 max-h-fit">
    <div class="w-full h-4/5" id='peta'></div>
</div>

@script
<script>
mapboxgl.accessToken = 'pk.eyJ1IjoidmFuc2VsaXRlMjEiLCJhIjoiY20yeWd2dDZyMDB3MjJtc2piZjE1ZDk0OSJ9.yDmaTMSvuPWK-iDhvldKWg';
const map = new mapboxgl.Map({
	container: 'peta', // container ID
	style: 'mapbox://styles/mapbox/streets-v12', // style URL
	center: [110.299322, -7.9701668], // starting position [lng, lat]
	zoom: 13, // starting zoom
});


</script>
@endscript
