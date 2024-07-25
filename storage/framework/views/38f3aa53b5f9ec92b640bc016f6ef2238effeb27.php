<main class="cd-main-content">
    <nav class="cd-side-nav">
        <ul>
            <li class="cd-label">Main</li>
            <li class="has-children patientlist <?php if(Request::is('patientlist')): ?> active <?php endif; ?>">
                <a href="<?php echo e(url('patientlist')); ?>">Patients</a>
            </li>



           



            <li class="has-children notifications <?php if(Request::is('consultation') || Request::is('consultation/*/edit')): ?> active <?php endif; ?>">
                <a href="<?php echo e(url('consultation')); ?>">Consultation</a>
                
            </li>
            
            
            
        </ul>

        <ul>
            <li class="cd-label">Secondary</li>
            <li class="has-children users <?php if(Request::is('requisition')): ?> active <?php endif; ?>">
                <a href="<?php echo e(url('requisition')); ?>">Requisition</a>
            </li>
            <li class="has-children bookmarks <?php if(Request::is('refferal')): ?> active <?php endif; ?>">
                <a href="<?php echo e(url('refferal')); ?>">Referral</a>
            </li>
            <li class="has-children images <?php if(Request::is('followup')): ?> active <?php endif; ?>">
                <a href="<?php echo e(url('followup')); ?>">Follow-Up</a>
            </li>

            

            <li class="has-children diseases <?php if(Request::is('diseases')): ?> active <?php endif; ?>">
                <a href="<?php echo e(url('diseases')); ?>">Diseases</a>
            </li>

        </ul>


        <!-- FOR FAMED ONLY -->
        

        <ul>
            <li class="cd-label">OTHERS</li>
            <li class="has-children reports">
                <a href="#">Reports</a>
                <ul>
                    <?php if(Auth::user()->clinic == 8): ?>
                        <li>
                            <a href="<?php echo e(url('smoke_cessation')); ?>">Smoke Cessation</a>
                        </li>
                    <?php endif; ?>
                    <li>
                        <a href="<?php echo e(url('doctors_census')); ?>">Age Gender Distribution</a>
                    </li>
                </ul>
            </li>
        </ul>


        

    </nav>

    <?php echo $__env->yieldContent('main-content'); ?>

</main> <!-- .cd-main-content -->