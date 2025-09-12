<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import CardTable from "@/Components/Cards/CardTable.vue";
import TableData from "@/Components/TableData.vue";
import Button from "@/Components/Button.vue";
import InputError from "@/Components/InputError.vue";
import Modal from "@/Components/Modal.vue";
import {nextTick, ref} from 'vue';
import {showToast} from "@/Utils/Helper.js";

const props = defineProps({
    filters: Object,
    batches: Object,
});

const tableHeads = ref(['#', 'Date', 'Person', 'Batch No', 'Volume (L)', 'Available Volume (L)', 'Unit Price', 'Purchasing Cost', 'Labour', 'Expenses', 'Total Expenses', 'Action']);

const showCreateModal = ref(false);
const dateInput = ref(null);
const form = useForm({
    batch_date: null,
    person: null,
    batch_no: null,
    volume_l: null,
    milk_unit_price: null,
    // milk_purchase_cost computed server-side
    labour_cost: null,
    other_expenses_total: null,
    // removed total_sales_expected
    notes: null,
});

const openCreate = () => {
    showCreateModal.value = true;
    nextTick(() => dateInput.value?.focus());
};
const closeModal = () => {
    showCreateModal.value = false;
    form.reset();
};
const submitCreate = () => {
    form.post(route('milk.batches.store'), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            showToast();
        },
    });
};
</script>

<template>
    <Head title="Milk Batches" />

    <AuthenticatedLayout>
        <template #breadcrumb>
            Milk > Batches
        </template>

        <div class="flex flex-wrap">
            <div class="w-full px-4">
                <CardTable
                    indexRoute="milk.batches"
                    :paginatedData="batches"
                    :filters="{}"
                    :tableHeads="tableHeads"
                >
                    <template #cardHeader>
                        <h4 class="text-2xl">Milk Batches ({{ batches.total }})</h4>
                    </template>
                    <template #cardHeaderRight>
                        <div class="flex items-center gap-2">
                            <div class="relative inline-block text-left">
                                <a :href="route('milk.batches', { export: 'excel' })" class="active:scale-95 rounded bg-gray-700 px-4 py-2 text-white text-xs font-bold uppercase shadow hover:shadow-lg outline-none focus:outline-none ease-linear transition-all duration-150">Export</a>
                            </div>
                            <Button @click="openCreate">Create Milk Batch</Button>
                        </div>
                    </template>

                    <tr v-for="(batch, index) in batches.data" :key="batch.id">
                        <TableData>
                            {{ (batches.current_page * batches.per_page) - (batches.per_page - (index + 1)) }}
                        </TableData>
                        <TableData>{{ batch.batch_date }}</TableData>
                        <TableData>{{ batch.person || '-' }}</TableData>
                        <TableData>{{ batch.batch_no }}</TableData>
                        <TableData>{{ batch.volume_l }}</TableData>
                        <TableData>{{ batch.available_volume ?? batch.volume_l }}</TableData>
                        <TableData>{{ batch.milk_unit_price ?? '-' }}</TableData>
                        <TableData>{{ batch.milk_purchase_cost }}</TableData>
                        <TableData>{{ batch.labour_cost }}</TableData>
                        <TableData>{{ batch.other_expenses_total ?? 0 }}</TableData>
                        <TableData>{{ (Number(batch.labour_cost) + Number(batch.other_expenses_total)).toFixed(2) }}</TableData>
                        <TableData>
                            <Button :href="route('milk.batches.show', batch.id)" buttonType="link"><i class="fa fa-eye"></i></Button>
                        </TableData>
                    </tr>
                </CardTable>
            </div>
        </div>

        <Modal
            title="Create Milk Batch"
            :show="showCreateModal"
            :formProcessing="form.processing"
            @close="closeModal"
            @submitAction="submitCreate"
        >
            <div class="grid gap-4 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">
                <div class="flex flex-col">
                    <label for="batch_date">Date</label>
                    <input id="batch_date" ref="dateInput" v-model="form.batch_date" type="date" class="px-3 py-2 rounded border" />
                    <InputError :message="form.errors.batch_date" />
                </div>
                <div class="flex flex-col">
                    <label for="person">Person</label>
                    <input id="person" v-model="form.person" type="text" placeholder="Collector name" class="px-3 py-2 rounded border" />
                    <InputError :message="form.errors.person" />
                </div>
                <div class="flex flex-col">
                    <label for="batch_no">Batch No</label>
                    <input id="batch_no" v-model="form.batch_no" type="text" placeholder="e.g., 1508-1" class="px-3 py-2 rounded border" />
                    <InputError :message="form.errors.batch_no" />
                </div>
                <div class="flex flex-col">
                    <label for="volume_l">Volume (L)</label>
                    <input id="volume_l" v-model="form.volume_l" type="number" step="0.001" placeholder="e.g., 120" class="px-3 py-2 rounded border" />
                    <InputError :message="form.errors.volume_l" />
                </div>
                <div class="flex flex-col">
                    <label for="milk_unit_price">Milk Unit Price</label>
                    <input id="milk_unit_price" v-model="form.milk_unit_price" type="number" step="0.001" placeholder="e.g., 1318.682" class="px-3 py-2 rounded border" />
                    <InputError :message="form.errors.milk_unit_price" />
                </div>
                <div class="flex flex-col">
                    <label for="labour_cost">Labour Cost (Optional)</label>
                    <input id="labour_cost" v-model="form.labour_cost" type="number" step="0.01" class="px-3 py-2 rounded border" />
                    <InputError :message="form.errors.labour_cost" />
                </div>
                <div class="flex flex-col">
                    <label for="other_expenses_total">Other Expenses (Optional)</label>
                    <input id="other_expenses_total" v-model="form.other_expenses_total" type="number" step="0.01" class="px-3 py-2 rounded border" />
                    <InputError :message="form.errors.other_expenses_total" />
                </div>
                <div class="flex flex-col md:col-span-3">
                    <label for="notes">Notes</label>
                    <textarea id="notes" v-model="form.notes" rows="2" class="px-3 py-2 rounded border" />
                    <InputError :message="form.errors.notes" />
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template> 