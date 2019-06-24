import CustomerProjectsCreate from "../components/customer/projects/Create"
import CustomerProjectsIndex from "../components/customer/projects/Index"
import CustomerProjectsEdit from "../components/customer/projects/Edit"
import CustomerProjectsSettingsIndex from "../components/customer/projects/settings/Index"

import CustomerSettingsIndex from "../components/customer/settings/Index"

import CustomerOrdersIndex from "../components/customer/orders/Index"
import CustomerOrdersCreate from "../components/customer/orders/Create"
import CustomerOrdersEdit from "../components/customer/orders/edit/edit.vue"

import CustomerBalance from "../components/customer/balance/balance.vue"

import CustomerProfile from "../components/customer/profile/profile.vue"

import CustomerTasksIndex from "../components/customer/tasks/index/index.vue";
import CustomerTasksEdit from "../components/customer/tasks/edit/edit.vue";

Vue.component("customer-projects-create", CustomerProjectsCreate)
Vue.component("customer-projects-index", CustomerProjectsIndex)
Vue.component("customer-projects-edit", CustomerProjectsEdit)
Vue.component("customer-projects-settings-index", CustomerProjectsSettingsIndex)

Vue.component("customer-settings-index", CustomerSettingsIndex)

Vue.component("customer-orders-index", CustomerOrdersIndex)
Vue.component("customer-orders-create", CustomerOrdersCreate)
Vue.component("customer-orders-edit", CustomerOrdersEdit)

Vue.component("customer-balance", CustomerBalance)

Vue.component("customer-profile", CustomerProfile)

Vue.component("customer-tasks-index", CustomerTasksIndex);
Vue.component("customer-tasks-edit", CustomerTasksEdit);
