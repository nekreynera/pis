@if(count($errors) > 0)
    <div class="alert alert-danger" style="">
        <strong>Whoops! looks like something went wrong.</strong>
        <br/>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif