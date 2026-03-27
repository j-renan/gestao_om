<template>
    <form @submit.prevent="submit">
        <fieldset class="fieldset h-full w-full bg-base-200 border-base-300 rounded-box border p-4">
            <legend class="fieldset-legend text-xl">Preencha os campos:</legend>
            
            <div class="mb-4 lg:columns-3 md:columns-1 sm:columns-1">
                <div>
                    <label class="label">Solicitante *</label>
                    <input v-model="form.solicitante" type="text" required class="input input-primary w-full" placeholder="Nome do solicitante" />
                    <div v-if="form.errors.solicitante" class="text-xs text-error mt-1">{{ form.errors.solicitante }}</div>
                </div>

                <div>
                    <label class="label">NI</label>
                    <input v-model="form.ni" type="number" required class="input input-primary w-full" placeholder="Número de identificação" />
                    <div v-if="form.errors.ni" class="text-xs text-error mt-1">{{ form.errors.ni }}</div>
                </div>

                <div>
                    <label class="label">Manutenção *</label>
                    <select v-model="form.tipo_manutencao" class="select select-primary w-full" required>
                        <option disabled value="">Selecione o tipo</option>
                        <option>Mecânica</option>
                        <option>Elétrica</option>
                        <option>Informática</option>
                    </select>
                    <div v-if="form.errors.tipo_manutencao" class="text-xs text-error mt-1">{{ form.errors.tipo_manutencao }}</div>
                </div>
            </div>

            <div class="mb-6 lg:columns-3 md:columns-1 sm:columns-1">
                <div>
                    <label class="label">Prioridade *</label>
                    <select v-model="form.prioridade" class="select select-primary w-full" required>
                        <option disabled value="">Selecione a prioridade</option>
                        <option>Alta</option>
                        <option>Média</option>
                        <option>Baixa</option>
                    </select>
                    <div v-if="form.errors.prioridade" class="text-xs text-error mt-1">{{ form.errors.prioridade }}</div>
                </div>

                <div>
                    <label class="label">Gestor do departamento solicitante</label>
                    <input v-model="form.gestor_responsavel" type="text" class="input input-primary w-full" placeholder="Nome do gestor responsável" />
                    <div v-if="form.errors.gestor_responsavel" class="text-xs text-error mt-1">{{ form.errors.gestor_responsavel }}</div>
                </div>

                <div>
                    <label class="label">Prazo *</label>
                    <input type="text" class="input input-primary pika-single w-full" 
                        ref="myDatepicker" 
                        required
                        readonly
                        placeholder="Clique para selecionar"
                    />
                    <div v-if="form.errors.prazo" class="text-xs text-error mt-1">{{ form.errors.prazo }}</div>
                </div>
            </div>

            <div class="flex justify-end mt-4">
                <button type="submit" class="btn btn-primary" :disabled="form.processing">
                    <span v-if="form.processing" class="loading loading-spinner"></span>
                    Salvar Ordem
                </button>
            </div>

        </fieldset>
    </form>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import Pikaday from "pikaday";
import "pikaday/css/pikaday.css";
import { onMounted, ref } from "vue";

const myDatepicker = ref(null);

const form = useForm({
    solicitante: '',
    ni: '',
    tipo_manutencao: '',
    prioridade: '',
    gestor_responsavel: '',
    prazo: '',
});

onMounted(() => {
    if (myDatepicker.value) {
        const picker = new Pikaday({
            field: myDatepicker.value,
            format: 'YYYY-MM-DD', // Internal format for DB
            toString(date, format) {
                // How it appears in the input
                const day = ("0" + date.getDate()).slice(-2);
                const month = ("0" + (date.getMonth() + 1)).slice(-2);
                const year = date.getFullYear();
                return `${day}/${month}/${year}`;
            },
            onSelect: () => {
                form.prazo = picker.toString('YYYY-MM-DD'); 
                // Actually Pikaday returns a date object, we need the formatted string for the backend or the date object
                const date = picker.getDate();
                if (date) {
                   const year = date.getFullYear();
                   const month = ("0" + (date.getMonth() + 1)).slice(-2);
                   const day = ("0" + date.getDate()).slice(-2);
                   form.prazo = `${year}-${month}-${day}`;
                }
            },
            minDate: new Date(),
        });
    }
});

const submit = () => {
    form.post(route('orders.store'), {
        onSuccess: () => {
            // Success handling is managed by redirect in controller
        },
    });
};
</script>
