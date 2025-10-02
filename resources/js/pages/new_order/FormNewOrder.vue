<template>
    <fieldset class="fieldset h-full w-full bg-base-200 border-base-300 rounded-box border p-4">
        <legend class="fieldset-legend text-xl">Preencha os campos:</legend>
        <div class="mb-4 lg:columns-3 md:columns-1 sm:columns-1">
            <label class="label">Solicitante *</label>
            <input type="text" required class="input input-success w-full" placeholder="Nome do solicitante" />

            <label class="label">NI</label>
            <input type="number" required class="input input-success w-full" placeholder="Número de identificação" />

            <label class="label">Manutenção *</label>
            <select class="select select-success w-full">
                <option disabled selected value="">Selecione o tipo</option>
                <option>Mecânica</option>
                <option>Elétrica</option>
                <option>Informática</option>
            </select>
        </div>


        <div class="mb-4 lg:columns-3 md:columns-1 sm:columns-1">
            <label class="label">Prioridade *</label>
            <select class="select select-success w-full">
                <option disabled selected value="">Selecione a prioridade</option>
                <option>Alta</option>
                <option>Média</option>
                <option>Baixa</option>
            </select>

            <label class="label">Gestor do departamento solicitante</label>
            <input type="text" required class="input input-success w-full" placeholder="Nome do gestor responsável" />

            <label class="label">Prazo</label>
            <input type="text" class="input pika-single" ref="myDatepicker" value="Pick a day"/>
        </div>

    </fieldset>
</template>

<script setup>
import Pikaday from "pikaday";
import { onMounted } from "vue";
onMounted(
    function() {
    const picker = new Pikaday({
      field: this.$refs.myDatepicker
    });
  }
)
</script>
