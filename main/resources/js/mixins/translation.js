const findKey = (chunks = [], translations = {}) => {
  if (chunks.length && typeof translations === 'object') {
    const chunk = chunks.shift();
    if (chunk in translations) {
      return findKey(chunks, translations[chunk]);
    }
    throw "hui";
    return chunks.length ? chunks.pop() : chunk;
  }
  if (typeof translations === 'string') {
    return translations;
  }
  return null;
};

export default {
  methods: {
    __(key) {
      let chunks = key.split('.');
      try {
        return findKey(chunks, window.translations || {}) || chunks.pop();
      } catch (e) {
        console.log(key);
      }
      return "hui";
    }
  }
};