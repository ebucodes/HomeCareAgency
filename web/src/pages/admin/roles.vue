<template>
    <div>
        <br>
        <div class="card">
            <div class="card-header">
                <div class="dataTables_length" id="basic-1_length">
                    <label>
                        Show
                        <select name="basic-1_length" aria-controls="basic-1" class="" v-model="perPage">
                            <option v-for="option in pageOptions" :key="option" :value="option">{{ option }}</option>
                        </select> entries
                    </label>
                </div>
                <div class="row justify-content-end">
                    <div class="col-auto">
                        <button class="btn btn-primary btn-lg" type="button" data-bs-toggle="modal"
                            data-original-title="test" data-bs-target="#exampleModal">Create New Role</button>
                    </div>
                </div>
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">New Role</h5>
                                <button class="btn-close" type="button" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form class="needs-validation" novalidate="" @submit.prevent="createData">
                                <div class="modal-body">
                                    <!-- First Name -->
                                    <div class="form-group mb-1">
                                        <label class="col-form-label">First Name <span class="text-danger">*</span>
                                        </label>
                                        <input v-model="name" class="form-control" type="text" required
                                            placeholder="Name" />
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button"
                                        data-bs-dismiss="modal">Close</button>
                                    <button :disabled="!isFormValid || loading" class="btn btn-primary">
                                        <span v-if="loading">Please Wait...</span>
                                        <span v-else>Save changes</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered display" id="basic-1">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <!-- <th>Status</th> -->
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="role in roles" :key="role.id">
                                <td class="text-uppercase">{{ role.name }}</td>
                                <!-- <td v-if="role.isActive == true">Active </td>
                                <td v-else-if="role.isActive == false">Disabled</td> -->
                                <!-- <td>{{ role.isActive }}</td> -->
                                <td>
                                    <!-- Edit Icon -->
                                    <a class="text-success" data-bs-toggle="modal" data-bs-target="#editModal"
                                        @click="setItem(role)">
                                        <vue-feather type="edit"></vue-feather></a>

                                    <!-- Delete Icon -->
                                    <a class="text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                        @click="setItem(role)">
                                        <vue-feather type="delete"></vue-feather>
                                    </a>

                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">New Role</h5>
                                    <button class="btn-close" type="button" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form class="needs-validation" novalidate="" @submit.prevent="updateData">
                                    <div class="modal-body">
                                        <input v-model="item.id" class="form-control" type="hidden" required
                                            placeholder="Name" />
                                        <!-- Name -->
                                        <div class="form-group mb-1">
                                            <label class="col-form-label">First Name <span class="text-danger">*</span>
                                            </label>
                                            <input v-model="editName" class="form-control" type="text" required
                                                placeholder="Name" />
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" type="button"
                                            data-bs-dismiss="modal">Close</button>
                                        <button class="btn btn-primary">
                                            Save changes
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Confirmation Modal -->
                    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">New Role</h5>
                                    <button class="btn-close" type="button" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form class="needs-validation" novalidate="" @submit.prevent="deleteData">
                                    <div class="modal-body">
                                        <input v-model="item.id" class="form-control" type="hidden" />
                                        <p>Are you sure you want to deactivate <strong>{{ item.name }}</strong></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" type="button"
                                            data-bs-dismiss="modal">Close</button>
                                        <button class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item" v-for="i in num_pages()" :key="i"
                        v-bind:class="[i == currentPage ? 'active' : '']" v-on:click="change_page(i)">
                        <a class="page-link">{{ i }}</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import dataTable from "@/mixins/dataTable"
import formValidation from '@/mixins/common/formValidation';
import Swal from 'sweetalert2';

