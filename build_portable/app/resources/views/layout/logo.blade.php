<a href="{{url('/')}}" class="brand-link">
    @if(session('logo') != '')
        <img src="{{asset('uploads/logo/' . session('logo'))}}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    @else
        <img src="{{asset('assets/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    @endif
    <span class="brand-text font-weight-light" style="{{ session('font_type') ? 'font-family: '.session('font_type').';' : '' }} {{ session('font_size') ? 'font-size: '.session('font_size').'px;' : '' }}">{{ session('instansi') }}</span>
</a>
