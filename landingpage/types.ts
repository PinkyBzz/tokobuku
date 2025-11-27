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
}

export interface NavLink {
    label: string;
    href: string;
    isActive?: boolean;
}