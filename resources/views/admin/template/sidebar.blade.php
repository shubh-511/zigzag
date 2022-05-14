 

<?php //echo '<pre>';print_r($roles);
  $smenus='';
  $m=array();
  $s=array();
  $mains=$subs=array();

if(Session::has('spmenus'))
  {
    $spmenus=Session::get('spmenus');
    
   $m=$spmenus->menu_id;
    $s=$spmenus->child_menu_id;
    $mains=explode(",",$m);
    $subs=explode(",",$s);
    //print_r($mains);

  } 
 
 ?>




 <!-- Left side column. contains the logo and sidebar -->
 <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            @if(Session::has('bu_user_info'))

                            <img src="{!! asset(Session::get('bu_user_info')->user_image)!!}" class="img-circle" alt="User Image" />
                            @else
                            <img src="{{ asset('assets/img/avatar3.png')}}" class="img-circle" alt="User Image" />
                            @endif
                        </div>
                        <div class="pull-left info">
                            <p>Hello,@if(Session::has('bu_user_info'))             
                                            {{ Session::get('bu_user_info')->name}}
                                            @endif</p>

                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    
                    <ul class="sidebar-menu">

                       <!-- <li class="active">
                            <a href="dashboard">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>-->

                       
@if(Session::has('menus'))

@foreach(Session::get('menus') as $main_menu)
        
        @if($main_menu->parent_menu_id==0)
           <?php /* @if(in_array($main_menu->id,$mains))*/?>
          @if(in_array($main_menu->id,$mains) || in_array($main_menu->id,$subs))
         <li class="@if($main_menu->id == 1) active @else treeview @endif">
           <a href="{!! url('admin/'.$main_menu->url) !!}">
            <i class="{{$main_menu->icon}}"></i>
                <span>{{$main_menu->name}}</span>
                <i class="fa fa-angle-left pull-right"></i>
                 </a>


                 <?php /**/?>
            <ul class="treeview-menu">
                @foreach(Session::get('menus') as $sub_menu)
                    @if($sub_menu->parent_menu_id==$main_menu->id) 
                      <?php /*  @if(in_array($sub_menu->id,$subs))*/?>
                      @if(in_array($sub_menu->id,$subs) || in_array($sub_menu->id,$mains)  )
                        <li>
                        <a href="{!! url('admin/'.$sub_menu->url) !!}">{{ $sub_menu->name }}</a>
                        </li>
                       <?php /* @endif */?>
                       @endif
                    @endif
                @endforeach
                                
            </ul>
        </li>
          <?php /*  @endif */?>
          @endif
        @endif
    @endforeach
@endif

</ul>
</section>
                <!-- /.sidebar -->
</aside>

			

			