export default {
  auth: {
    user: () => axios.get('/auth/user'),
    logout: () => axios.post('/auth/logout'),
    login: data => axios.post('/auth/login', data),
    register: data => axios.post('/auth/register', data)
  },
  customer: {
    projects: {
      index: params => axios.get('/customer/projects', {params}),
      destroy: id => axios.delete(`/customer/projects/${id}`),
      update: (id, data) => axios.put(`/customer/projects/${id}`, data),
      store: data => axios.post(`/customer/projects`, data),
      'index-action': data => axios.post('/customer/projects/action', data),
      compact: () => axios.get('/customer/projects/compact'),
      settings: {
        index: (project, params) => axios.get(`/customer/projects/${project}/settings`, {params}),
        destroy: (project, check) => axios.delete(`/customer/projects/${project}/settings/${check}`),
        'update-or-create': (project, check, value) => axios.post(`/customer/projects/${project}/settings/${check}`, {value}),
      }
    },
    settings: {
      index: params => axios.get('/customer/settings', {params}),
      destroy: check => axios.delete(`/customer/settings/${check}`),
      'update-or-create': (check, value) => axios.post(`/customer/settings/${check}`, {value}),
    },
    orders: {
      index: params => axios.get('/customer/orders', {params}),
      show: id => axios.get(`/customer/orders/${id}`),
      store: data => axios.post('/customer/orders', data),
      update: (id, data) => axios.put(`/customer/orders/${id}`, data),
      destroy: id => axios.delete(`/customer/orders/${id}`),
      'index-action': data => axios.post('/customer/orders/action', data),
      publish: id => axios.post(`/customer/orders/${id}/publish`),
      rollback: id => axios.post(`/customer/orders/${id}/rollback`),
      count: () => axios.get('/customer/orders/count')
    },
    balance: {
      index: () => axios.get('/customer/balance'),
      update: data => axios.patch('/customer/balance', data)
    },
    profile: {
      update: data => axios.patch('/customer/profile', data),
      password: data => axios.post('/customer/profile/password', data)
    }
  },
  config: {
    plan: () => axios.get('/config/plan')
  }
}
