import React, { Suspense } from 'react';
import Navbar from './components/Navbar';
import Hero from './components/Hero';
import BookGrid from './components/BookGrid';
import Footer from './components/Footer';
import BookShowcase from './components/BookShowcase';

const App: React.FC = () => {
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
            <BookGrid />
        </main>

        <Footer />
    </div>
  );
};

export default App;