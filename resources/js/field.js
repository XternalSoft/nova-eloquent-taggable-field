Nova.booting((Vue, router, store) => {
  Vue.component('index-nova-eloquent-taggable-field', require('./components/Nova/IndexField'))
  Vue.component('detail-nova-eloquent-taggable-field', require('./components/Nova/DetailField'))
  Vue.component('form-nova-eloquent-taggable-field', require('./components/Nova/FormField'))
})
