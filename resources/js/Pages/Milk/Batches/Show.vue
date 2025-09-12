<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import InputError from "@/Components/InputError.vue";
import SubmitButton from "@/Components/SubmitButton.vue";
import {showToast} from "@/Utils/Helper.js";

const props = defineProps({
    id: Number,
    batchNo: String,
    batch: Object,
});

const form = useForm({
    batch_date: props.batch.batch_date,
    person: props.batch.person,
    batch_no: props.batch.batch_no,
    volume_l: props.batch.volume_l,
    milk_unit_price: props.batch.milk_unit_price,
    labour_cost: props.batch.labour_cost,
    other_expenses_total: props.batch.other_expenses_total,
    notes: props.batch.notes,
});

const updateBatch = () => {
    form.transform((data) => ({ ...data, _method: 'put' }))
        .post(`/milk/batches/${props.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                showToast();
            },
        });
};

const deleteBatch = () => {
    // Reset transform so _method=put is NOT sent
    form.transform((data) => data)
        .post(`/milk/batches/${props.id}/delete`, {
            preserveScroll: true,
            onSuccess: () => {
                showToast();
                window.location.href = '/milk/batches';
            },
        });
};
</script>

<template>
    <Head :title="`Milk Batch ${batchNo}`" />

    <AuthenticatedLayout>
        <template #breadcrumb>
            Milk > Batch > {{ batchNo }}
        </template>

        <div class="flex flex-wrap">
            <div class="w-full px-4">
                <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white">
                    <div class="rounded-t mb-3 px-4 py-3 border-0">
                        <div class="flex flex-wrap items-center">
                            <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                                <div class="flex justify-between items-center">
                                    <h4 class="text-2xl">Milk Batch {{ batchNo }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block w-full overflow-x-auto px-8 py-4">
                        <div class="grid gap-4 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">
                            <div class="flex flex-col">
                                <label for="batch_date">Date</label>
                                <input id="batch_date" v-model="form.batch_date" type="date" class="px-3 py-2 rounded border" />
                                <InputError :message="form.errors.batch_date" />
                            </div>
                            <div class="flex flex-col">
                                <label for="person">Person</label>
                                <input id="person" v-model="form.person" type="text" class="px-3 py-2 rounded border" />
                                <InputError :message="form.errors.person" />
                            </div>
                            <div class="flex flex-col">
                                <label for="batch_no">Batch No</label>
                                <input id="batch_no" v-model="form.batch_no" type="text" class="px-3 py-2 rounded border" />
                                <InputError :message="form.errors.batch_no" />
                            </div>
                            <div class="flex flex-col">
                                <label for="volume_l">Volume (L)</label>
                                <input id="volume_l" v-model.number="form.volume_l" type="number" step="0.001" class="px-3 py-2 rounded border" />
                                <InputError :message="form.errors.volume_l" />
                            </div>
                            <div class="flex flex-col">
                                <label for="milk_unit_price">Milk Unit Price</label>
                                <input id="milk_unit_price" v-model.number="form.milk_unit_price" type="number" step="0.001" class="px-3 py-2 rounded border" />
                                <InputError :message="form.errors.milk_unit_price" />
                            </div>
                            <div class="flex flex-col">
                                <label for="labour_cost">Labour Cost</label>
                                <input id="labour_cost" v-model.number="form.labour_cost" type="number" step="0.01" class="px-3 py-2 rounded border" />
                                <InputError :message="form.errors.labour_cost" />
                            </div>
                            <div class="flex flex-col">
                                <label for="other_expenses_total">Other Expenses (Optional)</label>
                                <input id="other_expenses_total" v-model.number="form.other_expenses_total" type="number" step="0.01" class="px-3 py-2 rounded border" />
                                <InputError :message="form.errors.other_expenses_total" />
                            </div>
                            <div class="flex flex-col md:col-span-3">
                                <label for="notes">Notes</label>
                                <textarea id="notes" v-model="form.notes" rows="2" class="px-3 py-2 rounded border" />
                                <InputError :message="form.errors.notes" />
                            </div>
                        </div>
                        <div class="my-6 flex justify-end gap-2">
                            <SubmitButton :processing="form.processing" @click="deleteBatch" class="text-white bg-red-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-lg outline-none focus:outline-none ease-linear transition-all duration-150">
                                Delete Batch
                            </SubmitButton>
                            <SubmitButton :processing="form.processing" @click="updateBatch" class="text-white bg-emerald-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-lg outline-none focus:outline-none ease-linear transition-all duration-150">
                                Save Changes
                            </SubmitButton>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template> 