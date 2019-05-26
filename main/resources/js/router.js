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
      'index-action': data => axios.post('/projects/action', data),
      compact: () => axios.get('/projects/compact'),
      settings: {
        index: (project, params) => axios.get(`/projects/${project}/settings`, {params}),
        destroy: (project, check) => axios.delete(`/projects/${project}/settings/${check}`),
        'update-or-create': (project, check, value) => axios.post(`/projects/${project}/settings/${check}`, {value}),
      }
    },
    settings: {
      index: params => axios.get('/settings', {params}),
      destroy: check => axios.delete(`/settings/${check}`),
      'update-or-create': (check, value) => axios.post(`/settings/${check}`, {value}),
    },
    orders: {
      index: params => axios.get('/orders', {params}),
      show: id => axios.get(`/orders/${id}`),
      store: data => axios.post('/orders', data),
      update: (id, data) => axios.put(`/orders/${id}`, data),
      destroy: id => axios.delete(`/orders/${id}`),
      'index-action': data => axios.post('/orders/action', data),
      publish: id => axios.post(`/orders/${id}/publish`),
      rollback: id => axios.post(`/orders/${id}/rollback`)
    }
  },
  config: {
    plan: () => axios.get('/config/plan')
  }
}
