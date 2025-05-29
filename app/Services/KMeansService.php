<?php
// app/Services/KMeansService.php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Book;
use App\Models\User;
use App\Models\Category;
use App\Models\UserPreference;
use Illuminate\Support\Collection;

class KMeansService
{
     private $k; // Number of clusters
     private $maxIterations;
     private $tolerance;

     public function __construct($k = 3, $maxIterations = 100, $tolerance = 0.001)
     {
          $this->k = $k;
          $this->maxIterations = $maxIterations;
          $this->tolerance = $tolerance;
     }

     /**
      * Generate book recommendations for user based on K-Means clustering
      */
     public function getRecommendations(User $user, $limit = 10)
     {
          // Get user preferences
          $userPreferences = $this->getUserPreferenceVector($user);

          if (empty($userPreferences)) {
               // If no preferences, return popular books
               return Book::orderBy('views', 'desc')
                    ->orderBy('rating', 'desc')
                    ->limit($limit)
                    ->get();
          }

          // Get all users with their preference vectors
          $allUsers = $this->getAllUserPreferenceVectors();

          if (count($allUsers) < $this->k) {
               // Not enough users for clustering, return category-based recommendations
               return $this->getCategoryBasedRecommendations($user, $limit);
          }

          // Perform K-Means clustering
          $clusters = $this->performKMeans($allUsers);

          // Find user's cluster
          $userCluster = $this->findUserCluster($user->id, $clusters);

          // Get recommendations based on cluster
          return $this->getClusterBasedRecommendations($userCluster, $user, $limit);
     }

     /**
      * Get user preference vector
      */
     private function getUserPreferenceVector(User $user)
     {
          $categories = Category::all();
          $preferences = [];

          foreach ($categories as $category) {
               $preference = UserPreference::where('user_id', $user->id)
                    ->where('category_id', $category->id)
                    ->first();

               $preferences[$category->id] = $preference ? $preference->preference_score : 0;
          }

          return $preferences;
     }

     /**
      * Get all users' preference vectors
      */
     private function getAllUserPreferenceVectors()
     {
          $users = User::where('role', 'user')
               ->whereHas('preferences')
               ->get();

          $userVectors = [];

          foreach ($users as $user) {
               $userVectors[$user->id] = $this->getUserPreferenceVector($user);
          }

          return $userVectors;
     }

     /**
      * Perform K-Means clustering
      */
     private function performKMeans($userVectors)
     {
          if (empty($userVectors)) {
               return [];
          }

          $userIds = array_keys($userVectors);
          $dimensions = count(reset($userVectors));

          // Initialize centroids randomly
          $centroids = $this->initializeCentroids($userVectors, $this->k);

          for ($iteration = 0; $iteration < $this->maxIterations; $iteration++) {
               // Assign users to clusters
               $clusters = $this->assignToClusters($userVectors, $centroids);

               // Calculate new centroids
               $newCentroids = $this->calculateCentroids($clusters, $userVectors, $dimensions);

               // Check for convergence
               if ($this->hasConverged($centroids, $newCentroids)) {
                    break;
               }

               $centroids = $newCentroids;
          }

          return $this->assignToClusters($userVectors, $centroids);
     }

     /**
      * Initialize centroids randomly
      */
     private function initializeCentroids($userVectors, $k)
     {
          $centroids = [];
          $userIds = array_keys($userVectors);
          $dimensions = count(reset($userVectors));

          // Use K-Means++ initialization for better results
          $randomUserId = $userIds[array_rand($userIds)];
          $centroids[0] = $userVectors[$randomUserId];

          for ($i = 1; $i < $k; $i++) {
               $distances = [];

               foreach ($userIds as $userId) {
                    $minDistance = PHP_FLOAT_MAX;

                    for ($j = 0; $j < $i; $j++) {
                         $distance = $this->euclideanDistance($userVectors[$userId], $centroids[$j]);
                         $minDistance = min($minDistance, $distance);
                    }

                    $distances[$userId] = $minDistance * $minDistance;
               }

               // Select next centroid based on weighted probability
               $totalDistance = array_sum($distances);
               $random = mt_rand() / mt_getrandmax() * $totalDistance;
               $sum = 0;

               foreach ($distances as $userId => $distance) {
                    $sum += $distance;
                    if ($sum >= $random) {
                         $centroids[$i] = $userVectors[$userId];
                         break;
                    }
               }
          }

          return $centroids;
     }

     /**
      * Assign users to clusters
      */
     private function assignToClusters($userVectors, $centroids)
     {
          $clusters = array_fill(0, count($centroids), []);

          foreach ($userVectors as $userId => $vector) {
               $minDistance = PHP_FLOAT_MAX;
               $assignedCluster = 0;

               foreach ($centroids as $clusterIndex => $centroid) {
                    $distance = $this->euclideanDistance($vector, $centroid);

                    if ($distance < $minDistance) {
                         $minDistance = $distance;
                         $assignedCluster = $clusterIndex;
                    }
               }

               $clusters[$assignedCluster][] = $userId;
          }

          return $clusters;
     }

