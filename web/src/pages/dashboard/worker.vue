<template>
    <div>
        <Breadcrumbs main="Health Care Worker" title="default" />

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
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered display" id="basic-1">
                        <thead>
                            <tr>
                                <th>Incident Date</th>
                                <th>Type of Incident</th>
                                <th>Priority / Severity</th>
                                <th>Log</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="incident in incidents" :key="incident.id">
                                <td class="text-uppercase">{{ incident.date }}</td>
                                <td>{{ incident.type }}</td>
                                <td>{{ incident.priority }}</td>
                                <td>{{ incident.log }}</td>
                                <td class="text-uppercase">{{ incident.status }}</td>
                                <td>
                                    <!-- Log  -->
                                    <a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal"
                                        @click="setItem(incident)">
                                        <vue-feather type="edit"></vue-feather>Log </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Log Incident</h5>
                                    <button class="btn-close" type="button" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form class="needs-validation" novalidate="" @submit.prevent="reportLog">
                                    <div class="modal-body">
                                        <input v-model="item.id" type="hidden">
                                        <!-- Log -->
                                        <div class="form-group mb-1">
                                            <label class="col-form-label">Log Incident <span
                                                    class="text-danger">*</span>
                                            </label>
                                            <textarea v-model="log" class="form-control" required></textarea>
                                        </div>

                                        <!-- Status -->
                                        <div class="form-group mb-1">
                                            <label class="col-form-label">Status <span class="text-danger">*</span>
                                            </label>
                                            <select v-model="status" class="form-control" id="statusSelect" required>
                                                <option v-for="status in statuses" :value="status.name">
                                                    {{ status.name }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" type="button"
                                            data-bs-dismiss="modal">Close</button>
                                        <button :disabled="!isFormValid || loading" class="btn btn-primary">
                                            <span v-if="loading">Please Wait...</span>
                                            <span v-else>Submit</span>
                                        </button>
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
import Swal from 'sweetalert2';

export default {
    data() {
        return {
            elementsPerPage: 10,
            currentPage: 1,
            perPage: 10,
            pageOptions: [10, 25, 50, 100],
            active: true,
            loading: false,
            item: {},
            statuses: [],
            status: '',
            incidents: [],
            log: '',

        };
    },
    computed: {
        columns() {
            return ['Name', 'Status', 'Date Created'];
        },
        isFormValid() {
            return (
                this.log &&
                this.status
            );
        }
    },
    methods: {
        setItem(item) {
            this.item = item
            this.id = item.id
            // console.log(this.item)
        },

        // 
        async fetchIncidents() {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/health-care-worker/my-incidents', {
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

        // 
        async fetchStatuses() {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/statuses/list', {
                    headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + localStorage.getItem('HCA_TOKEN') }
                });
                if (response.data.status) {
                    this.statuses = response.data.data;
                } else {
                    console.error('Error fetching statuses:', response.data.message);
                }
            } catch (error) {
                console.error('Error fetching statuses:', error);
            }
        },

        // log
        async reportLog() {
            // Set loading state to true when submitting the form
            this.loading = true;
            const newData = {
                id: this.id,
                log: this.log,
                status: this.status,
            };

            axios.post('http://127.0.0.1:8000/api/health-care-worker/incident/log', newData, {
                headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + localStorage.getItem('HCA_TOKEN') }
            })
                .then(response => {
                    // console.log('success')
                    // console.log(response)
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
                    window.location.href = 'http://localhost:8080/worker/dashboard'
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
        },// log


        // 
        clearForm() {
            this.log = '',
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
        this.fetchStatuses();
        this.fetchIncidents();
    }
};
</script>
