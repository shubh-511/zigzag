<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Order;
use Exception;
use Session;
use Auth;
use Validator;

class OrderController extends Controller
{  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function orders()
    {
      $orders = Order::OrderBy('id', 'DESC')->paginate(20);
	  return view('admin.orders.list',compact('orders'));
    }

   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view_order($id)
    {
        $order = Order::where('id', $id)->first();
	    return view('admin.orders.view',compact('order'));
    }
    
    public function search_orders()
    {  
        if(!empty($_GET['search']))
          {
                $products=Order::where('id', 'like','%'.$_GET['search'].'%')->orWhere('order_number', 'like','%'.$_GET['search'].'%')->get();
                
          }
          else
          {
              $products=Order::OrderBy('id', 'DESC')->get();
          }
        
          foreach($products as $product)
          {

            echo '<tr>
            <td scope="col">
            <input type="checkbox" class="check_box" name="mul_del[]" id="mul_del[]" value="'.$product->id.'" /></td>
            
            <td>'.$product->order_number.'</td>
                       <td>'.$product->user->name.'</td>
                       <td>'.$product->provider->name.'</td>
                       <td>'.$product->final_order_amount.'</td>
                       <td>'.$product->delivery_charge.'</td>
                                             
                                          
                      <td>';
                     if($product->status!='0') { echo '<span class="label label-success"> Success </span>'; } else { echo '<span class="label label-warning"> Failed </span>'; } 
                     echo '</td>
			
			        <td>';
                     if($product->order_status==1) { echo 'Order placed'; } elseif($product->order_status==2) { echo 'Accepted by driver'; } elseif($product->order_status==3) { echo 'Out for delivery'; } elseif($product->order_status==4) { echo 'Order delivered'; } elseif($product->order_status==5) { echo 'Order cancelled'; } elseif($product->order_status==6) { echo 'Refunded'; } else { echo '--'; }
                     echo '</td>';
    
            
            
			echo '<td><a title="View Profile" href="'.url('admin/service-provider/view-profile',[$product->id]).'"><i class="fa fa-desktop"></i></a>';
            echo '</tr>';
                                         
        }
    }

    
}