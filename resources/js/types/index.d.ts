import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
};

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    role: 'admin' | 'supervisor' | 'technician' | 'collaborator';
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export interface Order {
    id: number;
    tecnico_id: number | null;
    user_id: number;
    solicitante: string;
    ni: string;
    tipo_manutencao: string;
    prioridade: string;
    prazo: string;
    status: string;
    created_at: string;
    user?: { name: string };
    tecnico?: { name: string };
}

export type BreadcrumbItemType = BreadcrumbItem;
