import { defineStore } from "pinia";
import { ref } from "vue";
import axiosInstance from "../lib/axios";

const useUser = defineStore('user', () => {
  const user = ref(null)
  const token = ref("")

  // Fetching the user detials if token found in localstorage
  const fetchUser = async () => {
    const localToken = localStorage.getItem("token")

    if (localToken) {
      const { data } = await axiosInstance.get('/me')
      token.value = localToken;
      user.value = data.data
    }
  }

  const loginUser = async (email, password) => {

    const bodyParameters = {
      email: email,
      password: password
    };

    const { data } = await axiosInstance.post('/user/login', bodyParameters)
      .then(function (result) {
        user.value = result.data.data
        token.value = result.data.token
        localStorage.setItem('token', result.data.token)
        return true;
      })
      .catch(console.log);

  }

  // Logout the user
  const logout = async () => {
    if (token.value) {
      await axiosInstance.post('/logout')
      token.value = ""
      user.value = ""
    }
  }

  // Set user/token value
  const login = (iToken, data) => {
    user.value = data
    token.value = iToken
    localStorage.setItem('token', iToken)
  }

  return {
    token,
    user,
    login,
    loginUser,
    fetchUser,
    logout
  }
})

export default useUser;
