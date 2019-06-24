import AuthorOrdersIndex from "../components/author/orders/index/index.vue"

import AuthorTasksIndex from "../components/author/tasks/index/index.vue";
import AuthorTasksEdit from "../components/author/tasks/edit/edit.vue";
import AuthorTasksDone from "../components/author/tasks/done/done.vue";

import AuthorBalance from "../components/author/balance/balance.vue"

import AuthorProfile from "../components/author/profile/profile.vue"

Vue.component("author-orders-index", AuthorOrdersIndex)

Vue.component("author-tasks-index", AuthorTasksIndex)
Vue.component("author-tasks-edit", AuthorTasksEdit)
Vue.component("author-tasks-done", AuthorTasksDone);

Vue.component("author-balance", AuthorBalance)

Vue.component("author-profile", AuthorProfile)
