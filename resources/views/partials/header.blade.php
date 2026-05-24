<!-- Header -->
<header class="d-flex p-3 align-items-center justify-content-between">
    <img src="{{ asset('images/logo-storify.png') }}" alt="logo" class="md:dx-logo-img dx-img-ht">
    <div class="d-flex">
        <a id="openBtn" class="dx-text-biru dx-text-sm hover:dx-text-biru-muda">
            <span>Buka</span>
            <img src="{{ asset('images/left-arrow.svg') }}" class="d-inline-block dx-ml-2"
                style="transform: rotate(180deg);">
        </a>
    </div>
    <div>
        <tabel>
            <thead>
                <tr>
                    <td>
                        <div class="d-flex align-items-center float-start">
                            <a type="button" id="dropdownMenu1" data-bs-toggle="dropdown" aria-expanded="false"
                                class="dx-notif-wrapper">
                                <img src="{{ asset('images/bell.svg') }}" alt="avatar" class="dx-h-8 dx-ml-4">
                                <span {{-- id="notifBadge"  --}} class="dx-badge-pulse">0</span>
                            </a>
                            <div class="dropdown-menu dx-edit-dropdown" aria-labelledby="dropdownMenu1">
                                <div class="dx-px-4 dx-pt-3">
                                    <span class="d-block dx-font-medium dx-truncate">Pesan
                                        Masuk:
                                    </span>
                                    <p class="dx-text-xs dx-cursor-pointer">Anda memiliki <b>0</b> pesan
                                        yang belum
                                        di baca !</p>
                                    <small class="d-block"></small>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex justify-content-end align-items-center float-end">

                            <a type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ asset('images/avatar-placeholder.png') }}" alt="avatar"
                                    class="dx-h-8 dx-ml-4"></a>
                            <span class="dx-text-right dx-font-bold dx-truncate">&nbsp;
                                {{ strtoupper(auth()->user()->name) }}</span>

                            <div class="dropdown-menu dx-edit-dropdown" aria-labelledby="dropdownMenu2">
                                <div class="dx-px-4 dx-py-3">
                                    <span class="d-block dx-font-medium dx-truncate">Hai
                                        {{ auth()->user()->name }},</span>
                                    <small class="d-block dx-text-xs">{{ auth()->user()->email }}</small>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="dx-bg-transparan dx-text-biru hover:dx-no-underline tw-px-4 tw-py-3 dx-text-xs">Logout</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </thead>
        </tabel>
    </div>
</header>
