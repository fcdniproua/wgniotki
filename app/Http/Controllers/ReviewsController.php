<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ReviewsController extends Controller
{
    // Отримання відгуків з Google
    public function getGoogleReviews()
    {
        $apiKey = config('services.google.api_key');
        $placeId = config('services.google.place_id');

        try {
            $response = Http::get("https://maps.googleapis.com/maps/api/place/details/json", [
                'place_id' => $placeId,
                'fields' => 'reviews,rating',
                'key' => $apiKey,
                'language' => 'pl', // Мова відгуків (польська)
                'reviews_no_translations' => true, // Тільки оригінальні відгуки
//                'reviews_sort' => 'newest' // Сортування від найновіших
            ]);

            $data = $response->json();
            if ($data['status'] !== 'OK') {
                return response()->json([
                    'error' => 'Failed to fetch Google reviews',
                    'details' => $data
                ], 400);
            }

            // Отримуємо всі відгуки
            $allReviews = $data['result']['reviews'] ?? [];
            // Фільтруємо тільки оригінальні відгуки (без перекладів)
            $originalReviews = array_filter($allReviews, function($review) {
                return empty($review['translated']);
            });

            // Сортуємо за датою (новіші першими) і обмежуємо 5 відгуками
            usort($originalReviews, function($a, $b) {
                return strtotime($b['time']) - strtotime($a['time']);
            });

//            $latestReviews = array_slice($originalReviews, 0, 5);

            // Форматуємо відповідь
            $formattedReviews = array_map(function($review) {
                return [
                    'text' => $review['text'],
                    'author_name' => $review['author_name'],
                    'author_photo_url' => $review['profile_photo_url'],
                    'author_url' => $review['author_url'],
                    'rating' => $review['rating'],
                    'time' => $review['time'],
                    'relative_time' => $review['relative_time_description']
                ];
            }, $originalReviews);

            return response()->json([
                'rating' => $data['result']['rating'] ?? 0,
                'reviews' => $formattedReviews
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Google API error',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    // Отримання відгуків з Facebook
    public function getFacebookReviews()
    {
        $pageId = config('services.facebook.page_id');
        $accessToken = config('services.facebook.access_token');

        try {
            $response = Http::get("https://graph.facebook.com/v12.0/{$pageId}/ratings", [
                'access_token' => $accessToken,
                'fields' => 'review_text,reviewer,created_time,rating'
            ]);

            $data = $response->json();

            if (isset($data['error'])) {
                return response()->json([
                    'error' => 'Failed to fetch Facebook reviews',
                    'details' => $data
                ], 400);
            }

            $reviews = array_map(function($review) {
                return [
                    'text' => $review['review_text'] ?? '',
                    'author' => $review['reviewer']['name'] ?? 'Anonymous',
                    'date' => $this->formatDate($review['created_time']),
                    'rating' => $review['rating'] ?? 0
                ];
            }, $data['data'] ?? []);

            $averageRating = count($reviews) > 0
                ? array_sum(array_column($reviews, 'rating')) / count($reviews)
                : 0;

            return response()->json([
                'rating' => round($averageRating, 1),
                'reviews' => $reviews
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Facebook API error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function formatDate($dateString)
    {
        try {
            $date = new \DateTime($dateString);
            $now = new \DateTime();
            $diff = $now->diff($date);

            if ($diff->y > 0) return $diff->y . ' lat temu';
            if ($diff->m > 0) return $diff->m . ' miesięcy temu';
            if ($diff->d > 7) return floor($diff->d/7) . ' tygodni temu';
            if ($diff->d > 0) return $diff->d . ' dni temu';
            if ($diff->h > 0) return $diff->h . ' godzin temu';
            if ($diff->i > 0) return $diff->i . ' minut temu';

            return 'przed chwilą';
        } catch (\Exception $e) {
            return $dateString;
        }
    }
}