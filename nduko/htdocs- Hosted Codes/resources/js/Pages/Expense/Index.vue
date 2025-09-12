<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import CardTable from "@/Components/Cards/CardTable.vue";
import TableData from "@/Components/TableData.vue";
import Button from "@/Components/Button.vue";
import InputError from "@/Components/InputError.vue";
import Modal from "@/Components/Modal.vue";
import {useForm} from '@inertiajs/vue3';
import {ref} from 'vue';
import {showToast} from "@/Utils/Helper.js";

const props = defineProps({
    filters: Object,
    expenses: Object,
});

const selectedExpense = ref(null);
const showCreateModal = ref(false);
const showEditModal = ref(false);
const showDeleteModal = ref(false);
const tableHeads = ref(['#', "Name", "Amount", "Expense Date", "Action"]);

const form = useForm({
    name: null,
    amount: null,
    expense_date: null,
});

const editExpenseModal = (expense) => {
    selectedExpense.value = expense;
    form.name = expense.name;
    form.amount = expense.amount;
    form.expense_date = expense.expense_date;
    showEditModal.value = true;
};

const deleteExpenseModal = (expense) => {
    selectedExpense.value = expense;
    showDeleteModal.value = true;
};

const createExpense = () => {
    form.post(route('expenses.store'), {
        preserveScroll: true,
        onSuccess: () => { closeModal(); showToast(); },
    });
};

const updateExpense = () => {
    form.put(route('expenses.update', selectedExpense.value.id), {
        preserveScroll: true,
        onSuccess: () => { closeModal(); showToast(); },
    });
};

const deleteExpense = () => {
    form.post(route('expenses.destroy', selectedExpense.value.id), {
        preserveScroll: true,
        onSuccess: () => { closeModal(); showToast(); },
    });
};

const closeModal = () => {
    showCreateModal.value = false;
    showEditModal.value = false;
    showDeleteModal.value = false;
    form.reset();
};
</script>

<template>
    <Head title="Expense"/>

    <AuthenticatedLayout>
        <template #breadcrumb>
            Expenses
        </template>

        <div class="flex flex-wrap">
            <div class="w-full px-4">
                <CardTable
                    indexRoute="expenses.index"
                    :paginatedData="props.expenses"
                    :filters="props.filters"
                    :tableHeads="tableHeads"
                >
                    <template #cardHeader>
                        <h4 class="text-2xl">Expenses ({{ expenses.total }})</h4>
                    </template>
                    <template #cardHeaderRight>
                        <div class="flex items-center gap-2">
                            <a :href="route('expenses.index', { export: 'excel' })" class="active:scale-95 rounded bg-gray-700 px-4 py-2 text-white text-xs font-bold uppercase shadow hover:shadow-lg outline-none focus:outline-none ease-linear transition-all duration-150">Export</a>
                            <Button @click=" showCreateModal = true">Create Expense</Button>
                        </div>
                    </template>

                    <tr v-for="(expense, index) in expenses.data" :key="expense.id">
                        <TableData>
                            {{ (expenses.current_page * expenses.per_page) - (expenses.per_page - (index + 1)) }}
                        </TableData>
                        <TableData>{{ expense.name }}</TableData>
                        <TableData>{{ expense.amount }}</TableData>
                        <TableData>{{ expense.expense_date }}</TableData>
                        <TableData>
                            <Button @click="editExpenseModal(expense)"><i class="fa fa-edit"></i></Button>
                            <Button @click="deleteExpenseModal(expense)" type="red"><i class="fa fa-trash-alt"></i></Button>
                        </TableData>
                    </tr>
                </CardTable>
            </div>
        </div>

        <Modal title="Create" :show="showCreateModal" :formProcessing="form.processing" @close="closeModal" @submitAction="createExpense">
            <div>
                <label for="name">Name</label>
                <input id="name" v-model="form.name" type="text" placeholder="Enter name" class="px-3 py-2 rounded border w-full" />
                <InputError :message="form.errors.name" />
            </div>
        </Modal>

        <Modal title="Edit" :show="showEditModal" :formProcessing="form.processing" @close="closeModal" @submitAction="updateExpense">
            <div>
                <label for="name">Name</label>
                <input id="name" v-model="form.name" type="text" placeholder="Enter name" class="px-3 py-2 rounded border w-full" />
                <InputError :message="form.errors.name" />
            </div>
        </Modal>

        <Modal title="Delete" :show="showDeleteModal" :formProcessing="form.processing" @close="closeModal" @submitAction="deleteExpense" maxWidth="sm" submitButtonText="Yes, delete it!">
            Are you sure you want to delete this expense?
        </Modal>
    </AuthenticatedLayout>
</template>
