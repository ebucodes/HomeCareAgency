<template>
    <div class="dataTables_length" id="basic-1_length">
        <label>Show <select name="basic-1_length" aria-controls="basic-1" class="" v-model="perPage">
                <option v-for="option in pageOptions" :key="option" :value="option">{{ option }}</option>
            </select> entries</label>
    </div>

    <table class=" display dataTable" id="basic-1">
        <thead>
            <tr>
                <th>User</th>
                <th>Action</th>
                <th>Description</th>
                <th>IP</th>
                <th>Agent (Browser)</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="row in get_rows()" :key="row.id">
                <td>{{ row.user }}</td>
                <td>{{ row.action }}</td>
                <td>{{ row.description }}</td>
                <td>{{ row.ip }}</td>
                <td>{{ row.agent }}</td>
                <td>{{ row.created_at }}</td>
            </tr>
        </tbody>
    </table>
    <ul class="pagination">
        <li class="page-item">
            <a class="page-link" href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        <li class="page-item" v-for="i in num_pages()" :key="i" v-bind:class="[i == currentPage ? 'active' : '']"
            v-on:click="change_page(i)"><a class="page-link">{{ i }}</a></li>
        <li class="page-item">
            <a class="page-link" href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</template>

<script>
import { mapState } from "vuex";
import axios from 'axios';

export default {
    data() {
        return {
            elementsPerPage: 10,
            currentPage: 1,
            ascending: false,
            sortColumn: '',
            perPage: 10,
            pageOptions: [10, 25, 50, 100],
            filter: null,
        };
    },
    computed: {
        ...mapState({
            tableItems: (state) => state.table.items,
        })
    },
    created() {
        this.fetchTableItems();
    },
    methods: {
        async fetchTableItems() {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/my-activities');
                if (response.data.status) {
                    this.$store.commit('setTableItems', response.data.data);
                } else {
                    console.error('Error fetching table items:', response.data.message);
                }
            } catch (error) {
                console.error('Error fetching table items:', error);
            }
        },
        num_pages() {
            return Math.ceil(this.tableItems.length / this.elementsPerPage);
        },
        change_page(page) {
            this.currentPage = page;
        },
        get_rows() {
            var start = (this.currentPage - 1) * this.elementsPerPage;
            var end = start + this.elementsPerPage;
            return this.tableItems.slice(start, end);
        }
    }
};
</script>
