<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CartController extends Controller
{
    private $redis;
    private const CART_PREFIX = 'cart:';
    private const CART_EXPIRY = 86400; 

    public function __construct()
    {
        $this->redis = Redis::connection();
    }

    private function getCartKey()
    {
        // Using a simple fixed cart key since we don't have authentication
        return self::CART_PREFIX . 'default';
    }

    public function index()
    {
        $cartKey = $this->getCartKey();
        $cart = $this->redis->hgetall($cartKey);
        
        if (empty($cart)) {
            return response()->json([
                'items' => [],
                'total' => 0
            ]);
        }

        $items = [];
        $total = 0;
        
        foreach ($cart as $productId => $data) {
            $itemData = json_decode($data, true);
            $items[] = $itemData;
            $total += $itemData['price'] * $itemData['quantity'];
        }

        return response()->json([
            'items' => $items,
            'total' => $total
        ]);
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        $cartKey = $this->getCartKey();

         // Check if the product already exists in cart
    $existingItem = $this->redis->hget($cartKey, $request->product_id);
    
    if ($existingItem) {
        // If product exists, update the quantity
        $existingData = json_decode($existingItem, true);
        $itemData = [
            'product_id' => $request->product_id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $existingData['quantity'] + $request->quantity,
            'display_image' => $product->display_image
        ];
    }else{


        $itemData = [
            'product_id' => $request->product_id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $request->quantity,
            'display_image'=>$product->display_image
        ];

    }
        
      

        $this->redis->hset(
            $cartKey,
            $request->product_id,
            json_encode($itemData)
        );
        
        $this->redis->expire($cartKey, self::CART_EXPIRY);

        return response()->json([
            'message' => 'Item added to cart',
            'item' => $itemData
        ]);
    }

  

    public function removeFromCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer'
        ]);

        $cartKey = $this->getCartKey();
        $this->redis->hdel($cartKey, $request->product_id);

        return response()->json([
            'message' => 'Item removed from cart'
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|string',
            'total_price' => 'required|numeric|min:0'
        ]);

        $order = Order::create([
            'items' => $request->items,
            'total_price' => $request->total_price,
            'status' => 'ordered'
        ]);

        $cartKey = $this->getCartKey();

        $this->redis->del($cartKey);

        return response()->json([
            'message' => 'Order placed successfully',
            'order' => $order
        ]);
    }

}
