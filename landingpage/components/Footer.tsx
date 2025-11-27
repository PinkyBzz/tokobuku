import React from 'react';

const Footer: React.FC = () => {
    return (
        <footer className="bg-white border-t border-gray-100 pt-20 pb-12">
            <div className="max-w-7xl mx-auto px-6 lg:px-8">
                <div className="flex flex-col md:flex-row justify-between items-start gap-12">
                    <div className="max-w-xs">
                        <span className="text-xl font-bold tracking-widest text-gray-900 serif">NOVELA.</span>
                        <p className="mt-6 text-sm text-gray-500 font-light leading-relaxed">
                            Kurasi buku terbaik untuk pemikir modern. Kami percaya pada kekuatan kata-kata untuk mengubah perspektif.
                        </p>
                    </div>
                    
                    <div className="grid grid-cols-2 md:grid-cols-3 gap-12 md:gap-24">
                        <div>
                            <h4 className="text-xs font-bold uppercase tracking-widest text-gray-900 mb-6">Explore</h4>
                            <ul className="space-y-4 text-sm font-light text-gray-500">
                                <li><a href="#" className="hover:text-gray-900 transition-colors">Bestsellers</a></li>
                                <li><a href="#" className="hover:text-gray-900 transition-colors">New Arrivals</a></li>
                                <li><a href="#" className="hover:text-gray-900 transition-colors">Authors</a></li>
                            </ul>
                        </div>
                        <div>
                            <h4 className="text-xs font-bold uppercase tracking-widest text-gray-900 mb-6">Support</h4>
                            <ul className="space-y-4 text-sm font-light text-gray-500">
                                <li><a href="#" className="hover:text-gray-900 transition-colors">FAQ</a></li>
                                <li><a href="#" className="hover:text-gray-900 transition-colors">Shipping</a></li>
                                <li><a href="#" className="hover:text-gray-900 transition-colors">Returns</a></li>
                            </ul>
                        </div>
                        <div className="col-span-2 md:col-span-1">
                            <h4 className="text-xs font-bold uppercase tracking-widest text-gray-900 mb-6">Stay Updated</h4>
                            <div className="flex border-b border-gray-300 pb-2">
                                <input type="email" placeholder="Email Address" className="w-full bg-transparent border-none p-0 text-sm focus:ring-0 placeholder-gray-400 outline-none" />
                                <button className="text-gray-900 text-xs font-bold uppercase hover:text-gray-600">Join</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div className="mt-20 flex flex-col md:flex-row justify-between items-center text-xs text-gray-400 uppercase tracking-wider">
                    <p>&copy; 2023 Novela Bookstore. Est. Jakarta.</p>
                    <div className="flex space-x-6 mt-4 md:mt-0">
                        <a href="#" className="hover:text-gray-900 transition-colors">Instagram</a>
                        <a href="#" className="hover:text-gray-900 transition-colors">Twitter</a>
                    </div>
                </div>
            </div>
        </footer>
    );
};

export default Footer;