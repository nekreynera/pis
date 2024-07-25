<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
    <?php echo e(strtoupper(Auth::user()->username)); ?>

    <span class="caret"></span>
</a>
<ul class="dropdown-menu">
    <li><a href="#">Update Profile</a></li>
    <li>
        <a href="<?php echo e(url('logout')); ?>"
            onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
            Logout
        </a>

        <form id="logout-form" action="<?php echo e(url('logout')); ?>" method="POST" style="display: none;">
            <?php echo e(csrf_field()); ?>

        </form>
    </li>
</ul>