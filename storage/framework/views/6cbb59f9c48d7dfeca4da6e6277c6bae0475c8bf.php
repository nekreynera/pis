<header class="cd-main-header">
    <a href="#0" class="cd-logo">
        
        
        <strong>OPDRMS - <?php echo e(Auth::user()->clinics->name); ?></strong>
    </a>

    <!-- cd-search -->

    <a href="#0" class="cd-nav-trigger"><span></span></a>

    <nav class="cd-nav" >
        <ul class="cd-top-nav">

            <?php if(count($checkIfSeniorDoctor) > 0): ?>
              <li class="approvals">
                  <a href="<?php echo e(url('forApprovals')); ?>">
                      <i class="fa fa-bell-o"></i>
                      <span class="badge"><?php echo e(count($checkIfSeniorDoctor)); ?></span>
                      For Approvals
                  </a>
              </li>
            <?php endif; ?>


                <li class="approvals consultationLogs">
                    <a href="<?php echo e(url('consultationLogs')); ?>" style="color: #fff">
                        <i class="fa fa-history"></i>
                        Consultation Logs
                    </a>
                </li>


            <li class="has-children account">

                <a href="#0">
                    <i class="fa fa-user-o" style="font-size:18px"></i>
                    <?php echo e(Auth::user()->username); ?>

                </a>

                <ul>
                    <li>
                        <a href="<?php echo e(url('doctors_account')); ?>">Edit Account &nbsp;<i class="fa fa-pencil"></i></a>
                    </li>
                      <?php if(!Auth::user()->checkIfIntern()): ?>
                    <li>
                        <a href="#" class="change-clinic">Change Clinic &nbsp;<i class="fa fa-pencil"></i></a>
                    </li>
                    <?php endif; ?>
                    <li>
                        <a href="#" data-target="#choose-theme" data-toggle="collapse" onclick="return false">
                            Choose Theme <span class="caret"></span>
                        </a>
                          <div id="choose-theme" class="collapse">
                            <a href="<?php echo e(url('theme/2')); ?>">
                                <input type="radio" /> &nbsp; Shady &nbsp;
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
                                <input type="radio" /> &nbsp; Forest &nbsp;
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
                        <a href="<?php echo e(url('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout &nbsp;<i class="fa fa-sign-out"></i>
                        </a>
                        <form id="logout-form" action="<?php echo e(url('logout')); ?>" method="POST" style="display: none;">
                            <?php echo e(csrf_field()); ?>

                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</header> <!-- .cd-main-header -->
