<!-- Load JS siles -->	
<script type="text/javascript" src="{{url('front-theme/js/jquery.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script type="text/javascript">
var csrftLarVe = $('meta[name="csrf-token"]').attr("content"),
    baseURL = $('meta[name="base-url"]').attr("content");
$(document).ready(function(){
        @if (session('status'))
        Swal.fire({
            icon: 'success',
            title: '<h3 class="text-success">Thank You</h3>',
            html: '<h5>{{session('status')}}</h5>'
        });
        <?php 
        Session::forget('status');
        ?>
    @endif
    
    @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: '<h3 class="text-danger">Warning</h3>',
            html: '<h5>{{session('error')}}!!!</h5>'
        });
        <?php 
        Session::forget('error');
        ?>
    @endif
    
});
</script>
<script type="text/javascript" src="{{asset('js/global-cart.js')}}"></script>
<!-- Waypoints script -->
<script type="text/javascript" src="{{url('front-theme/js/waypoints.min.js')}}"></script>
@yield('slider-js')
<!-- Input placeholder plugin -->
<script type="text/javascript" src="{{url('front-theme/js/jquery.placeholder.js')}}"></script>
<!-- Tweeter API plugin -->
<script type="text/javascript" src="{{url('front-theme/js/jflickrfeed.min.js')}}"></script>
<!-- NiceScroll plugin -->
<script type="text/javascript" src="{{url('front-theme/js/jquery.nicescroll.min.js')}}"></script>
<!-- general script file -->
<script type="text/javascript" src="{{url('front-theme/js/script.js')}}"></script>