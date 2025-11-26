<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            [
                'category_id' => 1,
                'judul' => 'Laskar Pelangi',
                'pengarang' => 'Andrea Hirata',
                'penerbit' => 'Bentang Pustaka',
                'tahun_terbit' => 2005,
                'sinopsis' => 'Novel tentang perjuangan anak-anak di Belitung untuk mendapatkan pendidikan yang layak.',
                'harga' => 85000,
                'stok' => 50,
                'isbn' => '9789793062792',
            ],
            [
                'category_id' => 1,
                'judul' => 'Bumi Manusia',
                'pengarang' => 'Pramoedya Ananta Toer',
                'penerbit' => 'Hasta Mitra',
                'tahun_terbit' => 1980,
                'sinopsis' => 'Novel sejarah yang mengisahkan perjalanan Minke dalam menghadapi kolonialisme Belanda.',
                'harga' => 95000,
                'stok' => 30,
                'isbn' => '9789799731234',
            ],
            [
                'category_id' => 4,
                'judul' => 'Clean Code',
                'pengarang' => 'Robert C. Martin',
                'penerbit' => 'Prentice Hall',
                'tahun_terbit' => 2008,
                'sinopsis' => 'Panduan menulis kode yang bersih, mudah dibaca, dan mudah di-maintain.',
                'harga' => 450000,
                'stok' => 20,
                'isbn' => '9780132350884',
            ],
            [
                'category_id' => 4,
                'judul' => 'Laravel: Up & Running',
                'pengarang' => 'Matt Stauffer',
                'penerbit' => 'O\'Reilly Media',
                'tahun_terbit' => 2019,
                'sinopsis' => 'Panduan lengkap untuk membangun aplikasi web modern dengan Laravel.',
                'harga' => 550000,
                'stok' => 15,
                'isbn' => '9781492041214',
            ],
            [
                'category_id' => 5,
                'judul' => 'Rich Dad Poor Dad',
                'pengarang' => 'Robert Kiyosaki',
                'penerbit' => 'Gramedia',
                'tahun_terbit' => 1997,
                'sinopsis' => 'Buku tentang pentingnya literasi keuangan dan investasi.',
                'harga' => 120000,
                'stok' => 40,
                'isbn' => '9786020333038',
            ],
            [
                'category_id' => 2,
                'judul' => 'Sapiens',
                'pengarang' => 'Yuval Noah Harari',
                'penerbit' => 'KPG',
                'tahun_terbit' => 2011,
                'sinopsis' => 'Sejarah singkat umat manusia dari zaman batu hingga era modern.',
                'harga' => 135000,
                'stok' => 25,
                'isbn' => '9786024246945',
            ],
            [
                'category_id' => 7,
                'judul' => 'Dongeng Sebelum Tidur',
                'pengarang' => 'Various',
                'penerbit' => 'Gramedia Pustaka',
                'tahun_terbit' => 2020,
                'sinopsis' => 'Kumpulan dongeng untuk anak-anak sebelum tidur.',
                'harga' => 65000,
                'stok' => 60,
                'isbn' => '9786020638122',
            ],
            [
                'category_id' => 8,
                'judul' => 'One Piece Vol. 1',
                'pengarang' => 'Eiichiro Oda',
                'penerbit' => 'Elex Media',
                'tahun_terbit' => 1997,
                'sinopsis' => 'Petualangan Monkey D. Luffy mencari harta karun One Piece.',
                'harga' => 28000,
                'stok' => 100,
                'isbn' => '9786230011771',
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
