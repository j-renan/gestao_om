<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { ref, watch, onMounted } from 'vue';
import { CheckCircle, AlertCircle, Info, XCircle, X } from 'lucide-vue-next';

interface Toast {
    id: number;
    type: 'success' | 'error' | 'warning' | 'info';
    message: string;
}

const toasts = ref<Toast[]>([]);
const page = usePage();

const addToast = (type: any, message: string) => {
    if (!message) return;
    const id = Date.now();
    toasts.value.push({ id, type, message });
    
    setTimeout(() => {
        removeToast(id);
    }, 5000);
};

const removeToast = (id: number) => {
    toasts.value = toasts.value.filter(t => t.id !== id);
};

// Watch for flash messages from Inertia
watch(() => page.props.flash, (flash: any) => {
    if (flash.success) addToast('success', flash.success);
    if (flash.error) addToast('error', flash.error);
    if (flash.warning) addToast('warning', flash.warning);
    if (flash.info) addToast('info', flash.info);
}, { deep: true });

// Check on initial load
onMounted(() => {
    const flash = page.props.flash as any;
    if (flash) {
        if (flash.success) addToast('success', flash.success);
        if (flash.error) addToast('error', flash.error);
        if (flash.warning) addToast('warning', flash.warning);
        if (flash.info) addToast('info', flash.info);
    }
});

const getIcon = (type: string) => {
    switch (type) {
        case 'success': return CheckCircle;
        case 'error': return XCircle;
        case 'warning': return AlertCircle;
        default: return Info;
    }
};

const getClasses = (type: string) => {
    switch (type) {
        case 'success': return 'bg-green-50 text-green-800 border-green-200 dark:bg-green-900/30 dark:text-green-400 dark:border-green-800';
        case 'error': return 'bg-red-50 text-red-800 border-red-200 dark:bg-red-900/30 dark:text-red-400 dark:border-red-800';
        case 'warning': return 'bg-yellow-50 text-yellow-800 border-yellow-200 dark:bg-yellow-900/30 dark:text-yellow-400 dark:border-yellow-800';
        default: return 'bg-blue-50 text-blue-800 border-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800';
    }
};
</script>

<template>
    <div class="fixed top-4 right-4 z-[100] flex flex-col gap-2 w-full max-w-xs pointer-events-none">
        <TransitionGroup 
            enter-active-class="transition duration-300 ease-out"
            enter-from-class="transform translate-x-10 opacity-0"
            enter-to-class="transform translate-x-0 opacity-100"
            leave-active-class="transition duration-200 ease-in"
            leave-from-class="transform translate-x-0 opacity-100"
            leave-to-class="transform translate-x-10 opacity-0"
        >
            <div 
                v-for="toast in toasts" 
                :key="toast.id"
                class="pointer-events-auto flex items-start gap-3 p-4 rounded-lg border shadow-lg"
                :class="getClasses(toast.type)"
            >
                <component :is="getIcon(toast.type)" class="size-5 shrink-0 mt-0.5" />
                <div class="flex-1 text-sm font-medium">
                    {{ toast.message }}
                </div>
                <button 
                    @click="removeToast(toast.id)"
                    class="shrink-0 rounded-md p-1 hover:bg-black/5 dark:hover:bg-white/10 transition-colors"
                >
                    <X class="size-4" />
                </button>
            </div>
        </TransitionGroup>
    </div>
</template>
