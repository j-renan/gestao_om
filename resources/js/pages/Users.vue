<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type User } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { Users as UsersIcon, ShieldCheck, ShieldAlert, User as UserIcon, Wrench } from 'lucide-vue-next';
import { computed } from 'vue';

defineProps<{
    users: User[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Usuários',
        href: '/users',
    },
];

const form = useForm({
    role: '',
});

const updateRole = (user: User, newRole: string) => {
    form.role = newRole;
    form.patch(route('users.update', user.id), {
        preserveScroll: true,
    });
};

const getRoleIcon = (role: string) => {
    switch (role) {
        case 'admin': return ShieldCheck;
        case 'supervisor': return ShieldAlert;
        case 'technician': return Wrench;
        default: return UserIcon;
    }
};

const getRoleLabel = (role: string) => {
    switch (role) {
        case 'admin': return 'Administrador';
        case 'supervisor': return 'Supervisor';
        case 'technician': return 'Técnico';
        case 'collaborator': return 'Colaborador';
        default: return role;
    }
};
</script>

<template>
    <Head title="Gestão de Usuários" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-6">
            <div class="card bg-base-100 shadow-sm border border-base-300">
                <div class="card-body p-0">
                    <div class="p-4 border-b border-base-300 flex justify-between items-center bg-base-200/50 rounded-t-xl">
                        <h2 class="card-title text-base flex gap-2">
                            <UsersIcon class="size-5" />
                            Gestão de Usuários e Perfis
                        </h2>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="table table-zebra w-full">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>E-mail</th>
                                    <th>Perfil Atual</th>
                                    <th class="text-right">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in users" :key="user.id" class="hover cursor-default">
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="avatar placeholder">
                                                <div class="bg-neutral text-neutral-content rounded-full w-8 text-[10px]">
                                                    <span>{{ user.name.charAt(0).toUpperCase() }}</span>
                                                </div>
                                            </div>
                                            <div class="font-bold">{{ user.name }}</div>
                                        </div>
                                    </td>
                                    <td>{{ user.email }}</td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <component :is="getRoleIcon(user.role)" class="size-4 opacity-50" />
                                            <span class="text-sm font-medium">{{ getRoleLabel(user.role) }}</span>
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <div class="dropdown dropdown-end">
                                            <label tabindex="0" class="btn btn-ghost btn-xs border border-base-300 hover:bg-base-200">Alterar Perfil</label>
                                            <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52 border border-base-300">
                                                <li><a @click="updateRole(user, 'admin')" :class="{ 'active': user.role === 'admin' }">Administrador</a></li>
                                                <li><a @click="updateRole(user, 'supervisor')" :class="{ 'active': user.role === 'supervisor' }">Supervisor</a></li>
                                                <li><a @click="updateRole(user, 'technician')" :class="{ 'active': user.role === 'technician' }">Técnico</a></li>
                                                <li><a @click="updateRole(user, 'collaborator')" :class="{ 'active': user.role === 'collaborator' }">Colaborador</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
