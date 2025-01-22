<?php

namespace App\Http\Controllers;
use App\Interfaces\TransactionRepositoryInterface;
use App\Interfaces\BoardingHouseRepositoryInterface;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    private TransactionRepositoryInterface $transactionRepository;
    private BoardingHouseRepositoryInterface $boardingHouseRepository;
    public function __construct(TransactionRepositoryInterface $transactionRepository, BoardingHouseRepositoryInterface $boardingHouseRepository)
    {
        $this->transactionRepository = $transactionRepository;
        $this->boardingHouseRepository = $boardingHouseRepository;
    }

    public function booking(Request $request, $slug)
    {
        $this->transactionRepository->saveTransactionDataToSession($request->all());
        return redirect()->route('booking.information', $slug);
    }

    public function check()
    {
        return view('pages.check-booking');
    }

    public function information($slug)
    {
        $transaction = $this->transactionRepository->getTransactionDataFromSession();
        $boardingHouse = $this->boardingHouseRepository->getBoardingHouseByCitySlug($slug);
        $room = $this->boardingHouseRepository->getBoardingHouseByid($transaction['room_id']);

        return view('pages.booking.information', compact('transaction', 'boardingHouse', 'room'));
    }

    public function saveInformation($slug)
    {

    }
}
