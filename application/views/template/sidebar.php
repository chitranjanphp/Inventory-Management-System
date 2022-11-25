	<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php if($this->session->userdata('login_img')!=''){ echo base_url('assets/users/'.$this->session->userdata('login_img'));}else{echo base_url('assets/users/defaultphoto.jpg');} ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $this->session->userdata('login_name'); ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="<?php echo activate_menu('dashboard'); ?>"><a href="<?php echo base_url('dashboard/'); ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
<?php if($this->session->userdata('role')=='Admin'){ ?>
        <li class="treeview  <?php echo activate_dropdown("shops") ?>">
          <a href="javascript:void(0);"><i class="fa fa-th"></i><span>Shops</span>
             <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('shops/'); ?>"><i class="fa fa-plus"></i> Add Shop</a></li>
            <li><a href="<?php echo base_url('shops/shoplist/'); ?>"><i class="fa fa-list"></i> Shop List</a></li>
          </ul>
        </li>
        <li class="treeview  <?php echo activate_dropdown("user") ?>">
          <a href="javascript:void(0);"><i class="fa fa-users"></i><span>Users</span>
             <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('user/'); ?>"><i class="fa fa-plus"></i> Add User</a></li>
            <li><a href="<?php echo base_url('user/userlist/'); ?>"><i class="fa fa-list"></i> User List</a></li>
          </ul>
        </li>
        <li class="treeview <?php echo activate_dropdown("products") ?>">
          <a href="javascript:void(0);">
            <i class="fa fa-share"></i> <span>Products</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('category/'); ?>"><i class="fa fa-circle-o"></i> Category</a></li>
            <li><a href="<?php echo base_url('subcategory/'); ?>"><i class="fa fa-circle-o"></i> Sub Category</a></li>
            <li><a href="<?php echo base_url('units/'); ?>"><i class="fa fa-circle-o"></i> Units</a></li>
            <li><a href="<?php echo base_url('products/'); ?>"><i class="fa fa-circle-o"></i> Products</a></li>
          </ul>
                
        </li>
        <li class="treeview <?php echo activate_dropdown("suppliers") ?>">
          <a href="javascript:void(0);"><i class="fa fa-users"></i><span>Suppliers</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('suppliers/'); ?>"><i class="fa fa-plus"></i> Add Supplier</a></li>
            <li><a href="<?php echo base_url('suppliers/supplierlist/'); ?>"><i class="fa fa-list"></i> Supplier List</a></li>
          </ul>
        </li>
        <li class="treeview <?php echo activate_dropdown("purchase") ?>">
          <a href="javascript:void(0);">
            <i class="fa fa-share"></i> <span>Purchase</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('purchase/'); ?>"><i class="fa fa-circle-o"></i> Purchase Invoice</a></li>
            <li><a href="<?php echo base_url('purchase/invoicelist/'); ?>"><i class="fa fa-circle-o"></i> Invoice List</a></li>
          </ul>
        </li>
        <li class="<?php echo activate_menu('stock_in'); ?>"><a href="<?php echo base_url('stock_in/'); ?>"><i class="fa fa-bitbucket"></i> <span>Stock In</span></a></li>
<?php } ?>       
        <li class="treeview <?php echo activate_dropdown("customers") ?>">
          <a href="javascript:void(0);"><i class="fa fa-users"></i><span>Customers</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('customers/'); ?>"><i class="fa fa-plus"></i> Add Customer</a></li>
            <li><a href="<?php echo base_url('customers/customerlist/'); ?>"><i class="fa fa-list"></i> Customer List</a></li>
          </ul>
        </li>
        <li class="treeview <?php echo activate_dropdown("sale") ?>">
          <a href="javascript:void(0);">
            <i class="fa fa-share"></i> <span>Sales</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('sale/'); ?>"><i class="fa fa-circle-o"></i> Sale Invoice</a></li>
            <li><a href="<?php echo base_url('sale/invoicelist/'); ?>"><i class="fa fa-circle-o"></i> Invoice List</a></li>
          </ul>
        </li>
        <li class="treeview <?php echo activate_dropdown("salesreturn") ?>">
          <a href="javascript:void(0);">
            <i class="fa fa-undo"></i> <span>Sales return</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('salesreturn/'); ?>"><i class="fa fa-circle-o"></i> Return Invoice</a></li>
            <li><a href="<?php echo base_url('salesreturn/returnlist/'); ?>"><i class="fa fa-circle-o"></i> Return List</a></li>
          </ul>
        </li>
        <li class="treeview  <?php echo activate_dropdown("expense") ?>">
          <a href="javascript:void(0);"><i class="fa fa-inr"></i><span>Expenses</span>
             <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('expense/'); ?>"><i class="fa fa-plus"></i> Add Expense</a></li>
            <li><a href="<?php echo base_url('expense/expenselist/'); ?>"><i class="fa fa-list"></i> Expense List</a></li>
          </ul>
        </li>
 <?php if($this->session->userdata('role')=='Admin'){ ?>       
        <li class="treeview  <?php echo activate_dropdown("reports") ?>">
          <a href="javascript:void(0);"><i class="fa fa-th"></i><span>Reports</span>
             <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('reports/'); ?>"><i class="fa fa-list"></i> Purchase Report</a></li>
            <li><a href="<?php echo base_url('reports/purchase_cancel'); ?>"><i class="fa fa-list"></i> Purchase Cancel Report</a></li>
            <li><a href="<?php echo base_url('reports/shop_sale/'); ?>"><i class="fa fa-list"></i> Shop Sale Report</a></li>
            <li><a href="<?php echo base_url('reports/user_sale/'); ?>"><i class="fa fa-list"></i> User Sale Report</a></li>
            <li><a href="<?php echo base_url('reports/customer_sale/'); ?>"><i class="fa fa-list"></i> Customer Sale Report</a></li>
            <li><a href="<?php echo base_url('reports/sales_return'); ?>"><i class="fa fa-list"></i> Sales Return Report</a></li>
            <li><a href="<?php echo base_url('reports/sale_cancel'); ?>"><i class="fa fa-list"></i> Sale Cancel Report</a></li>
            <li><a href="<?php echo base_url('reports/expense'); ?>"><i class="fa fa-list"></i> Expense Report</a></li>
          </ul>
        </li>
 <?php } ?>       
     <?php /*   
        <li>
          <a href="pages/widgets.html">
            <i class="fa fa-th"></i> <span>Widgets</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">new</small>
            </span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-pie-chart"></i>
            <span>Charts</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/charts/chartjs.html"><i class="fa fa-circle-o"></i> ChartJS</a></li>
            <li><a href="pages/charts/morris.html"><i class="fa fa-circle-o"></i> Morris</a></li>
            <li><a href="pages/charts/flot.html"><i class="fa fa-circle-o"></i> Flot</a></li>
            <li><a href="pages/charts/inline.html"><i class="fa fa-circle-o"></i> Inline charts</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-laptop"></i>
            <span>UI Elements</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/UI/general.html"><i class="fa fa-circle-o"></i> General</a></li>
            <li><a href="pages/UI/icons.html"><i class="fa fa-circle-o"></i> Icons</a></li>
            <li><a href="pages/UI/buttons.html"><i class="fa fa-circle-o"></i> Buttons</a></li>
            <li><a href="pages/UI/sliders.html"><i class="fa fa-circle-o"></i> Sliders</a></li>
            <li><a href="pages/UI/timeline.html"><i class="fa fa-circle-o"></i> Timeline</a></li>
            <li><a href="pages/UI/modals.html"><i class="fa fa-circle-o"></i> Modals</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Forms</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/forms/general.html"><i class="fa fa-circle-o"></i> General Elements</a></li>
            <li><a href="pages/forms/advanced.html"><i class="fa fa-circle-o"></i> Advanced Elements</a></li>
            <li><a href="pages/forms/editors.html"><i class="fa fa-circle-o"></i> Editors</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span>Tables</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/tables/simple.html"><i class="fa fa-circle-o"></i> Simple tables</a></li>
            <li><a href="pages/tables/data.html"><i class="fa fa-circle-o"></i> Data tables</a></li>
          </ul>
        </li>
        <li>
          <a href="pages/calendar.html">
            <i class="fa fa-calendar"></i> <span>Calendar</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-red">3</small>
              <small class="label pull-right bg-blue">17</small>
            </span>
          </a>
        </li>
        <li>
          <a href="pages/mailbox/mailbox.html">
            <i class="fa fa-envelope"></i> <span>Mailbox</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-yellow">12</small>
              <small class="label pull-right bg-green">16</small>
              <small class="label pull-right bg-red">5</small>
            </span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-folder"></i> <span>Examples</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/examples/invoice.html"><i class="fa fa-circle-o"></i> Invoice</a></li>
            <li><a href="pages/examples/profile.html"><i class="fa fa-circle-o"></i> Profile</a></li>
            <li><a href="pages/examples/login.html"><i class="fa fa-circle-o"></i> Login</a></li>
            <li><a href="pages/examples/register.html"><i class="fa fa-circle-o"></i> Register</a></li>
            <li><a href="pages/examples/lockscreen.html"><i class="fa fa-circle-o"></i> Lockscreen</a></li>
            <li><a href="pages/examples/404.html"><i class="fa fa-circle-o"></i> 404 Error</a></li>
            <li><a href="pages/examples/500.html"><i class="fa fa-circle-o"></i> 500 Error</a></li>
            <li><a href="pages/examples/blank.html"><i class="fa fa-circle-o"></i> Blank Page</a></li>
            <li><a href="pages/examples/pace.html"><i class="fa fa-circle-o"></i> Pace Page</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-share"></i> <span>Multilevel</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Level One
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                <li class="treeview">
                  <a href="#"><i class="fa fa-circle-o"></i> Level Two
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
          </ul>
        </li>
        <li><a href="https://adminlte.io/docs"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
        <li class="header">LABELS</li>
        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
		
		*/?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  
  
  <!---content wrapper-->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo $title; ?></h1>
      
      <ol class="breadcrumb">
       <?php
			$breadcrumb=$breadcrumb;
			if(!empty($breadcrumb) && is_array($breadcrumb)){
				foreach($breadcrumb as $link=>$crumb){
					if($link=='active'){
						echo '<li class="active">'.$crumb.'</li>';
					}
					else{
						echo '<li><a href="'.base_url($link).'">'.$crumb.'</a></li>';
					}
				}	
			}
		?>
      </ol>
    </section>

  