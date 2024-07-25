
<main class="cd-main-content">
    <nav class="cd-side-nav">
        <ul>
            <li class="cd-label">Main</li>
           
          <!--   <li class="has-children medicine <?php if(Request::is('directrequisition')): ?> active <?php endif; ?>">
                <a href="<?php echo e(url('directrequisition')); ?>">Requisition</a>
            </li> -->
            <li class="has-children transaction <?php if(Request::is('paidtransaction') || Request::is('unpaidtransaction')): ?> active <?php endif; ?>">
                <a href="#0">Transactions</a>

                <ul>
                    <li><a href="<?php echo e(url('paidtransaction')); ?>"><b>Paid</b> <i style="font-size: 10px;">(class D/charity and paid in cashier)</i></a></li>
                    <li><a href="<?php echo e(url('unpaidtransaction')); ?>"><b>Unpaid</b> <i style="font-size: 10px;">(class C-Bellow or Unpaid in cashier)</i></a></li>
                   
                </ul>
            </li>
            <!-- <li class="has-children medicine <?php if(Request::is('ancillarytransaction')): ?> active <?php endif; ?>">
                <a href="<?php echo e(url('ancillarytransaction')); ?>">Transaction</a>
            </li> -->
            <li class="has-children medicine <?php if(Request::is('pharmacy')): ?> active <?php endif; ?>">
                <a href="<?php echo e(url('ancillary')); ?>">Services</a>
            </li>
        </ul>
        <ul>
            <li class="cd-label">Secondary</li>
            <li class="has-children logs <?php if(Request::is('ancillarycensus')): ?> active <?php endif; ?>">
                <a href="ancillarycensus?top=ALL&from=<?php echo e(Carbon::now()->setTime(0,0)->format('Y-m-d')); ?>&to=<?php echo e(Carbon::now()->setTime(0,0)->format('Y-m-d')); ?>">Census</a>
            </li>
            <li class="has-children logs <?php if(Request::is('ancillaryreport')): ?> active <?php endif; ?>">
                <a href="<?php echo e(url('ancillaryreport')); ?>">Report</a>
            </li>
            
           
            
        </ul>

    </nav>

    <?php echo $__env->yieldContent('main-content'); ?>
    
</main> <!-- .cd-main-content -->
