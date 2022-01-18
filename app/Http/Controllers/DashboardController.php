<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;

class DashboardController extends Controller
{
  public function __construct() {
    $this->middleware('auth');
  }
  public function index(Request $request)
    {
      $cliente = new Cliente;
      return view('dashboard', compact('cliente'));
    }
    //ecommerce
    public function dashboardEcommerce(){
        return view('pages.dashboard-ecommerce');
    }
    // analystic
    public function dashboardAnalytics(){
        return view('pages.dashboard-analytics');
    }
}
