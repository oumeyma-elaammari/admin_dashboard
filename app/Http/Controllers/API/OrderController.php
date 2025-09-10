<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    //  Liste des commandes
    public function index()
    {
        return response()->json(Order::latest()->get());
    }

    // Enregistrer une nouvelle commande
    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string',
            'client_email' => 'required|email',
            'products' => 'required|array',
            'total' => 'required|numeric'
        ]);

        $order = Order::create($request->all());

        return response()->json([
            'message' => 'Commande enregistrée',
            'order' => $order
        ]);
    }
}
