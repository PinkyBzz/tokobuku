import React from 'react';
import { Search, ShoppingBag } from 'lucide-react';

const Navbar: React.FC = () => {
    return (
        // Fixed: use className instead of class
        <nav className="fixed top-0 w-full z-50 bg-white/70 backdrop-blur-xl border-b border-gray-100/50 transition-all duration-300">
            <div className="max-w-7xl mx-auto px-6 lg:px-8">
                <div className="flex justify-between h-20 items-center">
                    {/* Logo */}
                    <div className="flex-shrink-0 cursor-pointer">
                        <span className="text-xl font-bold tracking-widest text-gray-900 serif">NOVELA.</span>
                    </div>

                    {/* Desktop Menu */}
                    <div className="hidden md:flex space-x-10 items-center">
                        <a href="#" className="text-xs font-medium uppercase tracking-widest text-gray-900 border-b border-gray-900 pb-0.5">Editorial</a>
                        <a href="#" className="text-xs font-medium uppercase tracking-widest text-gray-500 hover:text-gray-900 transition-colors">Fiksi</a>
                        <a href="#" className="text-xs font-medium uppercase tracking-widest text-gray-500 hover:text-gray-900 transition-colors">Non-Fiksi</a>
                        <a href="#" className="text-xs font-medium uppercase tracking-widest text-gray-500 hover:text-gray-900 transition-colors">Koleksi</a>
                    </div>

                    {/* Icons */}
                    <div className="flex items-center space-x-6">
                        <button className="text-gray-400 hover:text-gray-900 transition-colors">
                            <Search className="w-5 h-5" />
                        </button>
                        <button className="relative text-gray-400 hover:text-gray-900 transition-colors group">
                            <ShoppingBag className="w-5 h-5" />
                            <span className="absolute -top-1 -right-1 h-1.5 w-1.5 rounded-full bg-red-500 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                        </button>
                    </div>
                </div>
            </div>
        </nav>
    );
};

export default Navbar;