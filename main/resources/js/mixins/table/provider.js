export default {
  data() {
    return {
      totalRows: 0
    };
  },
  methods: {
    itemsProvider(ctx) {
      return this.sendRequest(ctx.apiUrl, {
        filter: ctx.filter,
        sortBy: ctx.sortBy,
        sortDesc: +ctx.sortDesc,
        perPage: ctx.perPage,
        currentPage: ctx.currentPage
      }, () => []).then(response => {
        this.totalRows = response.data.totalRows;
        return response.data.rows;
      });
    }
  }
}