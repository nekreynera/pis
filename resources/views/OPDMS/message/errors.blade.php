@if(count($errors) > 0)
    <div class="callout callout-danger">
        <strong><i class="icon fa fa-ban"></i> Whoops! looks like something went wrong.</strong>
        <br/>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif