

<nav class=" flex justify-between items-center mb-4">
    <!-- Navigatiemenu code hier -->
    <ul class="border-2 border-solid border-black-200">

        <li class="py-2 px-4"><a href="/">
            <i class="fa fa-home pr-2"></i>Home
        </li>

        <li class="py-2 px-4"><a href="{{ url('families/create') }}">
            <i class="fa fa-plus pr-2"></i>Create Family</a>
        </li>

        <li class="py-2 px-4"><a href="{{ url('/memberships') }}">
            <i class="fa fa-address-card pr-2"></i>Memberships
        </li>

        <li class="py-2 px-4"><a href="{{ url('/contributions') }}">
            <i class="fa fa-book pr-2"></i>Contribution
        </li>

        <li class="py-2 px-4"><a href="{{ url('/financialyears') }}">
            <i class="fa fa-suitcase pr-2"></i>Financial Years
        </li>
        <li class="py-2 px-4">
            <form class="inline" method="POST" action="/logout">
                @csrf
                <button type="submit">
                    <i class="fa-solid fa-door-closed"></i> Log out
                </button>
            </form>
        </li>
    </ul>

</nav>