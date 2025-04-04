<br>
<br>
<br>
<nav class="bottom-nav">
    <a title="Feed" href="{{route('home')}}" class="btn-none @if(request()->route()->getName() == 'home') active @endif"><i class="fa-solid fa-infinity"></i></a>
    <a title="Shorts" href="{{route('trending')}}" class="btn-none  @if(request()->route()->getName() == 'trending') active @endif" ><i class="fa-solid fa-fire"></i></a>
    <a title="Donation" class="btn-none @if(explode('.',request()->route()->getName())[0] == 'donation') active @endif " href="{{route('donation')}}" ><i class="fa-solid fa-hand-holding-heart"></i></a>
    <a title="Profile" href="{{route('profile.view')}}" class="btn-none @if(explode('.',request()->route()->getName())[0] == 'profile') active @endif"><i class="fa-solid fa-user"></i></a>
</nav>
