<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import CardTable from "@/Components/Cards/CardTable.vue";
import TableData from "@/Components/TableData.vue";
import Button from "@/Components/Button.vue";
import InputError from "@/Components/InputError.vue";
import Modal from "@/Components/Modal.vue";
import {useForm} from '@inertiajs/vue3';
import {nextTick, ref} from 'vue';
import DashboardInputGroup from "@/Components/DashboardInputGroup.vue";
import {showToast} from "@/Utils/Helper.js";

const props = defineProps({
    filters: Object,
    customers: Object,
});

const selectedCustomer = ref(null);
const showCreateModal = ref(false);
const showEditModal = ref(false);
const showDeleteModal = ref(false);
const nameInput = ref(null);
const tableHeads = ref(['#', "Name", "Email", "Phone", "Action"]);

const form = useForm({
    name: null,
    email: null,
    phone: null,
    address: null,
    photo: null,
});

const createCustomerModal = () => {
    showCreateModal.value = true;
    nextTick(() => nameInput.value.focus());
};

const editCustomerModal = (customer) => {
    selectedCustomer.value = customer;
    form.name = customer.name;
    form.email = customer.email;
    form.phone = customer.phone;
    form.address = customer.address;
    form.photo = null;
    showEditModal.value = true;
    nextTick(() => nameInput.value.focus());
};

const deleteCustomerModal = (customer) => {
    selectedCustomer.value = customer;
    showDeleteModal.value = true;
};

const createCustomer = () => {
    form.post(route('customers.store'), {
        preserveScroll: true,
        onSuccess: () => { closeModal(); showToast(); },
        onError: () => nameInput.value.focus(),
    });
};

const updateCustomer = () => {
    form.put(route('customers.update', selectedCustomer.value.id), {
            preserveScroll: true,
        onSuccess: () => { closeModal(); showToast(); },
            onError: () => nameInput.value.focus(),
        });
};

const deleteCustomer = () => {
    form.post(route('customers.destroy', selectedCustomer.value.id), {
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
    <Head title="Customer"/>

    <AuthenticatedLayout>
        <template #breadcrumb>
            Customers
        </template>

        <div class="flex flex-wrap">
            <div class="w-full px-4">
                <CardTable
                    indexRoute="customers.index"
                    :paginatedData="props.customers"
                    :filters="props.filters"
                    :tableHeads="tableHeads"
                >
                    <template #cardHeader>
                        <h4 class="text-2xl">Customers ({{ customers.total }})</h4>
                    </template>
                    <template #cardHeaderRight>
                        <div class="flex items-center gap-2">
                            <a :href="route('customers.index', { export: 'excel' })" class="active:scale-95 rounded bg-gray-700 px-4 py-2 text-white text-xs font-bold uppercase shadow hover:shadow-lg outline-none focus:outline-none ease-linear transition-all duration-150">Export</a>
                            <Button @click="createCustomerModal">Create Customer</Button>
                        </div>
                    </template>

                    <tr v-for="(customer, index) in customers.data" :key="customer.id">
                        <TableData>
                            {{ (customers.current_page * customers.per_page) - (customers.per_page - (index + 1)) }}
                        </TableData>
                        <TableData class="text-left flex items-center">
                            <span class="ml-3 font-bold text-blueGray-600">{{ customer.name }}</span>
                        </TableData>
                        <TableData>{{ customer.email }}</TableData>
                        <TableData>{{ customer.phone }}</TableData>
                        <TableData>
                            <Button @click="editCustomerModal(customer)"><i class="fa fa-edit"></i></Button>
                            <Button @click="deleteCustomerModal(customer)" type="red"><i class="fa fa-trash-alt"></i></Button>
                        </TableData>
                    </tr>
                </CardTable>
            </div>
        </div>

        <Modal title="Create" :show="showCreateModal" :formProcessing="form.processing" @close="closeModal" @submitAction="createCustomer">
            <div>
                <DashboardInputGroup inputId="name" label="Name" placeholder="Enter name" v-model="form.name" :errorMessage="form.errors.name" />
                <DashboardInputGroup inputId="email" label="Email" placeholder="Enter email" v-model="form.email" :errorMessage="form.errors.email" />
                <DashboardInputGroup inputId="phone" label="Phone" placeholder="Enter phone" v-model="form.phone" :errorMessage="form.errors.phone" />
                <DashboardInputGroup inputId="address" label="Address" placeholder="Enter Address" v-model="form.address" :errorMessage="form.errors.address" />
            </div>
        </Modal>

        <Modal title="Edit" :show="showEditModal" :formProcessing="form.processing" @close="closeModal" @submitAction="updateCustomer">
            <div>
                <DashboardInputGroup inputId="name" label="Name" placeholder="Enter name" v-model="form.name" :errorMessage="form.errors.name" />
                <DashboardInputGroup inputId="email" label="Email" placeholder="Enter email" v-model="form.email" :errorMessage="form.errors.email" />
                <DashboardInputGroup inputId="phone" label="Phone" placeholder="Enter phone" v-model="form.phone" :errorMessage="form.errors.phone" />
                <DashboardInputGroup inputId="address" label="Address" placeholder="Enter Address" v-model="form.address" :errorMessage="form.errors.address" />
            </div>
        </Modal>

        <Modal title="Delete" :show="showDeleteModal" :formProcessing="form.processing" @close="closeModal" @submitAction="deleteCustomer" maxWidth="sm" submitButtonText="Yes, delete it!">
            Are you sure you want to delete this customer?
        </Modal>
    </AuthenticatedLayout>
</template>
