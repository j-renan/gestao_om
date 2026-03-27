<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { ClipboardList, Clock, CheckCircle, AlertCircle } from 'lucide-vue-next';

interface Order {
    id: number;
    solicitante: string;
    ni: string;
    tipo_manutencao: string;
    prioridade: string;
    gestor_responsavel: string;
    prazo: string;
    status: string;
    created_at: string;
}

const props = defineProps<{
    orders: Order[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Ordens',
        href: '/orders',
    },
];

const selectedStatus = ref<string | null>(null);

const counts = computed(() => {
    return {
        pending: props.orders.filter(o => o.status === 'Pendente').length,
        inProgress: props.orders.filter(o => o.status === 'Em Andamento').length,
        finished: props.orders.filter(o => o.status === 'Finalizada').length,
    };
});

const filteredOrders = computed(() => {
    if (!selectedStatus.value) return props.orders;
    return props.orders.filter(o => o.status === selectedStatus.value);
});

const toggleFilter = (status: string) => {
    if (selectedStatus.value === status) {
        selectedStatus.value = null;
    } else {
        selectedStatus.value = status;
    }
};

const getPriorityClass = (priority: string) => {
    switch (priority) {
        case 'Alta': return 'badge-error';
        case 'Média': return 'badge-warning';
        case 'Baixa': return 'badge-success';
        default: return 'badge-ghost';
    }
};

const getStatusClass = (status: string) => {
    switch (status) {
        case 'Pendente': return 'badge-secondary';
        case 'Em Andamento': return 'badge-info';
        case 'Finalizada': return 'badge-success';
        default: return 'badge-ghost';
    }
};

const formatDate = (dateString: string) => {
    const [year, month, day] = dateString.split('-');
    return `${day}/${month}/${year}`;
};

</script>

<template>
    <Head title="Ordens de Manutenção" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-6">
            <!-- Stats Cards -->
            <div class="grid gap-4 md:grid-cols-3">
                <div 
                    @click="toggleFilter('Pendente')"
                    :class="['card bg-base-100 shadow-sm border border-base-300 cursor-pointer transition-all hover:shadow-md active:scale-95', selectedStatus === 'Pendente' ? 'ring-2 ring-primary border-primary bg-primary/5' : '']"
                >
                    <div class="card-body p-4 flex-row items-center gap-4">
                        <div class="p-3 rounded-lg bg-secondary/10 text-secondary">
                            <Clock class="size-6" />
                        </div>
                        <div>
                            <div class="text-sm opacity-70">Pendentes</div>
                            <div class="text-2xl font-bold">{{ counts.pending }}</div>
                        </div>
                    </div>
                </div>

                <div 
                    @click="toggleFilter('Em Andamento')"
                    :class="['card bg-base-100 shadow-sm border border-base-300 cursor-pointer transition-all hover:shadow-md active:scale-95', selectedStatus === 'Em Andamento' ? 'ring-2 ring-primary border-primary bg-primary/5' : '']"
                >
                    <div class="card-body p-4 flex-row items-center gap-4">
                        <div class="p-3 rounded-lg bg-info/10 text-info">
                            <AlertCircle class="size-6" />
                        </div>
                        <div>
                            <div class="text-sm opacity-70">Em Andamento</div>
                            <div class="text-2xl font-bold">{{ counts.inProgress }}</div>
                        </div>
                    </div>
                </div>

                <div 
                    @click="toggleFilter('Finalizada')"
                    :class="['card bg-base-100 shadow-sm border border-base-300 cursor-pointer transition-all hover:shadow-md active:scale-95', selectedStatus === 'Finalizada' ? 'ring-2 ring-primary border-primary bg-primary/5' : '']"
                >
                    <div class="card-body p-4 flex-row items-center gap-4">
                        <div class="p-3 rounded-lg bg-success/10 text-success">
                            <CheckCircle class="size-6" />
                        </div>
                        <div>
                            <div class="text-sm opacity-70">Finalizadas</div>
                            <div class="text-2xl font-bold">{{ counts.finished }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Orders List -->
            <div class="card bg-base-100 shadow-sm border border-base-300">
                <div class="card-body p-0">
                    <div class="p-4 border-b border-base-300 flex justify-between items-center bg-base-200/50 rounded-t-xl">
                        <h2 class="card-title text-base flex gap-2">
                            <ClipboardList class="size-5" />
                            Listagem de Ordens
                            <span v-if="selectedStatus" class="badge badge-primary">{{ selectedStatus }}</span>
                        </h2>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="table table-zebra w-full">
                            <thead>
                                <tr>
                                    <th>NI</th>
                                    <th>Solicitante</th>
                                    <th>Tipo</th>
                                    <th>Prioridade</th>
                                    <th>Prazo</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="order in filteredOrders" :key="order.id" class="hover cursor-default">
                                    <td class="font-mono text-xs">{{ order.ni }}</td>
                                    <td>{{ order.solicitante }}</td>
                                    <td>{{ order.tipo_manutencao }}</td>
                                    <td>
                                        <div :class="['badge badge-sm font-semibold text-white border-0', getPriorityClass(order.prioridade)]">
                                            {{ order.prioridade }}
                                        </div>
                                    </td>
                                    <td>{{ formatDate(order.prazo) }}</td>
                                    <td>
                                        <div :class="['badge badge-sm font-semibold text-white border-0', getStatusClass(order.status)]">
                                            {{ order.status }}
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="filteredOrders.length === 0">
                                    <td colspan="6" class="text-center py-8 opacity-50 italic">
                                        Nenhuma ordem encontrada para este filtro.
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
