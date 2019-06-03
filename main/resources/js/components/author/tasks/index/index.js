import ProviderMixin from "../../../../mixins/table/provider";

export default {
  mixins: [ProviderMixin],
  data() {
    return {
      fields: [
        {
          key: "id",
          sortable: true,
          label: this.__("columns.id")
        },
        {
          key: "status",
          sortable: true,
          label: this.__("columns.status")
        },
        {
          key: "name",
          sortable: true,
          label: this.__("columns.name")
        },
        {
          key: "expired_at",
          sortable: true,
          label: this.__("columns.expired at")
        },
        {
          key: "date",
          sortable: true,
          label: this.__("columns.changed at")
        },
        {
          key: "actions",
          label: this.__("columns.actions")
        }
      ],
      perPage: 25,
      filter: null,
      sortBy: null,
      totalRows: 0,
      currentPage: 1,
      sortDesc: false,
      sortDirection: "desc",
      pageOptions: [25, 50, 100]
    };
  },
  methods: {
    itemsProviderCallback(response) {
      this.totalRows = response.data.totalRows;
      return response.data.rows;
    }
  }
};