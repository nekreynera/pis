<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
    {{ strtoupper(Auth::user()->username) }}
    <span class="caret"></span>
</a>
<ul class="dropdown-menu">
    <li><a href="#">Update Profile</a></li>
    <li>
        <a href="{{ url('logout') }}"
            onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
            Logout
        </a>

        <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </li>
</ul>