
<header class="cd-main-header">
    <a href="<?php echo e((Auth::user()->role == 4 && Auth::user()->clinic == 31)? url('radiologyHome') : url('overview')); ?>" class="cd-logo">
        
        <i class="fa fa-stethoscope"></i> OPDRMS | 

        <?php if(Auth::user()->clinic == 47 ): ?> 
        <?php echo e("LABORATORY"); ?>

        <?php elseif(Auth::user()->clinic == 31): ?>
        <?php echo e("RADIOLOGY"); ?>

        <?php elseif(Auth::user()->clinic == 32): ?>
        <?php echo e("REHABILITATION"); ?>

        <?php elseif(Auth::user()->clinic == 48): ?>
        <?php echo e("ECG"); ?>

        <?php endif; ?>
    </a>

    <a href="#0" class="cd-nav-trigger"><span></span></a>

    <nav class="cd-nav" >
        <ul class="cd-top-nav">
            <li class="has-children account">
                <a href="#0">
                    
                    <?php echo e(Auth::user()->last_name); ?>

                </a>

                <ul>
                    <li><a href="#0">Edit Account</a></li>
                    <li>
                        <a href="#" data-target="#choose-theme" data-toggle="collapse" onclick="return false">
                            Choose Theme <span class="caret"></span>
                        </a>
                          <div id="choose-theme" class="collapse">
                            <a href="<?php echo e(url('theme/2')); ?>">
                                <input type="radio" /> &nbsp; Dark &nbsp;
                                <table class="color-palette">
                                    <tr>
                                        <td style="background-color: #222">&nbsp;</td>
                                        <td style="background-color: #333">&nbsp;</td>
                                        <td style="background-color: #0073aa">&nbsp;</td>
                                        <td style="background-color: #00a0d2">&nbsp;</td>
                                    </tr>
                                </table>
                            </a>
                            <a href="<?php echo e(url('theme/1')); ?>">
                                <input type="radio" /> &nbsp; Green &nbsp;
                                <table class="color-palette">
                                    <tr>
                                        <td style="background-color: #00ff00">&nbsp;</td>
                                        <td style="background-color: #00e600">&nbsp;</td>
                                        <td style="background-color: #00b300">&nbsp;</td>
                                        <td style="background-color: #ccc">&nbsp;</td>
                                    </tr>
                                </table>
                            </a>
                          </div>
                    </li>

                    <li>
                    <a href="<?php echo e(url('logout')); ?>"
                        onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                        Logout
                    </a></li>

                    <form id="logout-form" action="<?php echo e(url('logout')); ?>" method="POST" style="display: none;">
                        <?php echo e(csrf_field()); ?>

                    </form>
                </ul>
            </li>
        </ul>
    </nav>
</header> <!-- .cd-main-header -->~