export default {
    mixins: [dataTable],
    mixins: [formValidation],
    data() {
        return {
            elementsPerPage: 10,
            currentPage: 1,
            perPage: 10,
            pageOptions: [10, 25, 50, 100],
            roles: [],
            active: true,
            editName: '',
            name: '',
            loading: false,
            item: {},
            status: '',
        };
    },
    computed: {
        columns() {
            return ['Name', 'Status', 'Date Created'];
        },
        isFormValid() {
            return (
                this.name
            );
        }
    },
    methods: {
        setItem(item) {
            this.item = item
            this.editName = item.name,
                this.id = item.id
            // console.log(this.item)
        },
        async fetchRoles() {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/admin/role/fetch-all', {
                    headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + localStorage.getItem('HCA_TOKEN') }
                });
                if (response.data.status) {
                    this.roles = response.data.data;
                } else {
                    console.error('Error fetching roles:', response.data.message);
                }
            } catch (error) {
                console.error('Error fetching roles:', error);
            }
        },
        // create
        async createData() {
            // Set loading state to true when submitting the form
            this.loading = true;
            const newData = {
                name: this.name,
            };

            axios.post('http://127.0.0.1:8000/api/admin/role/create', newData, {
                headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + localStorage.getItem('HCA_TOKEN') }
            })
                .then(response => {
                    console.log('success')
                    console.log(response)
                    Swal.fire({
                        icon: 'success',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        title: response.data.message,
                    });
                    this.clearForm();
                    // Redirect to login page after successful registration
                    // const router = useRouter();
                    window.location.href = 'http://localhost:8080/admin/roles'
                    // router.push('/'); // Assuming '/' is the path for the login page

                })
                .catch(error => {

                    console.log('success')
                    console.log(error)
                    Swal.fire({
                        icon: 'error',
                        title: error.response ? error.response.data.message : 'Failed',
                        // text: error.response.data.data
                        text: error.response ? error.response.data.data : 'An error occurred'
                    });
                })
                .finally(() => {
                    // Reset loading state regardless of success or failure
                    this.loading = false;
                });
        },
        // update
        async updateData() {
            // Set loading state to true when submitting the form
            this.loading = true;
            const newData = {
                id: this.id,
                name: this.editName,
            };

            axios.post('http://127.0.0.1:8000/api/admin/role/update', newData, {
                headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + localStorage.getItem('HCA_TOKEN') }
            })
                .then(response => {
                    console.log('success')
                    console.log(response)
                    Swal.fire({
                        icon: 'success',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        title: response.data.message,
                    });
                    this.clearForm();
                    // Redirect to login page after successful registration
                    // const router = useRouter();
                    window.location.href = 'http://localhost:8080/admin/roles'
                    // router.push('/'); // Assuming '/' is the path for the login page

                })
                .catch(error => {

                    console.log('success')
                    console.log(error)
                    Swal.fire({
                        icon: 'error',
                        title: error.response ? error.response.data.message : 'Failed',
                        // text: error.response.data.data
                        text: error.response ? error.response.data.data : 'An error occurred'
                    });
                })
                .finally(() => {
                    // Reset loading state regardless of success or failure
                    this.loading = false;
                });
        },
        // delete
        async deleteData() {
            // Set loading state to true when submitting the form
            this.loading = true;
            const itemData = {
                id: this.id,
            };

            axios.post('http://127.0.0.1:8000/api/admin/role/deactivate', itemData, {
                headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + localStorage.getItem('HCA_TOKEN') }
            })
                .then(response => {
                    console.log('success')
                    console.log(response)
                    Swal.fire({
                        icon: 'success',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: true,
                        // timer: 3000,
                        title: response.data.message,
                    });
                    // Redirect to login page after successful registration
                    // const router = useRouter();
                    window.location.href = 'http://localhost:8080/admin/roles'
                    // router.push('/'); // Assuming '/' is the path for the login page
                    this.clearForm();

                })
                .catch(error => {

                    console.log('success')
                    console.log(error)
                    Swal.fire({
                        icon: 'error',
                        title: error.response ? error.response.data.message : 'Failed',
                        // text: error.response.data.data
                        text: error.response ? error.response.data.data : 'An error occurred'
                    });
                })
                .finally(() => {
                    // Reset loading state regardless of success or failure
                    this.loading = false;
                });
        },
        clearForm() {
            this.name = '';
            // Reset loading state when the form is cleared
            this.loading = false;
        },
        num_pages() {
            return Math.ceil(this.roles.length / this.elementsPerPage);
        },
        change_page(page) {
            this.currentPage = page;
        },
    },
    mounted() {
        this.fetchRoles();
    }
};
</script>
