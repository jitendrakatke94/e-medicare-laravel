<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use App\Model\Cart;
use App\Model\CartItems;
use App\Model\LabTest;
use App\Model\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     *
     * @group Cart
     *
     * Create an empty cart
     *
     * @bodyParam type string required MED for medicine cart, LAB for Lab test cart
     *
     * @response 200 {
     *    "cart_id": 1
     *}
     */
    public function createCart(CartRequest $request)
    {
        $data = $request->validated();
        $user_id = NULL;
        if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();
            $user_id = $user->id;
        }
        $cart = Cart::create(
            [
                'user_id' => $user_id,
                'type' => $data['type']
            ]
        );
        return response()->json(['cart_id' => $cart->id], 200);
    }

    /**
     *
     * @group Cart
     *
     * Create cart with a single product
     *
     * @bodyParam item_id integer required id of medicine
     * @bodyParam quantity integer required
     * @bodyParam type string required MED for medicine cart, LAB for Lab test cart
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "item_id": [
     *            "The item id field is required."
     *        ],
     *        "quantity": [
     *            "The quantity field is required."
     *        ]
     *    }
     *}
     * @response 200 {
     *    "id": 1,
     *    "tax": null,
     *    "subtotal": 13000,
     *    "discount": null,
     *    "delivery_charge": null,
     *    "total": null,
     *    "cart_items_count": 1,
     *    "cart_items": [
     *        {
     *            "id": 1,
     *            "cart_id": 1,
     *            "item_id": 11,
     *            "price": 13000,
     *            "quantity": 65,
     *            "details": {
     *                "id": 11,
     *                "category_id": 1,
     *                "sku": "MED0000011",
     *                "composition": "paracet",
     *                "weight": 0.5,
     *                "weight_unit": "mg",
     *                "name": "Crocin",
     *                "manufacturer": "Inc",
     *                "medicine_type": "Tablet",
     *                "drug_type": "Generic",
     *                "qty_per_strip": 10,
     *                "price_per_strip": 200,
     *                "rate_per_unit": 10,
     *                "rx_required": 1,
     *                "short_desc": "Take for fever",
     *                "long_desc": null,
     *                "cart_desc": null,
     *                "image_name": null,
     *                "image_url": null
     *            }
     *        }
     *    ]
     *}
     */
    public function createCartWithSingleproduct(CartRequest $request)
    {
        $data = $request->validated();
        $user_id = NULL;
        if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();
            $user_id = $user->id;
        }
        $cart = Cart::create(
            [
                'user_id' => $user_id,
                'type' => $data['type']
            ]
        );
        if ($cart->type == 'LAB') {
            $product = LabTest::find($data['item_id']);
            $price = $product->price * $data['quantity'];
        } else {
            $product = Medicine::find($data['item_id']);
            $price = $product->price_per_strip * $data['quantity'];
        }

        CartItems::updateOrCreate([
            'cart_id' => $cart->id,
            'item_id' => $data['item_id'],
        ], [
            'cart_id' => $cart->id,
            'item_id' => $data['item_id'],
            'price' => $price,
            'quantity' => $data['quantity'],
            'type' => $cart->type
        ]);

        if ($cart->type == 'MED') {
            $current_cart = Cart::withCount('cart_items')->with('cart_items.medicine')->find($cart->id);
        } else {
            $current_cart = Cart::withCount('cart_items')->with('cart_items.test')->find($cart->id);
        }
        $subtotal = $current_cart->cart_items->sum('price');
        $current_cart->subtotal = $subtotal;
        $current_cart->save();
        return response()->json($current_cart, 200);
    }

    /**
     *
     * @group Cart
     *
     * Add product to cart
     *
     * @queryParam id required integer id of cart
     * @bodyParam item_id integer required id of medicine
     * @bodyParam quantity integer required
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "item_id": [
     *            "The item id field is required."
     *        ],
     *        "quantity": [
     *            "The quantity field is required."
     *        ]
     *    }
     *}
     * @response 200 {
     *    "id": 1,
     *    "tax": null,
     *    "subtotal": 13000,
     *    "discount": null,
     *    "delivery_charge": null,
     *    "total": null,
     *    "cart_items_count": 1,
     *    "cart_items": [
     *        {
     *            "id": 1,
     *            "cart_id": 1,
     *            "item_id": 11,
     *            "price": 13000,
     *            "quantity": 65,
     *            "medicine": {
     *                "id": 11,
     *                "category_id": 1,
     *                "sku": "MED0000011",
     *                "composition": "paracet",
     *                "weight": 0.5,
     *                "weight_unit": "mg",
     *                "name": "Crocin",
     *                "manufacturer": "Inc",
     *                "medicine_type": "Tablet",
     *                "drug_type": "Generic",
     *                "qty_per_strip": 10,
     *                "price_per_strip": 200,
     *                "rate_per_unit": 10,
     *                "rx_required": 1,
     *                "short_desc": "Take for fever",
     *                "long_desc": null,
     *                "cart_desc": null,
     *                "image_name": null,
     *                "image_url": null
     *            }
     *        }
     *    ]
     *}
     * @response 200 {
     *    "id": 58,
     *    "tax": null,
     *    "subtotal": 2406,
     *    "discount": null,
     *    "delivery_charge": null,
     *    "total": null,
     *    "type": "LAB",
     *    "cart_items_count": 1,
     *    "cart_items": [
     *        {
     *            "id": 62,
     *            "cart_id": 58,
     *            "item_id": 2,
     *            "type": "LAB",
     *            "price": 2406,
     *            "quantity": 12,
     *            "test": {
     *                "id": 2,
     *                "name": "Basic Metabolic Panel",
     *                "unique_id": "LAT0000002",
     *                "price": 200.5,
     *                "currency_code": "INR",
     *                "code": "BMP",
     *                "image": null
     *            }
     *        }
     *    ]
     *}
     * @response 404 {
     *    "message": "Cart id not found."
     *}
     */
    public function addProductToCart($id, CartRequest $request)
    {
        try {
            $data = $request->validated();
            $cart = Cart::findOrFail($id);

            if ($cart->type == 'LAB') {
                $product = LabTest::findOrFail($data['item_id']);
                $price = $product->price * $data['quantity'];
            } else {
                $product = Medicine::findOrFail($data['item_id']);
                $price = $product->price_per_strip * $data['quantity'];
            }
            CartItems::updateOrCreate([
                'cart_id' => $cart->id,
                'item_id' => $data['item_id'],
            ], [
                'cart_id' => $cart->id,
                'item_id' => $data['item_id'],
                'price' => $price,
                'quantity' => $data['quantity'],
                'type' => $cart->type
            ]);


            if ($cart->type == 'MED') {
                $current_cart = Cart::withCount('cart_items')->with('cart_items.medicine')->find($id);
            } else {
                $current_cart = Cart::withCount('cart_items')->with('cart_items.test')->find($id);
            }

            $subtotal = $current_cart->cart_items->sum('price');
            $current_cart->subtotal = $subtotal;
            $current_cart->save();
            return response()->json($current_cart, 200);
        } catch (\Exception $e) {
            return new ErrorMessage('Cart id not found.', 404);
        }
    }
    /**
     *
     * @group Cart
     *
     * Update product to cart
     *
     * @queryParam id required integer id of cart
     * @bodyParam cart_item_id integer required id of cart item
     * @bodyParam quantity integer required
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "cart_item_id": [
     *            "The cart item id field is required."
     *        ],
     *        "quantity": [
     *            "The quantity field is required."
     *        ]
     *    }
     *}
     *
     * @response 200 {
     *    "id": 1,
     *    "tax": null,
     *    "subtotal": 13000,
     *    "discount": null,
     *    "delivery_charge": null,
     *    "total": null,
     *    "cart_items_count": 1,
     *    "cart_items": [
     *        {
     *            "id": 1,
     *            "cart_id": 1,
     *            "item_id": 11,
     *            "price": 13000,
     *            "quantity": 65,
     *            "medicine": {
     *                "id": 11,
     *                "category_id": 1,
     *                "sku": "MED0000011",
     *                "composition": "paracet",
     *                "weight": 0.5,
     *                "weight_unit": "mg",
     *                "name": "Crocin",
     *                "manufacturer": "Inc",
     *                "medicine_type": "Tablet",
     *                "drug_type": "Generic",
     *                "qty_per_strip": 10,
     *                "price_per_strip": 200,
     *                "rate_per_unit": 10,
     *                "rx_required": 1,
     *                "short_desc": "Take for fever",
     *                "long_desc": null,
     *                "cart_desc": null,
     *                "image_name": null,
     *                "image_url": null
     *            }
     *        }
     *    ]
     *}
     * @response 200 {
     *    "id": 71,
     *    "tax": null,
     *    "subtotal": 5633,
     *    "discount": null,
     *    "delivery_charge": null,
     *    "total": null,
     *    "type": "LAB",
     *    "cart_items_count": 2,
     *    "cart_items": [
     *        {
     *            "id": 73,
     *            "cart_id": 71,
     *            "item_id": 4,
     *            "type": "LAB",
     *            "price": 3227,
     *            "quantity": 14,
     *            "test": {
     *                "id": 4,
     *                "name": "Lipid Panel",
     *                "unique_id": "LAT0000004",
     *                "price": 230.5,
     *                "currency_code": "INR",
     *                "code": "LP77",
     *                "image": null
     *            }
     *        }
     *    ]
     *}
     * @response 404 {
     *    "message": "Cart id not found."
     *}
     */
    public function updateProductToCart($id, CartRequest $request)
    {
        try {
            $data = $request->validated();
            $cart_items = CartItems::find($data['cart_item_id']);


            if ($cart_items->type == 'LAB') {
                $product = LabTest::find($cart_items->item_id);
                $price = $product->price * $data['quantity'];
            } else {
                $product = Medicine::find($cart_items->item_id);
                $price = $product->price_per_strip * $data['quantity'];
            }

            $cart_items->price = $price;
            $cart_items->quantity = $data['quantity'];
            $cart_items->save();

            if ($cart_items->type == 'MED') {
                $current_cart = Cart::withCount('cart_items')->with('cart_items.medicine')->find($id);
            } else {
                $current_cart = Cart::withCount('cart_items')->with('cart_items.test')->find($id);
            }
            $subtotal = $current_cart->cart_items->sum('price');
            $current_cart->subtotal = $subtotal;
            $current_cart->save();

            return response()->json($current_cart, 200);
        } catch (\Exception $e) {
            return new ErrorMessage('Cart id not found.', 404);
        }
    }
    /**
     *
     * @group Cart
     *
     * Get Cart By Id
     *
     * @queryParam id required integer id of cart
     *
     *
     * @response 200 {
     *    "id": 1,
     *    "tax": null,
     *    "subtotal": 13000,
     *    "discount": null,
     *    "delivery_charge": null,
     *    "total": null,
     *    "cart_items_count": 1,
     *    "cart_items": [
     *        {
     *            "id": 1,
     *            "cart_id": 1,
     *            "item_id": 11,
     *            "price": 13000,
     *            "quantity": 65,
     *            "details": {
     *                "id": 11,
     *                "category_id": 1,
     *                "sku": "MED0000011",
     *                "composition": "paracet",
     *                "weight": 0.5,
     *                "weight_unit": "mg",
     *                "name": "Crocin",
     *                "manufacturer": "Inc",
     *                "medicine_type": "Tablet",
     *                "drug_type": "Generic",
     *                "qty_per_strip": 10,
     *                "price_per_strip": 200,
     *                "rate_per_unit": 10,
     *                "rx_required": 1,
     *                "short_desc": "Take for fever",
     *                "long_desc": null,
     *                "cart_desc": null,
     *                "image_name": null,
     *                "image_url": null
     *            }
     *        }
     *    ]
     *}
     * @response 200 {
     *    "id": 51,
     *    "tax": null,
     *    "subtotal": 6616.5,
     *    "discount": null,
     *    "delivery_charge": null,
     *    "total": null,
     *    "type": "LAB",
     *    "cart_items_count": 1,
     *    "cart_items": [
     *        {
     *            "id": 61,
     *            "cart_id": 51,
     *            "item_id": 2,
     *            "type": "LAB",
     *            "price": 6616.5,
     *            "quantity": 33,
     *            "test": {
     *                "id": 2,
     *                "name": "Basic Metabolic Panel",
     *                "unique_id": "LAT0000002",
     *                "price": 200.5,
     *                "currency_code": "INR",
     *                "code": "BMP",
     *                "image": null
     *            }
     *        }
     *    ]
     *}
     * @response 200 {
     *    "id": 71,
     *    "tax": null,
     *    "subtotal": 5633,
     *    "discount": null,
     *    "delivery_charge": null,
     *    "total": null,
     *    "type": "LAB",
     *    "cart_items_count": 2,
     *    "cart_items": [
     *        {
     *            "id": 73,
     *            "cart_id": 71,
     *            "item_id": 4,
     *            "type": "LAB",
     *            "price": 3227,
     *            "quantity": 14,
     *            "test": {
     *                "id": 4,
     *                "name": "Lipid Panel",
     *                "unique_id": "LAT0000004",
     *                "price": 230.5,
     *                "currency_code": "INR",
     *                "code": "LP77",
     *                "image": null
     *            }
     *        }
     *    ]
     *}
     * @response 404 {
     *    "message": "Cart id not found."
     *}
     */
    public function getCartById($id)
    {
        try {
            $cart = Cart::findOrFail($id);

            if ($cart->type == 'MED') {
                $cart = Cart::withCount('cart_items')->with('cart_items.medicine')->find($id);
            } else {
                $cart = Cart::withCount('cart_items')->with('cart_items.test')->find($id);
            }
            return response()->json($cart, 200);
        } catch (\Exception $e) {
            return new ErrorMessage('Cart id not found.', 404);
        }
    }
    /**
     *
     * @group Cart
     *
     * Remove a item from cart
     *
     * @queryParam id required integer id of cart
     * @queryParam cart_item_id required integer id of cart item
     *
     * @response 200 {
     *    "id": 1,
     *    "tax": null,
     *    "subtotal": 13000,
     *    "discount": null,
     *    "delivery_charge": null,
     *    "total": null,
     *    "cart_items_count": 1,
     *    "cart_items": [
     *        {
     *            "id": 1,
     *            "cart_id": 1,
     *            "item_id": 11,
     *            "price": 13000,
     *            "quantity": 65,
     *            "details": {
     *                "id": 11,
     *                "category_id": 1,
     *                "sku": "MED0000011",
     *                "composition": "paracet",
     *                "weight": 0.5,
     *                "weight_unit": "mg",
     *                "name": "Crocin",
     *                "manufacturer": "Inc",
     *                "medicine_type": "Tablet",
     *                "drug_type": "Generic",
     *                "qty_per_strip": 10,
     *                "price_per_strip": 200,
     *                "rate_per_unit": 10,
     *                "rx_required": 1,
     *                "short_desc": "Take for fever",
     *                "long_desc": null,
     *                "cart_desc": null,
     *                "image_name": null,
     *                "image_url": null
     *            }
     *        }
     *    ]
     *}
     * @response 200 {
     *    "id": 71,
     *    "tax": null,
     *    "subtotal": 2406,
     *    "discount": null,
     *    "delivery_charge": null,
     *    "total": null,
     *    "type": "LAB",
     *    "cart_items_count": 1,
     *    "cart_items": [
     *        {
     *            "id": 74,
     *            "cart_id": 71,
     *            "item_id": 2,
     *            "type": "LAB",
     *            "price": 2406,
     *            "quantity": 12,
     *            "test": {
     *                "id": 2,
     *                "name": "Basic Metabolic Panel",
     *                "unique_id": "LAT0000002",
     *                "price": 200.5,
     *                "currency_code": "INR",
     *                "code": "BMP",
     *                "image": null
     *            }
     *        }
     *    ]
     *}
     * @response 404 {
     *    "message": "Id not found."
     *}
     */
    public function deleteProductFromCart($id, $cart_item_id)
    {
        try {
            $cart = Cart::with('cart_items')->whereHas('cart_items', function ($query) use ($cart_item_id) {
                $query->where('id', $cart_item_id);
            })->findOrFail($id);
            CartItems::destroy($cart_item_id);

            if ($cart->type == 'MED') {
                $current_cart = Cart::withCount('cart_items')->with('cart_items.medicine')->find($id);
            } else {
                $current_cart = Cart::withCount('cart_items')->with('cart_items.test')->find($id);
            }
            $subtotal = $current_cart->cart_items->sum('price');
            $current_cart->subtotal = $subtotal;
            $current_cart->save();
            return response()->json($current_cart, 200);
        } catch (\Exception $e) {
            return new ErrorMessage('Id not found.', 404);
        }
    }
    /**
     *
     * @group Cart
     *
     * Delete cart by id
     *
     * @queryParam id required integer id of cart
     *
     * @response 200 {
     *    "message": "Cart deleted successfully."
     *}
     * @response 404 {
     *    "message": "Cart id not found."
     *}
     */
    public function deleteCartById($id)
    {
        try {
            Cart::findOrFail($id)->destroy($id);
            return new SuccessMessage('Cart deleted successfully.');
        } catch (\Exception $e) {
            return new ErrorMessage('Cart id  not found.', 404);
        }
    }
}
