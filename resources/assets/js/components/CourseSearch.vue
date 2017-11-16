<template>
  <div>
    <input type="text" class="input" v-model="search">
    <label class="checkbox">
      <input type="checkbox" :checked="type == 1">
      Public Courses
    </label>
    <label class="checkbox">
      <input type="checkbox" :checked="type == 2">
      Professional Courses
    </label>
  </div>
</template>

<script>
  export default {
    name: 'course-search',
    data () {
      return {
        search: '',
        type: ''
      }
    },
    methods: {
    }
  }
</script>