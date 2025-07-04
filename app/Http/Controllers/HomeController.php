<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get services from database, fallback to static data if none exist
        $dbServices = Service::where('is_active', true)->get();
        
        if ($dbServices->count() > 0) {
            $services = $dbServices->map(function($service) {
                return [
                    'id' => $service->id,
                    'name' => $service->name,
                    'image' => 'sneaker.png', // Default image, you can add image field to services table
                    'detail' => $service->description,
                    'price' => 'Rp ' . number_format($service->price, 0, ',', '.'),
                    'price_numeric' => $service->price
                ];
            })->toArray();
        } else {
            // Fallback static data
            $services = [
                [
                    'name' => 'Sepatu Sneakers',
                    'image' => 'sneaker.png',
                    'detail' => 'Fast & Deep clean',
                    'price' => 'Rp 55.000',
                    'price_numeric' => 55000
                ],
                [
                    'name' => 'Sepatu Canvas',
                    'image' => 'canvas.png',
                    'detail' => 'Fast & Deep clean',
                    'price' => 'Rp 60.000',
                    'price_numeric' => 60000
                ],
                [
                    'name' => 'Sepatu Suede',
                    'image' => 'suede.png',
                    'detail' => 'Fast & Deep clean',
                    'price' => 'Rp 65.000',
                    'price_numeric' => 65000
                ],
                [
                    'name' => 'Sepatu Leather',
                    'image' => 'leather.png',
                    'detail' => 'Fast & Deep clean',
                    'price' => 'Rp 65.000',
                    'price_numeric' => 65000
                ],
                [
                    'name' => 'Sepatu Kets',
                    'image' => 'kets.png',
                    'detail' => 'Fast & Deep clean',
                    'price' => 'Rp 55.000',
                    'price_numeric' => 55000
                ],
                [
                    'name' => 'Sepatu Bola',
                    'image' => 'bola.png',
                    'detail' => 'Fast & Deep clean',
                    'price' => 'Rp 50.000',
                    'price_numeric' => 50000
                ]
            ];
        }

        return view('home', compact('services'));
    }
}
