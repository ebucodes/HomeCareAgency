import {useStore} from "vuex";
import axios from "axios";
import Swal from 'sweetalert2'

const Toast = Swal.mixin({
    toast: false,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
});

const instance = axios.create({
    baseURL: 'http://127.0.0.1:8000/api/',
    // timeout: 1000,
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
    }
});

// Add a request interceptor
instance.interceptors.request.use(function (config) {
    
    const store = useStore();
    
    // Do something before request is sent
    // console.log(store.getters?.getToken)
    console.log('frfrfr')
    axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('HCA_TOKEN')
    return config;
}, function (error) {
    // Do something with request error
    return Promise.reject(error);
});

// Add a response interceptor
instance.interceptors.response.use(function (response) {
    // Any status code that lie within the range of 2xx cause this function to trigger
    // Do something with response data
    let icon = response?.data?.status ? "success" : "error"
    let message = response?.data?.message

    Toast.fire({
        icon: icon,
        title: message
    });

    return response;
}, function (error) {
    
    let icon = "error"
    let message = error?.response?.data?.message

    Toast.fire({
        icon: icon,
        title: message
    });
    // Any status codes that falls outside the range of 2xx cause this function to trigger
    // Do something with response error
    return Promise.reject(error);
});

export default instance
