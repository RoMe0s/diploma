export default {
  auth: {
    user: () => axios.get('/auth/user'),
    logout: () => axios.post('/auth/logout'),
    login: data => axios.post('/auth/login', data),
    register: data => axios.post('/auth/register', data)
  },
  customer: {
    projects: {
      index: params => axios.get('/projects', {params}),
      destroy: id => axios.delete(`/projects/${id}`),
      update: (id, data) => axios.put(`/projects/${id}`, data),
      store: data => axios.post(`/projects`, data),
      'index-action': data => axios.post('/projects/action', data)
    }
  }
}