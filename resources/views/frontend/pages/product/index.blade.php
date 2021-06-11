<?php
$objSTD=new MenuPageController();
$Seo=$objSTD->Seo();
?>
@extends('frontend.layout.master')
@section('title','Order Your Menu | ')
@section('seo')
    <meta name="description" content="{{$Seo->online_order_description}}">
    <meta name="keywords" content="{{$Seo->meta}}">
@endsection
@section('content')	
   <div class="page-title title-1">
        <div class="container">
            <div class="row">
                <div class="cell-12">
                    <h1 class="fx proban head-title-product" data-animate="fadeInLeft">Order Your Food Online</h1>
                    
                        
                    </div>

                </div>
            </div>
        </div>
    </div>



    <div class="sectionWrapper product-sec-wrap">
        <div class="container">
            <div class="row">
                <div class="box success-box center hidden">Your item was added succesfully.</div>
                <div class="clearfix"></div>
                <div class="cell-6">
                    <div class="button-group" style="text-align: center;">
                        <a class="btn btn-md btn-3d btn-block btn-cart-info-mobile modal-trigger fx animated fadeInUp" href="#" data-modal="alergy_alert" data-animate="fadeInUp" data-animation-delay="1700" style="animation-delay: 1700ms;">
                            <span>FOOD ALLERGIES AND</span>
                            <span>INTOLERANCE INFORMATION</span>
                        </a>
                    </div>
                </div>
                <div class="clearfix"></div>
                <aside class="cell-3 left-shop">
                    @include('frontend.extra.product_left_bar')
                </aside>


                <!-- cell6  class="proButton modal-trigger" data-modal="modal-name" -->
                <div class="cell-6">
                    <div class="button-group" style="text-align: center;">
                        {{--<a class="btn btn-primary modal-trigger online-smart-way model-restaurant-btn fx animated fadeInUp" href="#" data-animate="fadeInUp" data-animation-delay="600" data-modal="delivery_time_detail" style="animation-delay: 600ms;">--}}
                            {{--<span><i class="fa fa-bus selectedI"></i>Delivery Time</span> </a>--}}

                        {{--<a class="btn btn-primary modal-trigger online-smart-way model-restaurant-btn fx animated fadeInUp" href="#" data-animate="fadeInUp" data-modal="alergy_alert" data-animation-delay="600" style="animation-delay: 600ms;">--}}
                            {{--<span><i class="fa fa-bus selectedI"></i>Allergy Alert</span> </a>--}}

                        {{--<a class="btn btn-primary modal-trigger online-smart-way model-restaurant-btn  fx animated fadeInUp" href="#" data-modal="delivery_detail_info" data-animate="fadeInUp" data-animation-delay="600" style="animation-delay: 600ms;">--}}
                            {{--<span><i class="fa fa-bus selectedI"></i>Delivery Info</span> </a>--}}

                        {{--<a class="btn btn-md btn-3d btn-cart-info modal-trigger fx animated fadeInUp" href="#" data-modal="delivery_time_detail" data-animate="fadeInUp" data-animation-delay="1700" style="animation-delay: 1700ms;">--}}
                            {{--<span class="line-one">DELIVERY TIME</span>--}}
                        {{--</a>--}}
                        <a class="btn btn-md btn-3d btn-block btn-cart-info-desktop modal-trigger fx animated fadeInUp" href="#" data-modal="alergy_alert" data-animate="fadeInUp" data-animation-delay="1700" style="animation-delay: 1700ms;">
                            <span>FOOD ALLERGIES AND</span>
                            <span>INTOLERANCE INFORMATION</span>
                        </a>
                        {{--<a class="btn btn-md btn-3d btn-cart-info modal-trigger fx animated fadeInUp" href="#" data-modal="delivery_detail_info" data-animate="fadeInUp" data-animation-delay="1700" style="animation-delay: 1700ms;">--}}
                            {{--<span class="line-one">DELIVERY INFO</span>--}}
                        {{--</a>--}}
                    </div>
                    
                    @if(isset($orderINfoText))
                        <div class="modal" id="delivery_time_detail" style="z-index: 9999;">
                            <div class="modal-sandbox"></div>
                            <div class="modal-box">
                                <div class="modal-header">
                                    <div class="close-modal">✖</div> 
                                    <h4><i class="fa fa-info-circle"></i> Opening information</h4>
                                </div>
                                <div class="modal-body" style="padding:20px 10px 10px 10px;">       
                                    <div class="cell-12">
                                       {!!html_entity_decode($orderINfoText->delivery_time)!!} 
                                    </div>               
                                </div>
                            </div>
                        </div>

                        <div class="modal" id="alergy_alert" style="z-index: 9999;">
                            <div class="modal-sandbox"></div>
                            <div class="modal-box">
                                <div class="modal-header">
                                    <div class="close-modal">✖</div> 
                                    <h4><i class="fa fa-info-circle"></i> Allergy & dietary information</h4>
                                </div>
                                <div class="modal-body" style="padding:20px 10px 10px 10px;">       
                                    <div class="cell-12">
                                       {!!html_entity_decode($orderINfoText->allergy_alert)!!} 
                                    </div>               
                                </div>
                            </div>
                        </div>

                        <div class="modal" id="delivery_detail_info" style="z-index: 9999;">
                            <div class="modal-sandbox"></div>
                            <div class="modal-box">
                                <div class="modal-header">
                                    <div class="close-modal">✖</div> 
                                    <h4><i class="fa fa-info-circle"></i> Delivery Info</h4>
                                </div>
                                <div class="modal-body" style="padding:20px 10px 10px 10px;">       
                                    <div class="cell-12">
                                       {!!html_entity_decode($orderINfoText->delivery_info)!!} 
                                    </div>               
                                </div>
                            </div>
                        </div>

                    

                    <!-- button -->
                    <div class="clearfix"></div>
                    <div class="padd-top-20"></div>
                    <div class="cell-12 order_info_des">
                        <blockquote>
                            {!!html_entity_decode($orderINfoText->description)!!} 
                        </blockquote>
                    </div>
                    @endif 

                    

                    @if (session('error'))
                        <div class="clearfix"></div>
                            <div class="padd-top-20"></div>
                            <div class="cell-12">
                                <blockquote>
                                    <h3 style="text-align: center; color: #f00;">{{session('error')}} </h3>
                                </blockquote>
                        </div>
                    @endif

                    @if ($orderINfoText->isoffline==1)
                        <div class="clearfix"></div>
                            <div class="padd-top-20"></div>
                            <div class="cell-12">
                                <blockquote style="color: #f00;">
                                    {!!html_entity_decode($orderINfoText->offline_notice)!!}
                                </blockquote>
                        </div>
                    @endif

                    

                    <div class="clearfix"></div>
                    <div class="padd-top-20"></div>
                    <!-- NOTE -->
                    
                    @include('frontend.extra.ros_menu')
                    
                     
                </div>

                
                @include('frontend.extra.cart',compact($orderINfoText))



            </div>
        </div>
    </div>
@endsection	





@section('css')
    <link rel="stylesheet" href="{{url('front-theme/css/custom.css')}}">
    <link rel="stylesheet" href="{{url('front-theme/css/radio-button/style.css')}}">
    <link rel="stylesheet" href="{{url('css/cart.css')}}">
@endsection

@section('slider-js')
    <script type="text/javascript" src="{{url('front-theme/js/jquery.animateNumber.min.js')}}"></script>
    <script type="text/javascript" src="{{url('front-theme/js/jquery.easypiechart.min.js')}}"></script>

    <script src="{{url('front-theme/js/sweetalert.min.js')}}"></script>
    <script type="text/javascript">     
        var inmJson=<?=json_encode($inclusiveMeal)?>;  
    </script>
    <script src="{{url('js/cart.js')}}"></script>    
@endsection
