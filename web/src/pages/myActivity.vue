<template>
    <div>
        <Breadcrumbs main="Health Care Worker" title="default" />
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
                                <th>Action</th>
                                <th>Description</th>
                                <th>IP</th>
                                <th>Agent</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="activity in activities" :key="activity.id">
                                <td>{{ activity.action }}</td>
                                <td class="text-uppercase">{{ activity.description }}</td>
                                <td>{{ activity.ip }}</td>
                                <td>{{ activity.agent }}</td>
                                <td>{{ activity.created_at }}</td>
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

export default {
    data() {
        return {
            elementsPerPage: 10,
            currentPage: 1,
            perPage: 10,
            pageOptions: [10, 25, 50, 100],
            activities: [],
        };
    },
    computed: {
        columns() {
            return ['Name', 'Status', 'Date Created'];
        },
    },
    methods: {
        // 
        async fetchActivities() {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/my-activities', {
                    headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + localStorage.getItem('HCA_TOKEN') }
                });
                if (response.data.status) {
                    this.activities = response.data.data;
                } else {
                    console.error('Error fetching activities:', response.data.message);
                }
            } catch (error) {
                console.error('Error fetching activities:', error);
            }
        },

        num_pages() {
            return Math.ceil(this.activities.length / this.elementsPerPage);
        },
        change_page(page) {
            this.currentPage = page;
        },
    },
    mounted() {
        this.fetchActivities();
    }
};
</script>
