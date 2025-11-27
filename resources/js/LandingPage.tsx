import React, { Suspense, useEffect, useState } from 'react';
import Navbar from './components/Navbar';
import Hero from './components/Hero';
import BookGrid from './components/BookGrid';
import Footer from './components/Footer';
import BookShowcase from './components/BookShowcase';
import { Book, LaravelBook, LaravelCategory } from './types';

const App: React.FC = () => {
  const [books, setBooks] = useState<Book[]>([]);
  const [categories, setCategories] = useState<LaravelCategory[]>([]);

  useEffect(() => {
    if (window.landingData) {
        // Map Laravel books to our frontend Book type
        const mappedBooks: Book[] = window.landingData.books.map((b: LaravelBook) => {
            // Generate a random pastel color for the background if no cover
            const colors = ['#F2F0E9', '#E8F0F2', '#F2E8E8', '#E8F2EA', '#F2E8F0'];
            const randomColor = colors[Math.floor(Math.random() * colors.length)];
            
            return {
                id: b.id,
                title: b.judul,
                author: b.pengarang,
                category: b.category?.name || 'Uncategorized',
                price: b.harga,
                imageColor: randomColor,
                soldOut: b.stok === 0,
                initial: b.judul.charAt(0),
                coverPhoto: b.cover_photo
            };
        });
        
        setBooks(mappedBooks);
        setCategories(window.landingData.categories);
    }
  }, []);

  return (
    <div className="min-h-screen bg-[#fcfcfc] text-gray-900">
        <Navbar />
        
        <main className="pt-28 pb-20 max-w-7xl mx-auto px-6 lg:px-8">
            <Hero />
        </main>

        {/* Full width section for 3D Showcase */}
        <section className="w-full">
            <Suspense fallback={<div className="h-[80vh] w-full bg-gray-100 animate-pulse" />}>
                <BookShowcase />
            </Suspense>
        </section>

        <main className="max-w-7xl mx-auto px-6 lg:px-8 pb-20">
            <BookGrid books={books} categories={categories} />
        </main>

        <Footer />
    </div>
  );
};

export default App;
