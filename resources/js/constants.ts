import { Book } from './types';

export const BOOKS: Book[] = [
    { id: 1, title: "Atomic Habits", author: "James Clear", category: "Self Development", price: 185000, imageColor: "#F2F0E9", initial: "A" },
    { id: 2, title: "Psychology of Money", author: "Morgan Housel", category: "Finance", price: 145000, imageColor: "#E8EDF2", initial: "P" },
    { id: 3, title: "Essentialism", author: "Greg McKeown", category: "Productivity", price: 160000, imageColor: "#f5f5f5", soldOut: true, initial: "E" },
    { id: 4, title: "Sapiens", author: "Yuval Noah Harari", category: "History", price: 210000, imageColor: "#EBEBEB", initial: "S" },
    { id: 5, title: "Deep Work", author: "Cal Newport", category: "Productivity", price: 136000, originalPrice: 160000, discount: "-15%", imageColor: "#E3E8E5", initial: "D" },
    { id: 6, title: "Berani Tidak Disukai", author: "Ichiro Kishimi", category: "Philosophy", price: 98000, imageColor: "#F2EDED", initial: "I" },
];