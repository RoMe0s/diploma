export default {
  auth: {
    logout: () => axios.post('/api/auth/logout'),
    login: data => axios.post('/api/auth/login', data),
    register: data => axios.post('/api/auth/register', data)
  }
}