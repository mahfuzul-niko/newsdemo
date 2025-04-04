@props(['back' => false])

<header class="header d-flex align-items-center justify-content-between w-100">
    @if ($back)
        <button onclick="history.back()" class="btn-none"><i class="fa fa-chevron-left text-dark"></i></button>
    @endif
    <button class="btn-none  ms-auto" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"
        aria-controls="offcanvasExample"><i
            class="fa-solid fa-bars   d-block w-100 d-flex justify-content-end"></i></button>
</header>





<div class="offcanvas offcanvas-end" data-bs-backdrop="static" tabindex="-1" id="offcanvasExample"
    aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
        <div>
            <ul class="p-0">
                <li class="d-flex align-items-center gap-3 border-bottom border-secondary px-3 py-2">
                    <div>
                        <i class="fa fa-location-dot h3"></i>
                    </div>
                    <div class="d-flex flex-column justify-content-start align-items-start">
                        <a href="{{ route('profile.location.set') }}" class="btn-none p-0">Locations</a>
                        <small class="text-secondary fs-small">Pick your default city or add more locations.</small>
                    </div>
                </li>
                <li class="d-flex align-items-center gap-3 border-bottom border-secondary px-3 py-2">
                    <div>
                        <i class="fa-regular fa-bell"></i>
                    </div>
                    <div class="d-flex justify-content-between w-100">
                        <div class="d-flex flex-column justify-content-start align-items-start">
                            <a href="" class="btn-none p-0">Notifications</a>
                            <small class="text-secondary fs-small">Choose what and how often to get alerted.</small>
                        </div>
                        <small class="text-secondary fs-small">on</small>
                    </div>

                </li>
                <li class="d-flex align-items-center gap-3  border-secondary px-3 py-2">
                    <div>
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div class="d-flex flex-column justify-content-start align-items-start">
                        <a href="" class="btn-none p-0">Privacy</a>
                        <small class="text-secondary fs-small">Change your privacy settings.</small>
                    </div>
                </li>
            </ul>

            <ul class="p-0 mt-5">
                <li class="d-flex align-items-center gap-3 border-bottom  border-top  border-secondary px-3 py-2">
                    <div>
                        <i class="fa-solid fa-globe"></i>
                    </div>
                    <div class="d-flex  justify-content-between w-100">
                        <a href="{{ route('establish.pick.locale') }}" class="btn-none p-0">Language</a>
                        <small class="text-secondary fs-small">{{ App\Helpers\System::getLocale() }}</small>
                    </div>
                </li>

            </ul>
            <ul class="p-0 mt-5">
                <li class="d-flex align-items-center gap-3 border-bottom    border-secondary p-3 ">
                    <div class="d-flex flex-column justify-content-start align-items-start">
                        <a href="" class="btn-none p-0">Help center</a>
                    </div>
                </li>
                <li class="d-flex align-items-center gap-3 border-bottom    border-secondary p-3 ">
                    <div class="d-flex flex-column justify-content-start align-items-start">
                        <a href="{{ route('admin.feedback') }}" class="btn-none p-0">Send feedback</a>
                    </div>
                </li>
                <li class="d-flex align-items-center gap-3 border-bottom    border-secondary p-3 ">
                    <div class="d-flex flex-column justify-content-start align-items-start">
                        <a href="#" onclick="share(this)" data-title="{{ env('APP_NAME') }}"
                            data-url="{{ route('home') }}" class="btn-none p-0">Recommend to friends & family</a>
                    </div>
                </li>
                <li class="d-flex align-items-center gap-3 border-bottom    border-secondary p-3 ">
                    <div class="d-flex flex-column justify-content-start align-items-start">
                        <a href="" class="btn-none p-0">Rate app</a>
                    </div>
                </li>
                <li class="d-flex align-items-center gap-3 border-bottom    border-secondary p-3 ">
                    <div class="d-flex flex-column justify-content-start align-items-start">
                        <a href="" class="btn-none p-0">About</a>
                    </div>
                </li>
                <li class="d-flex align-items-center gap-3   border-secondary    p-3 ">
                    <div class="d-flex flex-column justify-content-start align-items-start">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-none p-0">Log out</button>
                        </form>
                        @auth
                            <small class="text-secondary fs-small"> {{ auth()->user()->email }}</small>
                        @endauth
                    </div>
                </li>



            </ul>
        </div>

    </div>
</div>
