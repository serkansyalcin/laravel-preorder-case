import { defineStore } from "pinia";
import { ref } from "vue";
import axiosInstance from "../lib/axios";
import { useCartStore } from "../store/cart";


const useUser = defineStore('user', () => {
  const user = ref(null)
  const users = ref(null)
  const token = ref("")
  const error = ref("")
  const cartStore = useCartStore();

  // Fetching the user detials if token found in localstorage
  const fetchUser = async () => {
    const localToken = localStorage.getItem("token")

    if (localToken) {
      const { data } = await axiosInstance.get('/me')
      token.value = localToken;
      user.value = data.data
    }
  }

  // Fetching the user detials if token found in localstorage
  const fetchUsers = async () => {
    const localToken = localStorage.getItem("token")

    if (localToken) {
      const { data } = await axiosInstance.get('/admin/user/list')
      token.value = localToken;
      users.value = data.data
    }
  }

  const loginUser = async (email, password) => {
    const bodyParameters = { email, password };

    try {
      const { data } = await axiosInstance.post('/user/login', bodyParameters);
      user.value = data.data;
      token.value = data.token;
      localStorage.setItem('token', data.token);
      error.value = null;
      return true;
    } catch (err) {
      error.value = err.response?.data?.message || "Login failed";
      console.error("Login error:", err);
      return false;
    }
  };

  const registerUser = async (payload) => {
    const { data } = await axiosInstance.post('/user/register', payload)
      .then(function (result) {
        user.value = result.data.data
        token.value = result.data.token
        localStorage.setItem('token', result.data.token)
        return true;
      })
      .catch((err) => {
        error.value = err.response.data.message;
        console.error("API Error:", err);
      });

  }

  // Update an existing user
  const updateUser = async (id, updateUser) => {
    try {
      const { data } = await axiosInstance.post(`admin/user/update/${id}`, updateUser);
      user.value = data.data;
      error.value = null;
    } catch (err) {
      error.value = err.response.data.message;
      console.error("API Error:", err);
    }
  };

  // Logout the user
  const logout = async () => {
    if (token.value) {
      try {
        await axiosInstance.post('/logout');
        token.value = "";
        user.value = null;
        cartStore.clearCart();
        localStorage.removeItem('token'); // Clear token from local storage
      } catch (err) {
        console.error("Logout error:", err);
      }
    }
  };
  
  // Set user/token value
  const login = (iToken, data) => {
    user.value = data
    token.value = iToken
    localStorage.setItem('token', iToken)
  }

  return {
    token,
    user,
    error,
    users,
    login,
    loginUser,
    fetchUser,
    fetchUsers,
    registerUser,
    logout,
    updateUser
  }
})

export default useUser;
