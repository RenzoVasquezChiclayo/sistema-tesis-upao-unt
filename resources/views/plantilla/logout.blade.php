@auth
    <form style="display: inline" action="/logout" method="POST">
        @csrf
        <a href="#" onclick="this.closest('form').submit()" class="dropdown-item">Cerrar Sesion</a>
    </form>
@endauth
