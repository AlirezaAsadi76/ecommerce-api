<?php

namespace App\Http\Controllers;

use App\Contracts\CartContract;
use App\Http\Resources\CartCollection;
use App\Models\User;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use ApiResponseHelpers;

    private CartContract $cartRepository;
    private  $user; //Authentication
    public function __construct(CartContract $cartRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->user = auth()->user();
    }

    public function index()
    {

        $carts = $this->cartRepository->findCartByUser($this->user->id);
        if (!$carts){
            return $this->respondWithSuccess([]);
        }
        return $this->respondWithSuccess(new CartCollection($carts));
    }
}
