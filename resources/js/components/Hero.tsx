import React from 'react';

const Hero: React.FC = () => {
    return (
        <div className="relative w-full bg-gray-50 rounded-lg overflow-hidden mb-20 p-8 md:p-16 flex flex-col md:flex-row items-center justify-between min-h-[500px]">
            <div className="z-10 max-w-xl space-y-8">
                <div className="inline-flex items-center space-x-2 border-b border-gray-900 pb-1">
                    <span className="text-xs font-bold uppercase tracking-widest text-gray-900">Editor's Choice</span>
                </div>
                <h1 className="text-5xl md:text-7xl leading-tight text-gray-900 font-medium">
                    The Art of <br /><i className="font-serif italic text-gray-600">Thinking</i> Clearly.
                </h1>
                <p className="text-gray-600 text-lg max-w-md font-light leading-relaxed">
                    Edisi eksklusif hardcover dengan ilustrasi baru. Sebuah mahakarya tentang logika, bias kognitif, dan cara berpikir yang lebih baik.
                </p>
                <div className="pt-4">
                    <button className="bg-gray-900 text-white px-8 py-4 text-xs font-medium uppercase tracking-widest hover:bg-gray-800 transition-colors shadow-xl shadow-gray-200">
                        Lihat Detail Buku
                    </button>
                </div>
            </div>

            {/* Hero Image Composition */}
            <div className="mt-12 md:mt-0 relative w-full md:w-1/3 flex justify-center">
                <div className="absolute inset-0 bg-gradient-to-tr from-gray-200 to-gray-100 rounded-full blur-3xl opacity-50 transform scale-150"></div>
                <div className="relative w-64 aspect-[2/3] bg-[#e6e6e6] shadow-2xl rounded-sm transform rotate-[-6deg] hover:rotate-0 transition-transform duration-700 ease-out flex items-center justify-center border border-white/50">
                    {/* Fake Cover Art */}
                    <div className="text-center p-6 border-2 border-gray-400/20 w-[90%] h-[90%] flex flex-col justify-between">
                        <span className="text-[10px] uppercase tracking-[0.2em] text-gray-500 block">Rolf Dobelli</span>
                        <div className="w-12 h-12 rounded-full border border-gray-400 mx-auto"></div>
                        <span className="text-xs uppercase tracking-widest text-gray-900 block font-bold">Thinking</span>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Hero;