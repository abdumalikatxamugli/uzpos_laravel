<?php

namespace App\Http\Controllers\Dashboard;

use App\Exceptions\WarehouseOutOfProductException;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderItem\BulkStoreRequest;
use App\Http\Requests\Payment\StoreRequest;
use App\Models\CollectionRequest;
use App\Http\Requests\Order\CollectionRequest as CollectionHttpRequest;
use App\Http\Requests\Order\DeliverRequest as DeliveryHttpRequest;
use App\Http\Telegram\Telegram;
use App\Models\DeliveryRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Point;
use App\Models\PointProduct;
use App\Models\Transfer;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders = Order::where('status', $request->status);
        if(auth()->user()->user_role != User::roles['ADMIN']){
            if($request->other_shop!=1){
                $orders = $orders->where('division_id', auth()->user()->division_id);  
            }      
        }
        if($request->other_shop==1){
            $orders = $orders->where('supplying_division_id', auth()->user()->division_id)->where('supplying_division_id', '<>', 'division_id');
        }
        $orders = $orders->orderBy('order_no', 'desc')->paginate(10);
        $collectors = User::where('user_role', User::roles['COLLECTOR'])->where('busy', USER::FREE)->get();
        $delivers = User::where('user_role', User::roles['DELIVERY'])->where('busy', USER::FREE)->get();
        $status_text = Order::getStatusText($request->status);
        return view('dashboard.order.index')->with('orders', $orders)
                                            ->with('collectors', $collectors)
                                            ->with('delivers', $delivers)
                                            ->with('status_text', $status_text)
                                            ->with('status', $request->status)
                                            ->with('other_shop', $request->other_shop);
    }
    /**
     * create new empty order
     */
    public function new(Request $request){
        $order = new Order();
        $order->order_type = $request->type;
        $order->division_id = auth()->user()->division_id;
        $order->supplying_division_id = auth()->user()->division_id;
        $order->created_by_id =  auth()->user()->id;
        $order->save();
        return redirect()->route('dashboard.orders.edit', $order->id);
    }
    /**
     * Save order items
     */
    public function saveItems(BulkStoreRequest $request){
        $items = $request->validated()['items'];
        foreach($items as $item){
            OrderItem::createFromArray($item);
        }
        return redirect()->back();
    }
    /**
     * 
     * Delete order item
     */
    public function deleteItem(OrderItem $orderItem){
        $orderItem->delete();
        return redirect()->back();
    }
    /**
     * Create and Append payment
     */
    public function addPayment(StoreRequest $request){
        $data = $request->validated();
        $data['payed_amount_usd'] = $data['payed_amount'] / ( $data['payed_currency_type'] == Payment::UZS ? $data['payed_currency_rate'] : 1);        
        $data['change_amount_usd'] = $data['change_amount'] / ( $data['change_currency_type'] == Payment::UZS ? $data['change_currency_rate'] : 1 );
        $data['amount'] = $data['payed_amount_usd'] - $data['change_amount_usd'];
        $payment = Payment::createFromArray($data);
        return redirect()->back();
    }
    /**
     * Delete payment
     */
    public function deletePayment(Payment $payment){
        $payment->delete();
        return redirect()->back();
    }
    public function confirm(Order $order){
        try{
            $order->status = 2;
            $last_order = Order::where('status', 2)->orWhere('status', 3)->orderByDesc('created_at')->first();
           
            if($last_order){
                $order_no = $last_order->order_no + 1;
                $esf_no = ( empty($last_order->esf_no) ? 0 : $last_order->esf_no ) + 1;
            }else{
                $order_no = 1;
                $esf_no = 1;
            }
            $order->order_no = $order_no; 
            $order->esf_no = $esf_no;
            $order->save();
        }catch(WarehouseOutOfProductException $e){
    
        }
        return redirect()->back();
    
    }
    public function break(Order $order){
        try{
            $order->status = 3;
            $order->save();
        }catch(Exception $e){
    
        }
        return redirect()->back();
    
    }
    /**
     * get list of shops that have enough items to satisfy the full or part of the order
     */
    public function searchAvailableItems(Order $order){
        $pdo = DB::connection()->getPdo();

        $sql = "select p.name as product_name, 
                                      p.id as product_id,
                                      oi.quantity as order_count, 
                                      COALESCE(pp.quantity, 0) as storehouse_count, 
                                      d.name as match_division, 
                                      d.id as match_division_id,
                                      (oi.quantity - COALESCE(pp.quantity, 0)) as request_quantity, 
                                      pp2.quantity as match_count 
                                      from orders o
                                                join orderitems oi on oi.order_id  = o.id 
                                                join products p on p.id = oi.product_id 
                                                left join pointproducts pp on pp.product_id = oi.product_id and pp.division_id = o.supplying_division_id 
                                                join pointproducts pp2 on pp2.product_id  = oi.product_id and pp2.division_id  <> o.supplying_division_id and pp2.quantity >= ( oi.quantity - COALESCE(pp.quantity, 0) )
                                                join divisions d on d.id = pp2.division_id
                                                where o.id=:order_id
                                                order by oi.product_id asc
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':order_id' => $order->id]);
        $matches = $stmt->fetchAll();
        
        return view('dashboard.order.matches')->with('matches', $matches)
                                              ->with('order', $order);
    }
    /**
     * open transfer request from other shop 
     */
    public function openTransfer(Order $order, Point $point){
        Transfer::createFromOrder($order, $point);
        session()->flash('message', 'Запрос отправлен');
        return redirect()->back();
    }
    /**
     * open transfer request from other shop to satify the needed items partially
     */
    public function openTransferPartial(Request $request, Order $order, Point $point){
        $items = collect( json_decode( $request->input('items') ) );
        Transfer::createFromOrderPartial($order, $point, $items);
        session()->flash('message', 'Запрос отправлен');
        return redirect()->back();
    }
    /**
     * edit order
     */
    public function edit(Order $order)
    {   
        if($order->order_type == 1){
            return view('dashboard.order.edit')->with('order', $order);
        }else{
            return view('dashboard.order.edit_retail_order')->with('order', $order);
        }
    }

    public function assignCollector(Order $order, CollectionHttpRequest $request){
        CollectionRequest::createFromArrayWithUser($request->validated(), auth()->user());
        User::makeBusy($request->input('assigned_id'));
        return redirect()->back();
    }
    public function assignDeliver(Order $order, DeliveryHttpRequest $request){
        DeliveryRequest::createFromArrayWithUser($request->validated(), auth()->user());
        User::makeBusy($request->input('assigned_id'));
        return redirect()->back();
    }
    /**
     * generate esf for order
     */
    public function generateEsf(Order $order){
        return view('dashboard.order.esf')->with('order', $order);
    }
    /**
     * change from point id of order
     */
    public function changeFromPoint(Request $request, Order $order){
        $fromPoint = $request->input('point_id');
        $order->supplying_division_id = $fromPoint;
        $order->save();
        return redirect()->back();
    }
    public function notifyClient(Order $order)
    {
        $client = $order->client;
       
        if($client->chat){
        $telegram = new Telegram();
        $telegram->token = Telegram::CLIENT_BOT_TOKEN;
            $text = $order->getClientOrderDetail();
            $message = [
                'text'=>$text,
                'chat_id'=>$client->chat->chatId
            ];
            $telegram->sendMessage($message); 
        }
        return redirect()->back();
    }
}
