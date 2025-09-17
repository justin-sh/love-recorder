import { clsx, type ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export function getTenantId() {
    const tId = localStorage.getItem('tenant-id');

    return tId ?? '';
}

export function setTenantId(tId: string) {
    localStorage.setItem('tenant-id', tId);
}
