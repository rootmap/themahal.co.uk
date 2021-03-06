<div class="cell12">
    <div class="productItem">
        <!-- product view only mbl -->
    

        @include('frontend.extra.ros_mobile_view')
        <!-- product view only mbl end-->
        <div class="productdes">

            <div class="clearfix"></div>
            <div class="padd-top-20"></div>
            @if ($inclusive==1)
                <h4 id="pro_inclusive_meal" class="block-head  margin-bottom-40 fx animated fadeInUp" data-animate="fadeInUp" data-animation-delay="600" style="animation-delay: 600ms;">
                    <span>Inclusive Meal</span>
                </h4>
                @if(count($inclusiveMeal)>0)
                    @foreach($inclusiveMeal as $row)
                        <div class="cell-12" id="im{{$row->id}}" style="clear: both; padding: 0px; padding-bottom: 5px; padding-top: 5px; border-bottom: 1px #ccc solid;">
                            <div id="proName{{$row->id}}" class="cell-5" style="padding-left: 0px;">
                                <div><strong>{{$row->name}}</strong></div>
                                <p>{{$row->description}}</p>
                            </div>
                            <div class="cell-3">
                                <div style="text-align: center;"><strong>Price : Start £<span id="imp{{$row->id}}">{{$row->price}}</span></strong></div>
                            </div>
                            <?php
                                $optMenu=json_decode(unserialize($row->product_json));
                                $k=1;
                            ?>

                            <div class="cell-4" style="padding-right: 0px;">
                                @if(count($optMenu)>0)
                                    @foreach($optMenu as $rw)
                                        <div class="cell-12" style="margin-bottom: 5px; padding: 0px;">
                                            <div class="cell-12" style="padding-right: 0px;">
                                                <select name="imjname{{$row->id}}_{{$objSTD->clean($rw->pro_opt_name)}}" data-opt-cond="{{$objSTD->clean($rw->pro_opt_name)}}" class="form-control inmPrice imj{{$row->id}}" data-tag="{{$row->id}}" style="width: 100%;">
                                                    <option value="0">Choose {{$rw->pro_opt_name}}</option>
                                                    @if(count($rw->option_param)>0)
                                                        @foreach($rw->option_param as $rr)
                                                            <option data-price="{{$rr->price}}" value="{{$rr->name}}">{{$rr->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                                <div class="cell-12" style="text-align: right; padding-right: 0px;">
                                    <div class="cell-12" style="padding-right: 0px;">
                                        <button data-pull="{{$row->id}}" class="btn btn-block btn-danger addtocartim" type="button">Add To Cart</button>
                                    </div>
                                </div>
                                
                            </div>
                
                        </div>

                    @endforeach
                @endif
            @endif
            



            <?php 
            $modal='';
            //dd($category);
            ?>
            @if(count($category)>0)
                @foreach($category as $cat)
                    
                    <div class="clearfix"></div>
                    <div class="padd-top-20"></div>
                    <h4 id="pro{{$cat['id']}}" class="block-head  margin-bottom-40 fx animated fadeInUp" data-animate="fadeInUp" data-animation-delay="600" style="animation-delay: 600ms;">
                        <span>{{$cat['name']}}</span>
                    </h4>                     
                    <?php
                    if($cat['layout']==1 || $cat['layout']==4){
                        if(isset($cat['product_row']))
                        {

                            ?>
                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                <tbody id="place_pro_{{$cat['id']}}">
                                    @if(!empty($cat['description']))
                                        <tr>
                                            <td colspan="3">
                                                <p class="proDes" style="text-transform: capitalize;  font-style: italic !important;">
                                                    <?php echo strip_tags(html_entity_decode($cat['description']));?>
                                                </p>
                                            </td>
                                        </tr>
                                    @endif
                                    <?php 
                                    foreach ($cat['product_row'] as $key => $row) 
                                    {
                                        $interface=$row['interface'];
                                    ?>
                                        <tr>
                                            <td width="80%">
                                                <span class="proName">{{$row['name']}}</span>
                                                <p class="proDes" style=" font-style: italic !important;">
                                                    <?php echo strip_tags(html_entity_decode($row['description'])); ?>
                                                </p>
                                            </td>
                                            <td><span style="font-weight: 900;">
                                            @if($interface==3)
                                            <?php 
                                            $min_prince_row=0; 
                                            foreach($row['modal'] as $key=>$mod):
                                                if($min_prince_row>0)
                                                {
                                                    if($min_prince_row>$mod['price'])
                                                    {
                                                        $min_prince_row=$mod['price'];
                                                    }
                                                }
                                                else
                                                {
                                                    $min_prince_row=$mod['price'];
                                                }
                                            endforeach;
                                            echo "£".$min_prince_row;
                                            ?>
                                            @else
                                                £{{$row['price']}}
                                            @endif
                                            </span></td>
                                            <td align="right">
                                                <div class="prosec">
                                                    @if($interface==5)
                                                        <a href="javascript:void(0);" class="button-cart_wop button proButton modal-trigger" data-modal="pizza_modal_name_{{$row['id']}}"><i class="fa fa-plus"></i></a>
                                                    @elseif($interface==4)
                                                        <a href="javascript:void(0);" class="button-cart_wop button proButton modal-trigger" data-modal="ex_modal-name_{{$row['id']}}"><i class="fa fa-plus"></i></a>
                                                    @elseif($interface==3)
                                                        <a href="javascript:void(0);" class="button-cart_wop button proButton modal-trigger" data-modal="other_modal_name_{{$row['id']}}"><i class="fa fa-plus"></i></a>
                                                    @elseif($interface==2)
                                                        &nbsp;
                                                    @else
                                                    <p class="proPrice">
                                                        
                                                        <div style="height: 0px; width: 0px; overflow: hidden;">
                                                            <img src="{{url('front-theme/images/cart-icon.png')}}">
                                                        </div>
                                                        <a href="javascript:void(0);" data-id="{{$row['id']}}" class="proButton add-cart"><i class="fa fa-plus"></i></a>
                                                    </p>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @if($interface==2)

                                            @foreach($row['ProductOneSubLevel'] as $dt)
                                            <tr>
                                                <td>
                                                    <span class="proName">{{$dt['name']}}</span>
                                                </td>
                                                <td><span>£{{$dt['price']}}</span></td>
                                                <td align="right">
                                                    <div class="prosec">
                                                        <p class="proPrice">
                                                            
                                                            <div style="height: 0px; width: 0px; overflow: hidden;">
                                                                <img src="{{url('front-theme/images/cart-icon.png')}}">
                                                            </div>
                                                            <a  href="javascript:void(0);" data-name-snd="{{$dt['name']}}"  data-id="{{$row['id']}}" snd-data-id="{{$dt['id']}}" snd-data-price="{{$dt['price']}}" ex-class="add-snd-subcat-cart" name="dddd"  class="add-snd-cart proButton">
                                                               <i class="fa fa-plus"></i>
                                                           </a>
                                                        </p>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach

                                        @endif
                                    <?php
                                        
                                        if($interface==5)
                                        {
                                            $modal_name_pizza="pizza_modal_name_".$row['id'];
                                            $modal.='<div class="modal" data-array="" id="'.$modal_name_pizza.'">
                                                        <div class="modal-sandbox"></div>
                                                        <div class="modal-box">
                                                            <div class="modal-header">
                                                                <div class="close-modal">&#10006;</div> 
                                                                <h4><i class="fa fa-info-circle"></i> '.$row['name'].' </h4>
                                                            </div>
                                                            <div class="modal-body modal_fixer">';

                                                        $modal.='<div class="col-md-12">';

                                                        

                                                        $modal.='<section class="custom-radio-section-two data-select-place" id="data-select-place"></section>

                                                                <div class="menu_options-header"><h2 style="margin-bottom: 0px !important;">Select option:</h2></div>';


                                                        if(isset($row['PizzaSize']))
                                                        {
                                                            $modal.='<section class="custom-radio-section custom-border-style-bottom" id="dta-category">';
                                                           
                                                            foreach ($row['PizzaSize'] as $pzkey => $pz) {

                                                                $modal.='<div class="custom-radio-input-group selection-category-part">
                                                                          <input data-modal-id="'.$modal_name_pizza.'"  class="pizza-check-category" type="radio" id="control_'.str_replace(' ','_',strtolower($row['id'])).'_'.$pzkey.'" name="'.str_replace(' ','_',strtolower($row['id'])).'" value="'.$pz['id'].'">
                                                                          <label for="control_'.str_replace(' ','_',strtolower($row['id'])).'_'.$pzkey.'" class="custom-radio-input-group-border-bottom">
                                                                            <p style="margin: 0px !important;">'.$pz['name'].'</p>
                                                                          </label>
                                                                        </div>';

                                                            }

                                                           


                                                           $modal.='
                                                                </section>';
                                                        }



                                                       if(isset($row['PizzaFlabour']))
                                                       {

                                                       $modal.='<section class="custom-radio-section custom-border-style-bottom sub-category" id="sub-category_'.$row['id'].'" style="display: none !important;">';


                                                            foreach ($row['PizzaFlabour'] as $pzskey => $psz) {
                                                            $modal.='<div class="custom-radio-input-group selection-subcat-part">
                                                                      <input class="pizza-check-subcat" data-modal-id="'.$modal_name_pizza.'"  type="radio" id="control_'.str_replace(' ','_',strtolower($row['name'])).'_'.$pzskey.'" name="'.str_replace(' ','_',strtolower($row['name'])).'_subcat" value="'.$psz['id'].'">
                                                                      <label for="control_'.str_replace(' ','_',strtolower($row['name'])).'_'.$pzskey.'" class="custom-radio-input-group-border-bottom">
                                                                        <p style="margin: 0px !important;">'.$psz['name'].'</p>
                                                                      </label>
                                                                    </div>';
                                                            }

                                                        }

                                                        $modal.='</section>';


                                                        if(isset($row['pizzaExtra']))
                                                        {
                                                        $modal.='<style type="text/css">
                                                                    .table-under-quantity{ padding-right: 5px; }
                                                                    .table-under-quantity tbody tr td .proDesc a{ font-size:25px; }
                                                                    .table-under-quantity tbody tr td .proDesc{ line-height: 25px; font-size:15px; }
                                                                    .table-under-quantity tbody tr td{ border-bottom:2px #fff solid; }
                                                                    .table-under-quantity tbody tr td{ font-size: 20px !important;  padding-left: 5px; }
                                                                </style>';


                                                        $modal.='<table class="table-under-quantity cat-extra-table" cellpadding="0" cellspacing="0" width="100%">
                                                                    <tbody>';
                                                                        
                                                                    foreach($row['pizzaExtra'] as $indK=>$kr){
                                                                            
                                                                        $modal.='<tr style="">
                                                                                    <td width="60%" style="">
                                                                                        <span class="proName">'.$kr['name'].'</span>
                                                                                        <p class="proDesc classExtraCalculate" style="display: none;" data-extra-name="'.$kr['name'].'">
                                                                                            <a href="javascript:void(0)" class="deductQTYPizza" style="margin-right: 30px;">
                                                                                                <i class="fa fa-minus-circle" aria-hidden="true"></i> 
                                                                                            </a>
                                                                                            <span>0</span> 
                                                                                            <i class="fa fa-times" aria-hidden="true"></i> 
                                                                                            <span>'.$kr['price'].'</span>
                                                                                            =
                                                                                            <span>1</span>
                                                                                        </p>
                                                                                    </td>
                                                                                    <td width="20%"></td>
                                                                                    <td width="20%" align="right">

                                                                                        <div class="prosec">
                                                                                            <p class="proPrice" style="margin-bottom: 5px;"><span>£'.$kr['price'].'</span>
                                                                                                <a href="javascript:void(0);" data-price="'.$kr['price'].'" data-id="'.$kr['id'].'"  data-modal-id="'.$modal_name_pizza.'"  class="proButton add-to-extras"><i class="fa fa-plus"></i></a>
                                                                                            </p>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>';
                                                                            
                                                                        }
                                                                              
                                                            $modal.='</tbody>
                                                                </table>';


                                                                }





                                                    $modal.='</div>';     
                                                               
                                                    $modal.=' <div class="modal-footer" style="padding: 15px;">
                                                                    <button data-id="'.$row['id'].'" data-take="'.$modal_name_pizza.'" type="button" class="btn btn-primary left add-total-pizza-basket"  style="color: white; margin-bottom: 15px !important;">
                                                                        <i class="fa fa-shopping-cart"></i> <b>Skip Extras</b>
                                                                    </button>
                                                                    <span class="right" style="font-weight: 600; font-size: 16px; color: #000;">£<span class="totlabsk">'.$row['price'].'</span></span>
                                                              </div>';                
                                                        

                                                    $modal.='</div>
                                                        </div>
                                                </div>';
                                        }
                                        elseif($interface==4)
                                        {
                                            $modal.='<div class="modal" style="z-index:9999;" id="ex_modal-name_'.$row['id'].'">
                                                        <div class="modal-sandbox"></div>
                                                        <div class="modal-box">
                                                            <div class="modal-header">
                                                                <div class="close-modal">&#10006;</div> 
                                                                <h4><i class="fa fa-info-circle"></i> '.$row['name'].'</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                       
                                                                <form action="#" id="reg_form" style="padding-top:7px;">';

                                                         $im=0;
                                                           foreach($row['ProductOneSubLevel'] as $index=>$itm):
                                                           
                                                           $ikm='';
                                                           if(isset($row['ProductOneSubLevel'][$index+1]))
                                                           {
                                                                $ikm=$row['ProductOneSubLevel'][$index+1]['is_parent'];
                                                           }

                                                           if((!empty($ikm) && $ikm!=0 && $ikm!='No Parent') && $im==0)
                                                           {
                                                                $im=1;
                                                                $modal.='<div class="form_popup bgbor" data-m="'.$ikm.'" data-id="'.$itm['is_parent'].'">
                                                                        <div class="back_popup">';
                                                           }
                                                          

                                                           if($im==0)
                                                           {
                                                                $modal.='<div class="form_popup bgbor" data-m="'.$ikm.'" data-id="'.$itm['is_parent'].'">
                                                                        <div class="back_popup">';
                                                           }
                                                           

                                                         
                                                      
                                                           
                                                                
                                                           
                                                           
                                                           
                                                                    $modal.='<div class="cell-4" style="padding-top:12px;">
                                                                                <label>'.$itm['name'].'</label>
                                                                            </div>
                                                                            <div class="cell-8" style="padding-top:7px;">
                                                                                <select required="" title="'.$itm['name'].'" data-id="'.$itm['id'].'">';     
                                                                           foreach($itm['dropdown'] as $index=>$drp):
                                                                                $modal.='<option data-id="'.$index.'" value="'.trim($drp).'">'.trim($drp).'</option>';  
                                                                           endforeach;          
                                                                       $modal.='</select>
                                                                            </div><div class="clearfix"></div>';

                                                               
                                                             if((!empty($ikm) && $ikm!=0 && $ikm!='No Parent') && $im==1)
                                                               {
                                                                    $im=1;
                                                               }
                                                               else
                                                               {
                                                                    $modal.='</div>
                                                                        </div>';
                                                                    $im=0;
                                                               }


                                                               
                                                               
                                                               

                                                                
                                                                    
                                                                  

                                                               

                                                            endforeach;        
                                                                    
                                                        $modal.='<div class="form_popup">
                                                                        <a data-id="'.$row['id'].'" href="javascript:void(0);" class="btn executive-set-menu btn-mid main-bg"><i class="fa fa-shopping-cart"></i> Add To Cart</a>
                                                                    </div>                
                                                                </form>

                                                            </div>
                                                        </div>
                                                </div>';
                                        }
                                        elseif($interface==3)
                                        {
                                            $modal.='<div class="modal" id="other_modal_name_'.$row['id'].'">
                                                          <div class="modal-sandbox"></div>
                                                          <div class="modal-box">
                                                            <div class="modal-header">
                                                              <div class="close-modal">&#10006;</div> 
                                                              <h4><i class="fa fa-info-circle"></i> '.$row['name'].'</h4>

                                                          </div>
                                                          <div class="modal-header-details">
                                                            <p align="center">
                                                              <br>
                                                              <b>Please select a option.</b><br>
                                                            </p>   
                                                        </div>
                                                        <div class="modal-body" style="padding-bottom:10px;">';

                                            foreach($row['modal'] as $key=>$mod):
                                                $modal.='       <div class="cell-6">
                                                                   <a data-id="'.$row['id'].'" snd-data-id="'.$mod['id'].'" name="options" id="option_0" class="btn add-snd-cart btn-optionlist"><span class="pull-left">
                                                                            '.$mod['name'].'
                                                                       </span> 
                                                                       <span class="pull-right">
                                                                       £'.$mod['price'].'
                                                                       </span>
                                                                   </a>
                                                                </div>';
                                            endforeach;

                                        $modal.='                
                                                      </div>
                                                  </div>
                                                </div>';
                                        }

                                    }
                                    ?>         
                                </tbody>
                            </table>
                            <?php
                        }
                    }
                    elseif($cat['layout']==2)
                    {
                        if(isset($cat['product_row']))
                        {
                            ?>
                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                <tbody id="place_pro_{{$cat['id']}}">
                                    @if(!empty($cat['description']))
                                        <tr>
                                            <td colspan="3">
                                                <p class="proDes" style="text-transform: capitalize;  font-style: italic !important;">
                                                    <?php echo strip_tags(html_entity_decode($cat['description']));?>
                                                </p>
                                            </td>
                                        </tr>
                                    @endif
                                    <?php 

                                    foreach ($cat['product_row'] as $key => $sc) 
                                    {
                                        ?>
                                        <tr>
                                            <td colspan="3">
                                                <span class="proName">{{$sc['name']}}</span><br>
                                                <i>{{strip_tags(html_entity_decode($sc['description']))}}</i>
                                            </td>
                                        </tr>
                                        <?php
                                        foreach ($sc['sub_product_row'] as $key => $row) 
                                        {
                                        
                                        $interface=$row['interface'];
                                        
                                        ?>
                                        @if($interface!=2)
                                        
                                        <tr>
                                            <td width="80%">
                                                <p class="proDes">{{$row['name']}}
                                                    <i><?php echo strip_tags(html_entity_decode($row['description']))?'<br>'.strip_tags(html_entity_decode($row['description'])):'';?></i>
                                                </p>
                                            </td>
                                            <td>
                                            <span style="font-weight: 900;">
                                            @if($interface==3)
                                            <?php 
                                            $min_prince_row=0; 
                                            foreach($row['modal'] as $key=>$mod):
                                                if($min_prince_row>0)
                                                {
                                                    if($min_prince_row>$mod['price'])
                                                    {
                                                        $min_prince_row=$mod['price'];
                                                    }
                                                }
                                                else
                                                {
                                                    $min_prince_row=$mod['price'];
                                                }
                                            endforeach;
                                                echo "£".$min_prince_row;
                                            ?>
                                            @else
                                                @if(!empty($row['price']))
                                                    £{{$row['price']}}
                                                @endif
                                            @endif
                                            </span>
                                            </td>
                                            <td align="right">

                                                <div class="prosec">
                                                    @if($interface==5)
                                                        <a href="javascript:void(0);" class="button-cart_wop button proButton modal-trigger" data-modal="pizza_modal_name_{{$row['id']}}"><i class="fa fa-plus"></i></a>
                                                    @elseif($interface==4)
                                                        <a href="javascript:void(0);" class="button-cart_wop button proButton modal-trigger" data-modal="ex_modal-name_{{$row['id']}}"><i class="fa fa-plus"></i></a>
                                                    @elseif($interface==3)
                                                        <a href="javascript:void(0);" class="button-cart_wop button proButton modal-trigger" data-modal="other_modal_name_{{$row['id']}}"><i class="fa fa-plus"></i></a>
                                                    @elseif($interface==2)
                                                        &nbsp;
                                                    @else
                                                    <p class="proPrice">
                                                        
                                                        <div style="height: 0px; width: 0px; overflow: hidden;">
                                                            <img src="{{url('front-theme/images/cart-icon.png')}}">
                                                        </div>
                                                        <a href="javascript:void(0);" data-id="{{$row['id']}}"  data-sub-name="{{$sc['name']}}"  class="proButton add-cart"><i class="fa fa-plus"></i></a>
                                                    </p>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @endif
                                        @if($interface==2)
                                            @foreach($row['ProductOneSubLevel'] as $dt)
                                            <tr>
                                                <td width="60%" align="left" valign="top">
                                                    <span class="proName" style="font-weight: 100 !important;">{{$dt['name']}}</span>
                                                </td>
                                                <td align="right" style="font-weight: bold;"><span>£{{$dt['price']}}</span></td>
                                                <td width="20%" align="right" valign="top">
                                                    <div class="prosec">
                                                        <p class="proPrice">
                                                            
                                                            <div style="height: 0px; width: 0px; overflow: hidden;">
                                                                <img src="{{url('front-theme/images/cart-icon.png')}}">
                                                            </div>
                                                            <a href="javascript:void(0);"  data-extra-id="{{$dt['id']}}"  data-sub-name="{{$sc['name']}}"  data-id="{{$row['id']}}" class="proButton add-subcat-cart"><i class="fa fa-plus"></i></a>
                                                        </p>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endif
                                    <?php
                                        if($interface==5)
                                        {
                                            $modal_name_pizza="pizza_modal_name_".$row['id'];
                                            $modal.='<div class="modal" data-array="" id="'.$modal_name_pizza.'">
                                                        <div class="modal-sandbox"></div>
                                                        <div class="modal-box">
                                                            <div class="modal-header">
                                                                <div class="close-modal">&#10006;</div> 
                                                                <h4><i class="fa fa-info-circle"></i> '.$row['name'].' </h4>
                                                            </div>
                                                            <div class="modal-body modal_fixer">';

                                                        $modal.='<div class="col-md-12">';

                                                        

                                                        $modal.='<section class="custom-radio-section-two data-select-place" id="data-select-place"></section>

                                                                <div class="menu_options-header"><h2 style="margin-bottom: 0px !important;">Select option:</h2></div>';


                                                        if(isset($row['PizzaSize']))
                                                        {
                                                            $modal.='<section class="custom-radio-section custom-border-style-bottom" id="dta-category">';
                                                           
                                                            foreach ($row['PizzaSize'] as $pzkey => $pz) {

                                                                $modal.='<div class="custom-radio-input-group selection-category-part">
                                                                          <input data-modal-id="'.$modal_name_pizza.'"  class="pizza-check-category" type="radio" id="control_'.str_replace(' ','_',strtolower($row['id'])).'_'.$pzkey.'" name="'.str_replace(' ','_',strtolower($row['id'])).'" value="'.$pz['id'].'">
                                                                          <label for="control_'.str_replace(' ','_',strtolower($row['id'])).'_'.$pzkey.'" class="custom-radio-input-group-border-bottom">
                                                                            <p style="margin: 0px !important;">'.$pz['name'].'</p>
                                                                          </label>
                                                                        </div>';

                                                            }

                                                           


                                                           $modal.='
                                                                </section>';
                                                        }



                                                       if(isset($row['PizzaFlabour']))
                                                       {

                                                       $modal.='<section class="custom-radio-section custom-border-style-bottom sub-category" id="sub-category_'.$row['id'].'" style="display: none !important;">';


                                                            foreach ($row['PizzaFlabour'] as $pzskey => $psz) {
                                                            $modal.='<div class="custom-radio-input-group selection-subcat-part">
                                                                      <input class="pizza-check-subcat" data-modal-id="'.$modal_name_pizza.'"  type="radio" id="control_'.str_replace(' ','_',strtolower($row['name'])).'_'.$pzskey.'" name="'.str_replace(' ','_',strtolower($row['name'])).'_subcat" value="'.$psz['id'].'">
                                                                      <label for="control_'.str_replace(' ','_',strtolower($row['name'])).'_'.$pzskey.'" class="custom-radio-input-group-border-bottom">
                                                                        <p style="margin: 0px !important;">'.$psz['name'].'</p>
                                                                      </label>
                                                                    </div>';
                                                            }

                                                        }

                                                        $modal.='</section>';


                                                        if(isset($row['pizzaExtra']))
                                                        {
                                                        $modal.='<style type="text/css">
                                                                    .table-under-quantity{ padding-right: 5px; }
                                                                    .table-under-quantity tbody tr td .proDesc a{ font-size:25px; }
                                                                    .table-under-quantity tbody tr td .proDesc{ line-height: 25px; font-size:15px; }
                                                                    .table-under-quantity tbody tr td{ border-bottom:2px #fff solid; }
                                                                    .table-under-quantity tbody tr td{ font-size: 20px !important;  padding-left: 5px; }
                                                                </style>';


                                                        $modal.='<table class="table-under-quantity cat-extra-table" cellpadding="0" cellspacing="0" width="100%">
                                                                    <tbody>';
                                                                        
                                                                    foreach($row['pizzaExtra'] as $indK=>$kr){
                                                                            
                                                                        $modal.='<tr style="">
                                                                                    <td width="60%" style="">
                                                                                        <span class="proName">'.$kr['name'].'</span>
                                                                                        <p class="proDesc classExtraCalculate" style="display: none;" data-extra-name="'.$kr['name'].'">
                                                                                            <a href="javascript:void(0)" class="deductQTYPizza" style="margin-right: 30px;">
                                                                                                <i class="fa fa-minus-circle" aria-hidden="true"></i> 
                                                                                            </a>
                                                                                            <span>0</span> 
                                                                                            <i class="fa fa-times" aria-hidden="true"></i> 
                                                                                            <span>'.$kr['price'].'</span>
                                                                                            =
                                                                                            <span>1</span>
                                                                                        </p>
                                                                                    </td>
                                                                                    <td width="20%"></td>
                                                                                    <td width="20%" align="right">

                                                                                        <div class="prosec">
                                                                                            <p class="proPrice" style="margin-bottom: 5px;"><span>£'.$kr['price'].'</span>
                                                                                                <a href="javascript:void(0);" data-price="'.$kr['price'].'" data-id="'.$kr['id'].'"  data-modal-id="'.$modal_name_pizza.'"  class="proButton add-to-extras"><i class="fa fa-plus"></i></a>
                                                                                            </p>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>';
                                                                            
                                                                        }
                                                                              
                                                            $modal.='</tbody>
                                                                </table>';


                                                                }





                                                    $modal.='</div>';     
                                                               
                                                    $modal.=' <div class="modal-footer" style="padding: 15px;">
                                                                    <button data-id="'.$row['id'].'" data-take="'.$modal_name_pizza.'" type="button" class="btn btn-primary left add-total-pizza-basket"  style="color: white; margin-bottom: 15px !important;">
                                                                        <i class="fa fa-shopping-cart"></i> <b>Skip Extras</b>
                                                                    </button>
                                                                    <span class="right" style="font-weight: 600; font-size: 16px; color: #000;">£<span class="totlabsk">'.$row['price'].'</span></span>
                                                              </div>';                
                                                        

                                                    $modal.='</div>
                                                        </div>
                                                </div>';
                                        }
                                        elseif($interface==4)
                                        {
                                            $modal.='<div class="modal" id="ex_modal-name_'.$row['id'].'">
                                                        <div class="modal-sandbox"></div>
                                                        <div class="modal-box">
                                                            <div class="modal-header">
                                                                <div class="close-modal">&#10006;</div> 
                                                                <h4><i class="fa fa-info-circle"></i> MEAL FOR 2 PERSONS</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                       
                                                                <form action="#" id="reg_form" style="padding-top:7px;">';


                              

                                                            $im=0;
                                                           foreach($row['ProductOneSubLevel'] as $index=>$itm):
                                                           
                                                           $ikm='';
                                                           if(isset($row['ProductOneSubLevel'][$index+1]))
                                                           {
                                                                $ikm=$row['ProductOneSubLevel'][$index+1]['is_parent'];
                                                           }

                                                           if((!empty($ikm) && $ikm!=0 && $ikm!='No Parent') && $im==0)
                                                           {
                                                                $im=1;
                                                                $modal.='<div class="form_popup bgbor" data-m="'.$ikm.'" data-id="'.$itm['is_parent'].'">
                                                                        <div class="back_popup">';
                                                           }
                                                          

                                                           if($im==0)
                                                           {
                                                                $modal.='<div class="form_popup bgbor" data-m="'.$ikm.'" data-id="'.$itm['is_parent'].'">
                                                                        <div class="back_popup">';
                                                           }
                                                           

                                                         
                                                      
                                                           
                                                                
                                                           
                                                           
                                                           
                                                                    $modal.='<div class="cell-4" style="padding-top:12px;">
                                                                                <label>'.$itm['name'].'</label>
                                                                            </div>
                                                                            <div class="cell-8" style="padding-top:7px;">
                                                                                <select required="" title="'.$itm['name'].'" data-id="'.$itm['id'].'">';     
                                                                           foreach($itm['dropdown'] as $index=>$drp):
                                                                                $modal.='<option data-id="'.$index.'" value="'.trim($drp).'">'.trim($drp).'</option>';  
                                                                           endforeach;          
                                                                       $modal.='</select>
                                                                            </div><div class="clearfix"></div>';

                                                               
                                                             if((!empty($ikm) && $ikm!=0 && $ikm!='No Parent') && $im==1)
                                                               {
                                                                    $im=1;
                                                               }
                                                               else
                                                               {
                                                                    $modal.='</div>
                                                                        </div>';
                                                                    $im=0;
                                                               }



                                                            endforeach;        
                                                                    
                                                        $modal.='<div class="form_popup">
                                                                        <a data-id="'.$row['id'].'" href="javascript:void(0);" class="btn executive-set-menu btn-mid main-bg"><i class="fa fa-shopping-cart"></i> Add To Cart</a>
                                                                    </div>                
                                                                </form>

                                                            </div>
                                                        </div>
                                                </div>';
                                        }
                                        elseif($interface==3)
                                        {
                                            $modal.='<div class="modal" id="other_modal_name_'.$row['id'].'">
                                                          <div class="modal-sandbox"></div>
                                                          <div class="modal-box">
                                                            <div class="modal-header">
                                                              <div class="close-modal">&#10006;</div> 
                                                              <h4><i class="fa fa-info-circle"></i> '.$row['name'].'</h4>

                                                          </div>
                                                          <div class="modal-header-details">
                                                            <p align="center">
                                                              <br>
                                                              <b>Please select a option.</b><br>
                                                            </p>   
                                                        </div>
                                                        <div class="modal-body" style="padding-bottom:10px;">';

                                            foreach($row['modal'] as $key=>$mod):
                                                $modal.='       <div class="cell-6">
                                                                   <a data-id="'.$row['id'].'" snd-data-id="'.$mod['id'].'" name="options" id="option_0" class="btn add-snd-cart btn-optionlist"><span class="pull-left">
                                                                            '.$mod['name'].'
                                                                       </span> 
                                                                       <span class="pull-right">
                                                                       £'.$mod['price'].'
                                                                       </span>
                                                                   </a>
                                                                </div>';
                                            endforeach;
                                        $modal.='                
                                                      </div>
                                                  </div>
                                                </div>';
                                        }
                                    }

                                    }
                                    ?>         
                                </tbody>
                            </table>
                            <?php
                        }
                    }
                    ?>
                @endforeach
            @endif

            


            </div>

        </div>
    </div>


    <!--modal start area-->
            <!--modal 1 start here-->
                <style type="text/css" media="screen">
                   .modal-header h4{ margin: 0px !important;  }
                   .form_popup{max-width: 550px; padding: 5px;  font-weight: normal!important;}
                   .form_popup label{font-size: 13px;}
                   .modal-body,.back_popup{  display: block; overflow: hidden;}
                   .bgbor{ background-color: #F9F9F9;border-bottom: 1px dashed #dddddd;padding: 5px 0px 5px 0px; margin-bottom: 5px;}
                   .back_popup select{ width: 50%; margin-top: 0px; margin-bottom: 5px;}

               </style>

               <?php echo $modal;?>

                
            
                
                <!-- Modal 3 End-->
<!--modal end area-->