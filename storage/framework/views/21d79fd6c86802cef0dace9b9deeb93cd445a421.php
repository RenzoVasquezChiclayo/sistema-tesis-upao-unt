<?php if(auth()->guard()->check()): ?>
    <form style="display: inline" action="/logout" method="POST">
        <?php echo csrf_field(); ?>
        <a href="#" onclick="this.closest('form').submit()" class="dropdown-item">Cerrar Sesion</a>
    </form>
<?php endif; ?>
<?php /**PATH C:\Users\Usuario\Desktop\UNT\Escuela_Contabilidad\ProyectoActualizado\sistema-tesis-upao-unt\resources\views/plantilla/logout.blade.php ENDPATH**/ ?>