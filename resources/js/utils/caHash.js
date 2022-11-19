/*
 *   Created on: Jun 3, 2021   1:49:32 PM
 */

window.caHash = (function () {
  return {
    get() {
      return window.location.hash;
    },
    set(value) {
      window.location.hash = value;
    },
    clear() {
      history.pushState(
        "",
        document.title,
        window.location.pathname + window.location.search
      );
    },

    getParamSingleAndClear(hash) {
      const splitParams = _.chain(hash).split("=");

      const entityId = splitParams.last().value();

      this.clear();

      return entityId;
    },
    getParamsMultipleAndClear(hash) {
      const parts = _.chain(hash)
        .split("=")
        .value()
        .map((part) => {
          const pairs = part.split(":");
          if (pairs.length >= 2 && pairs[0]) {
            return {
              key: pairs[0],
              value: decodeURI(pairs[1]),
            };
          }
          return null;
        })
        .filter((part) => {
          return part ? true : false;
        });
      this.clear();
      return parts;
    },
  };
})();
