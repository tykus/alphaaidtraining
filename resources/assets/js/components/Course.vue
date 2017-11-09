<template>
  <div>
    <h3>{{course.title}}</h3>
    <p>{{course.description}}</p>
  </div>
</template>
<script>
    export default {
        props: ['course'],
        mounted() {
          console.log(this.course.name)
        }
    }
</script>