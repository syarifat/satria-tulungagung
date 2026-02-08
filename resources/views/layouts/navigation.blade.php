@if(Auth::user()->role === 'admin_pc')
    @include('layouts.partials.navigation_pc')
@elseif(Auth::user()->role === 'admin_pac')
    @include('layouts.partials.navigation_pac')
@elseif(Auth::user()->role === 'admin_pr')
    @include('layouts.partials.navigation_pr')
@elseif(Auth::user()->role === 'anggota')
    @include('layouts.partials.navigation_anggota')
@endif