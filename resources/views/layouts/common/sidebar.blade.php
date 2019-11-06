
<?php

    if(Auth::guard('admin')->check()){
        $permission = json_decode(Auth::guard('admin')->user()->permission,true);
        $location = Auth::guard('admin')->user()->location;
        $name = Auth::guard('admin')->user()->reg_personname;
        $file = Auth::guard('admin')->user()->upload_logo;
        $logo = "cat_images/admin.jpg";
        $role = 1;
		//echo "admin";
		//exit;
    }
    elseif(Auth::guard('web')->check()){
        $permission = json_decode(Auth::guard('web')->user()->permission,true);
        $role = 1;
        $logo = "cat_images/super_admin.png";
        $name="iPing";
    }
    elseif(Auth::guard('dealer')->check()){
        $permission = json_decode(Auth::guard('dealer')->user()->permission,true);
        $role = 4;
        $logo = "dist/img/logo.png";
        $name = Auth::guard('dealer')->user()->name;
    }
    else if(Auth::guard('employee')->check()){
        $id = Auth::guard('employee')->user()->cid;
        $client = \App\Admin::select('permission','upload_logo')->where(['rid'=>$id])->first();
        $location = Auth::guard('employee')->user()->lid;
        $logo = "cat_images/employee.png";
        $role = Auth::guard('employee')->user()->role;
        $name = Auth::guard('employee')->user()->name;
        $permission = json_decode($client->permission,true);
    }

//    echo "<pre>";print_r($permission);exit;
?><!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="image" style="text-align: center;">
          <img src="<?php if($logo != "") echo $logo; else echo "dist/img/logo.png"; ?>" class="" alt="User Image">
        </div>
        <div class="pull-left info">
            <p style="text-align:center;">{{$name}}</p>
        </div>
      </div>
      <ul class="sidebar-menu" data-widget="tree">
        <li class="active">
        @if(Auth::guard('admin')->check())
            <a href="{{url('home-admin')}}">
        @elseif(Auth::guard('web')->check())
            <a href="{{url('home')}}">
        @elseif(Auth::guard('employee')->check())
               <a href="{{url('employee-home')}}">
        @elseif(Auth::guard('dealer')->check())
               <a href="{{url('dealer-home')}}">
        @endif
            <i class="fa fa-dashboard"></i> <span>Home</span>
          </a>

        </li>
        @if(Auth::guard('dealer')->check())
            <li <?php if(Request::is('dealer-clients')) { ?>class="active" <?php } ?>>
                <a href="{{url('dealer-clients')}}">
                    <i class="fa fa-user"></i>Clients
                </a>
            </li>
        @endif

        <!--Super Admin -->
        @if(Auth::guard('web')->check())
        <li <?php if(Request::is('dealer_data')) { ?>class="active" <?php } ?>>
            <a href="{{url('dealer_data')}}">
                <i class="fa fa-user"></i>Dealer Registration
            </a>
        </li>
        <li <?php if(Request::is('machine_data')) { ?>class="active" <?php } ?>>
            <a href="{{url('machine_data')}}">
                <i class="fa fa-user"></i>Machine Tracking
            </a>
        </li>
        <li <?php if(Request::is('client_data')) { ?>class="active" <?php } ?>>
           <a href="{{url('client_data')}}">
               <i class="fa fa-user"></i>Client Data
           </a>
       </li>
       @endif

