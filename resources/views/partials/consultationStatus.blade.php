@if($patients)
<div class="row logsStatus text-center">
    <div class="col-md-12">
        <label for="" class="finLabel">Finished <span class="badge finished" id="spanFin">0</span> <span class="divider">|</span> </label>
        <label for="" class="servLabel">Serving <span class="badge serve" id="spanServe">0</span> <span class="divider">|</span> </label>
        <label for="" class="penLabel">Pending <span class="badge pending" id="spanPending">0</span> <span class="divider">|</span> </label>
        <label for="" class="pauLabel">Paused <span class="badge paused" id="spanPaused">0</span> <span class="divider">|</span> </label>
        <label for="" class="canLabel">NAWC <span class="badge canceled" id="spanCanceled">0</span> <span class="divider">=</span> </label>
        <label for="" class="totalLabel">Total <span class="badge total" id="spanTotal">0</span> </label>
    </div>
</div>
@endif