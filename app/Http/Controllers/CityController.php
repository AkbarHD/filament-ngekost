<?php

namespace App\Http\Controllers;

use App\Interfaces\BoardingHouseRepositoryInterface;
use App\Interfaces\CityRepositoryInterface;
use Illuminate\Http\Request;

class CityController extends Controller
{
    private CityRepositoryInterface $cityRepositoryInterface;
    private BoardingHouseRepositoryInterface $boardingHouseRepositoryInterface;

    public function __construct(CityRepositoryInterface $cityRepositoryInterface, BoardingHouseRepositoryInterface $boardingHouseRepositoryInterface)
    {
        $this->cityRepositoryInterface = $cityRepositoryInterface;
        $this->boardingHouseRepositoryInterface = $boardingHouseRepositoryInterface;
    }

    public function show($slug)
    {
        $boardingHouses = $this->boardingHouseRepositoryInterface->getBoardingHouseByCitySlug($slug);
        $city = $this->cityRepositoryInterface->getCityBySlug($slug);
        return view('pages.city.show', compact('boardingHouses', 'city'));
    }
}
