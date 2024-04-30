<template>
    <div>
        <Breadcrumbs main="Client Dashboard" title="default" />

        <div class="container-fluid">
            <div class="row widget-grid">
                <div class="row">
                    <!--  -->
                    <div class="col-xxl-6 col-md-6 box-col-6">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <a class="btn btn-primary btn-hover-effect f-w-500"
                                            href="/admin/roles">Roles</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
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
                            data-original-title="test" data-bs-target="#exampleModal">Report New Incident</button>
                    </div>
                </div>
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">New Incident</h5>
                                <button class="btn-close" type="button" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form class="needs-validation" novalidate="" @submit.prevent="createData">
                                <div class="modal-body">
                                    <!-- type of incident -->
                                    <div class="form-group mb-1">
                                        <label class="col-form-label">Type of Incident <span
                                                class="text-danger">*</span>
                                        </label>
                                        <select v-model="type" class="form-control" id="typeSelect" required>
                                            <option v-for="type in types" :value="type.name">
                                                {{ type.name }}
                                            </option>
                                        </select>
                                    </div>

                                    <!-- priority -->
                                    <div class="form-group mb-1">
                                        <label class="col-form-label">Priority / Severity <span
                                                class="text-danger">*</span>
                                        </label>
                                        <select v-model="priority" class="form-control" id="prioritySelect" required>
                                            <option v-for="priority in priorities" :value="priority.name">
                                                {{ priority.name }}
                                            </option>
                                        </select>
                                    </div>

                                    <!-- desc -->
                                    <div class="form-group mb-1">
                                        <label class="col-form-label">Describe the incident <span
                                                class="text-danger">*</span>
                                        </label>
                                        <textarea class="form-control" v-model="desc" required></textarea>
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
                                <th>Incident Date</th>
                                <th>Type of Incident</th>
                                <th>Priority / Severity</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="incident in incidents" :key="incident.id">
                                <td class="text-uppercase">{{ incident.date }}</td>
                                <td>{{ incident.type }}</td>
                                <td>{{ incident.priority }}</td>
                                <td class="text-uppercase">{{ incident.status }}</td>
                            </tr>
                        </tbody>
                    </table>
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
import Swal from 'sweetalert2';
import WelcomeCard from './WelcomeCard.vue';

export default {
    data() {
        return {
            elementsPerPage: 10,
            currentPage: 1,
            perPage: 10,
            pageOptions: [10, 25, 50, 100],
            active: true,
            editName: '',
            name: '',
            loading: false,
            item: {},
            status: '',
            types: [],
            priorities: [],
            type: '',
            priority: '',
            desc: '',
            incidents: []
        };
    },
    computed: {
        WelcomeCard,
        columns() {
            return ['Name', 'Status', 'Date Created'];
        },
        isFormValid() {
            return (
                this.type &&
                this.priority &&
                this.desc);
        }

    },
    methods: {
        async fetchTypes() {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/types/list', {
                    headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + localStorage.getItem('HCA_TOKEN') }
                });
                if (response.data.status) {
                    this.types = response.data.data;
                } else {
                    console.error('Error fetching types:', response.data.message);
                }
            } catch (error) {
                console.error('Error fetching types:', error);
            }
        },

        // 
        async fetchPriorities() {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/priorities/list', {
                    headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + localStorage.getItem('HCA_TOKEN') }
                });
                if (response.data.status) {
                    this.priorities = response.data.data;
                } else {
                    console.error('Error fetching priorities:', response.data.message);
                }
            } catch (error) {
                console.error('Error fetching priorities:', error);
            }
        },

        async fetchIncidents() {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/client/my-incidents', {
                    headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + localStorage.getItem('HCA_TOKEN') }
                });
                if (response.data.status) {
                    this.incidents = response.data.data;
                } else {
                    console.error('Error fetching incidents:', response.data.message);
                }
            } catch (error) {
                console.error('Error fetching incidents:', error);
            }
        },

        // create
        async createData() {
            // Set loading state to true when submitting the form
            this.loading = true;
            const newData = {
                type: this.type,
                priority: this.priority,
                desc: this.desc,
            };

            axios.post('http://127.0.0.1:8000/api/client/incident/report', newData, {
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
                        timer: 5000,
                        title: response.data.message,
                    });
                    this.clearForm();
                    // Redirect to login page after successful registration
                    // const router = useRouter();
                    window.location.href = 'http://localhost:8080/client/dashboard'
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
        // 
        clearForm() {
            this.type = '';
            this.priority = '',
                this.desc = '',
                // Reset loading state when the form is cleared
                this.loading = false;
        },
        num_pages() {
            return Math.ceil(this.incidents.length / this.elementsPerPage);
        },
        change_page(page) {
            this.currentPage = page;
        },
    },
    mounted() {
        this.fetchTypes();
        this.fetchPriorities();
        this.fetchIncidents();
    }
};
</script>
