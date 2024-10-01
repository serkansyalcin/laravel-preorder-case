import axios from 'axios';
import router from '../router';

const axiosInstance = axios.create({
  baseURL: "/api",
  timeout: 10000,
});

axiosInstance.interceptors.response.use(
  response => response,
  error => {
    if (error.response && error.response.status === 401) {
      const userType = error.response.data?.type;

      // Check user-type and redirect accordingly
      if (userType === 'admin') {
        router.push('/admin/login');
      } else {
        router.push('/');
      }
    }

    return Promise.reject(error);
  }
);

export default axiosInstance;
