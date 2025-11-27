import React from 'react';
import { Search, ShoppingBag, User } from 'lucide-react';

const Navbar: React.FC = () => {
    return (
        <nav className="fixed top-0 w-full z-50 bg-white/70 backdrop-blur-xl border-b border-gray-100/50 transition-all duration-300">
            <div className="max-w-7xl mx-auto px-6 lg:px-8">
                <div className="flex justify-between h-20 items-center">
                    {/* Logo */}
                    <div className="flex-shrink-0 cursor-pointer">
                        <a href="/" className="text-xl font-bold tracking-widest text-gray-900 serif">Z3LF BOOKSTORE.</a>
                    </div>

                    {/* Desktop Menu */}
                    <div className="hidden md:flex space-x-10 items-center">
                        <a href="/" className="text-xs font-medium uppercase tracking-widest text-gray-900 border-b border-gray-900 pb-0.5">Home</a>
                        <a href="#catalog" className="text-xs font-medium uppercase tracking-widest text-gray-500 hover:text-gray-900 transition-colors">Catalog</a>
                        <a href="/about" className="text-xs font-medium uppercase tracking-widest text-gray-500 hover:text-gray-900 transition-colors">About</a>
                        <a href="/contact" className="text-xs font-medium uppercase tracking-widest text-gray-500 hover:text-gray-900 transition-colors">Contact</a>
                    </div>

                    {/* Icons */}
                    <div className="flex items-center space-x-6">
                        <a href="/login" className="hidden sm:block text-xs font-medium uppercase tracking-widest text-gray-900 border border-gray-200 px-4 py-2 hover:border-gray-900 transition-colors">
                            Login
                        </a>
                        <a href="/login" className="sm:hidden text-gray-400 hover:text-gray-900 transition-colors">
                            <User className="w-5 h-5" />
                        </a>
                        <a href="/cart" className="relative text-gray-400 hover:text-gray-900 transition-colors group">
                            <ShoppingBag className="w-5 h-5" />
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    );
};

export default Navbar;
