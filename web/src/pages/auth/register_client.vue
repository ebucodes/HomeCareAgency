<template>
    <div>
        <div class="container-fluid p-0">
            <div class="row m-0">
                <!-- Left Column -->
                <div class="col-xl-5 b-center bg-size"
                    :style="{ backgroundImage: 'url(' + require('../../assets/images/login/3.jpg') + ')' }"
                    style="background-size: cover; background-position: center center; display: block;">
                    <img class="bg-img-cover bg-center" src="../../assets/images/login/3.jpg" alt="loginpage"
                        style="display: none;" />
                </div>
                <!-- Right Column -->
                <div class="col-xl-7 p-0">
                    <div class="login-card">
                        <div>
                            <div>
                                <a class="logo">
                                    <img class="img-fluid for-light" src="../../assets/images/logo/logo.png"
                                        alt="loginpage" />
                                    <img class="img-fluid for-dark" src="../../assets/images/logo/logo_dark.png"
                                        alt="loginpage" />
                                </a>
                            </div>
                            <div class="login-main">
                                <form class="theme-form needs-validation" novalidate="" @submit.prevent="createUser">
                                    <h4>Create your account</h4>
                                    <p>Enter your personal details to register as a Client</p>

                                    <!-- First Name -->
                                    <div class="form-group mb-1">
                                        <label class="col-form-label">First Name <span class="text-danger">*</span>
                                        </label>
                                        <input v-model="firstName" class="form-control" type="text" required
                                            placeholder="First name" />
                                    </div>

                                    <!-- Last Name -->
                                    <div class="form-group mb-1">
                                        <label class="col-form-label">Last Name<span
                                                class="text-danger">*</span></label>
                                        <input v-model="lastName" class="form-control" type="text" required
                                            placeholder="Last name" />
                                    </div>

                                    <!-- Email Address -->
                                    <div class="form-group mb-1">
                                        <label class="col-form-label">Email Address (Optional)</label>
                                        <input v-model="email" class="form-control" type="email"
                                            placeholder="Test@gmail.com" />
                                    </div>

                                    <!-- Phone Number -->
                                    <div class="form-group mb-1">
                                        <label class="col-form-label">Phone Number (Optional)</label>
                                        <input v-model="phone" class="form-control" type="text"
                                            placeholder="1234567890" />
                                    </div>

                                    <!-- Username -->
                                    <div class="form-group mb-1">
                                        <label class="col-form-label">Username <span class="text-danger">*</span>
                                        </label>
                                        <input v-model="userName" class="form-control" type="text" required
                                            placeholder="Username" />
                                    </div>

                                    <!-- Health Care Worker -->
                                    <div class="form-group mb-1">
                                        <label class="col-form-label">Health Care Worker</label>
                                        <select v-model="worker" class="form-control" id="workerSelect" required>
                                            <option v-for="worker in workers" :value="worker.userName">
                                                {{ worker.firstName + ' ' + worker.lastName }}
                                            </option>
                                        </select>
                                    </div>

                                    <!-- Password -->
                                    <div class="form-group mb-2">
                                        <label class="col-form-label">Password</label>
                                        <div class="form-input position-relative">
                                            <input v-model="password" class="form-control"
                                                :type="active ? 'password' : 'text'" name="login[password]" required
                                                placeholder="*********" />
                                            <div class="show-hide"><span :class="active ? 'show' : 'hide'"
                                                    @click.prevent="show"></span></div>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="form-group mb-6">
                                        <button :disabled="!isFormValid" class="btn btn-primary btn-block">
                                            Register as a Client
                                        </button>
                                    </div>

                                    <!-- Links -->
                                    <p class="mt-4 mb-0">
                                        <a class="btn-link ms-2" href="/register/health-care-worker">Register as a
                                            Health Care
                                            Worker</a>
                                    </p>
                                    <p class="mt-4 mb-0">
                                        Already have an account?
                                        <router-link class="ms-2" tag="a" to="/">
                                            Login
                                        </router-link>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Swal from 'sweetalert2';
import axios from 'axios';
import { useRouter } from 'vue-router';

export default {
    data() {
        return {
            active: true,
            firstName: '',
            lastName: '',
            email: '',
            phone: '',
            userName: '',
            password: '',
            workers: [],
            worker: '',
        }
    },
    computed: {
        isFormValid() {
            return (
                this.firstName &&
                this.lastName &&
                this.userName &&
                this.password &&
                this.worker
            );
        }
    },
    created() {
        this.fetchHealthcareWorkers();
    },
    methods: {
        show() {
            this.active = !this.active;
        },
        async fetchHealthcareWorkers() {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/fetch-workers');
                if (response.data.status) {
                    this.workers = response.data.data;
                } else {
                    console.error('Error fetching healthcare workers:', response.data.message);
                }
            } catch (error) {
                console.error('Error fetching healthcare workers:', error);
            }
        },
        async createUser() {
            const userData = {
                firstName: this.firstName,
                lastName: this.lastName,
                email: this.email,
                phone: this.phone,
                userName: this.userName,
                worker: this.worker,
                password: this.password
            };

            axios.post('http://127.0.0.1:8000/api/auth/register/client', userData)
                .then(response => {
                    Swal.fire({
                        icon: 'success',
                        title: response.data.message,
                    });
                    this.clearForm();
                    // Redirect to login page after successful registration
                    const router = useRouter();
                    router.push('/'); // Assuming '/' is the path for the login page

                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: error.response.data.message,
                        text: error.response.data.data
                    });
                });

        },
        clearForm() {
            this.firstName = '';
            this.lastName = '';
            this.email = '';
            this.phone = '';
            this.userName = '';
            this.password = '';
            this.worker = '';
        }
    }
}
</script>
