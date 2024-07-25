<form action="{{ url('search_patient') }}" method="post" class="sidebar-form whiteSearchBar">
    {{ csrf_field() }}
    <div class="input-group">
        <input type="hidden" name="redirector" value="{{ $redirector }}"/>
        <input type="text" name="search" class="form-control" placeholder="Search Patient...">
          <span class="input-group-btn">
              <button type="submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
    </div>
</form>