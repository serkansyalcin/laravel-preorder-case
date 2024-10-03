import axios from 'axios';
import router from '../router';

const axiosInstance = axios.create({
  baseURL: "/api",
  timeout: 10000,
});

axiosInstance.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('token');
    if (token) {
      // If token exists, add it to the headers
      config.headers['Authorization'] = `Bearer ${token}`;
    }
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);


axiosInstance.interceptors.response.use(
  response => response,
  error => {
    if (error.response && [401, 403].includes(error.response.status)) {
      if (location.pathname.startsWith('/admin')) {
        router.push('/admin/login');
      } else {
        router.push('/');
      }
    }

    return Promise.reject(error);
  }
);

export default axiosInstance;
