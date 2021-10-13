@if(Session::has('success'))
  <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
    {{ Session::get('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <button type="button" class="close" aria-label="Close" style="margin-right: 3rem">
      <a class="link-unstyled" href="{{url()->previous()}}"><span aria-hidden="true">&lt;</span></a>
    </button>
  </div>
@endif