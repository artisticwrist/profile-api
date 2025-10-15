<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{

    //my profile data
    private function getUserProfileData(): array {
        return [
            'email' => 'contactdev.bigjoe@gmail.com',
            'name' => 'George, Joseph Emmanuel',
            'stack' => 'laravel, php, mysql, javascript, git, postman',
        ];
    }



    //timestamp
    private function getCurrentUtcTimestamp(): string {
        return (new \DateTime('now', new \DateTimeZone('UTC')))->format(\DateTime::ATOM);
    }


    //cat fact api
    private function fetchCatFact(): string {
        try {
            Log::info('Fetching cat fact from api');
            $response = Http::timeout(30)->get('https://catfact.ninja/fact');
            $response->throw();
            $factData = $response->json();
            $fact = $factData['fact'] ?? 'No cat fact found.';
            Log::info('Successfully fetched cat fact.', ['fact' => $fact]);
            return $fact;
        } catch (RequestException $e) {
            Log::error('Failed to fetch cat fact.', ['error' => $e->getMessage()]);
            throw $e;
        }
    }


    
    public function myProfile(Request $request) {
        $user = $this->getUserProfileData();
        $timestamp = $this->getCurrentUtcTimestamp();

        try {
            $fact = $this->fetchCatFact();
        } catch (RequestException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch cat fact from api.',
                'error' => $e->getMessage(),
            ], 503);
        }

        return response()->json([
            'status' => true,
            'user' => $user,
            'timestamp' => $timestamp,
            'fact' => $fact,
        ], 200);
    }


}
