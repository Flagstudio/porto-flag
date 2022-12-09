<dropdown-trigger class="h-9 flex items-center p-relative">

    <img src="{{ asset('images/circle_logo.png') }}" class="mrmallow rounded-full w-8 h-8 mr-3"/>

    <span class="text-90">
        {{ $user->name ?? $user->email ?? __('Marshmallow User') }}
    </span>
</dropdown-trigger>

<dropdown-menu slot="menu" width="200" direction="rtl">
    <ul class="list-reset">
        <li>
            <a href="{{ route('nova.logout') }}" class="block no-underline text-90 hover:bg-30 p-3">
                {{ __('Logout') }}
            </a>
        </li>
    </ul>
</dropdown-menu>