     /**
      * Calculate new centroids
      */
     private function calculateCentroids($clusters, $userVectors, $dimensions)
     {
          $centroids = [];

          foreach ($clusters as $clusterIndex => $userIds) {
               if (empty($userIds)) {
                    // Keep old centroid if cluster is empty
                    $centroids[$clusterIndex] = array_fill(0, $dimensions, 0);
                    continue;
               }

               $centroid = array_fill(0, $dimensions, 0);
               $categoryIds = array_keys(reset($userVectors));

               foreach ($categoryIds as $index => $categoryId) {
                    $sum = 0;
                    foreach ($userIds as $userId) {
                         $sum += $userVectors[$userId][$categoryId];
                    }
                    $centroid[$categoryId] = $sum / count($userIds);
               }

               $centroids[$clusterIndex] = $centroid;
          }

          return $centroids;
     }

     /**
      * Check if centroids have converged
      */
     private function hasConverged($oldCentroids, $newCentroids)
     {
          foreach ($oldCentroids as $index => $oldCentroid) {
               if (!isset($newCentroids[$index])) {
                    return false;
               }

               $distance = $this->euclideanDistance($oldCentroid, $newCentroids[$index]);
               if ($distance > $this->tolerance) {
                    return false;
               }
          }

          return true;
     }

     /**
      * Calculate Euclidean distance between two vectors
      */
     private function euclideanDistance($vector1, $vector2)
     {
          $sum = 0;

          foreach ($vector1 as $key => $value) {
               $diff = $value - ($vector2[$key] ?? 0);
               $sum += $diff * $diff;
          }

          return sqrt($sum);
     }

     /**
      * Find which cluster the user belongs to
      */
     private function findUserCluster($userId, $clusters)
     {
          foreach ($clusters as $clusterIndex => $userIds) {
               if (in_array($userId, $userIds)) {
                    return $clusterIndex;
               }
          }

          return 0; // Default to first cluster
     }

     /**
      * Get recommendations based on cluster
      */
     private function getClusterBasedRecommendations($clusterIndex, User $user, $limit)
     {
          // Get books that users in the same cluster have read/bookmarked
          $clusterUserIds = $this->getClusterUserIds($clusterIndex);
          $userReadBooks = $user->readingHistories()->pluck('book_id')->toArray();

          $recommendedBooks = Book::whereHas('readingHistories', function ($query) use ($clusterUserIds) {
               $query->whereIn('user_id', $clusterUserIds);
          })
               ->whereNotIn('id', $userReadBooks)
               ->orderBy('rating', 'desc')
               ->orderBy('views', 'desc')
               ->limit($limit)
               ->get();

          // If not enough recommendations, fall back to category-based
          if ($recommendedBooks->count() < $limit) {
               $categoryRecommendations = $this->getCategoryBasedRecommendations($user, $limit - $recommendedBooks->count());
               $recommendedBooks = $recommendedBooks->merge($categoryRecommendations);
          }

          return $recommendedBooks;
     }

     /**
      * Get category-based recommendations
      */
     private function getCategoryBasedRecommendations(User $user, $limit)
     {
          $userPreferences = $user->preferences()
               ->orderBy('preference_score', 'desc')
               ->limit(3)
               ->get();

          if ($userPreferences->isEmpty()) {
               return Book::orderBy('views', 'desc')
                    ->orderBy('rating', 'desc')
                    ->limit($limit)
                    ->get();
          }

          $categoryIds = $userPreferences->pluck('category_id')->toArray();
          $userReadBooks = $user->readingHistories()->pluck('book_id')->toArray();

          return Book::whereIn('category_id', $categoryIds)
               ->whereNotIn('id', $userReadBooks)
               ->orderBy('rating', 'desc')
               ->orderBy('views', 'desc')
               ->limit($limit)
               ->get();
     }

     /**
      * Get user IDs in a specific cluster
      */
     private function getClusterUserIds($clusterIndex)
     {
          // This would need to be stored or recalculated
          // For now, return similar users based on preferences
          return User::where('role', 'user')
               ->whereHas('preferences')
               ->pluck('id')
               ->toArray();
     }

     /**
      * Update user preferences based on interaction
      */
     public function updateUserPreferences(User $user, Book $book, $interactionType = 'view')
     {
          $scoreIncrement = match ($interactionType) {
               'bookmark' => 3,
               'read' => 2,
               'view' => 1,
               default => 1
          };

          UserPreference::updateOrCreate(
               [
                    'user_id' => $user->id,
                    'category_id' => $book->category_id,
               ],
               [
                    'preference_score' => DB::raw("preference_score + {$scoreIncrement}")
               ]
          );
     }
}
