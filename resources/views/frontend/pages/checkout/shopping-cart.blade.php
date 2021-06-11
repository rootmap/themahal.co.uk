<?php
$objSTD=new MenuPageController();
$Seo=$objSTD->Seo();
?>
@extends('frontend.layout.master')
@section('title','Shopping Cart | ')
@section('seo')
    <meta name="description" content="{{$Seo->online_order_description}}">
    <meta name="keywords" content="{{$Seo->meta}}">
	
@endsection
@section('content')
<link rel="stylesheet" href="{{url('css/shopping-cart.css')}}">
<div id="contentWrapper">
				<div class="page-title title-1">
					<div class="container">
						<div class="row">
							<div class="cell-12">
								<h1 class="fx" data-animate="fadeInLeft">Shoping <span>cart</span></h1>
								<div class="breadcrumbs main-bg fx" data-animate="fadeInUp">
									<span class="bold">You Are In:</span><a href="#">Home</a><span class="line-separate">/</span><a href="#">Pages </a><span class="line-separate">/</span><a href="#">Shop </a><span class="line-separate">/</span><span>Shoping cart</span>
								</div>
								
							</div>
						</div>
					</div>
				</div>
				<div class="sectionWrapper">
					<div class="container">
						<table class="table-style2">
							<thead>
								<tr>
									<th class="left-text" colspan="2">Item in Shopping Cart</th>
									<th class="width-10">Price</th>
									<th class="width-50" style="width: 130px;">Qty</th>
									<th class="width-10">Subtotal</th>
								</tr>
							</thead>
							<tbody id="scTab">
								 								
								@if(isset($product))
									<?php $kkk=1; ?>
									@foreach($product as $index=>$pro)
										
										@if(isset($pro['inclusiveMeal']))
										<tr id="sc-{{$index}}" data-cid="{{$index}}"  data-id="{{$pro['item']->id}}" data-index="{{$index}}" data-exec="{{isset($pro['exec_menu'])?$pro['exec_menu']:''}}" >
											<td class="width-10"><a class="remove-item" href="#"><i class="fa fa-times-circle"></i></a></td>
											<td>
												<b>{{$pro['item']}} </b><br />
												@if(count($pro['flavour'])>0)
													@foreach($pro['flavour'] as $rr)
														<span>+{{$rr}}</span><br />
													@endforeach
												@endif
											</td>
											<td class="width-50 center">£<span>{{number_format(($pro['price']/$pro['qty']),2)}}</span></td>
											<td class="qty-txt-box">
												<input type="text" class="qtyyx" readonly="readonly" style="width: 60px !important;" value="{{$pro['qty']}}">
												<i style="font-size: large; color: #e7512f;" class="fa fa-plus-circle fa-2x"></i>
												<i style="font-size: large; color: #e7512f;" class="fa fa-minus-circle fa-2x"></i>
											</td>
											<td class="width-50 center">£<span>{{number_format($pro['price'],2)}}</span></td>
										</tr>
										@else

										<tr 
										@if(isset($pro['exec_menu']))
											id="sc-{{$index}}" 
										@else
											id="sc-{{$pro['item']->id}}" 
										@endif
										
										data-id="{{$pro['item']->id}}" data-cid="{{$pro['item']->cid}}" data-index="{{$index}}"  data-exec="{{isset($pro['exec_menu'])?$pro['exec_menu']:''}}" >
											<td class="width-10"><a class="remove-item" href="#"><i class="fa fa-times-circle"></i></a></td>
											<td>
												<b>
												@if(isset($pro['sub_cat_name']))
													[{{$pro['sub_cat_name']}}]

												@endif
												</b>
												@if(isset($pro['snd_item']) && isset($pro['item']))
													[<b>{{$pro['item']->name}}</b>]
													@if(count($pro['snd_item'])>0)
														@foreach($pro['snd_item'] as $row)
															<br /> + {{$row['item']->name}} ({{$row['qty']}} X £{{$row['item']->price}})
															
														@endforeach
													@endif
												@elseif(isset($pro['snd_item']) && !isset($pro['item']))
													@if(count($pro['snd_item'])>0)
														@foreach($pro['snd_item'] as $row)
															<br /> + {{$row['item']->name}} ({{$row['qty']}} X £{{$row['item']->price}})
															
														@endforeach
													@endif
												
												@elseif(isset($pro['execArrayData'])) 
													<b>{{$pro['item']->name}} </b>
													@if(count($pro['execArrayData'])>0)
														@foreach($pro['execArrayData'] as $row)
															<br /> + {{$row}}
														@endforeach
													@endif
												@else
												<b>{{$pro['item']->name}} </b>
												@endif
											</td>
											<td class="width-50 center">£<span>{{number_format(($pro['price']/$pro['qty']),2)}}</span></td>
											<td class="qty-txt-box">
												<input type="text" class="qtyyx" readonly="readonly" style="width: 60px !important;" value="{{$pro['qty']}}">
												<i style="font-size: large; color: #e7512f;" class="fa fa-plus-circle fa-2x"></i>
												<i style="font-size: large; color: #e7512f;" class="fa fa-minus-circle fa-2x"></i>
											</td>
											<td class="width-50 center">£<span>{{number_format($pro['price'],2)}}</span></td>
										</tr>
										@endif
										<?php $kkk++; ?>
									@endforeach
								@endif
							</tbody>
							
							<tfoot id="scFoot">
								<tr>
									<td colspan="4">Sub-Total</td>
									<td>£<span>1700</span></td>
								</tr>
								<tr class="tax_fid">
									<td colspan="4">Tax <span class="page_tax_rate"></span></td>
									<td>£<span>10.00</span></td>
								</tr>
								<tr>
									<td colspan="4">Discount <span class="discount_per_page"></span><span class="discount_message_page"></span></td>
									<td>£<span>1700</span></td>
								</tr>
								<tr style="display: none;">
									<td colspan="4">Delivery Charge </td>
									<td>£<span>0</span></td>
								</tr>
								<tr>
									<td colspan="4">Net Payable</td>
									<td>£<span>1700</span></td>
								</tr>
							</tfoot>
						</table>
						<div class="block shop-bottom-btns">
							<a class="btn btn-large left" href="{{url('order-item')}}">Continue Shopping</a>
							<a class="btn btn-large main-bg right" href="{{url('proced-to-payment')}}">Proceed to Checkout</a>
						</div>
					</div>
				</div>
				
			</div>
@endsection
@section('slider-js')
	<script type="text/javascript">
		var rec="<?php echo $rec; ?>";
	</script>
	<script type="text/javascript" src="{{url('js/shopping-cart.js')}}"></script>
@endsection