<!--       Single location admin-->
        @if(Auth::guard('admin')->check())
         <?php if(in_array(1,$permission) && $role == 1) { ?>
        <?php if($location=="single") { ?>
       <li class="treeview <?php if(Request::is('item_data') || Request::is('cust_data') || Request::is('inventory') || Request::is('active-inactive')){ ?> menu-open <?php } ?>">
          <a href="#">
            <i class="fa fa-list"></i> <span>MasterData</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
           <ul class="treeview-menu" <?php if(Request::is('type_data') || Request::is('category_data') 
                     || Request::is('item_data') || Request::is('customer_data') || Request::is('supplier_data')){ ?> style="display:block" <?php } ?>>
           <li <?php if(Request::is('category_data')) { ?>class="active" <?php } ?>><a href="{{url('category_data')}}"><i class="fa fa-circle-o"></i>Category</a></li>
           <li <?php if(Request::is('type_data')) { ?>class="active" <?php } ?>><a href="{{url('type_data')}}"><i class="fa fa-circle-o"></i>Units</a></li>
           <li <?php if(Request::is('item_data')) { ?>class="active" <?php } ?>><a href="{{url('item_data')}}"><i class="fa fa-circle-o"></i>Item</a></li>
           <li <?php if(Request::is('customer_data')) { ?>class="active" <?php } ?>><a href="{{url('customer_data')}}"><i class="fa fa-circle-o"></i>Customer</a></li>
           <li <?php if(Request::is('supplier_data')) { ?>class="active" <?php } ?>><a href="{{url('supplier_data')}}"><i class="fa fa-circle-o"></i>Supplier</a></li>
           </ul>
           </li>
                <li class="treeview">
         <a href="#">
           <i class="fa fa-list"></i> <span>Purchase</span>
           <span class="pull-right-container">
             <i class="fa fa-angle-left pull-right"></i>
           </span>
         </a>
         <ul class="treeview-menu" <?php if(Request::is('inventory')) {?> style="display:block" <?php } ?>>
           <li <?php if(Request::is('inventory')) { ?>class="active" <?php } ?>><a href="{{url('inventory')}}"><i class="fa fa-circle-o"></i>Inventory /Stock</a></li>
         </ul>
       </li>
        <li <?php if(Request::is('user-list')) { ?>class="active" <?php } ?>>
            <a href="{{url('user-list')}}">
                <i class="fa fa-user"></i>Users
            </a>
        </li>
       <li class="treeview">
           <a href="#">
            <i class="fa fa-list"></i> <span>Sales</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
             <ul class="treeview-menu">
                <li><a href="{{url('thumbnail')}}"><i class="fa fa-circle-o"></i>Thumbnail Wise</a></li>
         </ul>
        </li>
         <li class="treeview">
           <a href="#">
            <i class="fa fa-list"></i> <span>Settings</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
            <ul class="treeview-menu" <?php if(Request::is('settings')) {?> style="display:block" <?php } ?>>
                <li class="treeview">
                    <a href="#">
                     <i class="fa fa-list"></i> <span>Print Settings</span>
                     <span class="pull-right-container">
                       <i class="fa fa-angle-left pull-right"></i>
                     </span>
                    </a>
                     <ul class="treeview-menu" <?php if(Request::is('settings')) {?> style="display:block" <?php } ?>>
                         <li <?php if(Request::is('settings')) { ?>class="active" <?php } ?>>
                             <a href="{{url('settings')}}"><i class="fa fa-circle-o"></i>Header Footer Settings</a>
                             <a href="{{url('main-setting')}}"><i class="fa fa-circle-o"></i>Main Settings</a></li>
                     </ul>
                </li>
            </ul>
        </li>
        <li class="treeview">
           <a href="#">
            <i class="fa fa-list"></i> <span>Reports</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
             <ul class="treeview-menu" <?php if(Request::is('sale_report') || Request::is('inventory_report') || Request::is('item_report') || Request::is('item_sale_report')) {?> style="display:block" <?php } ?>>
                <li <?php if(Request::is('sale_report')) { ?>class="active" <?php } ?>><a href="{{url('sale_report')}}"><i class="fa fa-circle-o"></i>Sales Bill Report</a></li>
                <li <?php if(Request::is('inventory_report')) { ?>class="active" <?php } ?>><a href="{{url('inventory_report')}}"><i class="fa fa-circle-o"></i>Inventory Report</a></li>
                <li <?php if(Request::is('item_report')) { ?>class="active" <?php } ?>><a href="{{url('item_report')}}"><i class="fa fa-circle-o"></i>Stock Report</a></li>
                <li <?php if(Request::is('item_sale_report')) { ?>class="active" <?php } ?>><a href="{{url('item_sale_report')}}"><i class="fa fa-circle-o"></i>Item Sales Report</a></li>
         </ul>
        </li>
        <?php } else if($location=="multiple"){ 
            //multilocation admin?>
        <li class="treeview <?php if(Request::is('bil_location_list') || Request::is('user-list')){ ?> menu-open <?php } ?>">
          <a href="#">
            <i class="fa fa-list"></i> <span>MasterData</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
           <ul class="treeview-menu" <?php if(Request::is('bil_location_list') ){ ?> style="display:block" <?php } ?>>
           <li <?php if(Request::is('bil_location_list')) { ?>class="active" <?php } ?>><a href="{{url('bil_location_list')}}"><i class="fa fa-circle-o"></i>Location</a></li>
           </ul>
           </li>
                   <li <?php if(Request::is('user-list')) { ?>class="active" <?php } ?>>
            <a href="{{url('user-list')}}">
                <i class="fa fa-user"></i>Users
            </a>
        </li>
                <li class="treeview">
           <a href="#">
            <i class="fa fa-list"></i> <span>Reports</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
             <ul class="treeview-menu" <?php if(Request::is('sale_report') || Request::is('inventory_report') || Request::is('item_report') || Request::is('item_sale_report')) {?> style="display:block" <?php } ?>>
                <li <?php if(Request::is('sale_report')) { ?>class="active" <?php } ?>><a href="{{url('sale_report')}}"><i class="fa fa-circle-o"></i>Sales Bill Report</a></li>
                <li <?php if(Request::is('inventory_report')) { ?>class="active" <?php } ?>><a href="{{url('inventory_report')}}"><i class="fa fa-circle-o"></i>Inventory Report</a></li>
                <li <?php if(Request::is('item_report')) { ?>class="active" <?php } ?>><a href="{{url('item_report')}}"><i class="fa fa-circle-o"></i>Stock Report</a></li>
                <li <?php if(Request::is('item_sale_report')) { ?>class="active" <?php } ?>><a href="{{url('item_sale_report')}}"><i class="fa fa-circle-o"></i>Item Sales Report</a></li>
         </ul>
        </li>
        <?php } ?>
         <?php } ?>
        @endif
        <!--employee-->
        @if(Auth::guard('employee')->check())
         <?php if(in_array(1,$permission)) { ?>
       <li class="treeview <?php if(Request::is('item_data') || Request::is('cust_data') || Request::is('inventory') || Request::is('active-inactive')){ ?> menu-open <?php } ?>">
          <a href="#">
            <i class="fa fa-list"></i> <span>MasterData</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
           <ul class="treeview-menu" <?php if(Request::is('type_data') || Request::is('category_data') 
                     || Request::is('item_data') || Request::is('customer_data') || Request::is('supplier_data')){ ?> style="display:block" <?php } ?>>
           <li <?php if(Request::is('category_data')) { ?>class="active" <?php } ?>><a href="{{url('category_data')}}"><i class="fa fa-circle-o"></i>Category</a></li>
           <li <?php if(Request::is('type_data')) { ?>class="active" <?php } ?>><a href="{{url('type_data')}}"><i class="fa fa-circle-o"></i>Units</a></li>
           <li <?php if(Request::is('item_data')) { ?>class="active" <?php } ?>><a href="{{url('item_data')}}"><i class="fa fa-circle-o"></i>Item</a></li>
           <li <?php if(Request::is('customer_data')) { ?>class="active" <?php } ?>><a href="{{url('customer_data')}}"><i class="fa fa-circle-o"></i>Customer</a></li>
           <li <?php if(Request::is('supplier_data')) { ?>class="active" <?php } ?>><a href="{{url('supplier_data')}}"><i class="fa fa-circle-o"></i>Supplier</a></li>
           </ul>
           </li>
           <?php 
           if($role==1){
           ?>
           <li <?php if(Request::is('user-list')) { ?>class="active" <?php } ?>>
            <a href="{{url('user-list')}}">
                <i class="fa fa-user"></i>Users
            </a>
        </li>
           <?php } ?>
                <li class="treeview">
         <a href="#">
           <i class="fa fa-list"></i> <span>Purchase</span>
           <span class="pull-right-container">
             <i class="fa fa-angle-left pull-right"></i>
           </span>
         </a>
         <ul class="treeview-menu" <?php if(Request::is('inventory')) {?> style="display:block" <?php } ?>>
           <li <?php if(Request::is('inventory')) { ?>class="active" <?php } ?>><a href="{{url('inventory')}}"><i class="fa fa-circle-o"></i>Inventory /Stock</a></li>
         </ul>
       </li>
       <li class="treeview">
           <a href="#">
            <i class="fa fa-list"></i> <span>Sales</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
             <ul class="treeview-menu">
                <li><a href="{{url('thumbnail')}}"><i class="fa fa-circle-o"></i>Thumbnail Wise</a></li>
         </ul>
        </li>
         <li class="treeview">
           <a href="#">
            <i class="fa fa-list"></i> <span>Settings</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
            <ul class="treeview-menu" <?php if(Request::is('settings')) {?> style="display:block" <?php } ?>>
                <li class="treeview">
                    <a href="#">
                     <i class="fa fa-list"></i> <span>Print Settings</span>
                     <span class="pull-right-container">
                       <i class="fa fa-angle-left pull-right"></i>
                     </span>
                    </a>
                     <ul class="treeview-menu" <?php if(Request::is('settings')) {?> style="display:block" <?php } ?>>
                         <li <?php if(Request::is('settings')) { ?>class="active" <?php } ?>>
                             <a href="{{url('settings')}}"><i class="fa fa-circle-o"></i>Header Footer Settings</a>
                             <a href="{{url('main-setting')}}"><i class="fa fa-circle-o"></i>Main Settings</a></li>
                     </ul>
                </li>
            </ul>
        </li>
        <li class="treeview">
           <a href="#">
            <i class="fa fa-list"></i> <span>Reports</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
             <ul class="treeview-menu" <?php if(Request::is('sale_report') || Request::is('inventory_report') || Request::is('item_report') || Request::is('item_sale_report')) {?> style="display:block" <?php } ?>>
                <li <?php if(Request::is('sale_report')) { ?>class="active" <?php } ?>><a href="{{url('sale_report')}}"><i class="fa fa-circle-o"></i>Sales Bill Report</a></li>
                <li <?php if(Request::is('inventory_report')) { ?>class="active" <?php } ?>><a href="{{url('inventory_report')}}"><i class="fa fa-circle-o"></i>Inventory Report</a></li>
                <li <?php if(Request::is('item_report')) { ?>class="active" <?php } ?>><a href="{{url('item_report')}}"><i class="fa fa-circle-o"></i>Stock Report</a></li>
                <li <?php if(Request::is('item_sale_report')) { ?>class="active" <?php } ?>><a href="{{url('item_sale_report')}}"><i class="fa fa-circle-o"></i>Item Sales Report</a></li>
         </ul>
        </li>
        
        <?php } ?>
        @endif


      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>