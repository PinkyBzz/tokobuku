export interface LaravelBook {
    id: number;
    judul: string;
    pengarang: string;
    penerbit: string;
    tahun_terbit: number;
    harga: number;
    stok: number;
    cover_photo: string | null;
    category_id: number;
    created_at: string;
    updated_at: string;
    category?: {
        id: number;
        name: string;
    };
}

export interface LaravelCategory {
    id: number;
    name: string;
    books_count?: number;
}

export interface Book {
    id: number;
    title: string;
    author: string;
    category: string;
    price: number;
    originalPrice?: number;
    imageColor: string;
    soldOut?: boolean;
    discount?: string;
    initial: string;
    coverPhoto?: string | null;
}

export interface NavLink {
    label: string;
    href: string;
    isActive?: boolean;
}

declare global {
    interface Window {
        landingData: {
            books: LaravelBook[];
            categories: LaravelCategory[];
        };
    }
}
