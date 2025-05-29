<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;

class BookSeeder extends Seeder
{
    public function run()
    {
        $faker = FakerFactory::create('id_ID');
        $categories = Category::all();

        $sampleBooks = [
            [
                'title' => 'Belajar Laravel dari Dasar',
                'author' => 'Ahmad Programmer',
                'description' => 'Panduan lengkap untuk mempelajari framework Laravel dari dasar hingga advanced. Buku ini cocok untuk pemula yang ingin menguasai web development dengan PHP.',
                'category' => 'Teknologi',
                'pages' => 350,
                'published_year' => 2023,
                'isbn' => '978-602-1234-56-7',
                'is_featured' => true
            ],
            [
                'title' => 'Algoritma dan Struktur Data',
                'author' => 'Dr. Budi Santoso',
                'description' => 'Konsep fundamental algoritma dan struktur data yang penting untuk programming. Dilengkapi dengan contoh implementasi dalam berbagai bahasa pemrograman.',
                'category' => 'Teknologi',
                'pages' => 420,
                'published_year' => 2022,
                'isbn' => '978-602-1234-57-8',
                'is_featured' => false
            ],
            [
                'title' => 'Sejarah Nusantara',
                'author' => 'Prof. Siti Nurhaliza',
                'description' => 'Perjalanan sejarah Indonesia dari masa prasejarah hingga modern. Buku yang komprehensif untuk memahami perjalanan bangsa Indonesia.',
                'category' => 'Sejarah',
                'pages' => 500,
                'published_year' => 2023,
                'isbn' => '978-602-1234-58-9',
                'is_featured' => true
            ],
            [
                'title' => 'Laskar Pelangi Digital',
                'author' => 'Andrea Novelist',
                'description' => 'Novel inspiratif tentang perjuangan anak-anak desa dalam menghadapi era digital. Sebuah karya yang menyentuh hati dan memberikan motivasi.',
                'category' => 'Fiksi',
                'pages' => 280,
                'published_year' => 2023,
                'isbn' => '978-602-1234-59-0',
                'is_featured' => true
            ],
            [
                'title' => 'Fisika Quantum untuk Pemula',
                'author' => 'Dr. Albert Einstein Jr.',
                'description' => 'Penjelasan sederhana tentang konsep fisika quantum yang kompleks. Buku yang tepat untuk memahami dasar-dasar fisika modern.',
                'category' => 'Sains',
                'pages' => 320,
                'published_year' => 2022,
                'isbn' => '978-602-1234-60-6',
                'is_featured' => false
            ],
            [
                'title' => 'Strategi Bisnis Digital',
                'author' => 'Entrepreneur Success',
                'description' => 'Panduan praktis untuk membangun bisnis di era digital. Dari konsep hingga implementasi strategi pemasaran online.',
                'category' => 'Bisnis',
                'pages' => 250,
                'published_year' => 2023,
                'isbn' => '978-602-1234-61-7',
                'is_featured' => true
            ]
        ];

        foreach ($sampleBooks as $bookData) {
            $category = $categories->where('name', $bookData['category'])->first();

            Book::create([
                'title' => $bookData['title'],
                'author' => $bookData['author'],
                'description' => $bookData['description'],
                'category_id' => $category->id,
                'pages' => $bookData['pages'],
                'published_year' => $bookData['published_year'],
                'isbn' => $bookData['isbn'],
                'is_featured' => $bookData['is_featured'],
                'pdf_file' => 'books/sample.pdf', // You need to add a sample PDF file
                'views' => rand(10, 1000),
                'rating' => rand(35, 50) / 10, // 3.5 to 5.0
            ]);
        }

        // Create additional random books
        for ($i = 0; $i < 20; $i++) {
            Book::create([
                'title' => $faker->sentence(3),
                'author' => $faker->name(),
                'description' => $faker->paragraphs(3, true),
                'category_id' => $categories->random()->id,
                'pages' => rand(150, 500),
                'published_year' => rand(2018, 2023),
                'isbn' => $faker->isbn13(),
                'is_featured' => rand(0, 1) == 1,
                'pdf_file' => 'books/sample.pdf',
                'views' => rand(10, 500),
                'rating' => rand(30, 50) / 10,
            ]);
        }
    }
}
