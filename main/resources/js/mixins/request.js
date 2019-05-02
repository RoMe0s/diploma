import routes from '../router';

const findRoute = (chunks = [], routes = {}) => {
  const chunk = chunks.shift();
  if (chunk in routes) {
    return chunks.length ? findRoute(chunks, routes[chunk]) : routes[chunk];
  }
  return null;
};

const sendRequest = (routeName, parameters) => {
  const route = findRoute(routeName.split('.'), routes);
  if (typeof route === 'function') {
    if (Array.isArray(parameters)) {
      return route(...parameters);
    }
    return route(parameters);
  }
  throw 'Route not found';
};

export default {
  methods: {
    sendRequest(route, parameters, errorHandler) {
      return sendRequest(route, parameters)
        .catch(error => {
          switch (typeof errorHandler) {
            case 'function':
              errorHandler(error);
              break;
            case 'string':
              this.notify(errorHandler);
              break;
            default:
              this.httpErrorHandler(error);
              break;
          }
          throw error;
        });
    },
    httpErrorHandler(error) {
      if ('response' in error) {
        const responseData = error.response.data;
        if ('errors' in responseData) {
          for (let field in responseData.errors) {
            for (let error of responseData.errors[field]) {
              this.$validator.errors.add({field, msg: error});
            }
          }
        }
        if (responseData.message) {
          this.notify(responseData.message);
          return;
        }
      }
      this.notify(this.__('messages.error'));
    }
  }
};