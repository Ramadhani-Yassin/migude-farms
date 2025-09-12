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
    employees: Object,
});

const selectedEmployee = ref(null);
const showCreateModal = ref(false);
const showEditModal = ref(false);
const showDeleteModal = ref(false);
const nameInput = ref(null);
const tableHeads = ref(['#', "Name", "Designation", "Email", "Phone", "Salary", "Joining Date", "Action"]);

const form = useForm({
    name: null,
    email: null,
    phone: null,
    designation: null,
    address: null,
    salary: null,
    nid: null,
    joining_date: null,
    photo: null,
});

const createEmployeeModal = () => {
    showCreateModal.value = true;
    nextTick(() => nameInput.value.focus());
};

const editEmployeeModal = (employee) => {
    selectedEmployee.value = employee;
    form.name = employee.name;
    form.email = employee.email;
    form.phone = employee.phone;
    form.designation = employee.designation;
    form.address = employee.address;
    form.salary = employee.salary;
    form.nid = employee.nid;
    form.joining_date = employee.joining_date;
    form.photo = null;
    showEditModal.value = true;
    nextTick(() => nameInput.value.focus());
};

const deleteEmployeeModal = (employee) => {
    selectedEmployee.value = employee;
    showDeleteModal.value = true;
};

const createEmployee = () => {
    form.post(route('employees.store'), {
        preserveScroll: true,
        onSuccess: () => { closeModal(); showToast(); },
        onError: () => nameInput.value.focus(),
    });
};

const updateEmployee = () => {
    form.put(route('employees.update', selectedEmployee.value.id), {
            preserveScroll: true,
        onSuccess: () => { closeModal(); showToast(); },
            onError: () => nameInput.value.focus(),
        });
};

const deleteEmployee = () => {
    form.post(route('employees.destroy', selectedEmployee.value.id), {
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
    <Head title="Employee"/>

    <AuthenticatedLayout>
        <template #breadcrumb>
            Employees
        </template>

        <div class="flex flex-wrap">
            <div class="w-full px-4">
                <CardTable
                    indexRoute="employees.index"
                    :paginatedData="props.employees"
                    :filters="props.filters"
                    :tableHeads="tableHeads"
                >
                    <template #cardHeader>
                        <h4 class="text-2xl">Employees ({{ employees.total }})</h4>
                    </template>
                    <template #cardHeaderRight>
                        <div class="flex items-center gap-2">
                            <a :href="route('employees.index', { export: 'excel' })" class="active:scale-95 rounded bg-gray-700 px-4 py-2 text-white text-xs font-bold uppercase shadow hover:shadow-lg outline-none focus:outline-none ease-linear transition-all duration-150">Export</a>
                            <Button @click="createEmployeeModal">Create Employee</Button>
                        </div>
                    </template>

                    <tr v-for="(employee, index) in employees.data" :key="employee.id">
                        <TableData>
                            {{ (employees.current_page * employees.per_page) - (employees.per_page - (index + 1)) }}
                        </TableData>
                        <TableData class="text-left flex items-center">
                            <span class="ml-3 font-bold text-blueGray-600">{{ employee.name }}</span>
                        </TableData>
                        <TableData>{{ employee.designation }}</TableData>
                        <TableData>{{ employee.email }}</TableData>
                        <TableData>{{ employee.phone }}</TableData>
                        <TableData>{{ employee.salary }}</TableData>
                        <TableData>{{ employee.joining_date }}</TableData>
                        <TableData>
                            <Button @click="editEmployeeModal(employee)"><i class="fa fa-edit"></i></Button>
                            <Button @click="deleteEmployeeModal(employee)" type="red"><i class="fa fa-trash-alt"></i></Button>
                        </TableData>
                    </tr>
                </CardTable>
            </div>
        </div>

        <Modal title="Create" :show="showCreateModal" :formProcessing="form.processing" @close="closeModal" @submitAction="createEmployee">
            <div>
                <DashboardInputGroup inputId="name" label="Name" placeholder="Enter name" v-model="form.name" :errorMessage="form.errors.name" />
            </div>
        </Modal>

        <Modal title="Edit" :show="showEditModal" :formProcessing="form.processing" @close="closeModal" @submitAction="updateEmployee">
            <div>
                <DashboardInputGroup inputId="name" label="Name" placeholder="Enter name" v-model="form.name" :errorMessage="form.errors.name" />
            </div>
        </Modal>

        <Modal title="Delete" :show="showDeleteModal" :formProcessing="form.processing" @close="closeModal" @submitAction="deleteEmployee" maxWidth="sm" submitButtonText="Yes, delete it!">
            Are you sure you want to delete this employee?
        </Modal>
    </AuthenticatedLayout>
</template>
